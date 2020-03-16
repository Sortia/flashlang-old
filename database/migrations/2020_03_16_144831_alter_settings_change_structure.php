<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSettingsChangeStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('settings');

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->after('id');
            $table->string('description')->after('name');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('settings');

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('value');
            $table->bigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
