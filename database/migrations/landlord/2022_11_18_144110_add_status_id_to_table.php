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
        $statuses = SchemaSchema::tables(
            [
                'statuses',
                'menu_menu_sub',
                'team_user',
                'role_user',
                'permission_user',
                'permission_role',
                'migrations',
                'menu_sub_tenant'
        ]);

        
        foreach($statuses as $status){
            $name = data_get($status,'name');
            Schema::table($name, function (Blueprint $table) use($name) {
                if (!Schema::hasColumn($name, "status_id")) {
                   $table->foreignUuid('status_id')->nullable()->constrained('statuses')->cascadeOnDelete();
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
