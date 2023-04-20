<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $role_users = [
      [
        'user_id' => 1,
        'role_id' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'user_id' => 1,
        'role_id' => 2,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'user_id' => 1,
        'role_id' => 3,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'user_id' => 2,
        'role_id' => 2,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'user_id' => 3,
        'role_id' => 3,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]
    ];

    foreach ($role_users as $role_user) {
      RoleUser::create($role_user);
    }
  }
}
