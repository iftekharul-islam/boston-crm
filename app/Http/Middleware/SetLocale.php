<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class SetLocale {
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle( Request $request, Closure $next ): mixed {
        if ( session()->has( 'locale' ) ) {
            app()->setLocale( session()->get( 'locale' ) );
        }

        return $next( $request );
    }
}
