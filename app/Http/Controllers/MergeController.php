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
            'file_merge' => 'required|mimes:zip',
        ]);
        
        try {
            $file = request()->file('file_merge');
            $filename = slugify(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time();
            $today = date('Y-m-d');

            $zip = new ZipArchive();
            $file_new_path = $file->storeAs('public/merge/' . $today, $filename, 'local');
            $zipFile = $zip->open(Storage::path($file_new_path));
            if ($zipFile == TRUE) {
                $des = 'public/merge-unzip/' . $today . '/' . $filename;
                $zip->extractTo(Storage::path($des)); 
                $zip->close();

                $groups = [];
                $directories_path = Storage::directories($des);
                foreach ($directories_path as $directory_path) {
                    if (strpos($directory_path, '__MACOSX') !== false) {
                        continue;
                    }

                    $files_path = Storage::files($directory_path);

                    foreach ($files_path as $file_path) {
                        if (strpos($file_path, '.DS_Store') !== false) {
                            continue;
                        }

                        $file_content = Storage::get($file_path);
                        $explode_1 = explode("\n", $file_content);
                        foreach ($explode_1 as $line) {
                            $explode_2 = explode('|', $line);
                            $line = $explode_2[0] . '|' . $explode_2[1];
                            $groups[] = $line;
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
            }
          
            return redirect()->route('dashboard')->withError('Upload failed.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

}
