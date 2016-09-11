<?php
namespace Schweppesale\Access\Application\Database\Seeders\Access;

use Schweppesale\Access\Domain\Repositories\RoleRepository;
use Schweppesale\Access\Domain\Repositories\UserRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql')
            DB::table(config('access.assigned_roles_table'))->truncate();
        elseif (env('DB_DRIVER') == 'sqlite')
            DB::statement("DELETE FROM " . config('access.assigned_roles_table'));
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('access.assigned_roles_table') . " CASCADE");

        //Attach admin role to admin user
        $users = $this->users->fetchAll();
        $roles = $this->roles->fetchAll();

        $users[0]->setRoles([$roles[0]]);
        $users[1]->setRoles([$roles[1]]);
        $users[2]->setRoles([$roles[0]]);

        for ($i = 0; $i <= 2; $i++) {
            $this->users->save($users[$i]);
        }

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
