<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Models\Role;

class BaseController extends Controller
{
	 protected string $user_role;
	 protected bool $isOwner = false;
	 protected array $permissions = [];
	 
	 public function __construct()
	 {
			$this->middleware( function ($request, $next) {
				 if ( Auth::check() ) {
						$user            = Auth::user();
						$company         = $user->companies()->first();
						$this->isOwner   = $user->id === $company->owner_id;
						$this->user_role = $user->getUserRole( $user->id, $company->id );
						$role            = Role::query()->with( 'permissions', function ($query) {
							 return $query->get( [ 'name' ] );
						} )->where( 'name', $this->user_role )->first();
						if ( $role ) {
							 $this->permissions = $role->permissions->map( function ($permission) {
									return $permission->name;
							 } )->toArray();
						}
				 }
				 View::share( [
					 'user_role'   => $this->user_role ?? '',
					 'is_owner'    => $this->isOwner,
					 'permissions' => $this->permissions,
				 ] );
				 
				 return $next( $request );
			} );
	 }
}
