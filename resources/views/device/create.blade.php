@extends('layouts.main')
@section('page_title')
    Create device
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Device</li>
</ul>
@endsection
@section('content')
    <div class="sp-push-form">
        <form action="{{ route('device.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

            <div class="form-group @if (count($errors->all())) {{$errors->has(['username']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Username<span class="required">*</span></label>
                <input type="text" class="form-control {{ $errors->has('username') ? ' has-error' : '' }}" name="username" value="{{ old('username') }}" placeholder="Bắt buộc nhập Hải|Nam|Hiến">
                <div class="help-block">@if($errors->has('username')) {{ $errors->first('username') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['name']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Device Name<span class="required">*</span></label>
                <input type="text" class="form-control {{ $errors->has('name') ? ' has-error' : '' }}" name="name" value="{{ old('name') }}">
                <div class="help-block">@if($errors->has('name')) {{ $errors->first('name') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['ip_address']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Local IP address<span class="required">*</span></label>
                </br>
                <input type="text" class="form-control{{ $errors->has('ip_address') ? ' has-error' : '' }}" name="ip_address" value="{{ old('ip_address') }}">
                <div class="help-block">@if($errors->has('ip_address')) {{ $errors->first('ip_address') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['note']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Note</label>
                <input type="text" class="form-control {{ $errors->has('note') ? ' has-error' : '' }}" name="note" value="{{ old('note') }}">
                <div class="help-block">@if($errors->has('note')) {{ $errors->first('note') }} @endif</div>
            </div>

            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-success">{{ t('Create') }}</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')

@endpush
