<?php

namespace PiruPius\Skeleton;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PiruPius\Skeleton\Skeleton
 */
class SkeletonFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'skeleton';
    }
}
