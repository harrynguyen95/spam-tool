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
    <p>
        <form method="POST"
            style="display: inline-block"
            action="{{ route("device.startAll") }}">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <a class="btn btn-default" href="{{ route('device.create') }}">{{ t('Create') }}</a>
            <button type="submit" class="btn btn-success confirm">
                Start All
            </button>
        </form>
        <form method="POST"
            style="display: inline-block"
            action="{{ route("device.stopAll") }}">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <button type="submit" class="btn btn-danger confirm">
                Stop All
            </button>
        </form>
    </p>
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
                            <td>
                                {{ $key + 1 }}
                                <!-- <input type=checkbox name="device_ids[]" /> -->
                            </td>
                            <td>{{ $row['id'] }}</td>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['ip_address'] }}</td>
                            <td>{{ date_format(date_create($row['created_at']), 'Y-m-d H:i') }}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <form method="POST"
                                        style="display: inline-block"
                                        action="{{ route("device.start", $row['id']) }}">
                                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            Start
                                        </button>
                                    </form>

                                    <form method="POST"
                                        style="display: inline-block"
                                        action="{{ route("device.stop", $row['id']) }}">
                                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                        <button type="submit" class="btn btn-sm btn-warning">
                                            Stop
                                        </button>
                                    </form>

                                    <form method="POST"
                                        style="display: inline-block"
                                        action="{{ route("device.setup", $row['id']) }}">
                                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                        <button type="submit" class="btn btn-sm btn-default">
                                            Setup
                                        </button>
                                    </form>

                                    <a href="{{ route("device.edit", $row['id']) }}" class="btn btn-sm btn-primary">Update IP</a>

                                    <form method="POST"
                                        style="display: inline-block"
                                        action="{{ route("device.destroy", $row['id']) }}"
                                        onsubmit="return confirm('{{ t('Are you sure you want to delete this item?') }}');">
                                        <input name="_method" value="DELETE" type="hidden">
                                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
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
</div>
@endsection

@push('scripts')

@endpush
