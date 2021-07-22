<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImporteFacturaToCampaignMonthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_months', function (Blueprint $table) {
            $table->float('importe', 11,2)->default(0)->after('check_margen_real');
            $table->string('factura')->default('')->after('importe');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_months', function (Blueprint $table) {
            //
        });
    }
}
