<?php

namespace Database\Factories\Tall\Tenant\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
        /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Tall\Tenant\Models\Tenant::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           "status_id"=>\Tall\Form\Models\Status::all()->random()->id
        ];
    }
}
