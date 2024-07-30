<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImagesToParametersTable extends Migration
{
    public function up()
    {
        Schema::table('parameters', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->string('icon_gray')->nullable();
        });
    }

    public function down()
    {
        Schema::table('parameters', function (Blueprint $table) {
            $table->dropColumn(['icon', 'icon_gray']);
        });
    }
}
