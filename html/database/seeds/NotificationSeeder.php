<?php

use Illuminate\Database\Seeder;
use App\Models\{Campaign,Notification,Alert};
class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notification::query()->delete();
        $notifications = [
            [
                'name' => 'Cuando se crea una campaña',
                'class' => Campaign::class,
                'method' => 'store',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cuando se elimina una campaña',
                'class' => Campaign::class,
                'method' => 'destroy',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cuando se cierra una campaña',
                'class' => Campaign::class,
                'method' => 'marcarCerrada',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cuando se sube una factura a una campaña',
                'class' => Campaign::class,
                'method' => 'saveInfo',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => "Cuando se cree un aviso para talentos",
                'class' => Alert::class,
                'method' => 'store',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => "Cuando vaya a vencer un aviso para talentos ",
                'class' => Alert::class,
                'method' => 'expiringAlert',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        Notification::query()->insert($notifications);
    }
}
