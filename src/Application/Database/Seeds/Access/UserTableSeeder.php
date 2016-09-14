<?php
namespace Schweppesale\Module\Access\Application\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Schweppesale\Module\Access\Application\Services\Users\UserService;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;

class UserTableSeeder extends Seeder
{
    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserRepository $users, UserService $userService)
    {
        $this->users = $users;
        $this->userService = $userService;
    }

    public function run()
    {
//        if (env('DB_DRIVER') == 'mysql')
//            DB::table('users')->truncate();
//        elseif (env('DB_DRIVER') == 'sqlite')
//            DB::statement("DELETE FROM  users");
//        else //For PostgreSQL or anything else
//            DB::statement("TRUNCATE TABLE users");

        //Add the master administrator, user id of 1
        $this->userService->create('Admin Istrator', 'admin@admin.com', '1234', [], [], true, false, 1);
        $this->userService->create('Admin Istrator2', 'admin2@admin.com', '1234', [], [], true, false, 1);
        $this->userService->create('Admin Istrator3', 'admin3@admin.com', '1234', [], [], true, false, 1);

//        $users = [
//            [
//                'name' => ,
//                'company_id' => 1,
//                'email' => 'admin@admin.com',
//                'password' => bcrypt('1234'),
//                'confirmation_code' => md5(uniqid(mt_rand(), true)),
//                'confirmed' => true,
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now()
//            ],
//            [
//                'name' => 'Default User',
//                'company_id' => 1,
//                'email' => 'user@user.com',
//                'password' => bcrypt('1234'),
//                'confirmation_code' => md5(uniqid(mt_rand(), true)),
//                'confirmed' => true,
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now()
//            ],
//            [
//                'name' => 'John Tripi',
//                'company_id' => 1,
//                'email' => 'jrt@alexanderinteractive.com',
//                'password' => bcrypt('crash12'),
//                'confirmation_code' => md5(uniqid(mt_rand(), true)),
//                'confirmed' => true,
//                'created_at' => Carbon::now(),
//                'updated_at' => Carbon::now()
//            ]
//        ];
//
//        DB::table('users')->insert($users);
    }
}
