<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tall\Schema\Schema as SchemaSchema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tenants = SchemaSchema::tables(
            [
                'tenants',
                'menu_menu_sub',
                'team_user',
                'role_user',
                'permission_user',
                'permission_role',
                'migrations',
                'menu_sub_tenant'
        ]);

        
        foreach($tenants as $tenant){
            $name = data_get($tenant,'name');
            Schema::table($name, function (Blueprint $table) use($name) {
                if (!Schema::hasColumn($name, "tenant_id")) {
                   $table->foreignUuid('tenant_id')->after('id')->nullable()->constrained('tenants')->cascadeOnDelete();
                }     
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table', function (Blueprint $table) {
            //
        });
    }
};
