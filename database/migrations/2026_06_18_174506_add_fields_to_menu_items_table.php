<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {

            if (!Schema::hasColumn('menu_items', 'name')) {
                $table->string('name');
            }

            if (!Schema::hasColumn('menu_items', 'price')) {
                $table->decimal('price', 8, 2);
            }

            if (!Schema::hasColumn('menu_items', 'availability')) {
                $table->string('availability')->default('available');
            }

            if (!Schema::hasColumn('menu_items', 'image')) {
                $table->string('image')->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            if (Schema::hasColumn('menu_items', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('menu_items', 'price')) {
                $table->dropColumn('price');
            }

            if (Schema::hasColumn('menu_items', 'availability')) {
                $table->dropColumn('availability');
            }

            if (Schema::hasColumn('menu_items', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
