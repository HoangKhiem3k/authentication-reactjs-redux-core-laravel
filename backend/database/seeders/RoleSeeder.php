<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $roles = [
      [
        'id' => 1,
        'role_name' => 'admin',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 2,
        'role_name' => 'dac_member',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 3,
        'role_name' => 'advertiser',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]
    ];

    foreach ($roles as $role) {
      Role::create($role);
    }
  }
}
