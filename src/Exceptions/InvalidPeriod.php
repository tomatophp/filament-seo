<?php

namespace TomatoPHP\FilamentSeo\Exceptions;

use DateTime;
use Exception;

class InvalidPeriod extends Exception
{
    public static function startDateCannotBeAfterEndDate(DateTime $startDate, DateTime $endDate): self
    {
        return new self("Start date `{$startDate->format('Y-m-d')}` cannot be after end date `{$endDate->format('Y-m-d')}`.");
    }
}
