<?php

use App\Models\Dealer;
use Illuminate\Database\Seeder;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dataToInsert = [
            [" N/A"," N/A","",""],
            ["400001","THE STORY LAB SPAIN S.L.U.","B87050472","400001"],
            ["400003","YOUPLANET, S.L.","B95815783","400003"],
            ["400004","MONTCARRAL S.A.","A80286909","400004"],
            ["400005","TOPE DE GAMA, S.L.","B66705591","400005"]
        ];

        foreach ($dataToInsert as $key => $dataItem) {
            try {
                Dealer::create([
                    'dealer_code'       => $dataItem[0],
                    'business_name'     => $dataItem[1],
                    'CifDni'            => $dataItem[2],
                    'contable_code'     => $dataItem[3]
                ]);
            } catch (\Throwable $th) {
                throw $th;
            }

        }
    }
}
