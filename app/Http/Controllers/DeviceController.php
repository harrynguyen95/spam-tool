<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\LastConfig;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::orderBy('id', 'DESC')->orderBy('name', 'asc')->get();
        $config = LastConfig::latest()->first();
        if (empty($config)) {
            LastConfig::create([]);
        }

        $config = LastConfig::latest()->first();

        return view('device.index', ['devices' => $devices, 'config' => $config]);
    }

    public function create()
    {
        return view('device.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => [
                'required',
                'string',
                Rule::in(['Hải', 'Nam', 'Hiến']),
            ],
            'name' => 'required|string',
            'ip_address' => [
                'required',
                'ipv4',
                'regex:/^192\.168\.(?:25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)\.(?:25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)$/',
            ],
        ]);
        
        try {
            Device::create([
                'username' => $request->username,
                'note' => $request->note,
                'name' => $request->name,
                'ip_address' => $request->ip_address,
                'tsproxy_id' => $request->tsproxy_id,
                'tsproxy_port' => $request->tsproxy_port,
            ]);

            return redirect()->route('device.index')->withSuccess('Create ok.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function edit(Request $request)
    {
        $device = Device::findOrFail($request->id);
        return view('device.update', ['device' => $device]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => [
                'required',
                'string',
                Rule::in(['Hải', 'Nam', 'Hiến']),
            ],
            'name' => 'required|string',
            'tsproxy_id' => 'sometimes|string',
            'tsproxy_port' => 'sometimes|string',
            'ip_address' => [
                'required',
                'ipv4',
                'regex:/^192\.168\.(?:25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)\.(?:25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)$/',
            ],
        ]);
        
        try {
            $device = Device::find($request->id);
            Device::where('id', $request->id)->update([
                'username' => $request->username,
                'note' => $request->note,
                'name' => $request->name,
                'ip_address' => $request->ip_address,
                'tsproxy_id' => $request->tsproxy_id,
                'tsproxy_port' => $request->tsproxy_port,
            ]);

            $payloadData = [];
            $payloadData[] = [
                'username'                  => $device->username,
                'device'                    => $device->ip_address,
                'tsproxy_id'                => $request->tsproxy_id,
            ];

            if (! empty($request->tsproxy_id)) {
                try {
                    $apiUrl = url('https://tuongtacthongminh.com/reg_clone/device_config.php');
                    Http::asForm()->timeout(120)->post($apiUrl, [
                        'action' => 'update',
                        'data'   => json_encode($payloadData),
                    ]);
                } catch (\Exception $e) {
                    logger()->error($e->getMessage());
                }
            }

            return redirect()->route('device.index')->withSuccess('Update ok.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $device = Device::find($request->id);
        $device->delete();

        return redirect()->route('device.index')->withSuccess('Deleted successfully.');
    }

    public function getSourceFilecontent(Request $request)
    {
        try {
            $localIP = $request->get('localIP');
            $inputPath = storage_path('app/separated/'.$localIP.'.txt');

            if (!file_exists($inputPath)) {
                return response()->json(['error' => 'File not found'], 404);
            }

            $lines = file($inputPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            return response()->json([
                'status' => 'success',
                'count' => count($lines),
                'data' => $lines
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'info' => $e->getMessage()
            ]);
        }
    }

    public function countLineSourceFile(Request $request)
    {
        try {
            $localIP = $request->get('localIP');
            $countLine = $request->get('countLine');
            Device::where('ip_address', $localIP)->update(['count_line' => $countLine]);

            return response()->json([
                'status' => 'success',
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'info' => $e->getMessage()
            ]);
        }
    }
}
