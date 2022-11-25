<?php

namespace Database\Factories\Tall\Tenant\Models\Tenant;

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
            'name'=> fake()->company(),
            'domain'=> fake()->domainName(),
            "status_id"=>\Tall\Theme\Models\Status::all()->random()->id
        ];
    }
}
