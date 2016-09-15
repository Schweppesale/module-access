<?php namespace Schweppesale\Module\Access\Application\Database\Seeds;

use Illuminate\Database\Seeder;
use Schweppesale\Module\Access\Application\Database\Seeders\Access\OrganisationTableSeeder;
use Schweppesale\Module\Access\Application\Database\Seeders\Access\PermissionDependencyTableSeeder;
use Schweppesale\Module\Access\Application\Database\Seeders\Access\PermissionGroupTableSeeder;
use Schweppesale\Module\Access\Application\Database\Seeders\Access\PermissionTableSeeder;
use Schweppesale\Module\Access\Application\Database\Seeders\Access\RoleTableSeeder;
use Schweppesale\Module\Access\Application\Database\Seeders\Access\UserRoleSeeder;
use Schweppesale\Module\Access\Application\Database\Seeders\Access\UserTableSeeder;

class AccessDatabaseSeeder extends Seeder
{

    /**
     * Run the Database Seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(PermissionGroupTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(OrganisationTableSeeder::class);
    }
}