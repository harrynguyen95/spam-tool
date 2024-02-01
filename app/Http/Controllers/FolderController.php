<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Config;
use Illuminate\Http\Request;

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
        return view('dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'folder_path' => 'required|string',
        ]);
        
        try {
            $folder_path = request()->folder_path;
            $folder = Folder::create([
                'name' => $request->name,
                'folder_path' => $folder_path,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $configs = [];
            $files = glob($folder_path . "/*");
            foreach ($files as $file) {
                if (strpos($file, '.DS_Store') !== false) {
                    continue;
                }

                if (is_file($file)) {
                    $file_content = file_get_contents($file);
                    $explode_1 = explode("\n", $file_content);
                    foreach ($explode_1 as $line) {
                        $explode_2 = explode('|', $line);
                        $configs[] = [
                            'folder_id' => $folder->id,
                            'nick_uid' => basename($file),
                            'group_uid' => $explode_2[0],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                        if (count($configs) == 1000) {
                            Config::insert($configs);
                            $configs = [];
                        }
                    }
                }
            }
            Config::insert($configs);

            return redirect()->route('folder.index')->withSuccess('Upload ok.');
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
                ->orderBy('group_uid', 'ASC')
                ->orderBy('nick_uid', 'ASC')
                ->get()->toArray();

            $data = [];
            foreach ($configs_1 as $config) {
                if (! isset($data[$config['group_uid']])) {
                    $data[$config['group_uid']] = $config['nick_uid'];
                }
            }

            $nick_uids = array_unique(array_values($data));
            $group_uids = array_unique(array_keys($data));

            sort($nick_uids);
            sort($group_uids);

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

            $configs_3 = Config::selectRaw('group_uid, count(nick_uid) as ctn')
                ->where('folder_id', $folder->id)
                ->groupBy('group_uid')
                ->orderBy('ctn', 'ASC')
                ->get()
                ->toArray();

            $group_with_count_nicks = "";
            foreach ($configs_3 as $conf) {
                $line = $conf['group_uid'] . '|' . $conf['ctn'];
                $group_with_count_nicks .= $line . "\n";
            }

            return view('folder.show', [
                'folder' => $folder,
                'nick_uids' => $nick_uids,
                'ctn_nick_uids' => $ctn_nick_uids,
                'group_uids' => $group_uids,
                'ctn_group_uids' => $ctn_group_uids,
                'nick_with_count_groups' => $nick_with_count_groups,
                'ctn_nick_with_count_groups' => count($configs_2),
                'group_with_count_nicks' => $group_with_count_nicks,
                'ctn_group_with_count_nicks' => count($configs_3),
            ]);
        }

        return redirect()->route('folder.index')->withError('Not found this item.');
    }

    public function destroy(Request $request)
    {
        $folder = Folder::find($request->id);
        Config::where('folder_id', $request->id)->delete();
        $folder->delete();

        return redirect()->route('folder.index')->withSuccess('Deleted successfully.');
    }

    public function deleteAll()
    {
        Folder::truncate();
        Config::truncate();
        return redirect()->route('folder.index')->withSuccess('Deleted all successfully.');
    }

}
