<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    public function index()
    {
        $settings = CompanySetting::firstOrCreate([], []);
        return view('admin.setting', compact('settings'));
    }

    public function getSettings()
    {
        $settings = CompanySetting::firstOrCreate([], []);
        return response()->json([
            'success' => true,
            'data' => $settings->toArray()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_short_name' => 'nullable|string|max:100',
            'company_tagline' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
            'light_logo' => 'nullable|mimes:jpeg,png,jpg,webp|max:2048',
            'footer_images' => 'nullable|mimes:jpeg,png,jpg,webp|max:10001024',
            'favicon' => 'nullable|mimes:ico,png,jpg|max:1024',
            'company_email1' => 'nullable|email',
            'company_email2' => 'nullable|email',
            'company_mobile1' => 'nullable|string|max:20',
            'company_mobile2' => 'nullable|string|max:20',
            'company_whatsapp1' => 'nullable|string|max:20',
            'company_whatsapp2' => 'nullable|string|max:20',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'youtube' => 'nullable|url',
            'instagram' => 'nullable|url',
            'pintrest' => 'nullable|url',
            'map' => 'nullable|url',
            'company_address1' => 'nullable|string',
            'company_address2' => 'nullable|string',
            'currency_name' => 'nullable|string|max:50',
            'currency_symbol' => 'nullable|string|max:10',
        ]);

        $settings = CompanySetting::firstOrCreate([]);

        $data = $request->only([
            'company_name', 'company_short_name', 'company_tagline', 'company_description',
            'company_email1', 'company_email2',
            'company_mobile1', 'company_mobile2',
            'company_whatsapp1', 'company_whatsapp2',
            'facebook', 'twitter', 'youtube', 'instagram', 'pintrest', 'map',
            'company_address1', 'company_address2',
            'currency_name', 'currency_symbol'
        ]);

      // Handle file uploads — sirf jab new file aayi ho
    if ($request->hasFile('light_logo')) {
        if ($settings->light_logo && Storage::disk('public')->exists($settings->light_logo)) {
            Storage::disk('public')->delete($settings->light_logo);
        }
        $data['light_logo'] = $request->file('light_logo')->store('company/logos', 'public');
    }
    // Note: Agar file nahi aayi → purani image same rahegi (kuch nahi karenge)

    if ($request->hasFile('footer_images')) {
        if ($settings->footer_images && Storage::disk('public')->exists($settings->footer_images)) {
            Storage::disk('public')->delete($settings->footer_images);
        }
        $data['footer_images'] = $request->file('footer_images')->store('company/logos', 'public');
    }

    if ($request->hasFile('favicon')) {
        if ($settings->favicon && Storage::disk('public')->exists($settings->favicon)) {
            Storage::disk('public')->delete($settings->favicon);
        }
        $data['favicon'] = $request->file('favicon')->store('company/favicons', 'public');
    }

    $settings->update($data);

    return response()->json([
        'success' => true,
        'message' => 'Company settings updated successfully!'
    ]);
}

}