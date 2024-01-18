<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class MainController extends Controller
{

    public function dashboard()
    {

        return view('dashboard', ['data' => '']);
    }

    public function index()
    {
        $currentUser = auth()->user();
        $pages = Page::orderBy('id', 'DESC')->get()->toArray();
        $res = [];
        foreach ($pages as $page) {
            $query = Video::with(['earnings'])->where('page_id', $page['id']);
            if ($currentUser->role == 'staff') {
                $query->where('user_id', $currentUser->id);
            }    
            $videos = $query->orderBy('id', 'DESC')->get()->toArray();

            $earnings = 0;
            foreach ($videos as $video) {
                if (!empty($video['earnings'])) {
                    $earnings += array_sum(array_column($video['earnings'], 'total_video_ad_break_earnings')) / 5;
                }
            }

            $page['earnings'] = format_number_cent($earnings);
            $res[] = $page;
        }

        return view('page.index', ['data' => $res]);
    }

    public function create()
    {
        return view('page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'folder' => 'required|mimes:zip',
        ]);
        
        try {
            $req = $request->all();
            // $file = request()->file('folder');
            // $filename = slugify(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time();

            // $zip = new ZipArchive();
            // $file_new_path = $file->storeAs('public/shared', $filename, 'local');
            // $zipFile = $zip->open(Storage::path($file_new_path));
            // if ($zipFile == TRUE) {
            //     $des = 'public/shared-unzip/' . $filename;
            //     $zip->extractTo(Storage::path($des)); 
            //     $zip->close();
            // }

            $des = 'public/shared-unzip/' . 'ok-623-20files-1705559903';
            $files_path = Storage::files($des);
            foreach ($files_path as $file_path) {
                $file_name = basename($file_path);
                $file_content = Storage::get($file_path);
                // dd($file_content);
            }
            // dd($files_path);

            
            return redirect()->route('page.index')->withSuccess('Upload ok.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function show(Request $request)
    {
        $id = $request->id;
        $page = Page::with(['videos'])->find($id);
        if ($page) {
            return view('page.show', compact(['page']));
        }

        return redirect()->route('page.index')->withError('Not found this item.');
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $page = Page::with(['videos'])->find($id);
        if ($page) {
            return view('page.update', compact(['page']));
        }

        return redirect()->route('page.index')->withError('Not found this item.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'fb_id' => 'required|string'
        ]);
        try {
            $page = Page::find($request->id);
            if ($page) {
                $shortToken = $request->access_token;
                if (!empty($shortToken)) {
                    $fb = new \Facebook\Facebook(fb_config());
                    $oAuth2Client = $fb->getOAuth2Client();
                    $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($shortToken);
    
                    $page->access_token = $longLivedAccessToken->getValue();
                    $page->access_token_expire_at = Carbon::parse($longLivedAccessToken->getExpiresAt())->format('Y-m-d h:i:s');
                }
                
                $page->title = $request->title;
                $page->description = $request->description;
                $page->fb_id = $request->fb_id;
                $page->is_earning = $request->is_earning;

                $page->save();
                return redirect()->route('page.show', ['id' => $request->id])->withSuccess('Updated this item successfully.');
            }
            return redirect()->route('page.index')->withError('Not found this item.');
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            return redirect()->route('page.index')->withError('Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $page = Page::find($request->id);
        $page->delete();
        return redirect()->route('page.index')->withSuccess('Deleted successfully.');
    }

}
