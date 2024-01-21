@extends('layouts.main')
@section('page_title')
    {{ t('Detail') }}: {{ $folder->name ? $folder->name : "" }}
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li><a href="{{ route('folder.index') }}">Folder</a></li>
    <li class="active">{{ $folder->name ? $folder->name : "" }}</li>
</ul>
@endsection
@section('content')

    <table id="w0" class="table table-striped table-bordered detail-view">
        <tbody>
            <tr><th>ID</th><td>{{ $folder->id }}</td></tr>
            <tr><th>{{ t('Name') }}</th><td>{{ $folder->name }}</td></tr>
            <tr><th>{{ t('Folder path') }}</th><td>{{ $folder->folder_path }}</td></tr>
            <tr><th>{{ t('Created at') }}</th><td><p class="c_timezone">{{ $folder->created_at }}</p></td></tr>
        </tbody>
    </table>

        <div class="row folder">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nick đã join </h5>
                        <h6 class="card-subtitle mb-2 text-muted">(Sau khi merged như excel)</h6>

                        <div class="form-group">
                            <textarea rows="10" class="form-control" name="d1">{!! $nick_uids !!}</textarea>
                            <p class="card-text">Tổng: <b>{{ $ctn_nick_uids }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Group đã join</h5>
                        <h6 class="card-subtitle mb-2 text-muted">(Sau khi merged như excel)</h6>
                        <div class="form-group">
                            <textarea rows="10" class="form-control" name="d2">{!! $group_uids !!}</textarea>
                            <p class="card-text">Tổng: <b>{{ $ctn_group_uids }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nick và số group đã join tương ứng</h5>
                        <h6 class="card-subtitle mb-2 text-muted">(Sắp xếp số group tăng dần)</h6>
                        <div class="form-group">
                            <textarea rows="10" class="form-control" name="d2">{!! $nick_with_count_groups !!}</textarea>
                            <p class="card-text">Tổng: <b>{{ $ctn_nick_with_count_groups }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('css')
    <style>
        .folder .card {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #f2f2f2;
            width: 100%;
            /* background-color: #f2f2f2; */
        }
    </style>
@endpush

@push('scripts')

@endpush
