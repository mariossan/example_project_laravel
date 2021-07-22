<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeInfluencerIdColumnTableCampaignGastos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_gastos', function (Blueprint $table) {
            $table->string('influencer_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_gastos', function (Blueprint $table) {
            $table->integer('influencer_id')->default(0)->change();
        });
    }
}
