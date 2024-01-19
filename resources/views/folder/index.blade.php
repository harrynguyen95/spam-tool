@extends('layouts.main')
@section('page_title')
    Shared Folders
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Folder</li>
</ul>
@endsection
@section('content')
<div class="sp-push-index">
    <p>
        <a class="btn btn-success" href="{{ route('dashboard') }}">Create</a>
    </p>
    <br>
    <br>
    
    <div class="grid-view" id="w0">
        <div class="summary">
            <table class="table table-striped table-bordered table-style" id="datatables">
                <thead>
                    <tr>
                        <th class="un-orderable-col">#</th>
                        <th class="un-orderable-col">Id</th>
                        <th class="un-orderable-col">Name</th>
                        <th class="un-orderable-col">Folder path</th>
                        <th class="un-orderable-col">Created at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $row)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $row['id'] }}</td>
                            <td>{{ $row['name'] }}</td>
                            <td>{{ $row['folder_path'] }}</td>
                            <td>{{ date_format(date_create($row['created_at']), 'Y-m-d H:i') }}</td>
                            <td>
                                <form method="POST"
                                    action="{{ route("folder.destroy", $row['id']) }}"
                                    onsubmit="return confirm('{{ t('Are you sure you want to delete this item?') }}');">
                                    <input name="_method" value="DELETE" type="hidden">
                                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                    
                                    <a href="{{ route("folder.show", $row['id']) }}" class="btn btn-sm btn-primary">Show</a>
                                    {{-- <a href="{{ route("folder.compare.nick", $row['id']) }}" class="btn btn-sm btn-primary">Compare nick</a> --}}
                                    {{-- <a href="{{ route("folder.compare.group", $row['id']) }}" class="btn btn-sm btn-primary">Compare group</a> --}}

                                    <button type="submit" class="submit-with-icon">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </button>
                                </form>
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
