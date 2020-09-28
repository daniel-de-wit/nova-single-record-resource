<?php

namespace Marko298\NovaSingleRecordResource\Contracts;

interface SingleRecordResourceInterface
{
    public static function singleRecord(): bool;

    /**
     * @return string|int
     */
    public static function singleRecordId();
}
