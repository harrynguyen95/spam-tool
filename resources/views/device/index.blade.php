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
<div class="sp-push-index">
    <form method="POST" action="{{ route("device.bulkAction") }}">
        @csrf
        <div class="row">
            <div class="col-md-5">
                <div class="mb-3">
                    <button type="submit" class="btn btn-sm btn-success" name="action" value="start">Start Selected</button>
                    <button type="submit" class="btn btn-sm btn-danger" name="action" value="stop">Stop Selected</button>
                    <button type="submit" class="btn btn-sm btn-primary" name="action" value="pullcode">Pull Code Selected</button>
                    <button type="submit" class="btn btn-sm btn-warning" name="action" value="respring">Respring</button>
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-default"><a style="color: #444" href="{{ route('device.create') }}">Create new Device</a></button>
                    <button type="submit" class="btn btn-sm btn-default" name="action" value="clearInprogress">Clear INPROGRESS</button>
                    <button type="submit" class="btn btn-sm btn-default" name="action" value="openScreen">Open Screen</button>
                    <button type="submit" class="btn btn-sm btn-default" name="action" value="closeScreen">Close Screen</button>
                </div>
                <!-- <div class="mb-3">
                    <button type="submit" class="btn btn-sm btn-primary" name="action" value="setupES">Set App Facebook ES</button>
                    <button type="submit" class="btn btn-sm btn-primary" name="action" value="setupEN">Set App Facebook EN</button>
                </div> -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-sm btn-default" name="action" value="changeProxy"
                        onclick="return confirm('Are you sure you want to change Proxy Xoainfo?');">Proxy Xoainfo</button>
                    <button type="submit" class="btn btn-sm btn-default" name="action" value="setupES"
                        onclick="return confirm('Are you sure you want to set Device Spanish?');">Set App Facebook <b>ES</b></button>
                    <button type="submit" class="btn btn-sm btn-default" name="action" value="setupEN"
                        onclick="return confirm('Are you sure you want to set Device English?');">Set App Facebook <b>EN</b></button>
                </div>
                <br> 
                <div class="form-check">
                    <label class="form-check-label" for="check-all" style="font-size: 18px;">Select all</label>
                    <input type="checkbox" class="form-check-input" id="check-all" name="check-all">
                </div>
            </div>
            <div class="col-md-7 config-form">
                <div class="row mb-3">

                    <div class="col-md-4 d-flex align-items-center">
                        <label class="me-2 w-50 text-end" style="color: #f7630c">Note Memo</label>
                        <input type="text" name="note" class="form-control" value="" placeholder="note.." style="border-color: #f7630c" />
                    </div>

                    <div class="col-md-4 d-flex align-items-center">
                        <label class="me-2 w-50 text-end">Xoainfo (0|1|2)</label>
                        <input type="number" name="times_xoa_info" class="form-control" value="1" placeholder="2|3|4" />
                    </div>

                    <div class="col-md-4 d-flex align-items-center">
                        <label class="me-2 w-50 text-end">Proxy Xoainfo</label>
                        <input type="text" name="proxy" class="form-control" value="" placeholder="123.123.123.123:10000" />
                    </div>

                    <div class="col-md-4 d-flex align-items-center">
                        <label class="me-2 w-50 text-end" style="margin-right: 10px;">Mail:</label>
                        <div class="form-check form-check-inline me-3">
                            <input class="form-check-input" type="radio" name="mail_suply" id="mail_suply_yes" value="1" checked>
                            <label for="mail_suply_yes">dongvanfb</label>
                        </div>
                        <div class="form-check form-check-inline" style="margin-left: 5px;">
                            <input class="form-check-input" type="radio" name="mail_suply" id="mail_suply_no" value="2" >
                            <label for="mail_suply_no">thuemails</label>
                        </div>
                        <div class="form-check form-check-inline" style="margin-left: 5px;">
                            <input class="form-check-input" type="radio" name="mail_suply" id="mail_suply_no2" value="3" disabled>
                            <label for="mail_suply_no2">yagisongs</label>
                        </div>
                    </div>

                    <div class="col-md-4 d-flex align-items-center">
                        <label class="me-2 w-50 text-end" style="margin-right: 10px;">Hotmail source in file</label>
                        <div class="form-check form-check-inline me-3">
                            <input class="form-check-input" type="radio" name="hot_mail_source_from_file" id="hot_mail_source_from_file_yes" value="1">
                            <label for="hot_mail_source_from_file_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline" style="margin-left: 5px;">
                            <input class="form-check-input" type="radio" name="hot_mail_source_from_file" id="hot_mail_source_from_file_no" value="0" checked>
                            <label for="hot_mail_source_from_file_no">No</label>
                        </div>
                    </div>

                    <div class="col-md-4 d-flex align-items-center">
                        <label class="me-2 w-50 text-end" style="width: 240px">Hotmail service ids</label> 
                        <input type="text" name="hotmail_service_ids" class="form-control" value="{1,2,3,5,6,59,60}" placeholder="{1,2,3,5,6,59,60}" />
                    </div>

                    <div class="col-md-4 d-flex align-items-center">
                        <label class="me-2 w-50 text-end" style="margin-right: 10px;">Tool Language</label>
                        <div class="form-check form-check-inline me-3">
                            <input class="form-check-input" type="radio" name="language" id="language_yes" value="ES" checked>
                            <label for="language_yes">Spanish</label>
                        </div>
                        <div class="form-check form-check-inline" style="margin-left: 5px;">
                            <input class="form-check-input" type="radio" name="language" id="language_no" value="EN" >
                            <label for="language_no">English</label>
                        </div>
                    </div>

                    <div class="col-md-4 d-flex align-items-center">
                        <label class="me-2 w-50 text-end" style="margin-right: 10px;">Enter verify code</label>
                        <div class="form-check form-check-inline me-3">
                            <input class="form-check-input" type="radio" name="enter_verify_code" id="enter_verify_code_yes" value="1" checked>
                            <label for="enter_verify_code_yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline" style="margin-left: 5px;">
                            <input class="form-check-input" type="radio" name="enter_verify_code" id="enter_verify_code_no" value="0">
                            <label for="enter_verify_code_no">No</label>
                        </div>
                    </div>

                    <div class="col-md-4 d-flex align-items-center hidden">
                        <label class="me-2 w-50 text-end" style="margin-right: 10px;">Add mail domain</label>
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
                        <label class="me-2 w-50 text-end" style="margin-right: 10px;">Remove register mail</label>
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
                        <label class="me-2 w-50 text-end" style="margin-right: 10px;">Re-rent thuemails</label>
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
                        <label class="me-2 w-50 text-end" style="margin-right: 10px;">Provider thuemails</label>
                        <div class="form-check form-check-inline me-3">
                            <input class="form-check-input" type="radio" name="provider_mail_thuemails" id="provider_mail_thuemails_yes" value="1" checked>
                            <label for="provider_mail_thuemails_yes">Gmail</label>
                        </div>
                        <div class="form-check form-check-inline" style="margin-left: 5px;">
                            <input class="form-check-input" type="radio" name="provider_mail_thuemails" id="provider_mail_thuemails_no" value="3" >
                            <label for="provider_mail_thuemails_no">Icloud</label>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-md btn-primary" name="action" value="config">Config</button>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <div class="grid-view" id="w0">
            <div class="summary">
                <table class="table table-striped table-bordered table-style" id="device-datatables">
                    <thead>
                        <tr>
                            <!-- <th class="un-orderable-col">#</th> -->
                            <th class="un-orderable-col">Id</th>
                            <th class="un-orderable-col">Name</th>
                            <th class="un-orderable-col">IP Address</th>
                            <th class="un-orderable-col">Note</th>
                            <th class="un-orderable-col">App FB Lang</th>
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
                                        <input type="checkbox" id="device-id-{{$row['id']}}" name="device_ids[]" value="{{ $row['id'] }}" />
                                        <label class="form-check-label" for="device-id-{{$row['id']}}">{{ $row['name'] }}</label>
                                    </div>
                                </td>
                                <td>{{ $row['ip_address'] }}</td>
                                <!-- <td>{{ date_format(date_create($row['created_at']), 'Y-m-d H:i') }}</td> -->
                                <td>{{ $row['note'] }}</td>
                                <td>{{ $row['lang'] == 'ES' ? 'Spanish' : ($row['lang'] == 'EN' ? 'English' : '-') }}</td>
                                <td>
                                    <div class="">
                                        <button type="button" class="btn btn-sm btn-success" onclick="submitOneDevice('start', {{ $row['id'] }})">Start</button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="submitOneDevice('stop', {{ $row['id'] }})">Stop</button>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="submitOneDevice('pullcode', {{ $row['id'] }})">Pull Code</button>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="submitOneDevice('respring', {{ $row['id'] }})">Respring</button>
                                        <button type="button" class="btn btn-sm btn-default" onclick="submitOneDevice('clear', {{ $row['id'] }})">Clear Inprogress</button>
                                        <button type="button" class="btn btn-sm btn-default" onclick="submitOneDevice('openscreen', {{ $row['id'] }})">Open Screen</button>
                                        <button type="button" class="btn btn-sm btn-default" onclick="submitOneDevice('closescreen', {{ $row['id'] }})">Close Screen</button>
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

        $('#check-all').on('change', function () {
            $('input[name="device_ids[]"]').prop('checked', this.checked);
        });

        $(function () {
            $('#device-datatables').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : true,
                'order':      [[1, 'asc']],
                'info'        : true,
                'autoWidth'   : true,
                "sScrollX"    : "100%",
                "sScrollXInner": "100%",
                "bScrollCollapse": true,
                'pageLength'    : 100,
            });
        })

        $(document).ready(function () {
            setTimeout(function () {
                $('#check-all').trigger('click');
            }, 800); 
        });
    </script>
@endpush
