<?php
namespace Schweppesale\Module\Access\Application\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Schweppesale\Module\Access\Application\Services\Permissions\PermissionGroupService;

class PermissionGroupTableSeeder extends Seeder
{

    /**
     * @var PermissionGroupService
     */
    private $permissionGroupService;

    /**
     * PermissionGroupTableSeeder constructor.
     * @param PermissionGroupService $permissionGroupService
     */
    public function __construct(PermissionGroupService $permissionGroupService)
    {
        $this->permissionGroupService = $permissionGroupService;
    }

    public function run()
    {
        /**
         * Create the Access groups
         */
        $access = $this->permissionGroupService->create('Access', true, null, 1);
        $this->permissionGroupService->create('User', true, $access->getId(), 2);
        $this->permissionGroupService->create('Role', true, $access->getId(), 3);
        $this->permissionGroupService->create('Permission', true, $access->getId(), 4);
    }
}
