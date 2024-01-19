<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class MergeController extends Controller
{

    public function index()
    {
        return view('merge', ['groups' => []]);
    }

    public function merge(Request $request)
    {
        $request->validate([
            'folder_path' => 'required|string',
        ]);
        
        try {
            $folder_path = request()->folder_path;
            $files = glob($folder_path . "/*");

            $groups = [];
            foreach ($files as $file) {
                if (strpos($file, '.DS_Store') !== false) {
                    continue;
                }

                if (is_file($file)) {
                    $file_content = file_get_contents($file);
                    // $file_content = str_replace('\u{FEFF}', '', $file_content);

                    $explode_1 = explode("\n", $file_content);
                    foreach ($explode_1 as $line) {
                        $explode_2 = explode('|', $line);
                        if (isset($explode_2[2]) && intval($explode_2[2]) >= 5000) {
                            $line = $explode_2[0] . '|' . $explode_2[1] . '|' . $explode_2[2];
                            $groups[] = $line;
                        }
                    }
                }
            }

            $groups = array_unique($groups);
            $ctn_groups = count($groups);
            $groups = implode("\n", $groups);

            return view('merge', [
                'groups' => $groups,
                'ctn_groups' => $ctn_groups
            ]);
            // return redirect()->route('merge.index')->withSuccess('Upload ok.');
          
            return redirect()->route('dashboard')->withError('Upload failed.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

}
