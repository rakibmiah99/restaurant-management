<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $permissions = Lang::get('permission', [], 'en');
        $user = User::first();
        $role = Role::firstOrCreate(['name' => 'system-admin']);
        foreach ($permissions as $group=>$item){
            $groupName = $group.".name";
            $actions = array_keys($item['actions']);

            foreach ($actions as $actionName){
                $permissionName = $group.".actions.".$actionName;
                $data = [
                    'group_name' => $groupName,
                    'name' => $permissionName
                ];
                $permission = Permission::create($data);
                $role->givePermissionTo($permission);
                $permission->assignRole($role);
            }
        }


        $user->syncRoles($role);


    }
}
