<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyUser;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder {
	public function run() {
		$permissions = Permission::query()->get();
		Role::query()->insert(
			[
				['name' => 'super admin', 'guard_name' => 'web'],
				['name' => 'admin', 'guard_name' => 'web']
			]
		);

		$roles = Role::query()->get();
		$companies = Company::query()->get();
		foreach ($roles as $role) {
            $role->syncPermissions($permissions);
			foreach ($companies as $company) {
				$company->assignRole($role);
			}
		}
		CompanyUser::query()->where('company_id', 1)->where('user_id', 1)->update([ 'role_id' => 1 ]);
	}
}
