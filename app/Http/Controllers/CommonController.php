<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CommonController extends Controller
{
    private $defaultHashtags = '#trend #trending #viral #amazing #Amazing #reels';

    private $okCountry = [
        'Australia',
        'Denmark',
        'Norway',
        'USA',
        'United States',
        'Singapore',
        'New Zealand',
        'UK',
        'United Kingdom',
        'Canada',
        'Sweden',
    ];

    public function translateIndex()
    {
        return view('translate');
    }

    public function translateStore(Request $request)
    {
        set_time_limit(30000);

        $request->validate([
            'groups' => 'required|string',
        ]);

        try {
            $groups = $request->groups;

            if (strpos($groups, "\r") !== false) {
                $groups = explode("\r\n", $groups);
            } else {            
                $groups = explode("\n", $groups);
            }
            $ctn = count($groups);

            $translations = [];
            foreach ($groups as $key => $line) {
                if (($key % 5000) == 20) {
                    // sleep(1);
                }
                $explode = explode('|', $line);
                if (!preg_match('/[^A-Za-z0-9 #$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]+/', $explode[1])) { // is En
                    $text = $explode[1];
                } else {
                    $text = GoogleTranslate::trans($explode[1], 'en');
                }

                $output = $explode[0] . '|' . $text;
                $translations[] = $output;
            }
            $translations = implode("\n", $translations);
            
            return view('translate', [
                'message' => 'Success.',
                'ctn' => $ctn,
                'groups' => $request->groups,
                'translations' => $translations
            ]);
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function locationIndex()
    {
        return view('location');
    }

    public function locationStore(Request $request)
    {
        set_time_limit(30000);
        $start = Carbon::parse(now());

        $request->validate([
            'groups' => 'required|string',
        ]);

        try {
            $groups = $request->groups;

            if (strpos($groups, "\r") !== false) {
                $groups = explode("\r\n", $groups);
            } else {            
                $groups = explode("\n", $groups);
            }
            $ctn = count($groups);

            $locations = [];
            foreach ($groups as $key => $line) {
                $explode = explode('|', $line);
                if (isset($explode[2])) {
                    $address = $this->getAddress($explode[2]);
                    $country = $this->getCountry($address);
                    if (!empty($country)) {
                        $output = $line . '|' . $country;
                        $locations[] = $output;
                    }
                }
            }
            $ctn_locations = count($locations);
            $locations = implode("\n", $locations);

            $end = Carbon::parse(now());
            $minutes = $end->diffInMinutes($start);
            $seconds = $end->diffInSeconds($start);

            $time = $minutes . ':' . $seconds;
            return view('location', [
                'message' => 'Success in: ' . $time,
                'ctn' => $ctn,
                'groups' => $request->groups,
                'ctn_locations' => $ctn_locations,
                'locations' => $locations
            ]);
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    private function getAddress($text)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Goog-Api-Key' => 'AIzaSyD5-lH9byKok3Cm6jCVuvFPTlgBxj8xF7U',
            'X-Goog-FieldMask' => 'places.displayName,places.formattedAddress'
        ])->post('https://places.googleapis.com/v1/places:searchText', [
            'textQuery' => $text,
        ]);

        $address = '';
        $res = $response->json();
        if (!empty($res)) {
            $address = isset($res['places'][0]) ? $res['places'][0]['formattedAddress'] : '';
        }
        return $address;
    }

    private function getCountry($address)
    {
        if (empty($address)) return '';
        foreach ($this->okCountry as $country) {
            if (strpos($address, $country) !== false) {
                return $country;
            }
        }
        return '';
    }

    public function captionIndex()
    {
        return view('caption', [
            'defaultHashtags' => $this->defaultHashtags
        ]);
    }

    public function captionStore(Request $request)
    {
        set_time_limit(30000);
        $start = Carbon::parse(now());

        $request->validate([
            'captions' => 'required|string',
        ]);

        try {
            $captions = $request->captions;
            $hashtags = $request->hashtags;
            $num_hashtag = $request->num_hashtag;
            $has_hashtag = $request->has_hashtag;

            if ($has_hashtag) {
                $hashtags = str_replace(" ", "", $hashtags);
                $hashtags = str_replace("\r\n", "", $hashtags);
                $hashtags = str_replace("\n", "", $hashtags);
                $hashtags =  explode("#", $hashtags);
                $hashtags = array_filter($hashtags);
            }

            if (strpos($captions, "\r") !== false) {
                $captions = explode("\r\n", $captions);
            } else {            
                $captions = explode("\n", $captions);
            }
            $ctn = count($captions);

            $output = [];
            foreach ($captions as $key => $line) {
                if (strpos($line, 'like') !== false) {
                    continue;
                }
                if (strpos($line, 'share') !== false) {
                    continue;
                }
                if (strpos($line, 'click') !== false) {
                    continue;
                }

                $line = str_replace('"', '', $line);
                $line .= ' [r8]';

                if ($has_hashtag) {
                    $rand_keys = array_rand($hashtags, $num_hashtag);
                    if (!is_array($rand_keys)) {
                        $rand_keys = [$rand_keys];
                    }
                    foreach ($rand_keys as $key) {
                        $rand_hashtag = $hashtags[$key];
                        $line .= ' #' . $rand_hashtag;
                    }
                }
                
                $line = str_replace('  ', ' ', $line);
                $output[] = $line;
            }
            $output = array_unique($output);
            $ctn_output = count($output);
            $output = implode("\n", $output);

            $end = Carbon::parse(now());
            $minutes = $end->diffInMinutes($start);
            $seconds = $end->diffInSeconds($start);

            $time = $minutes . ':' . $seconds;
            return view('caption', [
                'message' => 'Success in: ' . $time,
                'ctn' => $ctn,
                'captions' => $request->captions,
                'ctn_output' => $ctn_output,
                'output' => $output,
                'defaultHashtags' => $this->defaultHashtags
            ]);
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

}
