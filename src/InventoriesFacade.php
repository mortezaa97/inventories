<?php

namespace Mortezaa97\Inventories;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mortezaa97\Inventories\Skeleton\SkeletonClass
 */
class InventoriesFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'inventories';
    }
}
