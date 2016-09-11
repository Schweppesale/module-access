<?php namespace Step\Access\Application\Database\Seeders;

use Step\Access\Application\Database\Seeders\Access\OrganisationTableSeeder;
use Step\Access\Application\Database\Seeders\Access\PermissionDependencyTableSeeder;
use Step\Access\Application\Database\Seeders\Access\PermissionGroupTableSeeder;
use Step\Access\Application\Database\Seeders\Access\PermissionTableSeeder;
use Step\Access\Application\Database\Seeders\Access\RoleTableSeeder;
use Step\Access\Application\Database\Seeders\Access\UserRoleSeeder;
use Step\Access\Application\Database\Seeders\Access\UserTableSeeder;
use Illuminate\Database\Seeder;

class AccessTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (env('DB_DRIVER') == 'mysql')
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(UserTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(PermissionGroupTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(PermissionDependencyTableSeeder::class);
        $this->call(OrganisationTableSeeder::class);

        if (env('DB_DRIVER') == 'mysql')
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}