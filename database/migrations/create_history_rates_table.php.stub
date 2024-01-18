<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('history_rates', function (Blueprint $table) {
            $table->id();
            $table->string('base');
            $table->string('filename');
            $table->string('filepath');
            $table->string('filedriver');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('history_rates');
    }
};
