<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class FolderController extends Controller
{

    public function dashboard()
    {

        return view('dashboard', ['data' => '']);
    }

    public function index()
    {
        $folders = Folder::orderBy('id', 'DESC')->get();
        return view('folder.index', ['data' => $folders]);
    }

    public function create()
    {
        return view('folder.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'folder' => 'required|mimes:zip',
        ]);
        
        try {
            $file = request()->file('folder');
            $filename = slugify(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time();
            $today = date('Y-m-d');

            $zip = new ZipArchive();
            $file_new_path = $file->storeAs('public/shared/' . $today, $filename, 'local');
            $zipFile = $zip->open(Storage::path($file_new_path));
            if ($zipFile == TRUE) {
                $des = 'public/shared-unzip/' . $today . '/' . $filename;
                $zip->extractTo(Storage::path($des)); 
                $zip->close();

                $folder = Folder::create([
                    'name' => $request->name,
                    'upload_name' => $filename,
                    'upload_destination' => $file_new_path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $configs = [];
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

                        $file_name = basename($file_path);
                        $file_content = Storage::get($file_path);
                        $explode_1 = explode("\n", $file_content);
                        foreach ($explode_1 as $line) {
                            $explode_2 = explode('|', $line);
                            $configs[] = [
                                'folder_id' => $folder->id,
                                'nick_uid' => $file_name,
                                'group_uid' => $explode_2[0],
                                'created_at' => now(),
                                'updated_at' => now(),
                            ];
    
                        }
                    }
                    Config::insert($configs);

                }
                return redirect()->route('folder.index')->withSuccess('Upload ok.');
            }
          
            return redirect()->route('dashboard')->withError('Upload failed.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $folder = Folder::find($id);

        if ($folder) {
            $configs_1 = Config::where('folder_id', $folder->id)
                ->distinct('group_uid', 'nick_uid')
                ->orderBy('group_uid', 'ASC')
                ->orderBy('nick_uid', 'ASC')
                ->get()
                ->toArray();
            $nick_uids = array_column($configs_1, 'nick_uid');
            $group_uids = array_column($configs_1, 'group_uid');

            $ctn_nick_uids = count($nick_uids);
            $ctn_group_uids = count($group_uids);

            $nick_uids = implode("\n", $nick_uids);
            $group_uids = implode("\n", $group_uids);

            $configs_2 = Config::selectRaw('nick_uid, count(group_uid) as ctn')
                ->where('folder_id', $folder->id)
                ->groupBy('nick_uid')
                ->orderBy('ctn', 'ASC')
                ->get()
                ->toArray();

            $nick_with_count_groups = "";
            foreach ($configs_2 as $conf) {
                $line = $conf['nick_uid'] . '|' . $conf['ctn'];
                $nick_with_count_groups .= $line . "\n";
            }

            return view('folder.show', [
                'folder' => $folder,
                'nick_uids' => $nick_uids,
                'ctn_nick_uids' => $ctn_nick_uids,
                'group_uids' => $group_uids,
                'ctn_group_uids' => $ctn_group_uids,
                'nick_with_count_groups' => $nick_with_count_groups,
                'ctn_nick_with_count_groups' => count($configs_2),
            ]);
        }

        return redirect()->route('folder.index')->withError('Not found this item.');
    }

    public function destroy(Request $request)
    {
        $folder = Folder::find($request->id);
        $uploadPath = $folder->upload_destination;
        $unzipPath = str_replace('shared', 'shared-unzip', $folder->upload_destination);

        Storage::delete($uploadPath);
        Storage::deleteDirectory($unzipPath);

        $folder->delete();
        Config::where('folder_id', $request->id)->delete();

        return redirect()->route('folder.index')->withSuccess('Deleted successfully.');
    }

}
