<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->unique();
            $table->string('nickname')->unique();
            $table->integer('level')->unsigned()->default(1);
            $table->integer('xp')->unsigned()->default(0);
            
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('profiles')->insert(
            array(
                'user_id' => 1,
                'nickname' => 'Admin',
                'level' => 1,
                'xp' => 0,
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
