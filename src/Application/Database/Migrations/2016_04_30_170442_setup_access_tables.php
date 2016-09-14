<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetupAccessTables extends Migration
{

    /**
     * Run the Migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unique('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('logo_image_id')->nullable();
            $table->index('logo_image_id');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('Organisation_id')->nullable();
            $table->string('email')->unique();
            $table->string('password', 60)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->string('confirmation_code');
            $table->boolean('confirmed')->default(false);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('roles', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name')->unique();
            $table->boolean('all')->default(false);
            $table->smallInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('assigned_roles', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles');
        });

        Schema::create('permission_groups', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('parent_id')->nullable();
            $table->string('name')->unique();
            $table->boolean('system')->default(false);
            $table->smallInteger('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('permissions', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('group_id')->unsigned()->nullable();
            $table->string('name')->unique();
            $table->string('display_name');
            $table->boolean('system')->default(false);
            $table->smallInteger('sort')->default(0);
            $table->timestamps();

            $table->foreign('group_id')
                ->references('id')
                ->on('permission_groups')
                ->onDelete('cascade');
        });

        Schema::create('permission_role', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
        });

        Schema::create('permission_dependencies', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->integer('dependency_id')->unsigned();

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('dependency_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('user_permissions', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the Migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assigned_roles', function (Blueprint $table) {
            $table->dropForeign('assigned_roles' . '_user_id_foreign');
            $table->dropForeign('assigned_roles' . '_role_id_foreign');
        });

        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropForeign('permission_role' . '_permission_id_foreign');
            $table->dropForeign('permission_role' . '_role_id_foreign');
        });

        Schema::table('user_permissions', function (Blueprint $table) {
            $table->dropForeign('user_permissions' . '_permission_id_foreign');
            $table->dropForeign('user_permissions' . '_user_id_foreign');
        });

        Schema::table('permission_dependencies', function (Blueprint $table) {
            $table->dropForeign('permission_dependencies_permission_id_foreign');
            $table->dropForeign('permission_dependencies_dependency_id_foreign');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign('permissions' . '_group_id_foreign');
        });

        Schema::drop('users');
        Schema::drop('organisations');
        Schema::drop('assigned_roles');
        Schema::drop('permission_role');
        Schema::drop('user_permissions');
        Schema::drop('permission_groups');
        Schema::drop('roles');
        Schema::drop('permissions');
        Schema::drop('permission_dependencies');
    }
}
