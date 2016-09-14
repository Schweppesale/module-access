<?php
namespace Schweppesale\Module\Access\Application\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Schweppesale\Module\Access\Domain\Repositories\RoleRepository;
use Schweppesale\Module\Access\Domain\Repositories\UserRepository;

class UserRoleSeeder extends Seeder
{

    /**
     * @var UserRepository
     */
    private $users;

    /**
     * @var RoleRepository
     */
    private $roles;

    /**
     * UserRoleSeeder constructor.
     *
     * @param UserRepository $users
     * @param RoleRepository $roles
     */
    public function __construct(UserRepository $users, RoleRepository $roles)
    {
        $this->users = $users;
        $this->roles = $roles;
    }

    public function run()
    {
//        if (env('DB_DRIVER') == 'mysql')
//            DB::table('assigned_roles')->truncate();
//        elseif (env('DB_DRIVER') == 'sqlite')
//            DB::statement("DELETE FROM " . 'assigned_roles');
//        else //For PostgreSQL or anything else
//            DB::statement("TRUNCATE TABLE " . 'assigned_roles' . " CASCADE");

        //Attach admin role to admin user
        $users = $this->users->fetchAll();
        $roles = $this->roles->fetchAll();

        $users[0]->setRoles([$roles[0]]);
        $users[1]->setRoles([$roles[1]]);
        $users[2]->setRoles([$roles[0]]);

        for ($i = 0; $i <= 2; $i++) {
            $this->users->save($users[$i]);
        }
    }
}
