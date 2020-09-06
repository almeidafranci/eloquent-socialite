<?php

namespace AlmeidaFranci\EloquentSocialite\Facades;

use Illuminate\Support\Facades\Facade;

class EloquentSocialite extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'almeidafranci.eloquentsocialite';
    }
}
