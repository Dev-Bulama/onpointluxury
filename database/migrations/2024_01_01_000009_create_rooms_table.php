<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('room_type')->default('Standard Room');
            $table->decimal('price_per_night', 10, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->integer('max_guests')->default(2);
            $table->integer('beds')->default(1);
            $table->integer('bathrooms')->default(1);
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('rooms'); }
};
