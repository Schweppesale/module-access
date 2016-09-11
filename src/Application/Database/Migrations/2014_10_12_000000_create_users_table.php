<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_metadata', function (Blueprint $table) {
            $table->dropForeign('project_metadata_contact_user_id_foreign');
        });

        Schema::drop('users');
        Schema::drop('companies');
        Schema::drop('project_metadata');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('companies', function (Blueprint $table) {
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
            $table->string('company_id')->nullable();
            $table->string('email')->unique();
            $table->string('password', 60)->nullable();
            $table->string('confirmation_code');
            $table->boolean('confirmed')->default(config('access.users.confirm_email') ? false : true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('project_metadata', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('contact_user_id')->nullable();
            $table->foreign('contact_user_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
            $table->unique('project_id');
        });
    }
}
