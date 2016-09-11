<?php
namespace Step\Access\Application\Database\Seeders\Access;

use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{

    public function run()
    {

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        if (env('DB_DRIVER') == 'mysql')
            DB::table(config('auth.table'))->truncate();
        elseif (env('DB_DRIVER') == 'sqlite')
            DB::statement("DELETE FROM " . config('auth.table'));
        else //For PostgreSQL or anything else
            DB::statement("TRUNCATE TABLE " . config('auth.table') . " CASCADE");

        //Add the master administrator, user id of 1
        $users = [
            [
                'name' => 'Admin Istrator',
                'company_id' => 1,
                'email' => 'admin@admin.com',
                'password' => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Default User',
                'company_id' => 1,
                'email' => 'user@user.com',
                'password' => bcrypt('1234'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'John Tripi',
                'company_id' => 1,
                'email' => 'jrt@alexanderinteractive.com',
                'password' => bcrypt('crash12'),
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table(config('auth.table'))->insert($users);

        if (env('DB_DRIVER') == 'mysql')
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
