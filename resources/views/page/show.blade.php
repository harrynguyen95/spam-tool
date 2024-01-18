@extends('layouts.main')
@section('page_title')
    {{ t('Detail') }}: {{ $page->title ? $page->title : "" }}
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ t('Home') }}</a></li>
    <li><a href="{{ route('page.index') }}">{{ t('page') }}</a></li>
    <li class="active">{{ $page->title ? $page->title : "" }}</li>
</ul>
@endsection
@section('content')
    <p>
        <form method="POST"
            action="{{ route("page.destroy", $page->id) }}"
            onsubmit="return confirm('{{ t('Are you sure you want to delete this item?') }}');">
            <input name="_method" value="DELETE" type="hidden">
            <input name="_token" value="{{ csrf_token() }}" type="hidden">
            <a class="btn btn-success" href="{{ route('page.create') }}">{{ t('Create') }}</a>
            <a class="btn btn-primary" href="{{ route('page.edit', $page->id) }}">{{ t('Edit') }}</a>
            <button type="submit" class="btn btn-danger confirm">
                {{ t('Delete') }}
            </button>
        </form>
    </p>

    <table id="w0" class="table table-striped table-bordered detail-view">
        <tbody>
            <tr><th>ID</th><td>{{ $page->id }}</td></tr>
            <tr><th>{{ t('Title') }}</th><td>{{ $page->title }}</td></tr>
            <tr><th>{{ t('Facebook page ID') }}</th><td>{{ $page->fb_id }}</td></tr>
            <tr><th>{{ t('Turn on earning?') }}</th><td>{{ $page->is_earning ? 'YES' : 'NO' }}</td></tr>
            <tr><th>{{ t('Description') }}</th><td>{!! $page->description ? $page->description : "<span class='not-set'>(not set)</span>"  !!}</td></tr>
            <tr><th>{{ t('Created at') }}</th><td><p class="c_timezone">{{ $page->created_at }}</p></td></tr>
            <tr><th>{{ t('Updated at') }}</th><td><p class="c_timezone">{{ $page->updated_at }}</p></td></tr>
        </tbody>
    </table>

@endsection

@push('scripts')

@endpush
