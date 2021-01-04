<?php

namespace App\Helpers;

class Helper
{

    public static $errors;

    public static function getActivClass(string $linkRouteNane): string
    {
        $currentRouteName = \Request::route()->getName();
        return $currentRouteName == $linkRouteNane ? 'active' : '';
    }

    public static function setErrorsEnv(object $errors): void
    {
        self::$errors = $errors;
    }

    public static function getErrorClass(string $inputNane): ?string
    {
        return self::$errors->has($inputNane) ? ' is-invalid' : null;
    }
}


// . ($errors->has('status_id') ? ' is-invalid' : null)
