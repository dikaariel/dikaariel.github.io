<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->string('flight_type')->default('direct')->after('price');
            $table->boolean('has_baggage')->default(true)->after('flight_type');
            $table->boolean('has_entertainment')->default(true)->after('has_baggage');
            $table->boolean('has_usb')->default(true)->after('has_entertainment');
            $table->boolean('has_wifi')->default(true)->after('has_usb');
            $table->boolean('has_meals')->default(true)->after('has_wifi');
        });
    }

    public function down(): void
    {
        Schema::table('flights', function (Blueprint $table) {
            $table->dropColumn([
                'flight_type',
                'has_baggage',
                'has_entertainment',
                'has_usb',
                'has_wifi',
                'has_meals',
            ]);
        });
    }
};