<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Role;

class RollPermission {
    public function handle( $request, Closure $next, $permission, $guard = null ) {
        $authGuard = app( 'auth' )->guard( $guard );
        if ( $authGuard->guest() ) {
            throw UnauthorizedException::notLoggedIn();
        }
        $permissions  = is_array( $permission ) ? $permission : explode( '|', $permission );
        $user_company = $authGuard->user()->companies()->where( 'active_company', 1 )->first();
        $role         = Role::query()->find( $user_company->pivot->role_id );
        if ( $role->name === 'admin' ) {
            return $next( $request );
        }
        $role_permissions = $role->permissions->pluck( 'name' )->toArray();
        if ( ! empty( array_intersect( $permissions, $role_permissions ) ) ) {
            return $next( $request );
        }
        throw UnauthorizedException::forPermissions( $permissions );
    }
}
