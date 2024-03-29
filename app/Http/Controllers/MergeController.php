<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

            // $groups = array_unique($groups);
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

    public function getCompare()
    {
        return view('compare');
    }

    public function compare(Request $request)
    {
        try {
            $part_1 = $request->part_1;
            $part_2 = $request->part_2;

            if (strpos($part_1, "\r") !== false) {
                $part_1 = explode("\r\n", $part_1);
            } else {            
                $part_1 = explode("\n", $part_1);
            }
            if (strpos($part_2, "\r") !== false) {
                $part_2 = explode("\r\n", $part_2);
            } else {            
                $part_2 = explode("\n", $part_2);
            }

            $ctn_part_1 = count($part_1);
            $ctn_part_2 = count($part_2);

            $diff_1 = array_unique(array_diff($part_1, $part_2));
            $ctn_diff_1 = count($diff_1);
            $diff_1 = implode("\n", $diff_1);


            $diff_2 = array_unique(array_diff($part_2, $part_1));
            $ctn_diff_2 = count($diff_2);
            $diff_2 = implode("\n", $diff_2);

            $intersect = array_unique(array_intersect($part_1, $part_2));
            $ctn_intersect = count($intersect);
            $intersect = implode("\n", $intersect);

            $part_1 = implode("\n", $part_1);
            $part_2 = implode("\n", $part_2);

            return view('compare', [
                'part_1' => $part_1,
                'ctn_part_1' => $ctn_part_1,
                'part_2' => $part_2,
                'ctn_part_2' => $ctn_part_2,
                'diff_1' => $diff_1,
                'ctn_diff_1' => $ctn_diff_1,
                'diff_2' => $diff_2,
                'ctn_diff_2' => $ctn_diff_2,
                'intersect' => $intersect,
                'ctn_intersect' => $ctn_intersect,
            ]);
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

}
