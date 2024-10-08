<?php

namespace TomatoPHP\FilamentSeo\Services;
use Carbon\Carbon;
use TomatoPHP\FilamentSeo\Exceptions\InvalidPeriod;

class Period
{
    /** @var Carbon */
    public $startDate;

    /** @var Carbon */
    public $endDate;

    public static function create(Carbon $startDate, Carbon $endDate): self
    {
        return new static($startDate, $endDate);
    }

    public function __construct(Carbon $startDate, Carbon $endDate)
    {
        if ($startDate > $endDate) {
            throw InvalidPeriod::startDateCannotBeAfterEndDate($startDate, $endDate);
        }

        $this->startDate = $startDate;

        $this->endDate = $endDate;
    }
}
