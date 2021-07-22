<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->integer("client_id");
            $table->string("agencia");
            $table->integer("advertiser_id");
            $table->string("name");
            $table->date("month_start");
            $table->date("month_end");
            $table->integer("total_months");
            $table->string("extraprima_agencia");
            // $table->integer("user_id"); // este es el producer ID

            $table->double("ingresos");
            $table->double("ppto_gastos");
            $table->double("margen");

            $table->boolean("status")->default(1);
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
        Schema::dropIfExists('campaigns');
    }
}
