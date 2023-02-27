<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder {
    public function run() {
        $permissions = [
            [
                "name"       => "view.user",
                "guard_name" => "web",
            ],
            [
                "name"       => "create.user",
                "guard_name" => "web",
            ],
            [
                "name"       => "update.user",
                "guard_name" => "web",
            ],
            [
                "name"       => "delete.user",
                "guard_name" => "web",
            ],
            [
                "name"       => "view.role",
                "guard_name" => "web",
            ],
            [
                "name"       => "create.role",
                "guard_name" => "web",
            ],
            [
                "name"       => "update.role",
                "guard_name" => "web",
            ],
            [
                "name"       => "delete.role",
                "guard_name" => "web",
            ],
            [
                "name"       => "view.client",
                "guard_name" => "web",
            ],
            [
                "name"       => "create.client",
                "guard_name" => "web",
            ],
            [
                "name"       => "update.client",
                "guard_name" => "web",
            ],
            [
                "name"       => "delete.client",
                "guard_name" => "web",
            ],
        ];
        Permission::query()->insert( $permissions );
    }
}
