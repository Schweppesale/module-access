<?php
namespace Schweppesale\Module\Access\Application\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Schweppesale\Module\Access\Application\Services\Users\UserService;

class UserTableSeeder extends Seeder
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserTableSeeder constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function run()
    {
        $this->userService->create('Admin Istrator', 'admin@admin.com', '1234', ['1'], range(1, 17), true, false, 1);
        $this->userService->create('Test User', 'user@yahoo.com', '1234', ['2'], [], true, false, 1);
    }
}
