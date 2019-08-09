<?php

namespace Sarfraznawaz2005\SSE\Facades;

use Illuminate\Support\Facades\Facade;

class SSEFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'SSE';
    }
}
