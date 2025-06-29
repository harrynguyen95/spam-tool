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
        
        <button type="button" class="btn btn-sm btn-default"><a style="color: #444" href="{{ route('device.create') }}">{{ t('Create') }}</a></button>
        <button type="submit" class="btn btn-sm btn-success" name="action" value="start">Start Selected</button>
        <button type="submit" class="btn btn-sm btn-danger" name="action" value="stop">Stop Selected</button>
        <button type="submit" class="btn btn-sm btn-primary" name="action" value="setup">Setup Selected</button>
        <br>
        <br>
        <div class="form-check">
            <label class="form-check-label" for="check-all">Select all</label>
            <input type="checkbox" class="form-check-input" id="check-all" name="check-all">
        </div>
        <br>
        <br>

        <div class="grid-view" id="w0">
            <div class="summary">
                <table class="table table-striped table-bordered table-style" id="device-datatables">
                    <thead>
                        <tr>
                            <th class="un-orderable-col">#</th>
                            <th class="un-orderable-col">Id</th>
                            <th class="un-orderable-col">Name</th>
                            <th class="un-orderable-col">IP Address</th>
                            <th class="un-orderable-col">Created at</th>
                            <th class="un-orderable-col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($devices as $key => $row)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $row['id'] }}</td>
                                <td>
                                    <div class="individual-check">
                                        <input type="checkbox" id="device-id-{{$row['id']}}" name="device_ids[]" value="{{ $row['id'] }}" />
                                        <label for="device-id-{{$row['id']}}">{{ $row['name'] }}</label>
                                    </div>
                                </td>
                                <td>{{ $row['ip_address'] }}</td>
                                <td>{{ date_format(date_create($row['created_at']), 'Y-m-d H:i') }}</td>
                                <td>
                                    <div class="">
                                        <button type="button" class="btn btn-sm btn-success" onclick="submitOneDevice('start', {{ $row['id'] }})">Start</button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="submitOneDevice('stop', {{ $row['id'] }})">Stop</button>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="submitOneDevice('setup', {{ $row['id'] }})">Setup</button>
                                        <a href="{{ route("device.edit", $row['id']) }}" class="btn btn-sm btn-default">Update</a>
                                        <button type="button" class="btn btn-sm btn-default" onclick="submitOneDevice('delete', {{ $row['id'] }})">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    
                        <tr>
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
                'order':      [[2, 'asc']],
                'info'        : true,
                'autoWidth'   : true,
                "sScrollX"    : "100%",
                "sScrollXInner": "100%",
                "bScrollCollapse": true,
                'pageLength'    : 100,
            });
        })
    </script>
@endpush
