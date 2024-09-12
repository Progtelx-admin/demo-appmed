<?php

use App\Models\Branch;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserBranch;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate(); 
        Role::truncate(); 
        RolePermission::truncate(); 
        UserRole::truncate(); 

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@progtelx.com',
            'password' => bcrypt('123456'),
            'token' => \Str::random(32),
            'point_of_sale_id' => 1, 
        ]);

        $role = Role::create([
            'name' => 'Super admin',
        ]);

        $permissions = Permission::all();
        foreach ($permissions as $permission) {
            RolePermission::create([
                'role_id' => $role->id,
                'permission_id' => $permission->id,
            ]);
        }

        UserRole::create([
            'role_id' => $role->id,
            'user_id' => $user->id,
        ]);

        $branches = Branch::all();
        foreach ($branches as $branch) {
            UserBranch::create([
                'branch_id' => $branch->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
