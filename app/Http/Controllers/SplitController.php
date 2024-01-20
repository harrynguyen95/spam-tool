<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SplitController extends Controller
{

    public function getSplit()
    {
        return view('split');
    }

    public function split(Request $request)
    {
        $request->validate([
            'columns' => 'required|numeric',
            'separate' => 'required|string',
            'data' => 'required|string',
        ]);
        
        try {
            $columns = $request->columns;
            $separate = $request->separate;
            $data = $request->data;

            if (strpos($data, "\r") !== false) {
                $data = explode("\r\n", $data);
            } else {            
                $data = explode("\n", $data);
            }
            $ctn_data = count($data);

            $splits = [];
            foreach ($data as $line) {
                $explode = explode($separate, $line);
                for ($i = 0; $i < intval($columns); $i++) {
                    $splits[$i][] = isset($explode[$i]) ? $explode[$i] : '';
                }
            }

            for ($i = 0; $i < intval($columns); $i++) {
                $splits[$i] = implode("\n", $splits[$i]);
            }

            return view('split', [
                'columns' => $columns,
                'separate' => $separate,
                'data' => $request->data,
                'ctn_data' => $ctn_data,
                'splits' => $splits,
            ]);
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

}
