<?php
namespace Schweppesale\Module\Access\Application\Database\Seeders\Access;

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{

    /**
     * @var \Schweppesale\Module\Access\Application\Services\Roles\RoleService
     */
    private $roleService;

    /**
     * RoleTableSeeder constructor.
     *
     * @param \Schweppesale\Module\Access\Application\Services\Roles\RoleService $roleService
     */
    public function __construct(\Schweppesale\Module\Access\Application\Services\Roles\RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function run()
    {
//        if (env('DB_DRIVER') == 'mysql')
//            DB::table('roles')->truncate();
//        elseif (env('DB_DRIVER') == 'sqlite')
//            DB::statement("DELETE FROM " . 'roles');
//        else //For PostgreSQL or anything else
//            DB::statement("TRUNCATE TABLE " . 'roles' . " CASCADE");

        $this->roleService->create(['name' => 'Administrator', 'sort' => 1, 'associated-permissions' => 'all']);
        $this->roleService->create(['name' => 'User', 'sort' => 2]);
        $this->roleService->create(['name' => 'Client', 'sort' => 3]);
    }
}
