<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\{LoginController, RegisterController, ForgotPasswordController, ResetPasswordController};
use App\Http\Controllers\{HomeController, PropertyController, BookingController, PaymentController, ContactController, BlogController, FaqController, PageController, FavoriteController};
use App\Http\Controllers\Client\{DashboardController as ClientDashboard, BookingController as ClientBookingController, ProfileController as ClientProfile, FavoriteController as ClientFavorite};
use App\Http\Controllers\Manager\{DashboardController as ManagerDashboard, PropertyController as ManagerProperty, BookingController as ManagerBooking};
use App\Http\Controllers\Admin\{DashboardController as AdminDashboard, PropertyController as AdminProperty, BookingController as AdminBooking, UserController as AdminUser, SettingsController as AdminSettings, BlogController as AdminBlog, FaqController as AdminFaq, TestimonialController as AdminTestimonial, ReviewController as AdminReview, PageController as AdminPage, MenuController as AdminMenu, PaymentController as AdminPayment, RoomController as AdminRoom, HeroSlideController as AdminHeroSlide};

// Guest / Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/{slug}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');

// Clean URL aliases for CMS pages
Route::get('/about', [PageController::class, 'show'])->defaults('slug', 'about')->name('about');
Route::get('/privacy', [PageController::class, 'show'])->defaults('slug', 'privacy')->name('privacy');
Route::get('/privacy-policy', [PageController::class, 'show'])->defaults('slug', 'privacy')->name('privacy-policy');
Route::get('/terms', [PageController::class, 'show'])->defaults('slug', 'terms')->name('terms');
Route::get('/refund-policy', [PageController::class, 'show'])->defaults('slug', 'refund-policy')->name('refund-policy');

// Booking
Route::get('/booking/{property}', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::get('/booking/{booking}/whatsapp', [BookingController::class, 'whatsappRedirect'])->name('booking.whatsapp');

// Payment
Route::get('/payment/{booking}/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::post('/payment/initialize', [PaymentController::class, 'initialize'])->name('payment.initialize');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

// Favorites (toggle works for guest and auth)
Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

// Client Dashboard
Route::middleware(['auth', 'client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboard::class, 'index'])->name('dashboard');
    Route::get('/bookings', [ClientBookingController::class, 'index'])->name('bookings');
    Route::get('/bookings/{booking}', [ClientBookingController::class, 'show'])->name('booking-show');
    Route::get('/favorites', [ClientFavorite::class, 'index'])->name('favorites');
    Route::post('/favorites/remove', [ClientFavorite::class, 'remove'])->name('favorites.remove');
    Route::get('/profile', [ClientProfile::class, 'show'])->name('profile');
    Route::post('/profile', [ClientProfile::class, 'update'])->name('profile.update');
});

// Manager Dashboard
Route::middleware(['auth', 'manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerDashboard::class, 'index'])->name('dashboard');
    Route::get('/properties', [ManagerProperty::class, 'index'])->name('properties');
    Route::get('/bookings', [ManagerBooking::class, 'index'])->name('bookings');
    Route::get('/bookings/{booking}', [ManagerBooking::class, 'show'])->name('booking-show');
});

// Admin Dashboard
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Hero Slides
    Route::resource('hero-slides', AdminHeroSlide::class)->parameters(['hero-slides' => 'heroSlide']);
    Route::post('/hero-slides/reorder', [AdminHeroSlide::class, 'reorder'])->name('hero-slides.reorder');
    Route::post('/hero-slides/{heroSlide}/toggle', [AdminHeroSlide::class, 'toggleActive'])->name('hero-slides.toggle');

    // Properties
    Route::resource('properties', AdminProperty::class);
    Route::delete('/properties/{property}/images/{image}', [AdminProperty::class, 'destroyImage'])->name('properties.images.destroy');
    Route::post('/properties/{property}/images/reorder', [AdminProperty::class, 'reorderImages'])->name('properties.images.reorder');

    // Rooms
    Route::resource('properties.rooms', AdminRoom::class)->shallow();

    // Bookings
    Route::get('/bookings', [AdminBooking::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [AdminBooking::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [AdminBooking::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [AdminBooking::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/status', [AdminBooking::class, 'updateStatus'])->name('bookings.status');

    // Users
    Route::resource('users', AdminUser::class)->except(['show']);
    Route::post('/users/{user}/toggle-status', [AdminUser::class, 'toggleStatus'])->name('users.toggle-status');

    // Payments
    Route::get('/payments', [AdminPayment::class, 'index'])->name('payments.index');

    // Blog
    Route::resource('blog', AdminBlog::class);

    // Reviews
    Route::get('/reviews', [AdminReview::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [AdminReview::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/reject', [AdminReview::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [AdminReview::class, 'destroy'])->name('reviews.destroy');

    // FAQs
    Route::resource('faqs', AdminFaq::class);

    // Testimonials
    Route::resource('testimonials', AdminTestimonial::class);

    // Pages
    Route::resource('pages', AdminPage::class);

    // Menus
    Route::resource('menus', AdminMenu::class);

    // Settings
    Route::get('/settings/general', [AdminSettings::class, 'general'])->name('settings.general');
    Route::post('/settings/general', [AdminSettings::class, 'updateGeneral'])->name('settings.general.update');
    Route::get('/settings/homepage', [AdminSettings::class, 'homepage'])->name('settings.homepage');
    Route::post('/settings/homepage', [AdminSettings::class, 'updateHomepage'])->name('settings.homepage.update');
    Route::get('/settings/smtp', [AdminSettings::class, 'smtp'])->name('settings.smtp');
    Route::post('/settings/smtp', [AdminSettings::class, 'updateSmtp'])->name('settings.smtp.update');
    Route::get('/settings/paystack', [AdminSettings::class, 'paystack'])->name('settings.paystack');
    Route::post('/settings/paystack', [AdminSettings::class, 'updatePaystack'])->name('settings.paystack.update');
    Route::get('/settings/whatsapp', [AdminSettings::class, 'whatsapp'])->name('settings.whatsapp');
    Route::post('/settings/whatsapp', [AdminSettings::class, 'updateWhatsapp'])->name('settings.whatsapp.update');
    Route::get('/settings/booking', [AdminSettings::class, 'booking'])->name('settings.booking');
    Route::post('/settings/booking', [AdminSettings::class, 'updateBooking'])->name('settings.booking.update');
    Route::get('/settings/seo', [AdminSettings::class, 'seo'])->name('settings.seo');
    Route::post('/settings/seo', [AdminSettings::class, 'updateSeo'])->name('settings.seo.update');
    Route::get('/settings/scripts', [AdminSettings::class, 'scripts'])->name('settings.scripts');
    Route::post('/settings/scripts', [AdminSettings::class, 'updateScripts'])->name('settings.scripts.update');

    // Messages
    Route::get('/messages', [\App\Http\Controllers\Admin\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{message}', [\App\Http\Controllers\Admin\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{message}/read', [\App\Http\Controllers\Admin\MessageController::class, 'markRead'])->name('messages.read');
    Route::delete('/messages/{message}', [\App\Http\Controllers\Admin\MessageController::class, 'destroy'])->name('messages.destroy');
});
