<?php

namespace Database\Factories;

use App\Models\Pedido;
use Illuminate\Database\Eloquent\Factories\Factory;


class PedidoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pedido::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'estado_pedido' => $this->faker->randomElement(['pago aceptado', 'preparacion en proceso', 'pago rechazado', 'enviado']),
            'direccion_id' => $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-2 years', $endDate = 'now'),
        ];
    }
}
