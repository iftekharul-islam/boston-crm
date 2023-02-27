<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = [
            [
                'name'     => 'Super Admin',
                'email'    => 'superadmin@boston.com',
                'password' => Hash::make( '123456' ),
            ],
        ];
        foreach ( $users as $user ) {
            $new_user = User::query()->create( $user );
            if ( $new_user ) {
                $company = Company::query()->create( [
                    'name'     => "Boston CRM " . $new_user->id,
                    'owner_id' => $new_user->id,
                ] );
                $new_user->companies()->attach( $company->id );
            }
        }
    }
}
