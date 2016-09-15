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
        $this->roleService->create(['name' => 'Administrator', 'sort' => 1, 'associated-permissions' => 'all']);
        $this->roleService->create(['name' => 'User', 'sort' => 2]);
        $this->roleService->create(['name' => 'Client', 'sort' => 3]);
    }
}
