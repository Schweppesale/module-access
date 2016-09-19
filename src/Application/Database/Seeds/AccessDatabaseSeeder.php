<?php namespace Schweppesale\Module\Access\Application\Database\Seeds;

use Illuminate\Database\Seeder;
use Schweppesale\Module\Access\Application\Database\Seeds\Access\GroupTableSeeder;
use Schweppesale\Module\Access\Application\Database\Seeds\Access\OrganisationTableSeeder;
use Schweppesale\Module\Access\Application\Database\Seeds\Access\PermissionTableSeeder;
use Schweppesale\Module\Access\Application\Database\Seeds\Access\RoleTableSeeder;
use Schweppesale\Module\Access\Application\Database\Seeds\Access\UserTableSeeder;

class AccessDatabaseSeeder extends Seeder
{

    /**
     * Run the Database Seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(OrganisationTableSeeder::class);
    }
}