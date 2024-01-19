@extends('layouts.main')
@section('page_title')
    Dashboard
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Dashboard</li>
</ul>
@endsection
@section('content')
    <div class="sp-push-form">
        <form action="{{ route('folder.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

            <div class="form-group @if (count($errors->all())) {{$errors->has(['name']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Name<span class="required">*</span></label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" name="name" value="{{ old('name') }}">
                <div class="help-block">@if($errors->has('name')) {{ $errors->first('name') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['folder_path']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Path<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('folder_path') ? ' has-error' : '' }}" name="folder_path" value="{{ old('folder_path') }}">
                <div class="help-block">@if($errors->has('folder_path')) {{ $errors->first('folder_path') }} @endif</div>
            </div>

            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-success">{{ t('Save') }}</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')

@endpush
