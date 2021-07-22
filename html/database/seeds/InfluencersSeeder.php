<?php

use App\Models\Influencer;
use Illuminate\Database\Seeder;

class InfluencersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $influencers = [
            [" N/A","",""],
            ["Neno","& Family","nenofamily"],
            ["Karina","& Marina","karina_dancer"],
            ["Rayas y Manchas (Alba)","(Rayas y manchas)","rayasymanchas"],
            ["Sergio","Abad","sergio_abad_"],
            ["María","Abajo","maria.abajo"],
            ["Victor","Abarca","victorabarca"]
        ];

        foreach ($influencers as $key => $influencer) {
            try {
                Influencer::create([
                    'name'      => $influencer[0],
                    'lastname'  => $influencer[1],
                    'nickname'  => $influencer[2]
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }

        }


    }
}
