<?php

use App\Models\Campaign;
use Illuminate\Database\Seeder;

class CampaignsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 20; $i++) {
            Campaign::create([
                'client_id'             => 1,
                'name'                  => "Campania $i",
                'agencia'               => "Agencia $i",
                'advertiser_id'         => "$i",
                'month_start'           => "2021-07-22",
                'month_end'             => "2021-12-01",
                'total_months'          => "7",
                'extraprima_agencia'    => "0%",
                "ingresos"              => "150000",
                "ppto_gastos"           => "50000",
                "margen"                => "20",
            ]);
        }
    }
}
