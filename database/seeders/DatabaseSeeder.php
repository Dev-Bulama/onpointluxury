<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Setting, PropertyType, PropertyCategory, Amenity, Property, PropertyImage, Page, Menu, MenuItem, Testimonial, Faq, BlogPost, Review};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding users...');

        $admin = User::updateOrCreate(
            ['email' => 'admin@onpointluxury.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password'), 'role' => 'admin', 'phone' => '+2348012345678', 'is_active' => true]
        );

        $manager = User::updateOrCreate(
            ['email' => 'manager@onpointluxury.com'],
            ['name' => 'Property Manager', 'password' => Hash::make('password'), 'role' => 'manager', 'phone' => '+2348023456789', 'is_active' => true]
        );

        User::updateOrCreate(
            ['email' => 'client@onpointluxury.com'],
            ['name' => 'Demo Client', 'password' => Hash::make('password'), 'role' => 'client', 'phone' => '+2348034567890', 'is_active' => true]
        );

        $this->command->info('Seeding property types...');

        $types = [
            ['name' => 'Hotel',               'slug' => 'hotel',               'icon' => '🏨'],
            ['name' => 'Apartment',           'slug' => 'apartment',           'icon' => '🏠'],
            ['name' => 'Short-let',           'slug' => 'short-let',           'icon' => '🛋️'],
            ['name' => 'Studio',              'slug' => 'studio',              'icon' => '🛏️'],
            ['name' => 'Luxury Suite',        'slug' => 'luxury-suite',        'icon' => '✨'],
            ['name' => 'Serviced Apartment',  'slug' => 'serviced-apartment',  'icon' => '🏢'],
            ['name' => 'Villa',               'slug' => 'villa',               'icon' => '🏡'],
            ['name' => 'Guest House',         'slug' => 'guest-house',         'icon' => '🏘️'],
            ['name' => 'Penthouse',           'slug' => 'penthouse',           'icon' => '🌆'],
            ['name' => 'Shared Apartment',    'slug' => 'shared-apartment',    'icon' => '🏗️'],
        ];
        foreach ($types as $i => $type) {
            PropertyType::updateOrCreate(['slug' => $type['slug']], array_merge($type, ['sort_order' => $i, 'is_active' => true]));
        }

        $this->command->info('Seeding property categories...');

        $categories = [
            ['name' => 'Luxury',             'slug' => 'luxury'],
            ['name' => 'Executive',          'slug' => 'executive'],
            ['name' => 'Budget Friendly',    'slug' => 'budget-friendly'],
            ['name' => 'Family Stay',        'slug' => 'family-stay'],
            ['name' => 'Business Stay',      'slug' => 'business-stay'],
            ['name' => 'Romantic Getaway',   'slug' => 'romantic-getaway'],
            ['name' => 'City Apartment',     'slug' => 'city-apartment'],
            ['name' => 'Premium Short-let',  'slug' => 'premium-short-let'],
            ['name' => 'Corporate Housing',  'slug' => 'corporate-housing'],
        ];
        foreach ($categories as $i => $cat) {
            PropertyCategory::updateOrCreate(['slug' => $cat['slug']], array_merge($cat, ['sort_order' => $i, 'is_active' => true]));
        }

        $this->command->info('Seeding amenities...');

        $amenities = [
            ['name' => 'Free WiFi',              'icon' => 'wifi',            'category' => 'connectivity'],
            ['name' => 'Air Conditioning',       'icon' => 'wind',            'category' => 'comfort'],
            ['name' => 'Swimming Pool',          'icon' => 'droplets',        'category' => 'recreation'],
            ['name' => 'Gym / Fitness Center',   'icon' => 'dumbbell',        'category' => 'recreation'],
            ['name' => 'Parking Space',          'icon' => 'car',             'category' => 'convenience'],
            ['name' => 'Fully Equipped Kitchen', 'icon' => 'chef-hat',        'category' => 'kitchen'],
            ['name' => 'Smart TV',               'icon' => 'tv',              'category' => 'entertainment'],
            ['name' => '24/7 Security',          'icon' => 'shield',          'category' => 'security'],
            ['name' => 'Standby Generator',      'icon' => 'zap',             'category' => 'utilities'],
            ['name' => 'Laundry Service',        'icon' => 'shirt',           'category' => 'services'],
            ['name' => 'Private Balcony',        'icon' => 'sun',             'category' => 'outdoor'],
            ['name' => 'Ocean View',             'icon' => 'waves',           'category' => 'views'],
            ['name' => 'City View',              'icon' => 'building-2',      'category' => 'views'],
            ['name' => 'CCTV Surveillance',      'icon' => 'camera',          'category' => 'security'],
            ['name' => '24hr Concierge',         'icon' => 'bell',            'category' => 'services'],
            ['name' => 'Netflix / Streaming',    'icon' => 'play-circle',     'category' => 'entertainment'],
            ['name' => 'Breakfast Included',     'icon' => 'coffee',          'category' => 'dining'],
            ['name' => 'Restaurant On-site',     'icon' => 'utensils',        'category' => 'dining'],
            ['name' => 'Elevator Access',        'icon' => 'arrow-up',        'category' => 'convenience'],
            ['name' => 'Workspace / Desk',       'icon' => 'laptop',          'category' => 'work'],
            ['name' => 'Water Heater',           'icon' => 'flame',           'category' => 'comfort'],
            ['name' => 'Welcome Drinks',         'icon' => 'glass-water',     'category' => 'services'],
        ];
        $amenityModels = [];
        foreach ($amenities as $a) {
            $amenityModels[] = Amenity::updateOrCreate(['name' => $a['name']], array_merge($a, ['is_active' => true]));
        }

        $this->command->info('Seeding properties...');

        $apt  = PropertyType::where('slug', 'apartment')->first();
        $slt  = PropertyType::where('slug', 'short-let')->first();
        $hot  = PropertyType::where('slug', 'hotel')->first();
        $ste  = PropertyType::where('slug', 'luxury-suite')->first();
        $svc  = PropertyType::where('slug', 'serviced-apartment')->first();
        $vil  = PropertyType::where('slug', 'villa')->first();
        $pth  = PropertyType::where('slug', 'penthouse')->first();
        $std  = PropertyType::where('slug', 'studio')->first();

        $lux  = PropertyCategory::where('slug', 'luxury')->first();
        $exc  = PropertyCategory::where('slug', 'executive')->first();
        $prm  = PropertyCategory::where('slug', 'premium-short-let')->first();
        $biz  = PropertyCategory::where('slug', 'business-stay')->first();
        $fam  = PropertyCategory::where('slug', 'family-stay')->first();
        $cit  = PropertyCategory::where('slug', 'city-apartment')->first();
        $rom  = PropertyCategory::where('slug', 'romantic-getaway')->first();
        $cor  = PropertyCategory::where('slug', 'corporate-housing')->first();

        // Unsplash luxury property images grouped by property
        $imageGroups = [
            'victoria-island-luxury-apartment' => [
                'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1200&q=80',
                'https://images.unsplash.com/photo-1600210492486-724fe5c67fb0?w=1200&q=80',
                'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?w=1200&q=80',
                'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1200&q=80',
            ],
            'lekki-executive-short-let-suite' => [
                'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?w=1200&q=80',
                'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1200&q=80',
                'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=1200&q=80',
                'https://images.unsplash.com/photo-1536376072261-38c75010e6c9?w=1200&q=80',
            ],
            'ikoyi-premium-serviced-apartment' => [
                'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1200&q=80',
                'https://images.unsplash.com/photo-1600607687644-c7171b62d0e3?w=1200&q=80',
                'https://images.unsplash.com/photo-1600566753376-12c8ab7fb75b?w=1200&q=80',
                'https://images.unsplash.com/photo-1600573472550-8090b5e0745e?w=1200&q=80',
            ],
            'banana-island-penthouse' => [
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1200&q=80',
                'https://images.unsplash.com/photo-1613977257363-707ba9348227?w=1200&q=80',
                'https://images.unsplash.com/photo-1613977257592-4a9a32f9141c?w=1200&q=80',
                'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=1200&q=80',
                'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=1200&q=80',
            ],
            'ikeja-airport-hotel-room' => [
                'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=1200&q=80',
                'https://images.unsplash.com/photo-1631049552057-403cdb8f0658?w=1200&q=80',
                'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=1200&q=80',
                'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1200&q=80',
            ],
            'eko-atlantic-marina-suite' => [
                'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=1200&q=80',
                'https://images.unsplash.com/photo-1590073242678-70ee3fc28e8e?w=1200&q=80',
                'https://images.unsplash.com/photo-1549294413-26f195200c16?w=1200&q=80',
                'https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?w=1200&q=80',
            ],
            'abuja-business-residence' => [
                'https://images.unsplash.com/photo-1554995207-c18c203602cb?w=1200&q=80',
                'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=1200&q=80',
                'https://images.unsplash.com/photo-1484154218962-a197022b5858?w=1200&q=80',
                'https://images.unsplash.com/photo-1493809842364-78817add7ffb?w=1200&q=80',
            ],
            'lekki-family-apartment' => [
                'https://images.unsplash.com/photo-1560184897-ae75f418493e?w=1200&q=80',
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80',
                'https://images.unsplash.com/photo-1556020685-ae41abfc9365?w=1200&q=80',
                'https://images.unsplash.com/photo-1600210491892-03d54c0aaf87?w=1200&q=80',
            ],
            'victoria-island-studio-stay' => [
                'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=1200&q=80',
                'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?w=1200&q=80',
                'https://images.unsplash.com/photo-1540518614846-7eded433c457?w=1200&q=80',
                'https://images.unsplash.com/photo-1505691938895-1758d7feb511?w=1200&q=80',
            ],
            'ikoyi-corporate-housing' => [
                'https://images.unsplash.com/photo-1574362848149-11496d93a7c7?w=1200&q=80',
                'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=1200&q=80',
                'https://images.unsplash.com/photo-1494526585095-c41746248156?w=1200&q=80',
                'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80',
            ],
            'lagos-island-boutique-hotel' => [
                'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200&q=80',
                'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=1200&q=80',
                'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=1200&q=80',
                'https://images.unsplash.com/photo-1561501878-aabd62634533?w=1200&q=80',
            ],
            'chevron-luxury-villa' => [
                'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=1200&q=80',
                'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=1200&q=80',
                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=1200&q=80',
                'https://images.unsplash.com/photo-1416331108676-a22ccb276e35?w=1200&q=80',
                'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1200&q=80',
            ],
        ];

        $properties = [
            [
                'name' => 'Victoria Island Luxury Apartment',
                'slug' => 'victoria-island-luxury-apartment',
                'location' => 'Victoria Island', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $apt->id, 'property_category_id' => $lux->id,
                'price_per_night' => 85000, 'weekend_price' => 95000,
                'bedrooms' => 3, 'bathrooms' => 3, 'max_guests' => 6, 'beds' => 3,
                'short_description' => 'Experience ultimate luxury in the heart of Victoria Island with stunning ocean views and world-class amenities.',
                'description' => '<p>Nestled in the prestigious Victoria Island district of Lagos, this stunning 3-bedroom luxury apartment offers an unparalleled living experience. Featuring panoramic views of the Atlantic Ocean, the apartment combines sleek contemporary design with traditional Nigerian warmth.</p><p>The open-plan living area flows seamlessly onto a private balcony with breathtaking ocean vistas. Three en-suite bedrooms are furnished with premium imported linens, smart TVs, and bespoke wardrobes. The gourmet kitchen is fully equipped for those who prefer to cook.</p>',
                'check_in_time' => '14:00', 'check_out_time' => '11:00',
                'cancellation_policy' => 'Free cancellation up to 48 hours before check-in.',
                'house_rules' => 'No smoking. No pets. Quiet hours 10pm–8am. Maximum 6 guests.',
                'is_featured' => true, 'status' => 'published', 'rating' => 4.9, 'review_count' => 47,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Lekki Executive Short-let Suite',
                'slug' => 'lekki-executive-short-let-suite',
                'location' => 'Lekki Phase 1', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $slt->id, 'property_category_id' => $prm->id,
                'price_per_night' => 45000,
                'bedrooms' => 2, 'bathrooms' => 2, 'max_guests' => 4, 'beds' => 2,
                'short_description' => 'Modern executive suite in Lekki Phase 1 with premium furnishings and all amenities for a comfortable stay.',
                'description' => '<p>This beautifully appointed 2-bedroom executive suite is located in the heart of Lekki Phase 1, one of Lagos\'s most vibrant neighbourhoods. Within walking distance of top restaurants, shopping centres, and business hubs.</p><p>Both bedrooms feature king-size beds, high-quality linen, and en-suite bathrooms. The living area has a 65" smart TV, high-speed WiFi, and comfortable seating. A fully equipped kitchen makes self-catering effortless.</p>',
                'check_in_time' => '15:00', 'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 24 hours before check-in.',
                'house_rules' => 'No smoking indoors. No parties. Maximum 4 guests.',
                'is_featured' => true, 'status' => 'published', 'rating' => 4.7, 'review_count' => 63,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Ikoyi Premium Serviced Apartment',
                'slug' => 'ikoyi-premium-serviced-apartment',
                'location' => 'Old Ikoyi', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $svc->id, 'property_category_id' => $exc->id,
                'price_per_night' => 120000, 'weekend_price' => 135000,
                'bedrooms' => 4, 'bathrooms' => 4, 'max_guests' => 8, 'beds' => 4,
                'short_description' => 'Opulent 4-bedroom serviced apartment in exclusive Old Ikoyi with butler service and premium amenities.',
                'description' => '<p>Welcome to the pinnacle of luxury serviced living. This exceptional 4-bedroom apartment occupies an entire floor in one of Ikoyi\'s most prestigious buildings, featuring dedicated butler service, daily housekeeping, and concierge.</p><p>The master bedroom has a private terrace with city views. The chef\'s kitchen, home cinema room, and executive workspace make this ideal for extended stays and corporate use.</p>',
                'check_in_time' => '13:00', 'check_out_time' => '11:00',
                'cancellation_policy' => 'Free cancellation up to 72 hours before check-in. 50% refund within 48 hours.',
                'house_rules' => 'No smoking. No pets. Professional events require prior approval. Maximum 8 guests.',
                'is_featured' => true, 'status' => 'published', 'rating' => 5.0, 'review_count' => 28,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Banana Island Penthouse',
                'slug' => 'banana-island-penthouse',
                'location' => 'Banana Island', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $pth->id, 'property_category_id' => $lux->id,
                'price_per_night' => 250000, 'weekend_price' => 280000,
                'bedrooms' => 5, 'bathrooms' => 5, 'max_guests' => 10, 'beds' => 5,
                'short_description' => 'Africa\'s most exclusive address — a spectacular penthouse on Banana Island with private pool and panoramic views.',
                'description' => '<p>Welcome to the crown jewel of Onpointluxury\'s collection. This extraordinary penthouse on the ultra-exclusive Banana Island represents the ultimate in Lagos luxury living. With 5 bedrooms spanning the entire top floor, a private rooftop infinity pool, and 360° panoramic views, this property is in a class of its own.</p><p>Bespoke Italian furnishings, a state-of-the-art cinema room, professional chef\'s kitchen, and a dedicated house manager ensure every moment of your stay is perfection.</p>',
                'check_in_time' => '15:00', 'check_out_time' => '12:00',
                'cancellation_policy' => 'Non-refundable. 25% deposit required at booking.',
                'house_rules' => 'No smoking indoors. Maximum 10 guests. Events require special arrangement. 3-night minimum stay.',
                'is_featured' => true, 'status' => 'published', 'rating' => 5.0, 'review_count' => 12,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Ikeja Airport Hotel Room',
                'slug' => 'ikeja-airport-hotel-room',
                'location' => 'Ikeja GRA', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $hot->id, 'property_category_id' => $biz->id,
                'price_per_night' => 28000,
                'bedrooms' => 1, 'bathrooms' => 1, 'max_guests' => 2, 'beds' => 1,
                'short_description' => 'Comfortable hotel room minutes from Murtala Muhammed Airport with shuttle service and all modern amenities.',
                'description' => '<p>Perfectly situated just 5 minutes from Murtala Muhammed International Airport, this comfortable hotel room is ideal for transit passengers and business travelers. A complimentary airport shuttle runs every 30 minutes.</p><p>The room features a king-size bed, high-speed WiFi, flat-screen TV, and a well-appointed en-suite bathroom. Complimentary breakfast is available daily.</p>',
                'check_in_time' => '14:00', 'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 6 hours before check-in.',
                'house_rules' => 'No smoking. Quiet hours 11pm–7am.',
                'is_featured' => false, 'status' => 'published', 'rating' => 4.3, 'review_count' => 156,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Eko Atlantic Marina Suite',
                'slug' => 'eko-atlantic-marina-suite',
                'location' => 'Eko Atlantic City', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $ste->id, 'property_category_id' => $lux->id,
                'price_per_night' => 175000, 'weekend_price' => 195000,
                'bedrooms' => 3, 'bathrooms' => 3, 'max_guests' => 6, 'beds' => 3,
                'short_description' => 'Ultra-modern suite in iconic Eko Atlantic City — Africa\'s newest luxury destination with ocean frontage.',
                'description' => '<p>Be among the first to experience living in Eko Atlantic City, Africa\'s most ambitious urban development project rising from the sea. This ultra-modern 3-bedroom marina suite offers floor-to-ceiling ocean views and access to exclusive marina facilities.</p><p>Designed by award-winning architects, the space features smart home automation, a Bose surround-sound system, wine cellar, and a gourmet kitchen with Sub-Zero appliances.</p>',
                'check_in_time' => '15:00', 'check_out_time' => '11:00',
                'cancellation_policy' => 'Free cancellation up to 72 hours before check-in.',
                'house_rules' => 'No smoking. No pets. Sophisticated guests only. Minimum 2-night stay.',
                'is_featured' => true, 'status' => 'published', 'rating' => 4.9, 'review_count' => 23,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Abuja Business Residence',
                'slug' => 'abuja-business-residence',
                'location' => 'Maitama', 'city' => 'Abuja', 'state' => 'FCT',
                'property_type_id' => $svc->id, 'property_category_id' => $biz->id,
                'price_per_night' => 65000, 'monthly_price' => 1500000,
                'bedrooms' => 2, 'bathrooms' => 2, 'max_guests' => 4, 'beds' => 2,
                'short_description' => 'Sophisticated serviced apartment in Maitama ideal for business executives and diplomats.',
                'description' => '<p>Located in Abuja\'s most prestigious district of Maitama, this elegantly furnished 2-bedroom serviced apartment is the preferred choice for business executives, consultants, and visiting diplomats.</p><p>Features include a dedicated executive workspace, fast fibre optic WiFi, daily housekeeping, and 24-hour security. Proximity to the State House, ministries, and major embassies makes this ideal for government-related visits.</p>',
                'check_in_time' => '14:00', 'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 48 hours before check-in.',
                'house_rules' => 'No smoking. No parties or events. Professional use only.',
                'is_featured' => true, 'status' => 'published', 'rating' => 4.8, 'review_count' => 34,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Lekki Family Apartment',
                'slug' => 'lekki-family-apartment',
                'location' => 'Lekki Phase 2', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $apt->id, 'property_category_id' => $fam->id,
                'price_per_night' => 35000,
                'bedrooms' => 3, 'bathrooms' => 2, 'max_guests' => 7, 'beds' => 4,
                'short_description' => 'Spacious 3-bedroom family apartment in Lekki with kids\' play area, garden, and family-friendly amenities.',
                'description' => '<p>This warm and welcoming 3-bedroom family apartment in Lekki Phase 2 is perfectly designed for families looking for a comfortable home away from home. The apartment features a children\'s play corner, board games, and a secure garden area.</p><p>The well-equipped kitchen, dining table for 8, and large living room with Netflix make family evenings enjoyable. Located near Lekki Conservation Centre and top schools.</p>',
                'check_in_time' => '14:00', 'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 24 hours before check-in.',
                'house_rules' => 'Children welcome. No smoking indoors. Maximum 7 guests.',
                'is_featured' => false, 'status' => 'published', 'rating' => 4.6, 'review_count' => 41,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Victoria Island Studio Stay',
                'slug' => 'victoria-island-studio-stay',
                'location' => 'Victoria Island', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $std->id, 'property_category_id' => $cit->id,
                'price_per_night' => 22000,
                'bedrooms' => 1, 'bathrooms' => 1, 'max_guests' => 2, 'beds' => 1,
                'short_description' => 'Chic studio apartment in Victoria Island — perfect for solo travelers and couples seeking a stylish Lagos base.',
                'description' => '<p>This smartly designed studio apartment in the heart of Victoria Island offers everything a modern traveler needs in a compact, stylish space. Floor-to-ceiling windows flood the room with natural light and city views.</p><p>The Murphy bed folds away to reveal a fully equipped workspace. High-speed WiFi, Nespresso machine, and curated local art make this a designer base for exploring Lagos\'s best restaurants, bars, and beaches.</p>',
                'check_in_time' => '15:00', 'check_out_time' => '11:00',
                'cancellation_policy' => 'Free cancellation up to 24 hours before check-in.',
                'house_rules' => 'No smoking. No pets. Maximum 2 guests.',
                'is_featured' => false, 'status' => 'published', 'rating' => 4.5, 'review_count' => 78,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Ikoyi Corporate Housing',
                'slug' => 'ikoyi-corporate-housing',
                'location' => 'Ikoyi', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $svc->id, 'property_category_id' => $cor->id,
                'price_per_night' => 95000, 'monthly_price' => 2200000,
                'bedrooms' => 3, 'bathrooms' => 3, 'max_guests' => 6, 'beds' => 3,
                'short_description' => 'Distinguished corporate housing in Ikoyi for senior executives and long-stay professionals.',
                'description' => '<p>This distinguished 3-bedroom corporate residence in Ikoyi is designed for senior professionals on extended assignments. The property combines the comfort of home with corporate-grade amenities including a dedicated meeting room, executive desk setup, and high-speed business internet.</p><p>Monthly rates available for stays of 30 days or more. Services include weekly housekeeping, linen changes, and building management on call 24/7.</p>',
                'check_in_time' => '14:00', 'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 72 hours. Non-refundable for same-day cancellations.',
                'house_rules' => 'No smoking. No unauthorized visitors. Professional conduct expected.',
                'is_featured' => false, 'status' => 'published', 'rating' => 4.8, 'review_count' => 15,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Lagos Island Boutique Hotel',
                'slug' => 'lagos-island-boutique-hotel',
                'location' => 'Lagos Island', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $hot->id, 'property_category_id' => $rom->id,
                'price_per_night' => 55000, 'weekend_price' => 65000,
                'bedrooms' => 1, 'bathrooms' => 1, 'max_guests' => 2, 'beds' => 1,
                'short_description' => 'Intimate boutique hotel on Lagos Island blending heritage charm with modern luxury — ideal for romantic getaways.',
                'description' => '<p>Housed in a beautifully restored colonial-era building on Lagos Island, this intimate boutique hotel offers a unique blend of heritage charm and contemporary luxury. Each of the 12 suites has been individually designed with a curated mix of Nigerian artisanal crafts and international designer furniture.</p><p>The rooftop bar with panoramic Marina views, in-house spa, and award-winning Nigerian restaurant make this a destination within a destination. Perfect for couples and luxury weekend retreats.</p>',
                'check_in_time' => '15:00', 'check_out_time' => '11:00',
                'cancellation_policy' => 'Free cancellation up to 48 hours before check-in.',
                'house_rules' => 'Adults only (18+). No smoking in rooms. Dress code applies at rooftop bar.',
                'is_featured' => true, 'status' => 'published', 'rating' => 4.7, 'review_count' => 89,
                'user_id' => $manager->id,
            ],
            [
                'name' => 'Chevron Luxury Villa',
                'slug' => 'chevron-luxury-villa',
                'location' => 'Chevron Drive, Lekki', 'city' => 'Lagos', 'state' => 'Lagos',
                'property_type_id' => $vil->id, 'property_category_id' => $lux->id,
                'price_per_night' => 150000, 'weekend_price' => 175000,
                'bedrooms' => 5, 'bathrooms' => 4, 'max_guests' => 12, 'beds' => 5,
                'short_description' => 'Grand 5-bedroom luxury villa on Chevron Drive with private pool, home cinema, and lush tropical gardens.',
                'description' => '<p>This magnificent 5-bedroom luxury villa on the exclusive Chevron Drive in Lekki is the ultimate choice for group travel, family gatherings, and special occasions. The sprawling property features a private heated pool, tropical gardens, and a fully equipped outdoor entertainment area.</p><p>Inside, the villa offers a home cinema with 4K projector, professional chef\'s kitchen, wine cellar, and a billiards room. A live-in housekeeper and cook can be arranged on request. The compound fits 6 cars.</p>',
                'check_in_time' => '15:00', 'check_out_time' => '12:00',
                'cancellation_policy' => 'Free cancellation up to 72 hours. 50% refund for cancellations within 48 hours.',
                'house_rules' => 'No outdoor amplified music after 10pm. Pool use with supervision only. Maximum 12 guests.',
                'is_featured' => true, 'status' => 'published', 'rating' => 4.9, 'review_count' => 31,
                'user_id' => $manager->id,
            ],
        ];

        $allAmenityIds = collect($amenityModels)->pluck('id')->toArray();

        foreach ($properties as $propData) {
            $property = Property::updateOrCreate(['slug' => $propData['slug']], $propData);

            // Sync amenities (only if not already attached)
            if ($property->amenities()->count() === 0) {
                $selected = $allAmenityIds;
                shuffle($selected);
                $property->amenities()->attach(array_slice($selected, 0, rand(8, 14)));
            }

            // Add images (only if not already added)
            if ($property->images()->count() === 0) {
                $imgs = $imageGroups[$property->slug] ?? [];
                foreach ($imgs as $i => $url) {
                    PropertyImage::create([
                        'property_id' => $property->id,
                        'image'       => $url,
                        'caption'     => $property->name . ' — Photo ' . ($i + 1),
                        'sort_order'  => $i,
                    ]);
                }
                // Also set featured_image to first image URL
                if (!empty($imgs)) {
                    $property->update(['featured_image' => $imgs[0]]);
                }
            }
        }

        $this->command->info('Seeding FAQs...');

        $faqs = [
            ['question' => 'How do I make a booking?', 'answer' => 'Simply browse our properties, select your preferred apartment or hotel, choose your check-in and check-out dates, and proceed to book. You can pay securely online with Paystack or contact us via WhatsApp.', 'category' => 'booking'],
            ['question' => 'What is the cancellation policy?', 'answer' => 'Cancellation policies vary by property. Most properties offer free cancellation up to 24–72 hours before check-in. The specific policy is clearly stated on each property\'s page.', 'category' => 'booking'],
            ['question' => 'Is my payment secure?', 'answer' => 'Yes, absolutely. We use Paystack, Nigeria\'s most trusted payment gateway, which is PCI-DSS compliant. Your card details are never stored on our servers.', 'category' => 'payment'],
            ['question' => 'Can I pay with bank transfer?', 'answer' => 'Yes, we accept bank transfers. After initiating your booking, select "Contact via WhatsApp" and our team will provide bank transfer details and confirm your reservation upon receipt of payment.', 'category' => 'payment'],
            ['question' => 'What happens after I book?', 'answer' => 'Once your booking is confirmed and payment received, you will receive a detailed confirmation email with your booking reference, property address, and check-in instructions.', 'category' => 'booking'],
            ['question' => 'Can I check in early or check out late?', 'answer' => 'Early check-in and late check-out are subject to availability. Please contact the property in advance. Additional charges may apply for late check-out after 2pm.', 'category' => 'checkin'],
            ['question' => 'Are utilities included in the price?', 'answer' => 'Yes, all utilities including electricity, water, WiFi, and air conditioning are included in the rental price. There are no hidden charges.', 'category' => 'pricing'],
            ['question' => 'Is there a minimum stay requirement?', 'answer' => 'Most properties can be booked for a minimum of 1 night. Some premium properties may require a minimum stay of 2–3 nights, which is indicated on the property page.', 'category' => 'booking'],
            ['question' => 'Do you offer monthly rates?', 'answer' => 'Yes, many of our properties offer discounted monthly rates for extended stays. Contact us via WhatsApp or check the property listing for monthly pricing.', 'category' => 'pricing'],
            ['question' => 'How do I contact the property after booking?', 'answer' => 'After your booking is confirmed, you will receive the property manager\'s contact details. You can also use our WhatsApp button on the property page for direct communication.', 'category' => 'general'],
            ['question' => 'Are pets allowed?', 'answer' => 'Pet policies vary by property. Some properties welcome pets with prior notice, while others have a strict no-pet policy. Please check the house rules on the property listing before booking.', 'category' => 'general'],
            ['question' => 'Is parking available?', 'answer' => 'Most of our properties include complimentary parking. The number of parking spaces available is listed in the amenities section of each property.', 'category' => 'general'],
        ];
        foreach ($faqs as $i => $faq) {
            Faq::updateOrCreate(['question' => $faq['question']], array_merge($faq, ['sort_order' => $i, 'is_active' => true]));
        }

        $this->command->info('Seeding testimonials...');

        $testimonials = [
            ['name' => 'Emeka Okafor',     'title' => 'Business Executive, Lagos',       'rating' => 5, 'comment' => 'Absolutely stunning property! The Victoria Island apartment exceeded every expectation. The views are incredible and the team was incredibly responsive. Will definitely book again!'],
            ['name' => 'Amina Bello',      'title' => 'Wedding Planner, Abuja',          'rating' => 5, 'comment' => 'We hosted our honeymoon at the Banana Island Penthouse and it was absolutely magical. From the seamless booking process to the immaculate property, every detail was perfect.'],
            ['name' => 'David Chen',       'title' => 'International Investor',          'rating' => 5, 'comment' => 'As someone who travels frequently to Lagos for business, finding Onpointluxury has been a game-changer. The Ikoyi apartment is consistently impeccable.'],
            ['name' => 'Chidinma Eze',     'title' => 'Fashion Designer, Lagos',         'rating' => 4, 'comment' => 'Stayed at the Lekki Executive Suite for a week and absolutely loved it! The location is perfect and the check-in process was so smooth. Highly recommend!'],
            ['name' => 'Abdullahi Musa',   'title' => 'Senior Government Official, FCT', 'rating' => 5, 'comment' => 'The Abuja Business Residence is exactly what you would expect — distinguished, private, and impeccably maintained. Perfect for my ministerial visits.'],
            ['name' => 'Sarah Williams',   'title' => 'Expat Professional, Lagos',       'rating' => 5, 'comment' => 'I\'ve been using Onpointluxury for all my Lagos accommodations for the past year. The quality is consistently excellent and the booking process is seamless.'],
        ];
        foreach ($testimonials as $i => $t) {
            Testimonial::updateOrCreate(['name' => $t['name']], array_merge($t, ['sort_order' => $i, 'is_active' => true]));
        }

        $this->command->info('Seeding blog posts...');

        $blogPosts = [
            [
                'title' => 'Best Luxury Apartments in Lagos: A Complete Guide for 2025',
                'slug' => 'best-luxury-apartments-lagos-2025',
                'category' => 'guides',
                'excerpt' => 'Discover the most prestigious addresses in Lagos for short-let luxury living — from Victoria Island to Banana Island.',
                'content' => '<p>Lagos, Africa\'s most vibrant megacity, has emerged as a premier destination for luxury short-term accommodation. With a booming economy, influx of international business, and a growing affluent middle class, demand for high-end short-lets has never been stronger.</p><h3>Victoria Island</h3><p>Home to the most prestigious addresses, Victoria Island offers ocean-view apartments, rooftop pools, and proximity to Lagos\'s finest dining and nightlife. Prices range from ₦80,000 to ₦200,000 per night.</p><h3>Banana Island</h3><p>Nigeria\'s answer to Beverly Hills. The most exclusive residential island in Africa, accessible only by bridge. Penthouse properties start at ₦200,000 per night.</p><h3>Ikoyi</h3><p>Old money meets new luxury. Tree-lined streets, consular residences, and serviced apartments for the corporate elite.</p>',
                'user_id' => $admin->id,
                'is_published' => true,
                'published_at' => now()->subDays(10),
                'seo_title' => 'Best Luxury Apartments in Lagos 2025 | Onpointluxury',
                'seo_description' => 'A complete guide to the best luxury apartments in Lagos for 2025, covering Victoria Island, Ikoyi, Lekki, and Eko Atlantic.',
            ],
            [
                'title' => 'How to Choose the Right Short-let Apartment in Nigeria',
                'slug' => 'how-to-choose-short-let-apartment-nigeria',
                'category' => 'tips',
                'excerpt' => 'Not all short-let apartments are created equal. Here\'s everything you need to know before making your next booking.',
                'content' => '<p>The short-let apartment market in Nigeria has grown exponentially over the past five years. With hundreds of options across Lagos, Abuja, and Port Harcourt, choosing the right property can feel overwhelming.</p><h3>1. Verify the Property is Legitimate</h3><p>Always book through verified platforms like Onpointluxury. Check for reviews, manager profiles, and contact details.</p><h3>2. Check the Amenities</h3><p>Ensure the property has stable power supply (generator), fast WiFi, and is in a safe, well-served neighbourhood.</p><h3>3. Read the Cancellation Policy</h3><p>Understand refund terms before paying. Most reputable short-lets offer free cancellation 24–48 hours before check-in.</p>',
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
                'excerpt' => 'For extended business trips, serviced apartments offer superior value, comfort, and productivity compared to traditional hotels.',
                'content' => '<p>As corporate travel evolves, more business travelers are discovering what seasoned road warriors have known for years: serviced apartments beat hotels on almost every metric for stays longer than 3 days.</p><h3>More Space</h3><p>A standard serviced apartment offers 2–3× the living space of a hotel room at a comparable price. Separate bedroom, living room, and kitchen make a week-long trip feel like home.</p><h3>Cost Savings</h3><p>With a fully equipped kitchen, you save significantly on daily restaurant bills. Many serviced apartments include utilities and WiFi in the rate.</p><h3>Productivity</h3><p>A dedicated workspace, fast internet, and a quiet environment away from a buzzing hotel lobby make deep work possible.</p>',
                'user_id' => $admin->id,
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'seo_title' => 'Why Serviced Apartments Beat Hotels for Business Travel | Onpointluxury',
                'seo_description' => 'Discover why serviced apartments offer better value, comfort and productivity than hotels for business travelers in Nigeria.',
            ],
        ];
        foreach ($blogPosts as $post) {
            BlogPost::updateOrCreate(['slug' => $post['slug']], $post);
        }

        $this->command->info('Seeding reviews...');

        $reviewData = [
            ['rating' => 5, 'comment' => 'Exceptional property! Everything was exactly as described and the host was incredibly helpful. Will definitely return.', 'reviewer_name' => 'Michael A.', 'reviewer_email' => 'michael@example.com'],
            ['rating' => 5, 'comment' => 'Perfect location, immaculate apartment, and outstanding service. This is how luxury should feel.', 'reviewer_name' => 'Fatima K.', 'reviewer_email' => 'fatima@example.com'],
            ['rating' => 4, 'comment' => 'Very comfortable stay. The apartment was clean and well-equipped. Minor issue with WiFi speed but resolved quickly.', 'reviewer_name' => 'James O.', 'reviewer_email' => 'james@example.com'],
            ['rating' => 5, 'comment' => 'Absolutely loved it! The views alone are worth every naira. Will be recommending to everyone.', 'reviewer_name' => 'Ngozi B.', 'reviewer_email' => 'ngozi@example.com'],
        ];
        foreach (Property::take(4)->get() as $i => $prop) {
            Review::firstOrCreate(
                ['property_id' => $prop->id, 'reviewer_email' => $reviewData[$i]['reviewer_email']],
                array_merge($reviewData[$i], ['status' => 'approved'])
            );
        }

        $this->command->info('Seeding CMS pages...');

        $pages = [
            ['title' => 'Home',              'slug' => 'home',          'template' => 'home',    'is_published' => true, 'sort_order' => 0,
             'content' => ''],
            ['title' => 'About Us',          'slug' => 'about',         'template' => 'default', 'is_published' => true, 'sort_order' => 1,
             'content' => '<h2>About On Point Luxury</h2><p>On Point Luxury is Nigeria\'s premier luxury apartment and hotel booking platform, connecting discerning travellers with the finest short-let apartments, serviced residences, and boutique hotels across Lagos, Abuja, and Port Harcourt.</p><p>Founded with a passion for exceptional hospitality, we curate only the best properties — spaces that meet our rigorous standards for quality, safety, cleanliness, and service.</p><h3>Our Mission</h3><p>To make luxury, hassle-free accommodation accessible to every business traveller, tourist, and discerning guest visiting Nigeria\'s premier cities.</p><h3>Why Choose Us?</h3><ul><li>Verified premium properties</li><li>Secure Paystack payments</li><li>24/7 WhatsApp support</li><li>Instant booking confirmation</li><li>No hidden charges</li></ul>'],
            ['title' => 'Contact Us',         'slug' => 'contact',       'template' => 'contact', 'is_published' => true, 'sort_order' => 2,
             'content' => ''],
            ['title' => 'FAQ',               'slug' => 'faq',           'template' => 'faq',     'is_published' => true, 'sort_order' => 3,
             'content' => ''],
            ['title' => 'Terms & Conditions','slug' => 'terms',         'template' => 'default', 'is_published' => true, 'sort_order' => 4,
             'content' => '<h2>Terms &amp; Conditions</h2><p>By accessing and using the On Point Luxury platform, you accept and agree to be bound by the following terms and conditions.</p><h3>Bookings</h3><p>All bookings are subject to availability and confirmation. A booking is only confirmed upon receipt of full payment or confirmed deposit.</p><h3>Cancellations</h3><p>Cancellation policies vary by property and are clearly stated on each listing page. We recommend purchasing travel insurance for non-refundable bookings.</p><h3>Payments</h3><p>All payments are processed securely through Paystack. We accept Visa, Mastercard, and bank transfers.</p><h3>Liability</h3><p>On Point Luxury acts as an intermediary between guests and property owners. We are not liable for issues arising from the property itself beyond our control.</p>'],
            ['title' => 'Privacy Policy',    'slug' => 'privacy',       'template' => 'default', 'is_published' => true, 'sort_order' => 5,
             'content' => '<h2>Privacy Policy</h2><p>On Point Luxury is committed to protecting your personal information. This policy explains how we collect, use, and safeguard your data.</p><h3>Information We Collect</h3><ul><li>Name, email address, and phone number</li><li>Booking and payment information</li><li>Communication history</li><li>Device and usage information</li></ul><h3>How We Use Your Data</h3><p>We use your information to process bookings, send confirmation emails, and improve our services. We do not sell your data to third parties.</p><h3>Security</h3><p>All data is stored on encrypted servers. Payment processing is handled by Paystack, which is PCI-DSS compliant.</p>'],
            ['title' => 'Refund Policy',     'slug' => 'refund-policy', 'template' => 'default', 'is_published' => true, 'sort_order' => 6,
             'content' => '<h2>Refund Policy</h2><p>Our refund policy is designed to be fair to both guests and property owners.</p><h3>Standard Refunds</h3><p>Refunds are processed within 5–7 business days of approval. The refund will be returned to the original payment method.</p><h3>Cancellation Refunds</h3><p>Refund amounts depend on the property\'s specific cancellation policy. Please review this carefully before booking.</p><h3>Disputes</h3><p>If you have a dispute regarding a refund, please contact us at hello@onpointluxury.com within 14 days of check-out.</p>'],
        ];
        foreach ($pages as $pageData) {
            Page::updateOrCreate(['slug' => $pageData['slug']], $pageData);
        }

        $this->command->info('Seeding menus...');

        $headerMenu = Menu::updateOrCreate(['location' => 'header'], ['name' => 'Header Menu', 'is_active' => true]);
        $footerMenu = Menu::updateOrCreate(['location' => 'footer'], ['name' => 'Footer Menu', 'is_active' => true]);

        if ($headerMenu->items()->count() === 0) {
            $headerItems = [
                ['label' => 'Home',       'url' => '/',           'sort_order' => 0],
                ['label' => 'Properties', 'url' => '/properties', 'sort_order' => 1],
                ['label' => 'Blog',       'url' => '/blog',       'sort_order' => 2],
                ['label' => 'FAQ',        'url' => '/faq',        'sort_order' => 3],
                ['label' => 'Contact',    'url' => '/contact',    'sort_order' => 4],
            ];
            foreach ($headerItems as $item) {
                MenuItem::create(array_merge($item, ['menu_id' => $headerMenu->id, 'is_active' => true]));
            }
        }

        if ($footerMenu->items()->count() === 0) {
            $footerItems = [
                ['label' => 'About Us',           'url' => '/about',         'sort_order' => 0],
                ['label' => 'Properties',         'url' => '/properties',    'sort_order' => 1],
                ['label' => 'Terms & Conditions', 'url' => '/terms',         'sort_order' => 2],
                ['label' => 'Privacy Policy',     'url' => '/privacy',       'sort_order' => 3],
                ['label' => 'Refund Policy',      'url' => '/refund-policy', 'sort_order' => 4],
                ['label' => 'Contact Us',         'url' => '/contact',       'sort_order' => 5],
                ['label' => 'FAQ',                'url' => '/faq',           'sort_order' => 6],
            ];
            foreach ($footerItems as $item) {
                MenuItem::create(array_merge($item, ['menu_id' => $footerMenu->id, 'is_active' => true]));
            }
        }

        $this->command->info('Seeding settings...');

        $settings = [
            ['key' => 'site_name',               'value' => 'On Point Luxury',                                           'group' => 'general'],
            ['key' => 'site_tagline',             'value' => 'Premium Stays, Perfectly Booked',                          'group' => 'general'],
            ['key' => 'contact_email',            'value' => 'hello@onpointluxury.com',                                  'group' => 'general'],
            ['key' => 'contact_phone',            'value' => '+234 800 ONPOINT',                                         'group' => 'general'],
            ['key' => 'whatsapp_number',          'value' => '2348012345678',                                            'group' => 'general'],
            ['key' => 'address',                  'value' => '15 Adeola Odeku Street, Victoria Island, Lagos, Nigeria',  'group' => 'general'],
            ['key' => 'currency',                 'value' => 'NGN',                                                      'group' => 'general'],
            ['key' => 'timezone',                 'value' => 'Africa/Lagos',                                             'group' => 'general'],
            ['key' => 'paystack_public_key',      'value' => 'pk_test_xxxxxxxxxxxxxxxxxxxx',                             'group' => 'paystack'],
            ['key' => 'paystack_secret_key',      'value' => 'sk_test_xxxxxxxxxxxxxxxxxxxx',                             'group' => 'paystack'],
            ['key' => 'paystack_mode',            'value' => 'test',                                                     'group' => 'paystack'],
            ['key' => 'paystack_currency',        'value' => 'NGN',                                                      'group' => 'paystack'],
            ['key' => 'paystack_enabled',         'value' => '1',                                                        'group' => 'paystack'],
            ['key' => 'guest_booking',            'value' => '1',                                                        'group' => 'booking'],
            ['key' => 'require_login',            'value' => '0',                                                        'group' => 'booking'],
            ['key' => 'default_checkin_time',     'value' => '14:00',                                                    'group' => 'booking'],
            ['key' => 'default_checkout_time',    'value' => '12:00',                                                    'group' => 'booking'],
            ['key' => 'tax_percentage',           'value' => '0',                                                        'group' => 'booking'],
            ['key' => 'service_charge',           'value' => '0',                                                        'group' => 'booking'],
            ['key' => 'cancellation_window',      'value' => '24',                                                       'group' => 'booking'],
            ['key' => 'auto_expire_minutes',      'value' => '30',                                                       'group' => 'booking'],
            ['key' => 'whatsapp_template',        'value' => "Hello, I am interested in booking {property}.\n\nProperty: {property}\nLocation: {location}\nPrice: {price} per night\nCheck-in: {checkin}\nCheck-out: {checkout}\nGuests: {guests}\n\nPlease confirm availability.", 'group' => 'whatsapp'],
            ['key' => 'whatsapp_inquiry_enabled', 'value' => '1',                                                        'group' => 'whatsapp'],
            ['key' => 'whatsapp_booking_enabled', 'value' => '1',                                                        'group' => 'whatsapp'],
            ['key' => 'meta_title',               'value' => 'On Point Luxury — Premium Apartment & Hotel Bookings in Nigeria', 'group' => 'seo'],
            ['key' => 'meta_description',         'value' => 'Book luxury apartments, hotel suites, and serviced residences across Lagos, Abuja, and Port Harcourt. Secure online payments, instant confirmation.', 'group' => 'seo'],
            ['key' => 'robots_txt',               'value' => "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /client\nDisallow: /manager", 'group' => 'seo'],
        ];
        foreach ($settings as $s) {
            \App\Models\Setting::set($s['key'], $s['value'], $s['group']);
        }

        $this->command->info('');
        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════');
        $this->command->info('  LOGIN CREDENTIALS');
        $this->command->info('═══════════════════════════════════════════');
        $this->command->info('  Admin');
        $this->command->info('    Email:    admin@onpointluxury.com');
        $this->command->info('    Password: password');
        $this->command->info('    URL:      /login  →  /admin/dashboard');
        $this->command->info('');
        $this->command->info('  Manager');
        $this->command->info('    Email:    manager@onpointluxury.com');
        $this->command->info('    Password: password');
        $this->command->info('    URL:      /login  →  /manager/dashboard');
        $this->command->info('');
        $this->command->info('  Client');
        $this->command->info('    Email:    client@onpointluxury.com');
        $this->command->info('    Password: password');
        $this->command->info('    URL:      /login  →  /client/dashboard');
        $this->command->info('═══════════════════════════════════════════');
    }
}
