<?php

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = [
            ["430000","THE STORY LAB SPAIN, S.L.U.","THE STORY LAB SPAIN, S.L.U."],
            ["430001","ARENA MEDIA COMUNICATIONS ESPAÑA, S","ARENA MEDIA COMUNICATIONS ESPAÑA, S"],
            ["430002","HAVAS MEDIA GROUP LEVANTE S.L.U","HAVAS MEDIA GROUP LEVANTE S.L.U"],
            ["430003","HAVAS MEDIA GROUP SPAIN SA ","HAVAS MEDIA GROUP SPAIN SA "],
            ["430004","PROXIMIA HAVAS, S.L.","PROXIMIA HAVAS, S.L."],
            ["430005","YMEDIA VIZEUM & WINK, S.A.","INTELIGENCIA Y MEDIA, S.A."],
            ["430006","PUBLICIS MEDIA SPAIN S.L.U  ","PUBLICIS MEDIA SPAIN S.L.U  "],
            ["430007","CARAT ESPAÑA, S.A.U.","CARAT ESPAÑA, S.A.U."]
        ];

        foreach ($clients as $key => $client) {
            Client::create([
                'client_code'   => $client[0],
                'business_name' => $client[1],
                'fiscal_name'   => $client[2],
            ]);
        }
    }
}
