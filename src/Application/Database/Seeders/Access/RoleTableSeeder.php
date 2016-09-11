<?php
namespace Step\Access\Application\Database\Seeders\Access;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{

    /**
     * @var \Step\Access\Application\Services\Roles\RoleService
     */
    private $roleService;

    /**
     * RoleTableSeeder constructor.
     *
     * @param \Step\Access\Application\Services\Roles\RoleService $roleService
     */
    public function __construct(\Step\Access\Application\Services\Roles\RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql')
            DB::table(config('access.roles_table'))->truncate();
        elseif (env('DB_DRIVER') == 'sqlite')
            DB::statement("DELETE FROM " . config('access.roles_table'));
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('access.roles_table') . " CASCADE");

        $this->roleService->create(['name' => 'Administrator', 'sort' => 1, 'associated-permissions' => 'all']);
        $this->roleService->create(['name' => 'User', 'sort' => 2]);
        $this->roleService->create(['name' => 'Client', 'sort' => 3]);

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
