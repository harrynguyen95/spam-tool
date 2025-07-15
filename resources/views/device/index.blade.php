@extends('layouts.main')
@section('page_title')
    Autotouch Device
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Device</li>
</ul>
@endsection
@section('content')
    @php
        $selected = session('selected_device_ids', []);
        $failed = session('failed_ids', []);
    @endphp

    <div class="sp-push-index">
        <form method="POST" action="{{ route("device.bulkAction") }}">
            @csrf
            
            <input type="hidden" name="order_dir" id="order_dir">
            <div class="row">
                <div class="col-md-5">
                    <div class="mb-3">
                        <button type="button" class="btn btn-sm btn-default"><a style="color: #444" href="{{ route('device.create') }}">Create New Device</a></button>
                        <button type="button" class="btn btn-sm btn-default" style="color: #ccc"> | </button>
                        <button type="submit" class="btn btn-sm btn-success" name="action" value="start">Start Reg Selected</button>
                        <button type="submit" class="btn btn-sm btn-danger" name="action" value="stop">Stop Reg Selected</button>
                        <button type="submit" class="btn btn-sm btn-primary" name="action" value="pullcode">Pull Code Selected</button>
                        <button type="submit" class="btn btn-sm btn-default" name="action" value="ClearLastInProgress">Clear INPROGRESS</button>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-default" name="action" value="deleteSelected"
                            onclick="return confirm('Are you sure you want to Delete these items?');" style="color: #d73925">Delete Selected</button>
                        <button type="submit" class="btn btn-sm btn-warning" name="action" value="Respring">Respring</button>
                        <button type="submit" class="btn btn-sm btn-default" name="action" value="Xoainfo"
                            onclick="return confirm('Are you sure you want to execute Xoainfo?');" style="color: #367fa9">Execute Xoainfo</button>
                        <button type="button" class="btn btn-sm btn-default" style="color: #ccc"> | </button>
                        <button type="submit" class="btn btn-sm btn-success" name="action" value="CheckInternet">Check Internet</button>
                        <button type="submit" class="btn btn-sm btn-default" name="action" value="OpenScreen" style="color: #008d4c">Open Screen</button>
                        <button type="submit" class="btn btn-sm btn-default" name="action" value="CloseScreen" style="color: #008d4c">Close Screen</button>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-default" name="action" value="ProxyXoainfo"
                            onclick="return confirm('Are you sure you want to change Proxy Xoainfo?');" style="color: #e08e0b">Proxy Xoainfo</button>
                        <button type="button" class="btn btn-sm btn-default" style="color: #ccc"> | </button>
                        <button type="submit" class="btn btn-sm btn-default" name="action" value="setupES"
                            onclick="return confirm('Are you sure you want to set Device Spanish?');">Device <b>Spanish</b></button>
                        <button type="submit" class="btn btn-sm btn-default" name="action" value="setupEN"
                            onclick="return confirm('Are you sure you want to set Device English?');">Device <b>English</b></button>
                    </div>
                    <br> 
                    <div class="d-flex align-items-center" style="justify-content: space-between">
                        <div class="form-check">
                            <label class="form-check-label" for="check-all" style="font-size: 18px;">Select All</label>
                            <input type="checkbox" class="form-check-input" id="check-all" name="check-all">
                        </div>
                        <div style="display: inline-flex">
                            <div class="form-check" style="margin-right: 15px;">
                                <label class="form-check-label" for="de-check-all" style="font-size: 14px;
                                    margin-bottom: 0;
                                    line-height: 28px;
                                    margin-right: 6px;
                                    opacity: 0.5;">De-Select All</label>
                                <input type="checkbox" class="form-check-input" id="de-check-all" name="de-check-all">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="check-all-failed" style="font-size: 14px;
                                    margin-bottom: 0;
                                    line-height: 28px;
                                    margin-right: 5px;
                                    opacity: 0.5;">Select Failed</label>
                                <input type="checkbox" class="form-check-input" id="check-all-failed" name="check-all-failed">
                            </div>
                        </div>
                    </div>
                    <span style="color: #d73925; font-weight: 700"><span class="count-selected">0</span> devices.</span>
                    <span style="float: right; font-weight: 700; opacity: 0.5"><span id="gmail-count">-</span> gmails..</span>
                </div>
                <div class="col-md-7 config-form">
                    <div class="row mb-3">
                        <div class="col-md-4 d-flex align-items-center">
                            <label class="text-end" style="color: #f7630c">Note Memo</label>
                            <input type="text" name="note" class="form-control" value="{{ $config->note }}" placeholder="note.." style="border-color: #f7630c" />
                        </div>

                        <div class="col-md-4 d-flex align-items-center">
                            <label class="text-end">Xoainfo (0|1|2)</label>
                            <input type="number" name="times_xoa_info" class="form-control" value="{{ $config->times_xoa_info }}" placeholder="2|3|4" />
                        </div>

                        <div class="col-md-4 d-flex align-items-center">
                            <label class="text-end">Proxy Xoainfo</label>
                            <input type="text" name="proxy" class="form-control" value="{{ $config->proxy }}" placeholder="123.123.123.123:10000" />
                        </div>

                        <div class="col-md-4 d-flex align-items-center">
                            <label class="text-end" style="margin-right: 10px; width: 120px">Mail Suply</label>
                            <select name="mail_suply" class="form-control">
                                <option {{ $config->mail_suply == '1' ? 'selected' : '' }} value="1">DongvanFB</option>
                                <option {{ $config->mail_suply == '2' ? 'selected' : '' }} value="2">Thuemails</option>
                                <option {{ $config->mail_suply == '3' ? 'selected' : '' }} value="3">Yagisongs</option>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-center">
                            <label class="text-end">API-key thuemails</label>
                            <input type="text" name="api_key_thuemails" class="form-control" value="{{ $config->api_key_thuemails }}" placeholder="" />
                        </div>

                        <div class="col-md-4 d-flex align-items-center">
                            <label class="text-end">API-key dongvanfb</label>
                            <input type="text" name="api_key_dongvanfb" class="form-control" value="{{ $config->api_key_dongvanfb }}" placeholder="" />
                        </div>

                        <div class="col-md-4 d-flex align-items-center">
                            <label class="text-end" style="margin-right: 10px; width: 120px">Dummy Reg</label>
                            <select name="reg_phone_first" class="form-control">
                                <option {{ $config->reg_phone_first == '0' ? 'selected' : '' }} value="0">Normal</option>
                                <option {{ $config->reg_phone_first == '1' ? 'selected' : '' }} value="1">Phone</option>
                                <option {{ $config->reg_phone_first == '2' ? 'selected' : '' }} value="2">Gmail</option>
                                <option {{ $config->reg_phone_first == '3' ? 'selected' : '' }} value="3">Icloud</option>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex align-items-center">
                            <label class="text-end" style="width: 240px">Hotmail service ids</label> 
                            <input type="text" name="hotmail_service_ids" class="form-control" value="{{ $config->hotmail_service_ids }}" placeholder="{1,2,3,5,6,59,60}" />
                        </div>

                        <div class="col-md-4 d-flex align-items-center" style="height: 34px;">
                            <label class="text-end" style="margin-right: 10px;">Hotmail source in file</label>
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input" type="radio" name="hot_mail_source_from_file" id="hot_mail_source_from_file_yes" value="1" {{ $config->hot_mail_source_from_file == '1' ? 'checked' : '' }} >
                                <label for="hot_mail_source_from_file_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline" style="margin-left: 5px;">
                                <input class="form-check-input" type="radio" name="hot_mail_source_from_file" id="hot_mail_source_from_file_no" value="0" {{ $config->hot_mail_source_from_file == '0' ? 'checked' : '' }} >
                                <label for="hot_mail_source_from_file_no">No</label>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex align-items-center" style="height: 34px;">
                            <label class="text-end" style="margin-right: 10px;">Tool Language</label>
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input" type="radio" name="language" id="language_yes" value="ES" {{ $config->language == 'ES' ? 'checked' : '' }} >
                                <label for="language_yes">Spanish</label>
                            </div>
                            <div class="form-check form-check-inline" style="margin-left: 5px;">
                                <input class="form-check-input" type="radio" name="language" id="language_no" value="EN" {{ $config->language == 'EN' ? 'checked' : '' }} >
                                <label for="language_no">English</label>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex align-items-center" style="height: 34px;">
                            <label class="text-end" style="margin-right: 10px;">Enter verify code</label>
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input" type="radio" name="enter_verify_code" id="enter_verify_code_yes" value="1" {{ $config->enter_verify_code == '1' ? 'checked' : '' }} >
                                <label for="enter_verify_code_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline" style="margin-left: 5px;">
                                <input class="form-check-input" type="radio" name="enter_verify_code" id="enter_verify_code_no" value="0" {{ $config->enter_verify_code == '0' ? 'checked' : '' }} >
                                <label for="enter_verify_code_no">No</label>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex align-items-center" style="height: 34px;">
                            <label class="text-end" style="margin-right: 10px;">Login With Code</label>
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input" type="radio" name="login_with_code" id="login_with_code_yes" value="1" {{ $config->login_with_code == '1' ? 'checked' : '' }} >
                                <label for="login_with_code_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline" style="margin-left: 5px;">
                                <input class="form-check-input" type="radio" name="login_with_code" id="login_with_code_no" value="0" {{ $config->login_with_code == '0' ? 'checked' : '' }} >
                                <label for="login_with_code_no">No</label>
                            </div>
                        </div>

                        <div class="col-md-4 d-flex align-items-center hidden">
                            <label class="text-end" style="margin-right: 10px;">Add mail domain</label>
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input" type="radio" name="add_mail_domain" id="add_mail_domain_yes" value="1" disabled>
                                <label for="add_mail_domain_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline" style="margin-left: 5px;">
                                <input class="form-check-input" type="radio" name="add_mail_domain" id="add_mail_domain_no" value="0" checked disabled>
                                <label for="add_mail_domain_no">No</label>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center hidden">
                            <label class="text-end" style="margin-right: 10px;">Remove register mail</label>
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input" type="radio" name="remove_register_mail" id="remove_register_mail_yes" value="1" disabled>
                                <label for="remove_register_mail_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline" style="margin-left: 5px;">
                                <input class="form-check-input" type="radio" name="remove_register_mail" id="remove_register_mail_no" value="0" checked disabled>
                                <label for="remove_register_mail_no">No</label>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center hidden">
                            <label class="text-end" style="margin-right: 10px;">Re-rent thuemails</label>
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input" type="radio" name="thue_lai_mail_thuemails" id="thue_lai_mail_thuemails_yes" value="1" disabled>
                                <label for="thue_lai_mail_thuemails_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline" style="margin-left: 5px;">
                                <input class="form-check-input" type="radio" name="thue_lai_mail_thuemails" id="thue_lai_mail_thuemails_no" value="0" checked disabled>
                                <label for="thue_lai_mail_thuemails_no">No</label>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center hidden">
                            <label class="text-end" style="margin-right: 10px;">Provider thuemails</label>
                            <div class="form-check form-check-inline me-3">
                                <input class="form-check-input" type="radio" name="provider_mail_thuemails" id="provider_mail_thuemails_yes" value="1" checked>
                                <label for="provider_mail_thuemails_yes">Gmail</label>
                            </div>
                            <div class="form-check form-check-inline" style="margin-left: 5px;">
                                <input class="form-check-input" type="radio" name="provider_mail_thuemails" id="provider_mail_thuemails_no" value="3" >
                                <label for="provider_mail_thuemails_no">Icloud</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p style="color: #d73925; font-weight: 700"><span class="count-selected">0</span> devices.</p>
                        </div>
                        <div class="col-md-4">
                        </div>
                        
                        <div class="col-md-4 text-right">
                            <button type="submit" class="btn btn-md btn-primary" name="action" value="config">Config</button>
                        </div>

                        <div class="col-md-12 text-right" style="margin: 5px 0 10px">
                            <a style="color: #f7630c; font-weight: 700; text-decoration: underline" href="javascript:void(0);" id="separate-btn">Separate file</a>
                        </div>
                    </div>
                    <div class="row mb-3" id="separate-div" style="display: none;">
                         <div class="col-md-3 d-flex align-items-center">
                            <label class="text-end">Local server</label>
                            <input type="text" name="local_server" class="form-control" value="{{ $config->local_server }}" placeholder="" />
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <label class="text-end">Destination filename</label>
                                <input type="text" name="destination_filename" class="form-control" value="{{ $config->destination_filename }}" placeholder="" />
                            </div>
                            <p style="opacity: 0.5;">hotmail_source.txt|accounts_code.txt</p>
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <label class="text-end">Source filepath</label>
                            <input type="text" name="source_filepath" class="form-control" value="{{ $config->source_filepath }}" placeholder="" />
                        </div>
                        <div class="col-md-3 d-flex align-items-center">
                            <label class="text-end">Separate items</label>
                            <input type="text" name="separate_items" class="form-control" value="{{ $config->separate_items }}" placeholder="" />
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-3">
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-md btn-default" name="action" value="CountLineSourceFile">Count Line</button>
                            <button type="submit" class="btn btn-md btn-default" name="action" value="CleanSourceFile"
                                onclick="return confirm('Are you sure you want to CleanSourceFile in these items?');">Clean File</button>
                            <button type="submit" class="btn btn-md btn-danger" name="action" value="Separate"
                                onclick="return confirm('Are you sure you want to Separate data to these items?');">Separate</button>
                            <input type="hidden" id="separate-status" name="separate_status" value="0">
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid-view" id="w0">
                <div class="summary">
                    <table class="table table-striped table-bordered table-style" id="device-datatables">
                        <thead>
                            <tr>
                                <!-- <th class="un-orderable-col">#</th> -->
                                <th class="un-orderable-col">Id</th>
                                <th class="un-orderable-col">Name</th>
                                <th class="un-orderable-col">IP Address</th>
                                <th class="un-orderable-col" style="min-width: 200px;">Note</th>
                                <th class="un-orderable-col">Device Lang</th>
                                <th class="un-orderable-col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devices as $key => $row)
                                <tr>
                                    <!-- <td>{{ $key + 1 }}</td> -->
                                    <td>{{ $row['id'] }}</td>
                                    <td>
                                        <div class="individual-check">
                                            <input type="checkbox" id="device-id-{{$row['id']}}" name="device_ids[]" 
                                                value="{{ $row['id'] }}" {{ in_array($row['id'], $selected) ? "checked" : "" }} 
                                                data-is-failed="{{ in_array($row['id'], $failed) ? '1' : '0' }}"
                                            />
                                            <label class="form-check-label" for="device-id-{{$row['id']}}">{{ $row['name'] }}</label>
                                        </div>
                                    </td>
                                    <td>{{ $row['ip_address'] }}</td>
                                    <!-- <td>{{ date_format(date_create($row['created_at']), 'Y-m-d H:i') }}</td> -->
                                    <td>{{ $row['note'] }}</td>
                                    <td style="vertical-align: middle;">
                                        @if ($row['lang'] == 'ES')
                                            <span style="color: #fff;border-radius: 10px;
                                                padding: 3px 10px;
                                                color: #245c7c; border: 1px solid #245c7c; border-radius: 8px">
                                                Spanish | {{ $row['language'] }} | {{ $row['mail_suply'] == 1 ? 'dongvanFB' : ($row['mail_suply'] == 2 ? 'thuemails' : '-' ) }}
                                            </span>
                                        @elseif ($row['lang'] == 'EN')
                                            <span style="color: #fff;border-radius: 10px;
                                                padding: 3px 10px;
                                                color: #007c43; border: 1px solid #007c43; border-radius: 8px">
                                                English | {{ $row['language'] }} | {{ $row['mail_suply'] == 1 ? 'dongvanFB' : ($row['mail_suply'] == 2 ? 'thuemails' : '-' ) }}
                                            </span>
                                        @endif
                                        @if($row['count_line']) <span style="margin-left: 5px;">{{ $row['count_line'] . "L" }}</span>@endif
                                    </td>
                                    <td>
                                        <div class="">
                                            <button type="button" class="btn btn-sm btn-success" onclick="submitOneDevice('start', {{ $row['id'] }})">Start Reg</button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="submitOneDevice('stop', {{ $row['id'] }})">Stop Reg</button>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="submitOneDevice('pullcode', {{ $row['id'] }})">Pull Code</button>
                                            <button type="button" class="btn btn-sm btn-warning" onclick="submitOneDevice('respring', {{ $row['id'] }})">Respring</button>
                                            <button type="button" class="btn btn-sm btn-default" onclick="submitOneDevice('clear', {{ $row['id'] }})">Clear INPROGRESS</button>
                                            <button type="button" class="btn btn-sm btn-default" onclick="submitOneDevice('openscreen', {{ $row['id'] }})" style="color: #008d4c">Open Screen</button>
                                            <button type="button" class="btn btn-sm btn-default" onclick="submitOneDevice('closescreen', {{ $row['id'] }})" style="color: #008d4c">Close Screen</button>
                                            <button type="button" class="btn btn-sm btn-success" onclick="window.open('http://{{ $row['ip_address'] }}:8080', '_blank')">Open URL</button>
                                            <a href="{{ route("device.edit", $row['id']) }}" class="btn btn-sm btn-default">Update</a>
                                            <button type="button" class="btn btn-sm btn-default" onclick="submitOneDevice('delete', {{ $row['id'] }})">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                        
                            <tr>
                                <!-- <th></th> -->
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        var orderDevice = "{{ session('order_dir') ?: env('ORDER_DEVICE', 'asc') }}";
        var separateStatus = "{{ session('separate_status') ?? '' }}";
        var APIKEYthuemails = "{{ $config->api_key_thuemails ?? '' }}"

        function fetchGmailCount() {
            $.getJSON("https://api.thuemails.com/api/count-gmail?api_key=" + APIKEYthuemails, function(data) {
                $('#gmail-count').text(data.count);
            }).fail(function() {
                $('#gmail-count').text('---');
            });
        }

        fetchGmailCount();
        setInterval(fetchGmailCount, 30000);

        if (separateStatus && separateStatus != '' && separateStatus != 0) {
            $('#separate-div').toggle();

            const isVisible = $('#separate-div').is(':visible');
            $('#separate-status').val(isVisible ? '1' : '0');
        }

        function updateCountSelected() {
            const selectedCount = $('input[name="device_ids[]"]:checked').length;
            $('.count-selected').text(selectedCount);
        }

        function submitOneDevice(method, deviceId) {
            if (method == 'delete') {
                if (! confirm('Are you sure you want to delete this item?')) {
                    return;
                }
            }
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/devices/${method}/${deviceId}`;

            const csrf = document.createElement('input');
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);

            document.body.appendChild(form);
            form.submit();
        } 

        $(function () {
            var lastOrder = null;
            var table = $('#device-datatables').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'lengthMenu'  : [ [10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"] ],
                'searching'   : true,
                'ordering'    : true,
                'order':      [[1, orderDevice]],
                'info'        : true,
                'autoWidth'   : true,
                "sScrollX"    : "100%",
                "sScrollXInner": "100%",
                "bScrollCollapse": true,
                'pageLength'  : -1,
            });

            table.on('order.dt', function () {
                lastOrder = table.order();
                $('#order_dir').val(lastOrder[0][1]); 
            });
        })

        $(document).ready(function () {
            let all = $('input[name="device_ids[]"]');
            let checked = all.filter(':checked');

            $('#check-all').prop('checked', all.length === checked.length);
            updateCountSelected()
        });

        $('#check-all').on('change', function () {
            $('input[name="device_ids[]"]').prop('checked', this.checked);
            this.checked ? $('#de-check-all').prop('checked', false) : null;
            updateCountSelected()
        });

        $('#de-check-all').on('change', function () {
            if (this.checked) {
                $('input[name="device_ids[]"]').prop('checked', false);
                $('#check-all').prop('checked', false);
            }
            updateCountSelected()
        });

        $('#check-all-failed').on('change', function () {
            $('input[name="device_ids[]"]').each(function () {
                if ($(this).data('is-failed') == 1) {
                    $(this).prop('checked', $('#check-all-failed').prop('checked'));
                } else {
                    $(this).prop('checked', false);
                }
            });
            updateCountSelected()
        });

        let lastChecked = null;
        $(document).ready(function () {
            const $checkboxes = $('input[name="device_ids[]"]');

            function handleCheckboxClick(checkbox, e) {
                if (!lastChecked) {
                    lastChecked = checkbox;
                    return;
                }

                if (e.shiftKey) {
                    const start = $checkboxes.index(checkbox);
                    const end = $checkboxes.index(lastChecked);

                    $checkboxes.slice(Math.min(start, end), Math.max(start, end) + 1)
                        .prop('checked', lastChecked.checked);
                }

                lastChecked = checkbox;
                updateCountSelected()
            }

            $checkboxes.on('click', function (e) {
                handleCheckboxClick(this, e);
            });

            $('#device-datatables tbody tr').on('click', function (e) {
                if ($(e.target).is('input, label, button, a')) {
                    return;
                }

                const $checkbox = $(this).find('input[name="device_ids[]"]');
                const checkbox = $checkbox.get(0);
                if (!checkbox) return;

                checkbox.checked = !checkbox.checked;

                handleCheckboxClick(checkbox, e);
            });
        });

        $(document).on('change', 'input[name="device_ids[]"]', function () {
            updateCountSelected()
        });

        $('#separate-btn').on('click', function (e) {
            e.preventDefault();
            $('#separate-div').toggle();

            const isVisible = $('#separate-div').is(':visible');
            $('#separate-status').val(isVisible ? '1' : '0');
        });
        
    </script>
@endpush
