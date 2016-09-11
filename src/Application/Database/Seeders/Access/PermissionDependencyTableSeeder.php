<?php
namespace Schweppesale\Access\Application\Database\Seeders\Access;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionDependencyTableSeeder
 */
class PermissionDependencyTableSeeder extends Seeder
{

    /**
     * @var \Modules\Peggy\Services\Projects\PermissionService
     */
    private $projectService;

    /**
     * @var \Schweppesale\Access\Application\Services\Permissions\PermissionGroupService
     */
    private $permissionGroupService;

    /**
     * PermissionGroupTableSeeder constructor.
     *
     * @param \Modules\Peggy\Services\Projects\PermissionService $permissionService
     */
    public function __construct(\Modules\Peggy\Services\Projects\PermissionService $projectService, \Schweppesale\Access\Application\Services\Permissions\PermissionGroupService $permissionGroupService)
    {
        $this->projectService = $projectService;
        $this->permissionGroupService = $permissionGroupService;
    }

    /**
     *
     */
    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql') {
            DB::table(config('access.permission_dependencies_table'))->truncate();
        } elseif (env('DB_DRIVER') == 'sqlite') {
            DB::statement("DELETE FROM " . config('access.permission_dependencies_table'));
        } else { //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('access.permission_dependencies_table') . " CASCADE");
        }

        //View access management needs view backend
        DB::table(config('access.permission_dependencies_table'))->insert([
            'permission_id' => 2,
            'dependency_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        //All of the access permissions need view access management and view backend
        for ($i = 3; $i <= 17; $i++) {
            DB::table(config('access.permission_dependencies_table'))->insert([
                'permission_id' => $i,
                'dependency_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            DB::table(config('access.permission_dependencies_table'))->insert([
                'permission_id' => $i,
                'dependency_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }


        //All of the access permissions need view access management and view backend
        for ($i = 19; $i <= 23; $i++) {
            DB::table(config('access.permission_dependencies_table'))->insert([
                'permission_id' => $i,
                'dependency_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        /**
         * Project Permissions
         */

        $this->permissionGroupService->create('Projects', 1);
        $this->projectService->create(12731);

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
