<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Basic fields
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('sku')->nullable(); // optional if you don't have SKU data yet
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete(); // optional, create brands table if needed
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete(); // optional

            // Pricing - store in integer cents to avoid floats
            $table->unsignedBigInteger('price_cents')->default(0);
            $table->string('currency', 3)->default('CAD');

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // Inventory
            $table->integer('stock')->default(0); // quantity on hand
            $table->boolean('track_inventory')->default(true);

            // Images (primary image path) and optional images JSON
            $table->string('image')->nullable();
            $table->json('images')->nullable();

            // Flags
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}

