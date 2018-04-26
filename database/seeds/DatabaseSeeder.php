<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        // $this->call(RepositoriesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(FollowsTableSeeder::class);
        $this->call(StarsTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(VoyagerDatabaseSeeder::class);

        Model::reguard();
    }
}
