<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transport_routes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("city_id");
            $table->smallInteger("route_number");
            $table->string("transport_type");
            $table->string("route_endpoint_1");
            $table->string("route_endpoint_2");

            $table->foreign("city_id")
                ->references("id")
                ->on("cities")
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_routes');
    }
};
