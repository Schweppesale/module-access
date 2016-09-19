<?php
namespace Schweppesale\Module\Access\Application\Database\Seeds\Access;

use Illuminate\Database\Seeder;
use Schweppesale\Module\Access\Application\Services\Roles\RoleService;

class RoleTableSeeder extends Seeder
{

    /**
     * @var RoleService
     */
    private $roleService;

    /**
     * RoleTableSeeder constructor.
     *
     * @param RoleService $roleService
     */
    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function run()
    {
        $this->roleService->create(['name' => 'Administrator', 'permissions' => range(1, 17), 'sort' => 1]);
        $this->roleService->create(['name' => 'User', 'sort' => 2]);
        $this->roleService->create(['name' => 'Client', 'sort' => 3]);
    }
}
