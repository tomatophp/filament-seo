<?php

namespace TomatoPHP\FilamentSeo\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function credentialsJsonDoesNotExist($path)
    {
        return new static("Could not find a credentials file at `{$path}`.");
    }
}
