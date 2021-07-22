<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_gastos', function (Blueprint $table) {
            $table->id();
            $table->integer('campaign_month_id');
            $table->integer('talent_id');
            $table->integer('dealer_id')->default(0);
            $table->integer('influencer_id')->default(0);
            $table->string('concepto');
            $table->string('comentarios')->nullable();
            $table->float('gasto', 11, 2);
            $table->integer("status")->default(1); //status 1 = activo, 2 = asignado
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
        Schema::dropIfExists('campaign_gastos');
    }
}
