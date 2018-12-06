<?php

namespace DanielDeWit\NovaSingleRecordResource\Contracts;

interface SingleRecordResourceInterface
{
    public static function singleRecord(): bool;

    public static function firstRecordId(): int;
}
