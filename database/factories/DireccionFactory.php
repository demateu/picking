<?php

namespace Database\Factories;

use App\Models\Direccion;
use Illuminate\Database\Eloquent\Factories\Factory;


class DireccionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Direccion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->name(),
            'direccion' => $this->faker->address,
            'pais' => $this->faker->country,//deberia de estar en una tabla aparte pero lo pongo aqui por simplicidad
            'telefono' => $this->faker->numberBetween(600000000, 699999999),
        ];
    }
}
