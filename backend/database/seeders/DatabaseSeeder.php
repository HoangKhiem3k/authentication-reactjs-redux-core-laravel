<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    // \App\Models\User::factory(1)->create();

    // \App\Models\User::factory()->create([
    //     'first_name' => 'Le',
    //     'last_name' => 'Le',
    //     'email' => 'test@example.com',
    //     'password' => 'test@example.com',
    // ]);
    $this->call([
      UserSeeder::class,
      RoleSeeder::class,
      RoleUserSeeder::class,
    ]);
    // User::factory(3)->create();
    // $roles = ['admin', 'dac_member', 'advertiser'];
    // foreach ($roles as $role) {
    //   Role::create(['role_name' => $role]);
    // }
    // foreach (User::all() as $user) {
    //   foreach (Role::all() as $role) {
    //     $user->roles()->attach($role->id);
    //   }
    // }
  }
}
