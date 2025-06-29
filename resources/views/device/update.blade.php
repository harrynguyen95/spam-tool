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

            <div class="form-group @if (count($errors->all())) {{$errors->has(['name']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">{{ t('Name') }}<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' has-error' : '' }}" name="name" value="{{ $device->name }}">
                <div class="help-block">@if($errors->has('name')) {{ $errors->first('name') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['ip_address']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Local IP Address<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('ip_address') ? ' has-error' : '' }}" name="ip_address" value="{{ $device->ip_address }}">
                <div class="help-block">@if($errors->has('ip_address')) {{ $errors->first('ip_address') }} @endif</div>
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

