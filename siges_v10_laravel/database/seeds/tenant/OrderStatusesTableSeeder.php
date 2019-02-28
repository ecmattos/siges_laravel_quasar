<?php

use Illuminate\Database\Seeder;

class OrderStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $order_statuses =
        [
            [
                'code'        => 'ORC',
                'description' => 'Orçamento'
            ],
            [
                'code'        => 'AGU',
                'description' => 'Aguardando'
            ],
            [
                'code'        => 'AUT',
                'description' => 'Autorizado'
            ]
        ];
    
        foreach ($order_statuses as $order_status)
        {
            \App\Entities\OrderStatus::create($order_status);
        }
    }
}

