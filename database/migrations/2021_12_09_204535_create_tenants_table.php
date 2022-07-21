<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('slug')->nullable(); 
            $table->string('domain')->nullable(); 
            $table->string('prefix')->default('admin')->nullable();
            $table->string('database')->default('tenant_db');
            $table->string('middleware')->default('tenants');
            $table->string('provider')->default('tenants');
            $table->foreignUuid('user_id')->nullable()->constrained('users')->cascadeOnDelete();            
            if (Schema::hasTable('statuses')) {           
                $table->foreignUuid('status_id')->nullable()->constrained('statuses')->cascadeOnDelete();
            }
            else{
                $table->enum('status_id',['draft','published'])->nullable()->comment("Situação")->default('published');
            }
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
