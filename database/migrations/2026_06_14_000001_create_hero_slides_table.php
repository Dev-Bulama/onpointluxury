<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->nullable();
            $table->string('headline');
            $table->text('description')->nullable();
            $table->string('cta1_text')->default('Explore Properties');
            $table->string('cta1_url')->default('/properties');
            $table->string('cta2_text')->nullable();
            $table->string('cta2_url')->nullable();
            $table->string('desktop_image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->string('alt_text')->nullable();
            $table->string('focal_position')->default('center');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('hero_slides'); }
};
