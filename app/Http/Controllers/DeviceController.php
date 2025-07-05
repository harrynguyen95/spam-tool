<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::orderBy('id', 'DESC')->get();

        return view('device.index', ['devices' => $devices]);
    }

    // http://192.168.1.188:8080/control/stop_playing?path=/Facebook/Main.lua
    public function pullcode(Request $request)
    {
        try {
            $device = Device::findOrFail($request->id);
            $title = $device->name . ' - ' . $device->ip_address;

            $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Device/Setup.lua';
            $response = Http::timeout(3)->get($url);

            if ($response->successful()) {
                $res = $response->json(); 
                if ($res['status'] == 'success') {
                    return redirect()->route('device.index')->withSuccess($title . ': PULL CODE success.');
                } else {
                    return redirect()->route('device.index')->withError($title . ": failed " . $res['info']);
                }
            }
            return redirect()->route('device.index')->withError($title . ': PULL CODE failed.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function start(Request $request)
    {
        try {
            $device = Device::findOrFail($request->id);
            $title = $device->name . ' - ' . $device->ip_address;

            $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Main.lua';
            $response = Http::timeout(3)->get($url);
            if ($response->successful()) {
                $res = $response->json(); 
                if ($res['status'] == 'success') {
                    return redirect()->route('device.index')->withSuccess($title . ': START success.');
                } else {
                    return redirect()->route('device.index')->withError($title . ": " . $res['info']);
                }
            }
            return redirect()->route('device.index')->withError($title . ': START failed.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function stop(Request $request)
    {
        try {
            $device = Device::findOrFail($request->id);
            $title = $device->name . ' - ' . $device->ip_address;

            $url = 'http://' . $device->ip_address . ':8080/control/stop_playing?path=/Facebook/Main.lua';
            $response = Http::timeout(3)->get($url);
            if ($response->successful()) {
                $res = $response->json(); 
                if ($res['status'] == 'success') {
                    return redirect()->route('device.index')->withSuccess($title . ': STOP success.');
                } else {
                    return redirect()->route('device.index')->withError($title . ": " . $res['info']);
                }
            }

            return redirect()->route('device.index')->withError($title . ': STOP failed.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function clear(Request $request)
    {
        try {
            $device = Device::findOrFail($request->id);
            $title = $device->name . ' - ' . $device->ip_address;

            $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/zClearLastInProgress.lua';
            $response = Http::timeout(3)->get($url);
            if ($response->successful()) {
                $res = $response->json(); 
                if ($res['status'] == 'success') {
                    return redirect()->route('device.index')->withSuccess($title . ': CLEAR success.');
                } else {
                    return redirect()->route('device.index')->withError($title . ": " . $res['info']);
                }
            }

            return redirect()->route('device.index')->withError($title . ': CLEAR failed.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function respring(Request $request)
    {
        try {
            $device = Device::findOrFail($request->id);
            $title = $device->name . ' - ' . $device->ip_address;

            $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Respring.lua';
            $response = Http::timeout(3)->get($url);
            if ($response->successful()) {
                $res = $response->json(); 
                if ($res['status'] == 'success') {
                    return redirect()->route('device.index')->withSuccess($title . ': RESPRING success.');
                } else {
                    return redirect()->route('device.index')->withError($title . ": " . $res['info']);
                }
            }

            return redirect()->route('device.index')->withError($title . ': RESPRING failed.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function bulkAction(Request $request)
    {
        $deviceIds = $request->input('device_ids', []);
        $action = $request->input('action');

        if (empty($deviceIds)) {
            return redirect()->route('device.index')->withError('Empty device.');
        }

        if ($action == 'start') {
            return $this->startAll($deviceIds);
        } elseif ($action == 'stop') {
            return $this->stopAll($deviceIds);
        } elseif ($action == 'pullcode') {
            return $this->pullcodeAll($deviceIds);
        } elseif ($action == 'clear_inprogress') {
            return $this->clearInprogressAll($deviceIds);
        } elseif ($action == 'respring') {
            return $this->respringAll($deviceIds);
        } elseif ($action == 'config') {
            return $this->configAll($request);
        } elseif ($action == 'change_proxy') {
            return 'change_proxy chưa code.';
        }
    }

    public function startAll($ids)
    {
        $results = [];

        $devices = Device::whereIn('id', $ids)->get();
        foreach ($devices as $device) {
            $title = $device->name . ' - ' . $device->ip_address;

            try {
                $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Main.lua';
                $response = Http::timeout(3)->get($url);
                if ($response->successful()) {
                    $res = $response->json(); 
                    if ($res['status'] == 'success') {
                        $results[] = $title . ': START success.';
                    } else {
                        $results[] = $title . ": failed " . $res['info'];
                    }
                } else {
                    $results[] = $title . ': START failed.';
                }
            } catch (\Exception $e) {
                $results[] = $title . ': START failed.' . ' ' . $e->getMessage();
            }
        }

        return redirect()->route('device.index')->with('results', $results);
    }

    public function stopAll($ids)
    {
        $results = [];

        $devices = Device::whereIn('id', $ids)->get();
        foreach ($devices as $device) {
            $title = $device->name . ' - ' . $device->ip_address;

            try {
                $url = 'http://' . $device->ip_address . ':8080/control/stop_playing?path=/Facebook/Main.lua';
                $response = Http::timeout(3)->get($url);
                if ($response->successful()) {
                    $res = $response->json(); 
                    if ($res['status'] == 'success') {
                        $results[] = $title . ': STOP success.';
                    } else {
                        $results[] = $title . ": failed " . $res['info'];
                    }
                } else {
                    $results[] = $title . ': STOP failed.';
                }
            } catch (\Exception $e) {
                $results[] = $title . ': STOP failed.' . ' ' . $e->getMessage();
            }
        }

        return redirect()->route('device.index')->with('results', $results);
    }

    public function clearInprogressAll($ids)
    {
        $results = [];

        $devices = Device::whereIn('id', $ids)->get();
        foreach ($devices as $device) {
            $title = $device->name . ' - ' . $device->ip_address;

            try {
                $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/zClearLastInProgress.lua';
                $response = Http::timeout(3)->get($url);
                if ($response->successful()) {
                    $res = $response->json(); 
                    if ($res['status'] == 'success') {
                        $results[] = $title . ': CLEAR INPROGRESS success.';
                    } else {
                        $results[] = $title . ": failed " . $res['info'];
                    }
                } else {
                    $results[] = $title . ': CLEAR INPROGRESS failed.';
                }
            } catch (\Exception $e) {
                $results[] = $title . ': CLEAR INPROGRESS failed.' . ' ' . $e->getMessage();
            }
        }

        return redirect()->route('device.index')->with('results', $results);
    }

    public function respringAll($ids)
    {
        $results = [];

        $devices = Device::whereIn('id', $ids)->get();
        foreach ($devices as $device) {
            $title = $device->name . ' - ' . $device->ip_address;

            try {
                $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Respring.lua';
                $response = Http::timeout(3)->get($url);
                if ($response->successful()) {
                    $res = $response->json(); 
                    if ($res['status'] == 'success') {
                        $results[] = $title . ': RESPRING success.';
                    } else {
                        $results[] = $title . ": failed " . $res['info'];
                    }
                } else {
                    $results[] = $title . ': RESPRING failed.';
                }
            } catch (\Exception $e) {
                $results[] = $title . ': RESPRING failed.' . ' ' . $e->getMessage();
            }
        }

        return redirect()->route('device.index')->with('results', $results);
    }

    public function pullcodeAll($ids)
    {
        $results = [];

        $devices = Device::whereIn('id', $ids)->get();
        foreach ($devices as $device) {
            $title = $device->name . ' - ' . $device->ip_address;

            try {
                $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Device/Setup.lua';
                $response = Http::timeout(3)->get($url);
                if ($response->successful()) {
                    $res = $response->json(); 
                    if ($res['status'] == 'success') {
                        $results[] = $title . ': PULL CODE success.';
                    } else {
                        $results[] = $title . ": failed " . $res['info'];
                    }
                } else {
                    $results[] = $title . ': PULL CODE failed.';
                }
            } catch (\Exception $e) {
                $results[] = $title . ': PULL CODE failed.' . ' ' . $e->getMessage();
            }
        }

        return redirect()->route('device.index')->with('results', $results);
    }

    public function configAll($request)
    {
        $ids = $request->input('device_ids', []);

        $results = [];

        $devices = Device::whereIn('id', $ids)->get();
        foreach ($devices as $device) {
            $title = $device->name . ' - ' . $device->ip_address;
            $device->update(['note' => $request->input('note')]);

            try {
                $apiUrl = 'https://tuongtacthongminh.com/device_config.php';
                $response = Http::asForm()->timeout(3)->post($apiUrl, [
                    'action'                      => 'upsert',
                    'username'                    => $device->username,
                    'device_name'                 => $device->name,
                    'device'                      => $device->ip_address,
                    'language'                    => $request->input('language') ?: 'ES',
                    'mail_suply'                  => $request->input('mail_suply') ?: '1',
                    'proxy'                       => $request->input('proxy') ?: '',
                    'hotmail_service_ids'         => $request->input('hotmail_service_ids') ?: '{2,6,1,3,5,59,60}',
                    'enter_verify_code'           => $request->input('enter_verify_code') ?: '0',
                    'hot_mail_source_from_file'   => $request->input('hot_mail_source_from_file') ?: '0',
                    'thue_lai_mail_thuemails'     => $request->input('thue_lai_mail_thuemails') ?: '0',
                    'add_mail_domain'             => $request->input('add_mail_domain') ?: '0',
                    'remove_register_mail'        => $request->input('remove_register_mail') ?: '0',
                    'provider_mail_thuemails'     => $request->input('provider_mail_thuemails') ?: '1',
                    'times_xoa_info'              => $request->input('times_xoa_info') ?: '0',
                    'note'                        => $request->input('note') ?: '',
                ]);

                if ($response->successful()) {
                    $res = $response->json(); 
                    if ($res['status'] == 'success') {
                        $results[] = $title . ': CONFIG success.';
                    } else {
                        $results[] = $title . ": failed " . $res['info'];
                    }
                } else {
                    $results[] = $title . ': CONFIG failed.';
                }
            } catch (\Exception $e) {
                $results[] = $title . ': CONFIG failed.' . ' ' . $e->getMessage();
            }
        }

        return redirect()->route('device.index')->with('results', $results);
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
            'ip_address' => [
                'required',
                'ipv4',
                'regex:/^192\.168\.(?:25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)\.(?:25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)$/',
            ],
        ]);
        
        try {
            Device::where('id', $request->id)->update([
                'username' => $request->username,
                'note' => $request->note,
                'name' => $request->name,
                'ip_address' => $request->ip_address,
            ]);

            return redirect()->route('device.index')->withSuccess('Update ok.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        $device = device::find($request->id);
        $device->delete();

        return redirect()->route('device.index')->withSuccess('Deleted successfully.');
    }

    public function deleteAll()
    {
        device::truncate();
        return redirect()->route('device.index')->withSuccess('Deleted all successfully.');
    }

}
