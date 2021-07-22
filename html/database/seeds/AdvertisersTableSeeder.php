<?php

use App\Models\Advertiser;
use Illuminate\Database\Seeder;

class AdvertisersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertiser::create(['name' => "20TH CENTURY FOX / HISPANO FOXFILM"]);
        Advertiser::create(['name' => "8BELTS"]);
        Advertiser::create(['name' => "ÓPTICA DEL PENEDES"]);
        Advertiser::create(['name' => "ABANCA"]);
        Advertiser::create(['name' => "AC MARCA"]);
        Advertiser::create(['name' => "ACCIÓN CONTRA EL HAMBRE"]);
        Advertiser::create(['name' => "ACCIONA"]);
        Advertiser::create(['name' => "ACIERTO.COM"]);
        Advertiser::create(['name' => "ACTIVISION"]);
        Advertiser::create(['name' => "ADESLAS"]);
        Advertiser::create(['name' => "ADIDAS"]);
        Advertiser::create(['name' => "AEG"]);
        Advertiser::create(['name' => "AFFINITY"]);
    }
}
