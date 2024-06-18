<?php

namespace Database\Seeders;

use App\Models\UserDetailEloquent;
use App\Models\UserEloquent;
use App\Models\UserHashedPasswordEloquent;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserEloquent::factory(10)->has(UserHashedPasswordEloquent::factory(1))->has(UserDetailEloquent::factory(1))->create();

        UserEloquent::factory(1)->has(UserHashedPasswordEloquent::factory(1)->state([
            'hashed_password' => '$2y$10$P/ds2511WmZRZlAf3.DZIu.EOubgcqxNpdO32ONQcO0R6fvlpvM0m',
        ]))->has(UserDetailEloquent::factory(1))->create();
    }
}
