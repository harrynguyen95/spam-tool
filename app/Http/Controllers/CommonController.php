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
                if (($key % 1000) == 20) {
                    sleep(2);
                }
                $explode = explode('|', $line);

                $text = GoogleTranslate::trans($explode[1], 'en');
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
