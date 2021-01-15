<?php

namespace App\Helpers;

use Request;

class Helper
{
    public static function getActivClass(string $linkRouteNane): string
    {
        $currentRouteName = Request::route()->getName();
        return $currentRouteName == $linkRouteNane ? 'active' : '';
    }
}
