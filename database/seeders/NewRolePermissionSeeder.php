<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class NewRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'session-view-own','display_name' => 'View Own Session'],
            ['name' => 'session-view-all','display_name' => 'View All Session']
        ];
        $adminRoleId = DB::table('roles')->where('system_name', '=', 'admin')->first()->id;
        foreach ($permissions as $permission) {
            $permissionId = DB::table('role_permissions')->insertGetId([
                'name' => $permission['name'],
                'display_name' => $permission['display_name'],
                'created_at'   => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at'   => \Carbon\Carbon::now()->toDateTimeString(),
            ]);
            DB::table('permission_role')->insert([
                    'role_id'       => $adminRoleId,
                    'permission_id' => $permissionId,
                ]);
        }
    }
}
