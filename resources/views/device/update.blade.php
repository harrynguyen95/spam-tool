@extends('layouts.main')
@section('page_title')
    {{ t('Edit') }}: {{ $device->name ? $device->name : ''}}
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ t('Home') }}</a></li>
    <li><a href="{{ route('device.index') }}">{{ t('device') }}</a></li>
    <li><a href="{{ route('device.show', $device->id) }}">{{ $device->title ? $device->title : ''}}</a></li>
    <li class="active">{{ t('Update') }}</li>
</ul>
@endsection
@section('content')
    <br>
    <div class="sp-push-form">
        <form action="{{ route('device.update', $device->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
            <input type="hidden" name="_method" value="PUT"/>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['username']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">{{ t('Username') }}<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('username') ? ' has-error' : '' }}" name="username" value="{{ $device->username }}">
                <div class="help-block">@if($errors->has('username')) {{ $errors->first('username') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['name']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">{{ t('Device Name') }}<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' has-error' : '' }}" name="name" value="{{ $device->name }}">
                <div class="help-block">@if($errors->has('name')) {{ $errors->first('name') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['ip_address']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Local IP Address<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('ip_address') ? ' has-error' : '' }}" name="ip_address" value="{{ $device->ip_address }}">
                <div class="help-block">@if($errors->has('ip_address')) {{ $errors->first('ip_address') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['note']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">{{ t('Note') }}</label>
                <input type="text" class="form-control{{ $errors->has('note') ? ' has-error' : '' }}" name="note" value="{{ $device->note }}">
                <div class="help-block">@if($errors->has('note')) {{ $errors->first('note') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['tsproxy_id']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">tsproxy ID</label>
                <input type="text" class="form-control{{ $errors->has('tsproxy_id') ? ' has-error' : '' }}" name="tsproxy_id" value="{{ $device->tsproxy_id }}">
                <div class="help-block">@if($errors->has('tsproxy_id')) {{ $errors->first('tsproxy_id') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['tsproxy_port']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">tsproxy Port</label>
                <input type="text" class="form-control{{ $errors->has('tsproxy_port') ? ' has-error' : '' }}" name="tsproxy_port" value="{{ $device->tsproxy_port }}">
                <div class="help-block">@if($errors->has('tsproxy_port')) {{ $errors->first('tsproxy_port') }} @endif</div>
            </div>

            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ t('Save') }}</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
  
@endpush

@push('css')
    <style>
        .marg-right {
            margin: 0 5px 0 50px !important;
        }
    </style>
@endpush

