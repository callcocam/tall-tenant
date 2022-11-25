<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \Tall\Theme\Models\Status::query()->forceDelete();
        \Tall\Theme\Models\Status::factory()->create([
            'name'=>'Published'
        ]);
        \Tall\Theme\Models\Status::factory()->create([
            'name'=>'Draft'
        ]);
     
        $connection = config("tenant.database.connections.tenants","tenants");

        \Tall\Tenant\Models\Tenant::factory()->create([
            'database'=>$connection,
            'prefix'=>'admin',
            'middleware'=>$connection,
            'provider'=>$connection,
        ]);

    }
}
