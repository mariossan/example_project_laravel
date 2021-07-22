<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignBillMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_bill_months', function (Blueprint $table) {
            $table->id();
            $table->integer('campaign_month_id');
            $table->integer('user_id');
            $table->integer('dealer_id');
            $table->string('file');
            $table->string('no_factura');
            $table->float('importe_bruto', 11,2);
            $table->float('importe_neto', 11,2);
            $table->boolean('ok_pago')->default(1);
            $table->integer('condiciones_pago');
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
        Schema::dropIfExists('campaign_bill_months');
    }
}
