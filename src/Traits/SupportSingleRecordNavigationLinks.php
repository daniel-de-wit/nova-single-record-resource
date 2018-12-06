<?php

namespace DanielDeWit\NovaSingleRecordResource\Traits;

trait SupportSingleRecordNavigationLinks
{
    public static function singleRecord(): bool
    {
        return false;
    }

    public static function firstRecordId(): int
    {
        return 1;
    }
}
