<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('property_type_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('property_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('location');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('Nigeria');
            $table->text('address')->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('video_link')->nullable();
            $table->decimal('price_per_night', 10, 2)->default(0);
            $table->decimal('weekend_price', 10, 2)->nullable();
            $table->decimal('monthly_price', 10, 2)->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('bedrooms')->default(1);
            $table->integer('bathrooms')->default(1);
            $table->integer('max_guests')->default(2);
            $table->integer('beds')->default(1);
            $table->string('property_size')->nullable();
            $table->string('check_in_time')->default('14:00');
            $table->string('check_out_time')->default('12:00');
            $table->text('cancellation_policy')->nullable();
            $table->text('house_rules')->nullable();
            $table->text('refund_policy')->nullable();
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('review_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'published', 'inactive'])->default('draft');
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('properties'); }
};
