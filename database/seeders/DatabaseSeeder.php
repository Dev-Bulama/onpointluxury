<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Setting, PropertyType, PropertyCategory, Amenity, Property, PropertyImage, Room, Page, Menu, MenuItem, Testimonial, Faq, BlogPost, Review};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+2348012345678',
            'is_active' => true,
        ]);

        $manager = User::create([
            'name' => 'Property Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'phone' => '+2348023456789',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'John Client',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'phone' => '+2348034567890',
            'is_active' => true,
        ]);

        // Property Types
        $types = [
            ['name' => 'Hotel', 'slug' => 'hotel', 'icon' => '🏨'],
            ['name' => 'Apartment', 'slug' => 'apartment', 'icon' => '🏠'],
            ['name' => 'Short-let', 'slug' => 'short-let', 'icon' => '🛋️'],
            ['name' => 'Studio', 'slug' => 'studio', 'icon' => '🛏️'],
            ['name' => 'Luxury Suite', 'slug' => 'luxury-suite', 'icon' => '✨'],
            ['name' => 'Serviced Apartment', 'slug' => 'serviced-apartment', 'icon' => '🏢'],
            ['name' => 'Villa', 'slug' => 'villa', 'icon' => '🏡'],
            ['name' => 'Guest House', 'slug' => 'guest-house', 'icon' => '🏘️'],
            ['name' => 'Resort', 'slug' => 'resort', 'icon' => '🌴'],
            ['name' => 'Shared Apartment', 'slug' => 'shared-apartment', 'icon' => '🏗️'],
        ];
        foreach ($types as $i => $type) {
            PropertyType::create(array_merge($type, ['sort_order' => $i, 'is_active' => true]));
        }

        // Property Categories
        $categories = [
            ['name' => 'Luxury', 'slug' => 'luxury'],
            ['name' => 'Executive', 'slug' => 'executive'],
            ['name' => 'Budget Friendly', 'slug' => 'budget-friendly'],
            ['name' => 'Family Stay', 'slug' => 'family-stay'],
            ['name' => 'Business Stay', 'slug' => 'business-stay'],
            ['name' => 'Romantic Getaway', 'slug' => 'romantic-getaway'],
            ['name' => 'Beachfront', 'slug' => 'beachfront'],
            ['name' => 'City Apartment', 'slug' => 'city-apartment'],
            ['name' => 'Premium Short-let', 'slug' => 'premium-short-let'],
            ['name' => 'Corporate Housing', 'slug' => 'corporate-housing'],
        ];
        foreach ($categories as $i => $cat) {
            PropertyCategory::create(array_merge($cat, ['sort_order' => $i, 'is_active' => true]));
        }

        // Amenities
        $amenities = [
            ['name' => 'Free WiFi', 'icon' => 'wifi', 'category' => 'connectivity'],
            ['name' => 'Air Conditioning', 'icon' => 'wind', 'category' => 'comfort'],
            ['name' => 'Swimming Pool', 'icon' => 'droplets', 'category' => 'recreation'],
            ['name' => 'Gym / Fitness Center', 'icon' => 'dumbbell', 'category' => 'recreation'],
            ['name' => 'Parking Space', 'icon' => 'car', 'category' => 'convenience'],
            ['name' => 'Fully Equipped Kitchen', 'icon' => 'chef-hat', 'category' => 'kitchen'],
            ['name' => 'Smart TV', 'icon' => 'tv', 'category' => 'entertainment'],
            ['name' => '24/7 Security', 'icon' => 'shield', 'category' => 'security'],
            ['name' => 'Standby Generator', 'icon' => 'zap', 'category' => 'utilities'],
            ['name' => 'Laundry Service', 'icon' => 'shirt', 'category' => 'services'],
            ['name' => 'Private Balcony', 'icon' => 'sun', 'category' => 'outdoor'],
            ['name' => 'Ocean View', 'icon' => 'waves', 'category' => 'views'],
            ['name' => 'City View', 'icon' => 'building-2', 'category' => 'views'],
            ['name' => 'CCTV Surveillance', 'icon' => 'camera', 'category' => 'security'],
            ['name' => '24hr Concierge', 'icon' => 'bell-concierge', 'category' => 'services'],
            ['name' => 'Netflix / Streaming', 'icon' => 'play-circle', 'category' => 'entertainment'],
            ['name' => 'Breakfast Included', 'icon' => 'coffee', 'category' => 'dining'],
            ['name' => 'Restaurant On-site', 'icon' => 'utensils', 'category' => 'dining'],
            ['name' => 'Elevator Access', 'icon' => 'arrow-up-down', 'category' => 'convenience'],
            ['name' => 'Workspace / Desk', 'icon' => 'laptop', 'category' => 'work'],
            ['name' => 'Water Heater', 'icon' => 'flame', 'category' => 'comfort'],
            ['name' => 'Welcome Drinks', 'icon' => 'glass-water', 'category' => 'services'],
        ];
        $amenityModels = [];
        foreach ($amenities as $a) {
            $amenityModels[] = Amenity::create(array_merge($a, ['is_active' => true]));
        }

        // Properties
        $apartmentType = PropertyType::where('slug', 'apartment')->first();
        $shortletType = PropertyType::where('slug', 'short-let')->first();
        $hotelType = PropertyType::where('slug', 'hotel')->first();
        $suiteType = PropertyType::where('slug', 'luxury-suite')->first();
        $servicedType = PropertyType::where('slug', 'serviced-apartment')->first();
        $villaType = PropertyType::where('slug', 'villa')->first();

        $luxuryCat = PropertyCategory::where('slug', 'luxury')->first();
        $executiveCat = PropertyCategory::where('slug', 'executive')->first();
        $premiumCat = PropertyCategory::where('slug', 'premium-short-let')->first();
        $businessCat = PropertyCategory::where('slug', 'business-stay')->first();
        $familyCat = PropertyCategory::where('slug', 'family-stay')->first();

        $properties = [
            [
                'name' => 'Victoria Island Luxury Apartment',
                'slug' => 'victoria-island-luxury-apartment',
                'location' => 'Victoria Island',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'property_type_id' => $apartmentType->id,
                'property_category_id' => $luxuryCat->id,
                'price_per_night' => 85000,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'max_guests' => 6,
                'beds' => 3,
                'short_description' => 'Experience ultimate luxury in the heart of Victoria Island with stunning ocean views and world-class amenities.',
                'description' => 'Nestled in the prestigious Victoria Island district of Lagos, this stunning 3-bedroom luxury apartment offers an unparalleled living experience.',
                'check_in_time' => '14:00',
                'check_out_time' => '11:00',
                'cancellation_policy' => 'Free cancellation up to 48 hours before check-in.',
                'house_rules' => 'No smoking. No pets. Quiet hours 10pm-8am. Maximum 6 guests.',
                'is_featured' => true,
                'status' => 'published',
                'rating' => 4.9,
                'review_count' => 47,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Lekki Executive Short-let Suite',
                'slug' => 'lekki-executive-short-let-suite',
                'location' => 'Lekki Phase 1',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'property_type_id' => $shortletType->id,
                'property_category_id' => $premiumCat->id,
                'price_per_night' => 45000,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'max_guests' => 4,
                'beds' => 2,
                'short_description' => 'Modern executive suite in Lekki Phase 1 with premium furnishings and all amenities for a comfortable stay.',
                'description' => 'This beautifully appointed 2-bedroom executive suite is located in the heart of Lekki Phase 1.',
                'check_in_time' => '15:00',
                'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 24 hours before check-in.',
                'house_rules' => 'No smoking indoors. No parties. Maximum 4 guests.',
                'is_featured' => true,
                'status' => 'published',
                'rating' => 4.7,
                'review_count' => 63,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Ikoyi Premium Serviced Apartment',
                'slug' => 'ikoyi-premium-serviced-apartment',
                'location' => 'Old Ikoyi',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'property_type_id' => $servicedType->id,
                'property_category_id' => $executiveCat->id,
                'price_per_night' => 120000,
                'weekend_price' => 135000,
                'bedrooms' => 4,
                'bathrooms' => 4,
                'max_guests' => 8,
                'beds' => 4,
                'short_description' => 'Opulent 4-bedroom serviced apartment in exclusive Old Ikoyi with butler service and premium amenities.',
                'description' => 'Welcome to the pinnacle of luxury serviced living. This exceptional 4-bedroom apartment occupies an entire floor in one of Ikoyi\'s most prestigious buildings.',
                'check_in_time' => '13:00',
                'check_out_time' => '11:00',
                'cancellation_policy' => 'Free cancellation up to 72 hours before check-in. 50% refund within 48 hours.',
                'house_rules' => 'No smoking. No pets. Professional events require prior approval. Maximum 8 guests.',
                'is_featured' => true,
                'status' => 'published',
                'rating' => 5.0,
                'review_count' => 28,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Lagos Marina Hotel Suite',
                'slug' => 'lagos-marina-hotel-suite',
                'location' => 'Lagos Island',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'property_type_id' => $hotelType->id,
                'property_category_id' => $businessCat->id,
                'price_per_night' => 55000,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'max_guests' => 2,
                'beds' => 1,
                'short_description' => 'Elegant hotel suite overlooking the Lagos Marina with complimentary breakfast and business facilities.',
                'description' => 'The Lagos Marina Hotel Suite offers a perfect blend of comfort and convenience for business and leisure travelers.',
                'check_in_time' => '15:00',
                'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 24 hours before check-in.',
                'house_rules' => 'No smoking in rooms. Quiet hours after 11pm.',
                'is_featured' => false,
                'status' => 'published',
                'rating' => 4.6,
                'review_count' => 89,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Abuja Business Residence',
                'slug' => 'abuja-business-residence',
                'location' => 'Maitama',
                'city' => 'Abuja',
                'state' => 'FCT',
                'property_type_id' => $servicedType->id,
                'property_category_id' => $businessCat->id,
                'price_per_night' => 65000,
                'monthly_price' => 1500000,
                'bedrooms' => 2,
                'bathrooms' => 2,
                'max_guests' => 4,
                'beds' => 2,
                'short_description' => 'Sophisticated serviced apartment in Maitama ideal for business executives and diplomats.',
                'description' => 'Located in Abuja\'s most prestigious district of Maitama, this elegantly furnished 2-bedroom serviced apartment is the preferred choice for business executives and diplomats.',
                'check_in_time' => '14:00',
                'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 48 hours before check-in.',
                'house_rules' => 'No smoking. No parties or events. Professional use only.',
                'is_featured' => true,
                'status' => 'published',
                'rating' => 4.8,
                'review_count' => 34,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Banana Island Penthouse',
                'slug' => 'banana-island-penthouse',
                'location' => 'Banana Island',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'property_type_id' => $suiteType->id,
                'property_category_id' => $luxuryCat->id,
                'price_per_night' => 250000,
                'weekend_price' => 280000,
                'bedrooms' => 5,
                'bathrooms' => 5,
                'max_guests' => 10,
                'beds' => 5,
                'short_description' => 'Africa\'s most exclusive address — a spectacular penthouse on Banana Island with private pool and panoramic views.',
                'description' => 'Welcome to the crown jewel of Onpointluxury\'s collection. This extraordinary penthouse on the ultra-exclusive Banana Island represents the ultimate in Lagos luxury living.',
                'check_in_time' => '15:00',
                'check_out_time' => '12:00',
                'cancellation_policy' => 'Non-refundable. 25% deposit required at booking.',
                'house_rules' => 'No smoking indoors. Maximum 10 guests. Events require special arrangement. 3-night minimum stay.',
                'is_featured' => true,
                'status' => 'published',
                'rating' => 5.0,
                'review_count' => 12,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Ikeja Airport Hotel Room',
                'slug' => 'ikeja-airport-hotel-room',
                'location' => 'Ikeja GRA',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'property_type_id' => $hotelType->id,
                'property_category_id' => $executiveCat->id,
                'price_per_night' => 28000,
                'bedrooms' => 1,
                'bathrooms' => 1,
                'max_guests' => 2,
                'beds' => 1,
                'short_description' => 'Comfortable hotel room minutes from Murtala Muhammed Airport with shuttle service and all modern amenities.',
                'description' => 'Perfectly situated just 5 minutes from Murtala Muhammed International Airport, this comfortable hotel room is ideal for transit passengers and business travelers.',
                'check_in_time' => '14:00',
                'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 6 hours before check-in.',
                'house_rules' => 'No smoking. Quiet hours 11pm-7am.',
                'is_featured' => false,
                'status' => 'published',
                'rating' => 4.3,
                'review_count' => 156,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Eko Atlantic Luxury Stay',
                'slug' => 'eko-atlantic-luxury-stay',
                'location' => 'Eko Atlantic City',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'property_type_id' => $apartmentType->id,
                'property_category_id' => $luxuryCat->id,
                'price_per_night' => 175000,
                'weekend_price' => 195000,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'max_guests' => 6,
                'beds' => 3,
                'short_description' => 'Ultra-modern apartment in the iconic Eko Atlantic City — Africa\'s newest luxury destination with ocean frontage.',
                'description' => 'Be among the first to experience living in Eko Atlantic City, Africa\'s most ambitious urban development project.',
                'check_in_time' => '15:00',
                'check_out_time' => '11:00',
                'cancellation_policy' => 'Free cancellation up to 72 hours before check-in.',
                'house_rules' => 'No smoking. No pets. Sophisticated guests only. Minimum 2-night stay.',
                'is_featured' => true,
                'status' => 'published',
                'rating' => 4.9,
                'review_count' => 23,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Port Harcourt Garden Villa',
                'slug' => 'port-harcourt-garden-villa',
                'location' => 'GRA Phase 2',
                'city' => 'Port Harcourt',
                'state' => 'Rivers',
                'property_type_id' => $villaType->id,
                'property_category_id' => $familyCat->id,
                'price_per_night' => 75000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'max_guests' => 8,
                'beds' => 4,
                'short_description' => 'Spacious garden villa in the serene GRA with lush private gardens, family amenities and a domestic staff quarter.',
                'description' => 'This exquisite 4-bedroom garden villa in Port Harcourt\'s most coveted GRA Phase 2 offers a serene escape with all the comforts of a luxury home.',
                'check_in_time' => '14:00',
                'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 48 hours before check-in.',
                'house_rules' => 'No smoking indoors. Pets considered with prior approval. Maximum 8 guests.',
                'is_featured' => false,
                'status' => 'published',
                'rating' => 4.7,
                'review_count' => 19,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Asokoro Diplomatic Residence',
                'slug' => 'asokoro-diplomatic-residence',
                'location' => 'Asokoro',
                'city' => 'Abuja',
                'state' => 'FCT',
                'property_type_id' => $servicedType->id,
                'property_category_id' => $executiveCat->id,
                'price_per_night' => 95000,
                'monthly_price' => 2200000,
                'bedrooms' => 3,
                'bathrooms' => 3,
                'max_guests' => 6,
                'beds' => 3,
                'short_description' => 'Distinguished diplomatic-grade residence in Asokoro for senior executives, diplomats and VIP visitors to Abuja.',
                'description' => 'Located in Abuja\'s exclusive Asokoro district, this distinguished 3-bedroom residence offers exceptional privacy, security, and comfort.',
                'check_in_time' => '14:00',
                'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 72 hours. Non-refundable for same-day cancellations.',
                'house_rules' => 'No smoking. No unauthorized visitors. Professional conduct expected at all times.',
                'is_featured' => false,
                'status' => 'published',
                'rating' => 4.8,
                'review_count' => 15,
                'user_id' => $manager->id,
            ],
        ];

        $allAmenityIds = collect($amenityModels)->pluck('id')->toArray();

        foreach ($properties as $propData) {
            $property = Property::create($propData);
            $selected = $allAmenityIds;
            shuffle($selected);
            $property->amenities()->attach(array_slice($selected, 0, rand(8, 12)));
        }

        // FAQs
        $faqs = [
            ['question' => 'How do I make a booking?', 'answer' => 'Simply browse our properties, select your preferred apartment or hotel, choose your check-in and check-out dates, and proceed to book. You can pay securely online with Paystack or contact us via WhatsApp.', 'category' => 'booking'],
            ['question' => 'What is the cancellation policy?', 'answer' => 'Cancellation policies vary by property. Most properties offer free cancellation up to 24-72 hours before check-in. The specific policy is clearly stated on each property\'s page.', 'category' => 'booking'],
            ['question' => 'Is my payment secure?', 'answer' => 'Yes, absolutely. We use Paystack, Nigeria\'s most trusted payment gateway, which is PCI-DSS compliant. Your card details are never stored on our servers.', 'category' => 'payment'],
            ['question' => 'Can I pay with bank transfer?', 'answer' => 'Yes, we accept bank transfers. After initiating your booking, select "Contact via WhatsApp" and our team will provide bank transfer details and confirm your reservation upon receipt of payment.', 'category' => 'payment'],
            ['question' => 'What happens after I book?', 'answer' => 'Once your booking is confirmed and payment received, you will receive a detailed confirmation email with your booking reference, property address, and check-in instructions.', 'category' => 'booking'],
            ['question' => 'Can I check in early or check out late?', 'answer' => 'Early check-in and late check-out are subject to availability. Please contact the property in advance. Additional charges may apply for late check-out after 2pm.', 'category' => 'checkin'],
            ['question' => 'Are utilities included in the price?', 'answer' => 'Yes, all utilities including electricity, water, WiFi, and air conditioning are included in the rental price. There are no hidden charges.', 'category' => 'pricing'],
            ['question' => 'Is there a minimum stay requirement?', 'answer' => 'Most properties can be booked for a minimum of 1 night. Some premium properties may require a minimum stay of 2-3 nights, which is indicated on the property page.', 'category' => 'booking'],
            ['question' => 'Do you offer monthly rates?', 'answer' => 'Yes, many of our properties offer discounted monthly rates for extended stays. Contact us via WhatsApp or check the property listing for monthly pricing.', 'category' => 'pricing'],
            ['question' => 'How do I contact the property after booking?', 'answer' => 'After your booking is confirmed, you will receive the property manager\'s contact details. You can also use our WhatsApp button on the property page for direct communication.', 'category' => 'general'],
            ['question' => 'Are pets allowed?', 'answer' => 'Pet policies vary by property. Some properties welcome pets with prior notice, while others have a strict no-pet policy. Please check the house rules on the property listing before booking.', 'category' => 'general'],
            ['question' => 'Is parking available?', 'answer' => 'Most of our properties include complimentary parking. The number of parking spaces available is listed in the amenities section of each property.', 'category' => 'general'],
        ];
        foreach ($faqs as $i => $faq) {
            Faq::create(array_merge($faq, ['sort_order' => $i, 'is_active' => true]));
        }

        // Testimonials
        $testimonials = [
            ['name' => 'Emeka Okafor', 'title' => 'Business Executive, Lagos', 'rating' => 5, 'comment' => 'Absolutely stunning property! The Victoria Island apartment exceeded every expectation. The views are incredible and the team was incredibly responsive. Will definitely book again!'],
            ['name' => 'Amina Bello', 'title' => 'Wedding Planner, Abuja', 'rating' => 5, 'comment' => 'We hosted our honeymoon at the Banana Island Penthouse and it was absolutely magical. From the seamless booking process to the immaculate property, every detail was perfect.'],
            ['name' => 'David Chen', 'title' => 'International Investor', 'rating' => 5, 'comment' => 'As someone who travels frequently to Lagos for business, finding Onpointluxury has been a game-changer. The Ikoyi apartment is consistently impeccable.'],
            ['name' => 'Chidinma Eze', 'title' => 'Fashion Designer, Lagos', 'rating' => 4, 'comment' => 'Stayed at the Lekki Executive Suite for a week and absolutely loved it! The location is perfect and the check-in process was so smooth. Highly recommend!'],
            ['name' => 'Abdullahi Musa', 'title' => 'Senior Government Official, FCT', 'rating' => 5, 'comment' => 'The Asokoro Diplomatic Residence is exactly what you would expect from its name — distinguished, private, and impeccably maintained.'],
            ['name' => 'Sarah Williams', 'title' => 'Expat Professional, Lagos', 'rating' => 5, 'comment' => 'I\'ve been using Onpointluxury for all my Lagos accommodations for the past year. The quality is consistently excellent and the booking process is seamless.'],
        ];
        foreach ($testimonials as $i => $t) {
            Testimonial::create(array_merge($t, ['sort_order' => $i, 'is_active' => true]));
        }

        // Blog Posts
        $blogPosts = [
            [
                'title' => 'Best Luxury Apartments in Lagos: A Complete Guide for 2024',
                'slug' => 'best-luxury-apartments-lagos-2024',
                'category' => 'guides',
                'excerpt' => 'Discover the most prestigious addresses in Lagos for short-let luxury living — from Victoria Island to Banana Island.',
                'content' => '<p>Lagos, Africa\'s most vibrant megacity, has emerged as a premier destination for luxury short-term accommodation.</p>',
                'user_id' => $admin->id,
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'seo_title' => 'Best Luxury Apartments in Lagos 2024 | Onpointluxury',
                'seo_description' => 'A complete guide to the best luxury apartments in Lagos for 2024, covering Victoria Island, Ikoyi, Lekki, and Eko Atlantic.',
            ],
            [
                'title' => 'How to Choose the Right Short-let Apartment in Nigeria',
                'slug' => 'how-to-choose-short-let-apartment-nigeria',
                'category' => 'tips',
                'excerpt' => 'Not all short-let apartments are created equal. Here\'s everything you need to know before making your next booking.',
                'content' => '<p>The short-let apartment market in Nigeria has grown exponentially over the past five years.</p>',
                'user_id' => $admin->id,
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'seo_title' => 'How to Choose the Right Short-let Apartment in Nigeria | Onpointluxury',
                'seo_description' => 'Expert tips on choosing the perfect short-let apartment in Nigeria. Learn what to look for before booking.',
            ],
            [
                'title' => 'Why Serviced Apartments Are Better Than Hotels for Business Travel',
                'slug' => 'serviced-apartments-vs-hotels-business-travel',
                'category' => 'insights',
                'excerpt' => 'For extended business trips, serviced apartments offer superior value, comfort, and productivity compared to traditional hotel stays.',
                'content' => '<p>As corporate travel evolves, more business travelers are discovering what seasoned road warriors have known for years.</p>',
                'user_id' => $admin->id,
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'seo_title' => 'Why Serviced Apartments Beat Hotels for Business Travel | Onpointluxury',
                'seo_description' => 'Discover why serviced apartments offer better value, comfort and productivity than hotels for business travelers in Nigeria.',
            ],
        ];
        foreach ($blogPosts as $post) {
            BlogPost::create($post);
        }

        // Reviews
        $propertyModels = Property::all();
        $reviewData = [
            ['rating' => 5, 'comment' => 'Exceptional property! Everything was exactly as described and the host was incredibly helpful. Will definitely return.', 'reviewer_name' => 'Michael A.', 'reviewer_email' => 'michael@example.com'],
            ['rating' => 5, 'comment' => 'Perfect location, immaculate apartment, and outstanding service. This is how luxury should feel.', 'reviewer_name' => 'Fatima K.', 'reviewer_email' => 'fatima@example.com'],
            ['rating' => 4, 'comment' => 'Very comfortable stay. The apartment was clean and well-equipped. Minor issue with WiFi speed but resolved quickly.', 'reviewer_name' => 'James O.', 'reviewer_email' => 'james@example.com'],
            ['rating' => 5, 'comment' => 'Absolutely loved it! The views alone are worth every naira. Will be recommending to everyone.', 'reviewer_name' => 'Ngozi B.', 'reviewer_email' => 'ngozi@example.com'],
        ];
        foreach ($propertyModels->take(4) as $i => $prop) {
            Review::create(array_merge($reviewData[$i], [
                'property_id' => $prop->id,
                'status' => 'approved',
            ]));
        }

        // CMS Pages
        $pages = [
            ['title' => 'Home', 'slug' => 'home', 'template' => 'home', 'is_published' => true, 'sort_order' => 0],
            ['title' => 'About Us', 'slug' => 'about', 'template' => 'default', 'is_published' => true, 'sort_order' => 1,
             'content' => '<h2>About Onpointluxury</h2><p>Onpointluxury is Nigeria\'s premier luxury apartment and hotel booking platform.</p>'],
            ['title' => 'Contact Us', 'slug' => 'contact', 'template' => 'contact', 'is_published' => true, 'sort_order' => 2],
            ['title' => 'FAQ', 'slug' => 'faq', 'template' => 'faq', 'is_published' => true, 'sort_order' => 3],
            ['title' => 'Terms & Conditions', 'slug' => 'terms', 'template' => 'default', 'is_published' => true, 'sort_order' => 4,
             'content' => '<h2>Terms & Conditions</h2><p>By using Onpointluxury, you agree to these terms and conditions.</p>'],
            ['title' => 'Privacy Policy', 'slug' => 'privacy', 'template' => 'default', 'is_published' => true, 'sort_order' => 5,
             'content' => '<h2>Privacy Policy</h2><p>Onpointluxury is committed to protecting your personal information.</p>'],
            ['title' => 'Refund Policy', 'slug' => 'refund-policy', 'template' => 'default', 'is_published' => true, 'sort_order' => 6,
             'content' => '<h2>Refund Policy</h2><p>Our refund policy is designed to be fair to both guests and property owners.</p>'],
        ];
        foreach ($pages as $pageData) {
            Page::create($pageData);
        }

        // Menus
        $headerMenu = Menu::create(['name' => 'Header Menu', 'location' => 'header', 'is_active' => true]);
        $footerMenu = Menu::create(['name' => 'Footer Menu', 'location' => 'footer', 'is_active' => true]);

        // Header menu items
        $headerItems = [
            ['label' => 'Home', 'url' => '/', 'sort_order' => 0],
            ['label' => 'Properties', 'url' => '/properties', 'sort_order' => 1],
            ['label' => 'Blog', 'url' => '/blog', 'sort_order' => 2],
            ['label' => 'FAQ', 'url' => '/faq', 'sort_order' => 3],
            ['label' => 'Contact', 'url' => '/contact', 'sort_order' => 4],
        ];
        foreach ($headerItems as $item) {
            MenuItem::create(array_merge($item, ['menu_id' => $headerMenu->id, 'is_active' => true]));
        }

        // Footer menu items
        $footerItems = [
            ['label' => 'About Us', 'url' => '/about', 'sort_order' => 0],
            ['label' => 'Properties', 'url' => '/properties', 'sort_order' => 1],
            ['label' => 'Terms & Conditions', 'url' => '/terms', 'sort_order' => 2],
            ['label' => 'Privacy Policy', 'url' => '/privacy', 'sort_order' => 3],
            ['label' => 'Refund Policy', 'url' => '/refund-policy', 'sort_order' => 4],
            ['label' => 'Contact Us', 'url' => '/contact', 'sort_order' => 5],
            ['label' => 'FAQ', 'url' => '/faq', 'sort_order' => 6],
        ];
        foreach ($footerItems as $item) {
            MenuItem::create(array_merge($item, ['menu_id' => $footerMenu->id, 'is_active' => true]));
        }

        // Settings
        $settings = [
            ['key' => 'site_name', 'value' => 'Onpointluxury', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Premium Apartment & Hotel Bookings', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'hello@onpointluxury.com', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+234 800 ONPOINT', 'group' => 'general'],
            ['key' => 'whatsapp_number', 'value' => '2348012345678', 'group' => 'general'],
            ['key' => 'address', 'value' => '15 Adeola Odeku Street, Victoria Island, Lagos, Nigeria', 'group' => 'general'],
            ['key' => 'currency', 'value' => 'NGN', 'group' => 'general'],
            ['key' => 'timezone', 'value' => 'Africa/Lagos', 'group' => 'general'],
            ['key' => 'paystack_public_key', 'value' => 'pk_test_xxxxxxxxxxxxxxxxxxxx', 'group' => 'paystack'],
            ['key' => 'paystack_secret_key', 'value' => 'sk_test_xxxxxxxxxxxxxxxxxxxx', 'group' => 'paystack'],
            ['key' => 'paystack_mode', 'value' => 'test', 'group' => 'paystack'],
            ['key' => 'paystack_currency', 'value' => 'NGN', 'group' => 'paystack'],
            ['key' => 'paystack_enabled', 'value' => '1', 'group' => 'paystack'],
            ['key' => 'guest_booking', 'value' => '1', 'group' => 'booking'],
            ['key' => 'require_login', 'value' => '0', 'group' => 'booking'],
            ['key' => 'default_checkin_time', 'value' => '14:00', 'group' => 'booking'],
            ['key' => 'default_checkout_time', 'value' => '12:00', 'group' => 'booking'],
            ['key' => 'tax_percentage', 'value' => '0', 'group' => 'booking'],
            ['key' => 'service_charge', 'value' => '0', 'group' => 'booking'],
            ['key' => 'cancellation_window', 'value' => '24', 'group' => 'booking'],
            ['key' => 'auto_expire_minutes', 'value' => '30', 'group' => 'booking'],
            ['key' => 'whatsapp_template', 'value' => "Hello, I am interested in booking {property}.\n\nProperty: {property}\nLocation: {location}\nPrice: {price} per night\nCheck-in: {checkin}\nCheck-out: {checkout}\nGuests: {guests}\n\nPlease confirm availability.", 'group' => 'whatsapp'],
            ['key' => 'whatsapp_inquiry_enabled', 'value' => '1', 'group' => 'whatsapp'],
            ['key' => 'whatsapp_booking_enabled', 'value' => '1', 'group' => 'whatsapp'],
            ['key' => 'meta_title', 'value' => 'Onpointluxury — Premium Apartment & Hotel Bookings in Nigeria', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Book luxury apartments, hotel suites, and serviced residences across Lagos, Abuja, and Port Harcourt. Secure online payments, instant confirmation.', 'group' => 'seo'],
            ['key' => 'robots_txt', 'value' => "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /dashboard\nDisallow: /manager", 'group' => 'seo'],
        ];
        foreach ($settings as $s) {
            \App\Models\Setting::set($s['key'], $s['value'], $s['group']);
        }
    }
}
