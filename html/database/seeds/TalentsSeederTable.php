<?php

use App\Models\Talent;
use Illuminate\Database\Seeder;

class TalentsSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Talent::create(['name' => 'Talentos']);
        Talent::create(['name' => 'Producción Interna']);
        Talent::create(['name' => 'Producción Externa']);
    }
}
