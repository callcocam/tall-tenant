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
        $users = SchemaSchema::tables(
            ['team_user',
            'users',
            'password_resets',
            'menu_menu_sub',
            'role_user',
            'permission_user',
            'permission_role',
            'migrations',
            'menu_sub_tenant'
        ]);

        
        foreach($users as $user){
            $name = data_get($user,'name');
            Schema::table($name, function (Blueprint $table) use($name) {
                if (!Schema::hasColumn($name, "user_id")) {
                   $table->foreignUuid('user_id')->after('id')->nullable()->constrained('users')->cascadeOnDelete();
                }     
                if (!Schema::hasColumn($name, "team_id")) {
                   $table->foreignUuid('team_id')->after('user_id')->nullable()->constrained('teams')->cascadeOnDelete();
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
