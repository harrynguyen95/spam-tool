@extends('layouts.main')
@section('page_title')
    {{ t('Pages management') }}
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ t('Home') }}</a></li>
    <li class="active">{{ t('page') }}</li>
</ul>
@endsection
@section('content')
<div class="sp-push-index">
    <p>
        <a class="btn btn-success" href="{{ route('page.create') }}">{{ t('Create') }}</a>
    </p>
    <br>
    <br>
    
    <div class="grid-view" id="w0">
        <div class="summary">
            <table class="table table-striped table-bordered table-style" id="datatables">
                <thead>
                    <tr>
                        <th class="un-orderable-col">#</th>
                        <th class="un-orderable-col">Title</th>
                        <th class="un-orderable-col">Your earnings</th>
                        <th class="un-orderable-col">Turn on page's earning?</th>
                        <th class="un-orderable-col">{{ t('Facebook page ID') }}</th>
                        <th class="un-orderable-col">{{ t('Description') }}</th>
                        <th class="orderable-col">{{ t('Created at') }}</th>
                        <th class="un-orderable-col">{{ t('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $row)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $row['title'] }}</td>
                            <td>${{ $row['earnings'] }}</td>
                            <td>{{ $row['is_earning'] ? 'YES' : 'NO' }}</td>
                            <td>{{ $row['fb_id'] }}</td>
                            <td>{{ $row['description'] }}</td>
                            <td>{{ date_format(date_create($row['created_at']), 'Y-m-d H:i') }}</td>
                            <td>
                                <form method="POST"
                                    action="{{ route("page.destroy", $row['id']) }}"
                                    onsubmit="return confirm('{{ t('Are you sure you want to delete this item?') }}');">
                                    <input name="_method" value="DELETE" type="hidden">
                                    <input name="_token" value="{{ csrf_token() }}" type="hidden">
                                    <a href="{{ route("videos.list", $row['id']) }}" class="btn btn-sm btn-primary">videos</a>
                                    @if(is_admin())
                                        <a class=""
                                            href="{{ route("page.show", $row['id']) }}"><span
                                                class="glyphicon glyphicon-eye-open"></span></a>
                                        <a class=""
                                            href="{{ route("page.edit", $row['id']) }}"><span
                                                class="glyphicon glyphicon-pencil"></span></a>
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    @endif
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
