<?php
namespace Schweppesale\Module\Access\Application\Database\Seeds\Access;

use Illuminate\Database\Seeder;
use Schweppesale\Module\Access\Application\Services\Permissions\GroupService;

class GroupTableSeeder extends Seeder
{

    /**
     * @var GroupService
     */
    private $groupService;

    /**
     * GroupTableSeeder constructor.
     * @param GroupService $groupService
     */
    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function run()
    {
        /**
         * Create the Access groups
         */
        $access = $this->groupService->create('Access', true, null, 1);
        $this->groupService->create('User', true, $access->getId(), 2);
        $this->groupService->create('Role', true, $access->getId(), 3);
        $this->groupService->create('Permission', true, $access->getId(), 4);
    }
}
