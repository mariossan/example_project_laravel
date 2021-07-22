<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraDataToCampaignMonths extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_months', function (Blueprint $table) {
            $table->float('ingreso_real', 11, 2)->after('ingreso')->default(0);
            $table->float('gasto_real', 11, 2)->after('presupuesto')->default(0);
            $table->float('exceso_ppto_gato', 11, 2)->after('gasto_real')->default(0);
            $table->float('importe_adicional_a_provisionar', 11, 2)->after('exceso_ppto_gato')->default(0);
            $table->float('prov_acum2', 11, 2)->after('importe_adicional_a_provisionar')->default(0);
            $table->float('aux1', 11, 2)->after('prov_acum2')->default(0);
            $table->float('margen_recalculo', 11, 2)->after('aux1')->default(0);
            $table->float('gasto_ajustado', 11, 2)->after('margen_recalculo')->default(0);
            $table->float('resultado_real', 11, 2)->after('gasto_ajustado')->default(0);
            $table->float('check_margen_real', 11, 2)->after('resultado_real')->default(0);

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
