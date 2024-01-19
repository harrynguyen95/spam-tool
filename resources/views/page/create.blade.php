@extends('layouts.main')
@section('page_title')
    {{ t('Create new page') }}
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ t('Home') }}</a></li>
    <li><a href="{{ route('page.index') }}">{{ t('Page') }}</a></li>
    <li class="active">{{ t('Create') }}</li>
</ul>
@endsection
@section('content')
    <div class="sp-push-form">
        <form action="{{ route('page.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

            <div class="form-group @if (count($errors->all())) {{$errors->has(['title']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">{{ t('Title') }}<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('title') ? ' has-error' : '' }}" name="title" value="{{ old('title') }}">
                <div class="help-block">@if($errors->has('title')) {{ $errors->first('title') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['fb_id']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">{{ t('Facebook page ID') }}<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('fb_id') ? ' has-error' : '' }}" name="fb_id" value="{{ old('fb_id') }}">
                <div class="help-block">@if($errors->has('fb_id')) {{ $errors->first('fb_id') }} @endif</div>
            </div>

            <div class="form-group field-page-description @if (count($errors->all())) {{$errors->has(['description']) ? 'has-error' : 'has-success'}} @endif">
                <label class="control-label" for="page-description">{{ t('Description') }}</label>
                <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" >{{ old('description') }}</textarea>
                <div class="help-block">@if($errors->has('description')) {{ $errors->first('description') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['access_token']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Access token <span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('access_token') ? ' has-error' : '' }}" name="access_token" value="{{ !empty($data->access_token) ? $data->access_token : old('access_token') }}">
                <div class="help-block">@if($errors->has('access_token')) {{ $errors->first('access_token') }} @endif</div>
            </div>
            <p><i>Need to update this token every 2 months.</i></p>

            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-success">{{ t('Save') }}</button>
            </div>

        </form>
    </div>

@endsection

@push('scripts')

@endpush
