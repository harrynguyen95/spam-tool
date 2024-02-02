<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class CommonController extends Controller
{

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

}
