<?php

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

if (!function_exists('res')) {
    function res($code = 200, $message = '', $data = [])
    {
        if (is_array($message)) {
            $data = $message['data'];
            $message = $message['message'];
        }
        return response()->json(
            [
                'success' => in_array($code, [200, 201]) ? true : false,
                'code' => $code,
                'message' => $message,
                'data' => $data,
            ],
            200
        );
    }
}

if (!function_exists('serverError')) {
    function serverError($ex)
    {
        return res(500, $ex->getMessage() ?? $ex);
    }
}

if (!function_exists('cxl_asset')) {
    function cxl_asset($path)
    {
        $path = asset('/' . $path);
        return $path;
    }
}

if (!function_exists('setLanguageSession')) {
    function setLanguageSession()
    {
        $lang_code = 'en';
        $cookieLang = Cookie::get('suggest_lang_code');
        if ($cookieLang) {
            $decrypt = Crypt::decrypt($cookieLang, false);
            $decrypt = explode('|', $decrypt);
            $lang_code = isset($decrypt[1]) ? $decrypt[1] : 'en';
        }
        
        $all = \App\Models\Translation::where('lang_code', $lang_code)
            ->select('text_key', 'text_translation')
            ->get()
            ->keyBy('text_key')
            ->toArray();

        session(['trans' => $all]);
    }
}

if (!function_exists('languageArray')) {
    function languageArray($code = '')
    {
        $arr = ['ja' => '日本語', 'en' => 'English', 'vn' => 'Tiếng Việt'];
        return $code ? $arr[$code] : $arr;
    }
}

if (!function_exists('languageArrayEn')) {
    function languageArrayEn($code = '')
    {
        $arr = ['ja' => 'Japanese', 'en' => 'English', 'vn' => 'Vietnamese'];
        return $code ? $arr[$code] : $arr;
    }
}

if (!function_exists('t')) {
    function t($key = '')
    {   
        $trans = cache()->get('trans');
        return isset($trans[$key]) && isset($trans[$key]['text_translation']) ? $trans[$key]['text_translation'] : $key;
    }
}

if (!function_exists('fb_config')) {
    function fb_config()
    {
        $appId = '356283358815027';
        $appSecret = 'e7eeac0c90d7062dae627322e3a275dd';
        return [
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v2.10',
        ];
    }
}

if (!function_exists('format_number')) {
    function format_number($number)
    {
        if ($number < 1000) return $number;
        return number_format((float)($number/1000), 2, '.', '') . 'K';
    }
}

if (!function_exists('format_number_cent')) {
    function format_number_cent($number)
    {
        $cent = number_format((float)($number/100), 2, '.', '');
        if ($cent < 1000) return $cent;
        return number_format((float)($cent/1000), 2, '.', '') . 'K';
    }
}

if (!function_exists('format_miliseconds')) {
    function format_miliseconds($seconds)
    {
        $mili = number_format((float)($seconds/1000), 0, '.', '');
        if ($mili < 60) return $mili . ' seconds';
        if ($mili >= 3600) return number_format((float)($mili/3600), 1, '.', '') . ' hour';
        if ($mili >= 60) return number_format((float)($mili/60), 1, '.', '') . ' minutes';
        return '-';
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        return auth()->user()->role == 'admin';
    }
}

if (!function_exists('slugify')) {
    function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
