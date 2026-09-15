<?php

namespace TomatoPHP\FilamentSeo\Services;

use Google\Service\Exception;
use Google\Service\Indexing\UrlNotificationMetadata;
use Google_Service_Indexing;
use Google_Service_Indexing_UrlNotification;
use Google_Service_Indexing_UrlNotificationMetadata;
use Google_Service_Webmasters;
use Google_Service_Webmasters_ApiDimensionFilter;
use Google_Service_Webmasters_ApiDimensionFilterGroup;
use Google_Service_Webmasters_SearchAnalyticsQueryRequest;
use Illuminate\Support\Collection;

/**
 * Class SearchConsole
 *
 * @method static SearchConsole google()
 * @method static SearchConsole setQuotaUser(string $quotaUser)
 * @method static SearchConsole setAccessToken($accessToken)
 * @method static SearchConsole getSite(string $siteUrl)
 * @method static SearchConsole listSites()
 */
class SearchConsole
{
    /** @var SearchConsoleClient */
    protected $client;

    public function __construct(SearchConsoleClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return $this
     */
    public function setQuotaUser(string $quotaUser)
    {
        $this->client->setQuotaUser($quotaUser);

        return $this;
    }

    /**
     * @param  string|array  $accessToken
     * @return $this
     */
    public function setAccessToken($accessToken)
    {
        if (is_array($accessToken)) {
            $accessToken = trim(json_encode($accessToken));
        }

        $this->client->setAccessToken($accessToken);

        $this->client->getGoogleClient()->getCache()->clear();

        return $this;
    }

    /**
     * @return array
     */
    public function getSite(string $siteUrl)
    {
        $sites = $this->client->getWebmastersService()->sites;

        $siteInfo = $sites->get($siteUrl);

        $response = [
            'siteUrl' => $siteInfo->getSiteUrl(),
            'permissionLevel' => $siteInfo->getPermissionLevel(),
        ];

        return $response;
    }

    public function listSites()
    {
        $sites = $this->client->getWebmastersService()->sites;
        $siteList = $sites->listSites();

        $sitesCollection = new Collection;
        foreach ($siteList->getSiteEntry() as $site) {
            $sitesCollection->push([
                'siteUrl' => $site->siteUrl,
                'permissionLevel' => $site->permissionLevel,
            ]);
        }
        $sitesCollection = $sitesCollection->sortBy('siteUrl');

        return $sitesCollection;
    }

    /**
     * Call the query method on the authenticated client.
     *
     * @return Collection
     *
     * @throws \Exception
     */
    public function searchAnalyticsQuery(string $siteUrl, Period $period, array $dimensions = [], array $filters = [], int $rows = 1000, string $searchType = 'web', string $dataState = 'final', string $aggregationType = 'auto')
    {
        $request = new Google_Service_Webmasters_SearchAnalyticsQueryRequest;
        $request->setStartDate($period->startDate->toDateString());
        $request->setEndDate($period->endDate->toDateString());
        $request->setSearchType($searchType);
        $request->setDimensions($dimensions);
        $request->setDataState($dataState);
        $request->setAggregationType($aggregationType);
        $request = $this->applyFilters($request, $filters);

        return $this->client->performQuery($siteUrl, $rows, $request);
    }

    /**
     * @throws Exception
     */
    public function indexUrl(string $url): UrlNotificationMetadata
    {
        $request = new Google_Service_Indexing_UrlNotification;
        $request->setUrl($url);
        $request->setType('URL_UPDATED');

        return $this->client->getIndexingService()->urlNotifications->publish($request)->getUrlNotificationMetadata();
    }

    /**
     * @throws Exception
     */
    public function getIndexStatus(string $url, string $type = 'URL_UPDATED'): UrlNotificationMetadata
    {
        $request = new Google_Service_Indexing_UrlNotificationMetadata;
        $request->setUrl($url);

        return $this->client->getIndexingService()->urlNotifications->getMetadata(['url' => $request->getUrl()]);
    }

    /**
     * @throws Exception
     */
    public function removeIndexedUrl(string $url): UrlNotificationMetadata
    {
        $request = new Google_Service_Indexing_UrlNotification;
        $request->setUrl($url);
        $request->setType('URL_DELETED');

        return $this->client->getIndexingService()->urlNotifications->publish($request)->getUrlNotificationMetadata();
    }

    public function batchIndex(array $urls): ?array
    {
        $urlMap = collect($urls)->map(function ($url) {
            $request = new Google_Service_Indexing_UrlNotification;
            $request->setUrl($url);
            $request->setType('URL_UPDATED');

            return $request;
        });

        $batch = $this->client->getIndexingService()->createBatch();

        $urlMap->each(fn ($request) => $batch->add($request));

        return $batch->execute();
    }

    public function batchRemove(array $urls): ?array
    {
        $urlMap = collect($urls)->map(function ($url) {
            $request = new Google_Service_Indexing_UrlNotification;
            $request->setUrl($url);
            $request->setType('URL_DELETED');

            return $request;
        });

        $batch = $this->client->getIndexingService()->createBatch();

        $urlMap->each(fn ($request) => $batch->add($request));

        return $batch->execute();
    }

    public function isAccessTokenExpired()
    {
        $googleClient = $this->client->getGoogleClient();

        $newToken = $googleClient->fetchAccessTokenWithRefreshToken();

        if (isset($newToken['error'])) {
            return true;
        }

        $googleClient->setAccessToken($newToken);

        return $googleClient->isAccessTokenExpired();
    }

    /*
     * Get the underlying Google_Service_Webmasters object. You can use this
     * to basically call anything on the Google Search Console API.
     */
    public function getWebmastersService(): Google_Service_Webmasters
    {
        return $this->client->getWebmastersService();
    }

    public function getIndexingService(): Google_Service_Indexing
    {
        return $this->client->getIndexingService();
    }

    private function applyFilters(Google_Service_Webmasters_SearchAnalyticsQueryRequest $request, $filters)
    {
        $filterArray = [];
        foreach ($filters as $filterItem) {
            if (strlen($filterItem['expression']) === 0) {
                continue;
            }
            $filter = new Google_Service_Webmasters_ApiDimensionFilter;
            $filter->setDimension($filterItem['dimension']);
            $filter->setOperator($filterItem['operator']);
            $filter->setExpression($filterItem['expression']);
            $filterArray[] = $filter;
        }

        if (count($filterArray)) {
            $filtergroup = new Google_Service_Webmasters_ApiDimensionFilterGroup;
            $filtergroup->setFilters($filterArray);
            $request->setDimensionFilterGroups([$filtergroup]);
        }

        return $request;
    }
}
