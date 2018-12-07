<?php

namespace DanielDeWit\NovaSingleRecordResource\Traits;

trait SupportSingleRecordNavigationLinks
{
    public static function singleRecord(): bool
    {
        return false;
    }

    /**
     * @return string|int
     */
    public static function singleRecordId()
    {
        return 1;
    }
}
