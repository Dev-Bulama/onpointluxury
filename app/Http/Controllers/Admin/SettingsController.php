<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller {
    public function general() {
        $settings = Setting::where('group','general')->pluck('value','key');
        return view('admin.settings.general', compact('settings'));
    }
    
    public function updateGeneral(Request $request) {
        $fields = ['site_name','site_tagline','contact_email','contact_phone','whatsapp_number',
                   'address','currency','timezone','google_map_embed','logo_size'];
        foreach ($fields as $field) {
            Setting::set($field, $request->input($field), 'general');
        }
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings','public');
            Setting::set('logo', $path, 'general');
        }
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('settings','public');
            Setting::set('favicon', $path, 'general');
        }
        return back()->with('success','General settings updated.');
    }
    
    public function smtp() {
        $settings = Setting::where('group','smtp')->pluck('value','key');
        return view('admin.settings.smtp', compact('settings'));
    }
    
    public function updateSmtp(Request $request) {
        $fields = ['smtp_host','smtp_port','smtp_username','smtp_password','smtp_encryption','mail_from_address','mail_from_name'];
        foreach ($fields as $field) {
            Setting::set($field, $request->input($field), 'smtp');
        }
        $this->setEnvValue('MAIL_MAILER', 'smtp');
        $this->setEnvValue('MAIL_HOST', $request->smtp_host);
        $this->setEnvValue('MAIL_PORT', $request->smtp_port);
        $this->setEnvValue('MAIL_USERNAME', $request->smtp_username);
        $this->setEnvValue('MAIL_PASSWORD', $request->smtp_password);
        $this->setEnvValue('MAIL_ENCRYPTION', $request->smtp_encryption);
        $this->setEnvValue('MAIL_FROM_ADDRESS', $request->mail_from_address);
        $this->setEnvValue('MAIL_FROM_NAME', $request->mail_from_name);
        return back()->with('success','SMTP settings updated.');
    }
    
    public function sendTestEmail(Request $request) {
        $request->validate(['test_email' => 'required|email']);
        try {
            Mail::raw('This is a test email from Onpointluxury. Your SMTP settings are working correctly.', function($msg) use ($request) {
                $msg->to($request->test_email)->subject('Test Email - Onpointluxury');
            });
            return back()->with('success','Test email sent successfully.');
        } catch (\Exception $e) {
            return back()->with('error','Failed to send test email: '.$e->getMessage());
        }
    }
    
    public function paystack() {
        $settings = Setting::where('group','paystack')->pluck('value','key');
        return view('admin.settings.paystack', compact('settings'));
    }
    
    public function updatePaystack(Request $request) {
        $fields = ['paystack_public_key','paystack_secret_key','paystack_mode','paystack_currency','paystack_enabled'];
        foreach ($fields as $field) {
            Setting::set($field, $request->input($field), 'paystack');
        }
        return back()->with('success','Paystack settings updated.');
    }
    
    public function booking() {
        $settings = Setting::where('group','booking')->pluck('value','key');
        return view('admin.settings.booking', compact('settings'));
    }
    
    public function updateBooking(Request $request) {
        $fields = ['guest_booking','require_login','default_checkin_time','default_checkout_time',
                   'tax_percentage','service_charge','cancellation_window','auto_expire_minutes'];
        foreach ($fields as $field) {
            Setting::set($field, $request->input($field), 'booking');
        }
        return back()->with('success','Booking settings updated.');
    }
    
    public function whatsapp() {
        $settings = Setting::where('group','whatsapp')->pluck('value','key');
        return view('admin.settings.whatsapp', compact('settings'));
    }
    
    public function updateWhatsapp(Request $request) {
        $fields = ['whatsapp_number','whatsapp_template','whatsapp_inquiry_enabled','whatsapp_booking_enabled'];
        foreach ($fields as $field) {
            Setting::set($field, $request->input($field), 'whatsapp');
        }
        return back()->with('success','WhatsApp settings updated.');
    }
    
    public function scripts() {
        $settings = Setting::where('group','scripts')->pluck('value','key');
        return view('admin.settings.scripts', compact('settings'));
    }
    
    public function updateScripts(Request $request) {
        $fields = ['chatbot_script','google_analytics','facebook_pixel','header_scripts','footer_scripts'];
        foreach ($fields as $field) {
            Setting::set($field, $request->input($field), 'scripts');
        }
        return back()->with('success','Script settings updated.');
    }
    
    public function seo() {
        $settings = Setting::where('group','seo')->pluck('value','key');
        return view('admin.settings.seo', compact('settings'));
    }
    
    public function updateSeo(Request $request) {
        $fields = ['meta_title','meta_description','robots_txt'];
        foreach ($fields as $field) {
            Setting::set($field, $request->input($field), 'seo');
        }
        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('settings','public');
            Setting::set('og_image', $path, 'seo');
        }
        return back()->with('success','SEO settings updated.');
    }
    
    private function setEnvValue($key, $value) {
        $path = base_path('.env');
        if (file_exists($path)) {
            $content = file_get_contents($path);
            $pattern = "/^{$key}=.*/m";
            $replacement = "{$key}={$value}";
            if (preg_match($pattern, $content)) {
                file_put_contents($path, preg_replace($pattern, $replacement, $content));
            } else {
                file_put_contents($path, $content . "\n{$key}={$value}");
            }
        }
    }
}
