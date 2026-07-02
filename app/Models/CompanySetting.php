<?php
// Model: app/Models/CompanySetting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanySetting extends Model
{
    protected $table = 'company_settings';

    protected $fillable = [
        'company_name', 'company_short_name', 'company_tagline', 'company_description',
        'light_logo', 'footer_images', 'favicon',
        'company_email1', 'company_email2',
        'company_mobile1', 'company_mobile2',
        'company_whatsapp1', 'company_whatsapp2',
        'facebook', 'twitter', 'linkedin', 'instagram', 'pintrest', 'map',
        'company_address1', 'company_address2',
        'currency_name', 'currency_symbol'
    ];


    public static function getValue($key, $default = null)
    {
        $setting = static::first(); 
        return $setting?->$key ?? $default; 
    }

    // All data ek saath
    public static function allData()
    {
        return static::first(); // Full object
    }


}