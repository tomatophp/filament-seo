<?php

namespace TomatoPHP\FilamentSeo\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function credentialsJsonDoesNotExist($path): self
    {
        return new self("Could not find a credentials file at `{$path}`.");
    }
}
