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
        $host = \Illuminate\Support\Str::replace("www.",'',request()->getHost());
     
        \Tall\Tenant\Models\Tenant::factory()->create([
            'name'=> 'Base',
            'domain'=> $host,
            'database'=>env("DB_DATABASE","landlord"),
            'prefix'=>'admin',
            'middleware'=>'landlord',
            'provider'=>'mysql',
        ]);

    }
}
