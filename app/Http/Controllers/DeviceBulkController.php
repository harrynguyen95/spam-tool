<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\LastConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DeviceBulkController extends Controller
{
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

            $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Remote/ClearLastInProgress.lua';
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

    public function openscreen(Request $request)
    {
        try {
            $device = Device::findOrFail($request->id);
            $title = $device->name . ' - ' . $device->ip_address;

            $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Remote/OpenScreen.lua';
            $response = Http::timeout(3)->get($url);
            if ($response->successful()) {
                $res = $response->json(); 
                if ($res['status'] == 'success') {
                    return redirect()->route('device.index')->withSuccess($title . ': Open Screen success.');
                } else {
                    return redirect()->route('device.index')->withError($title . ": " . $res['info']);
                }
            }

            return redirect()->route('device.index')->withError($title . ': Open Screen failed.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function closescreen(Request $request)
    {
        try {
            $device = Device::findOrFail($request->id);
            $title = $device->name . ' - ' . $device->ip_address;

            $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Remote/CloseScreen.lua';
            $response = Http::timeout(3)->get($url);
            if ($response->successful()) {
                $res = $response->json(); 
                if ($res['status'] == 'success') {
                    return redirect()->route('device.index')->withSuccess($title . ': Close Screen success.');
                } else {
                    return redirect()->route('device.index')->withError($title . ": " . $res['info']);
                }
            }

            return redirect()->route('device.index')->withError($title . ': Close Screen failed.');
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

    public function respring(Request $request)
    {
        try {
            $device = Device::findOrFail($request->id);
            $title = $device->name . ' - ' . $device->ip_address;

            $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Remote/Respring.lua';
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
        session(['order_dir' => $request->input('order_dir')]);
        session(['file_setting_status' => $request->input('file_setting_status')]);
        session(['common_setting_status' => $request->input('common_setting_status')]);
        session(['account_setting_status' => $request->input('account_setting_status')]);
        
        if (empty($deviceIds)) {
            return redirect()->route('device.index')->withError('Empty device.');
        }

        if ($action == 'start') {
            return $this->startAll($deviceIds);
        } elseif ($action == 'stop') {
            return $this->stopAll($deviceIds);
        } elseif ($action == 'pullcode') {
            return $this->pullcodeAll($deviceIds);
        }

        if ($action == 'config') {
            return $this->configAll($request);
        } elseif ($action == 'setupES') {
            return $this->setupLang($request, 'ES');
        } elseif ($action == 'setupEN') {
            return $this->setupLang($request, 'EN');
        } elseif ($action == 'setupVN') {
            return $this->setupLang($request, 'VN');
        } elseif ($action == 'deleteSelected') {
            return $this->deleteSelected($deviceIds);
        } elseif ($action == 'Separate') {
            return $this->separateFile($request);
        }

        if (in_array($action, ['ClearLastInProgress', 'CheckInternet', 'ProxyXoainfo', 'Respring', 'CloseScreen', 'XoaPhotoImage',
            'OpenScreen', 'Xoainfo', 'CleanSourceFile', 'CountLineSourceFile', 'OffShadowRocket', 'OnShadowRocket'])) {
            return $this->executeRemoteScript($deviceIds, $action);
        }

        return 'Not found action.';
    }

    public function executeRemoteScript($ids, $action)
    {
        $results = [];
        $failedIds = [];

        $devices = Device::whereIn('id', $ids)->orderBy('name', 'asc')->get();
        foreach ($devices as $device) {
            $title = $device->name . ' - ' . $device->ip_address;

            try {
                $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Remote/'.$action.'.lua';
                $response = Http::timeout(3)->get($url);
                if ($response->successful()) {
                    $res = $response->json(); 
                    if ($res['status'] == 'success') {
                        $results[] = $title . ': '.$action.' success.';
                    } else {
                        $results[] = $title . ": failed " . $res['info'];
                        $failedIds[] = $device->id;
                    }
                } else {
                    $results[] = $title . ': '.$action.' failed.';
                    $failedIds[] = $device->id;
                }
            } catch (\Exception $e) {
                $results[] = $title . ': '.$action.' failed.' . ' ' . $e->getMessage();
                $failedIds[] = $device->id;
            }
        }

        if ($action == 'CountLineSourceFile') {
            sleep(3);
        }

        return redirect()->route('device.index')->with('results', $results)->with('selected_device_ids', $ids)->with('failed_ids', $failedIds);
    }

    public function startAll($ids)
    {
        $results = [];
        $failedIds = [];

        $devices = Device::whereIn('id', $ids)->orderBy('name', 'asc')->get();
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
                        $failedIds[] = $device->id;
                    }
                } else {
                    $results[] = $title . ': START failed.';
                    $failedIds[] = $device->id;
                }
            } catch (\Exception $e) {
                $results[] = $title . ': START failed.' . ' ' . $e->getMessage();
                $failedIds[] = $device->id;
            }
        }

        return redirect()->route('device.index')->with('results', $results)->with('selected_device_ids', $ids)->with('failed_ids', $failedIds);
    }

    public function stopAll($ids)
    {
        $results = [];
        $failedIds = [];

        $devices = Device::whereIn('id', $ids)->orderBy('name', 'asc')->get();
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
                        $failedIds[] = $device->id;
                    }
                } else {
                    $results[] = $title . ': STOP failed.';
                    $failedIds[] = $device->id;
                }
            } catch (\Exception $e) {
                $results[] = $title . ': STOP failed.' . ' ' . $e->getMessage();
                $failedIds[] = $device->id;
            }
        }

        return redirect()->route('device.index')->with('results', $results)->with('selected_device_ids', $ids)->with('failed_ids', $failedIds);
    }

    

    public function pullcodeAll($ids)
    {
        $results = [];
        $failedIds = [];

        $devices = Device::whereIn('id', $ids)->orderBy('name', 'asc')->get();
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
                        $failedIds[] = $device->id;
                    }
                } else {
                    $results[] = $title . ': PULL CODE failed.';
                    $failedIds[] = $device->id;
                }
            } catch (\Exception $e) {
                $results[] = $title . ': PULL CODE failed.' . ' ' . $e->getMessage();
                $failedIds[] = $device->id;
            }
        }

        return redirect()->route('device.index')->with('results', $results)->with('selected_device_ids', $ids)->with('failed_ids', $failedIds);
    }

    public function setupLang($request, $lang)
    {
        $ids = $request->input('device_ids', []);
        $results = [];
        $failedIds = [];

        Device::whereIn('id', $ids)->update(['lang' => $lang]);
        $devices = Device::whereIn('id', $ids)->orderBy('name', 'asc')->get();
        foreach ($devices as $device) {
            $title = $device->name . ' - ' . $device->ip_address;

            try {
                $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Remote/SetupDevice'.$lang.'.lua';
                $response = Http::timeout(3)->get($url);
                if ($response->successful()) {
                    $res = $response->json(); 
                    if ($res['status'] == 'success') {
                        $results[] = $title . ': Setup '.$lang.' success.';
                    } else {
                        $results[] = $title . ": failed " . $res['info'];
                        $failedIds[] = $device->id;
                    }
                } else {
                    $results[] = $title . ': Setup '.$lang.' failed.';
                    $failedIds[] = $device->id;
                }
            } catch (\Exception $e) {
                $results[] = $title . ': Setup '.$lang.' failed.' . ' ' . $e->getMessage();
                $failedIds[] = $device->id;
            }
        }

        return redirect()->route('device.index')->with('results', $results)->with('selected_device_ids', $ids)->with('failed_ids', $failedIds);
    }

    public function configAll($request)
    {
        $ids = $request->input('device_ids', []);
        session(['order_dir' => $request->input('order_dir')]);
        session(['file_setting_status' => $request->input('file_setting_status')]);
        session(['common_setting_status' => $request->input('common_setting_status')]);
        session(['account_setting_status' => $request->input('account_setting_status')]);

        $devices = Device::whereIn('id', $ids)->orderBy('name', 'asc')->get();

        Device::whereIn('id', $ids)->update([
            'note' => $request->input('note'),
            'mail_suply' => $request->input('mail_suply'),
            'language' => $request->input('language'),
            'account_region' => $request->input('account_region'),
        ]);

        LastConfig::latest()->first()->update([
            'language'                  => $request->input('language') ?: 'EN',
            'account_region'            => $request->input('account_region') ?: 'US',
            'mail_suply'                => $request->input('mail_suply') ?: '1',
            'proxy'                     => $request->input('proxy') ?: '',
            'hotmail_service_ids'       => $request->input('hotmail_service_ids') ?: '{2,6,1,3,5,59,60}',
            'enter_verify_code'         => $request->input('enter_verify_code') ?: '0',
            'api_key_thuemails'         => $request->input('api_key_thuemails') ?: '',
            'api_key_dongvanfb'         => $request->input('api_key_dongvanfb') ?: '',
            'hot_mail_source_from_file' => $request->input('hot_mail_source_from_file') ?: '0',
            'thue_lai_mail_thuemails'   => $request->input('thue_lai_mail_thuemails') ?: '0',
            'add_mail_domain'           => $request->input('add_mail_domain') ?: '0',
            'reg_phone_first'           => $request->input('reg_phone_first') ?: '0',
            'login_with_code'           => $request->input('login_with_code') ?: '0',
            'remove_register_mail'      => $request->input('remove_register_mail') ?: '0',
            'provider_mail_thuemails'   => $request->input('provider_mail_thuemails') ?: '1',
            'times_xoa_info'            => $request->input('times_xoa_info') ?: '0',
            'change_info'               => $request->input('change_info') ?: '0',
            'note'                      => $request->input('note') ?: '',
            'local_server'              => $request->input('local_server') ?: '',
            'destination_filename'      => $request->input('destination_filename') ?: '',
            'source_filepath'           => $request->input('source_filepath') ?: '',
            'separate_items'            => $request->input('separate_items') ?: '',
        ]);


        $payloadData = [];

        foreach ($devices as $device) {
            $payloadData[] = [
                'username'                  => $device->username,
                'device_name'               => $device->name,
                'device'                    => $device->ip_address,
                'language'                  => $request->input('language') ?: 'EN',
                'account_region'            => $request->input('account_region') ?: 'US',
                'mail_suply'                => $request->input('mail_suply') ?: '1',
                'proxy'                     => $request->input('proxy') ?: '',
                'hotmail_service_ids'       => $request->input('hotmail_service_ids') ?: '{2,6,1,3,5,59,60}',
                'enter_verify_code'         => $request->input('enter_verify_code') ?: '0',
                'api_key_thuemails'         => $request->input('api_key_thuemails') ?: '',
                'api_key_dongvanfb'         => $request->input('api_key_dongvanfb') ?: '',
                'hot_mail_source_from_file' => $request->input('hot_mail_source_from_file') ?: '0',
                'thue_lai_mail_thuemails'   => $request->input('thue_lai_mail_thuemails') ?: '0',
                'add_mail_domain'           => $request->input('add_mail_domain') ?: '0',
                'reg_phone_first'           => $request->input('reg_phone_first') ?: '0',
                'login_with_code'           => $request->input('login_with_code') ?: '0',
                'remove_register_mail'      => $request->input('remove_register_mail') ?: '0',
                'provider_mail_thuemails'   => $request->input('provider_mail_thuemails') ?: '1',
                'times_xoa_info'            => $request->input('times_xoa_info') ?: '0',
                'change_info'               => $request->input('change_info') ?: '0',
                'note'                      => $request->input('note') ?: '',
                'local_server'              => $request->input('local_server') ?: '',
                'destination_filename'      => $request->input('destination_filename') ?: '',
                'source_filepath'           => $request->input('source_filepath') ?: '',
                'separate_items'            => $request->input('separate_items') ?: '',
            ];
        }

        try {
            $apiUrl = url('/reg_clone/device_config.php');
            $response = Http::asForm()->timeout(120)->post($apiUrl, [
                'action' => 'upsert',
                'data'   => json_encode($payloadData),
            ]);

            $results = [];
            $failedIds = [];

            if ($response->successful()) {
                $res = $response->json();

                foreach ($res['results'] ?? [] as $index => $result) {
                    $device = $devices[$index];
                    $title = $device->name . ' - ' . $device->ip_address;

                    if ($result['status'] === 'success') {
                        $results[] = "$title: CONFIG success.";
                    } else {
                        $message = $result['message'] ?? $result['info'] ?? '(no message)';
                        $results[] = "$title: CONFIG failed. $message";
                        $failedIds[] = $device->id;
                    }
                }
            } else {
                $results[] = 'API request failed (non-200).';
                $failedIds[] = $device->id;
            }
        } catch (\Exception $e) {
            $results[] = 'API exception: ' . $e->getMessage();
            $failedIds[] = $device->id;
        }

       
        return redirect()->route('device.index')->with('results', $results)->with('selected_device_ids', $ids)->with('failed_ids', $failedIds);
    }

    public function deleteSelected($ids)
    {
        $results = [];
        $failedIds = [];

        $devices = Device::whereIn('id', $ids)->orderBy('name', 'asc')->get();
        foreach ($devices as $device) {
            try {
                $title = $device->name . ' - ' . $device->ip_address;
                $device->delete();

                $results[] = $title . ': Delete success.';
            } catch (\Exception $e) {
                $results[] = $title . ': Delete failed.' . ' ' . $e->getMessage();
                $failedIds[] = $device->id;
            }
        }

        return redirect()->route('device.index')->with('results', $results)->with('selected_device_ids', $ids)->with('failed_ids', $failedIds);
    }

    public function separateFile($request)
    {
        try {
            $ids = $request->input('device_ids', []);
            session(['order_dir' => $request->input('order_dir')]);
            session(['file_setting_status' => $request->input('file_setting_status')]);
            session(['common_setting_status' => $request->input('common_setting_status')]);
            session(['account_setting_status' => $request->input('account_setting_status')]);

            $sourceFilepath = $request->input('source_filepath');
            $separateItems = $request->input('separate_items');
            
            $devices = Device::whereIn('id', $ids)->orderBy('name', 'asc')->get();

            if (!file_exists($sourceFilepath)) {
                return 'File không tồn tại hoặc PHP không có quyền truy cập.';
            }

            $outputDir = 'separated';
            $allLines = file($sourceFilepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            Storage::delete(Storage::files($outputDir));
            
            foreach ($devices as $i => $device) {
                $chunk = array_slice($allLines, $i * $separateItems, $separateItems);
                $ipAddress = $device->ip_address;

                $filename = $ipAddress . ".txt";
                $fileContent = implode("\n", $chunk);

                Storage::put("$outputDir/$filename", $fileContent);
            }

            $usedLinesCount = count($devices) * $separateItems;
            $remainingLines = array_slice($allLines, $usedLinesCount);

            file_put_contents($sourceFilepath, implode("\n", $remainingLines));
            // return 'OK';

            $results = [];
            $failedIds = [];
            foreach ($devices as $device) {
                $title = $device->name . ' - ' . $device->ip_address;

                try {
                    $url = 'http://' . $device->ip_address . ':8080/control/start_playing?path=/Facebook/Remote/UploadSourceFile.lua';
                    $response = Http::timeout(3)->get($url);
                    if ($response->successful()) {
                        $res = $response->json(); 
                        if ($res['status'] == 'success') {
                            $results[] = $title . ': UploadSourceFile success.';
                        } else {
                            $results[] = $title . ": failed " . $res['info'];
                            $failedIds[] = $device->id;
                        }
                    } else {
                        $results[] = $title . ': UploadSourceFile failed.';
                        $failedIds[] = $device->id;
                    }
                } catch (\Exception $e) {
                    $results[] = $title . ': UploadSourceFile failed.' . ' ' . $e->getMessage();
                    $failedIds[] = $device->id;
                }
            }

            return redirect()->route('device.index')->with('results', $results)->with('selected_device_ids', $ids)->with('failed_ids', $failedIds);
        } catch(\Exception $e) {
            return redirect()->route('dashboard')->withError('Error: ' . $e->getMessage());
        }
    }

}
