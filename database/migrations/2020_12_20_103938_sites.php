<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Sites extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('name',50);
            $table->string('domain',255 );
            $table->integer("site_id");
            $table->string("frontend_id",50);
            $table->string("frontend_url",255);
            $table->string("custom_domain",255)->nullable();
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
        //
        Schema::dropIfExists('sites');
    }
}
