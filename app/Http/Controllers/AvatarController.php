<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AvatarController extends Controller
{

    public function index()
    {
        return view('avatar');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numb' => 'required|integer|max:1000|min:1',
            'path' => 'required|string',
        ]);

        try {
            $numb = intval($request->numb);
            $path = $request->path;
            for ($i = 0; $i < $numb; $i++) {
                $url = 'https://thispersondoesnotexist.com/';
                $content = file_get_contents($url);
                $name = time() . '.png';
                file_put_contents($path . '/' . $name, $content);
                // sleep(1);
            }

            return view('avatar', [
                'message' => 'Success.',
                'numb' => $request->numb,
                'path' => $request->path,
            ]);
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

}
