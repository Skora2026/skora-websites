<?php

if (!function_exists('company_settings')) {
    function settings($key = null, $default = null)
    {
       if ($key === null) {
            return \App\Models\CompanySetting::allData(); // Full object
        }
        return \App\Models\CompanySetting::getValue($key, $default); // Single value
    }
}

if (!function_exists('hero_ticker_items')) {

    function hero_ticker_items(): array
    {
        $moveText = \App\Models\HeroBanner::query()->value('move_text');

        if (empty($moveText)) {
            return [
                'Sports Injury Physiotherapy',
                'Orthopedic Rehabilitation',
                'Post-Surgery Recovery',
                'Neurological Physiotherapy',
                'Pediatric Physiotherapy',
                'Geriatric Pain Management',
                'Manual Therapy & Mobilization',
                'Spinal Decompression Therapy',
            ];
        }

        return array_values(array_filter(array_map('trim', explode('||', $moveText))));
    }
}