<?php

namespace DanielDeWit\NovaSingleRecordResource\Traits;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Laravel\Nova\Authorizable;

trait SupportSingleRecordNavigationLinks
{
    use Authorizable;
    
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
    
    /**
     * Overridding Authorizable to prevent user from viewing the wrong database row
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $ability
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeTo(Request $request, $ability)
    {
        if (static::singleRecord()) {
            throw_unless(((int) $request->route('resourceId') === (int) static::singleRecordId()), AuthorizationException::class);
        }
        parent::authorizeTo($request, $ability);
    }
}
