<?php

namespace TomatoPHP\FilamentSeo\Jobs;

use Google\Service\Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use TomatoPHP\FilamentSeo\Facades\FilamentSeo;

class GoogleIndexURLJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ?string $url=null,
        public ?string $client='service_account'
    )
    {
        //
    }


    /**
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        FilamentSeo::google($this->client)->indexUrl($this->url);
    }
}
