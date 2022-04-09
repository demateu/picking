<?php

namespace Database\Seeders;

use App\Models\Direccion;
use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Pedido;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Producto::factory(20)->create();

        Direccion::factory(10)->create();

        
        $pedidos = Pedido::factory(30)->create()
            ->each(function($pedido){
                $pedido->productos()->attach([
                    mt_rand(1, 10) => [
                    //'created_at' => $this->faker->birth_date,
                    'unidades' => mt_rand(1, 3),
                    'pedido_id' => mt_rand(1, 10),
                    'producto_id' => mt_rand(1, 20),
                    ]
                ]);
        });
        


    }
}
