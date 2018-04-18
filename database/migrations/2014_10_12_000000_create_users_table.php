<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rule_id')->unsigned()->nullable()->default(null);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('instagram_user_id')->nullable()->default(null);
            $table->string('instagram_access_token')->nullable()->default(null);
            $table->string('instagram_username')->nullable()->default(null);
            $table->text('instagram_profile_picture')->nullable()->default(null);
            $table->string('instagram_full_name')->nullable()->default(null);
            $table->longText('instagram_bio')->nullable()->default(null);
            $table->string('instagram_website')->nullable()->default(null);
            $table->boolean('instagram_is_business')->nullable()->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
