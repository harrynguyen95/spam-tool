@extends('layouts.main')
@section('page_title')
    {{ t('Edit') }}: {{ $page->title ? $page->title : ''}}
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">{{ t('Home') }}</a></li>
    <li><a href="{{ route('page.index') }}">{{ t('page') }}</a></li>
    <li><a href="{{ route('page.show', $page->id) }}">{{ $page->title ? $page->title : ''}}</a></li>
    <li class="active">{{ t('Update') }}</li>
</ul>
@endsection
@section('content')
    <br>
    <div class="sp-push-form">
        <form action="{{ route('page.update', $page->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
            <input type="hidden" name="_method" value="PUT"/>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['title']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">{{ t('Title') }}<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('title') ? ' has-error' : '' }}" name="title" value="{{ $page->title }}">
                <div class="help-block">@if($errors->has('title')) {{ $errors->first('title') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['fb_id']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Facebook page ID<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('fb_id') ? ' has-error' : '' }}" name="fb_id" value="{{ $page->fb_id }}">
                <div class="help-block">@if($errors->has('fb_id')) {{ $errors->first('fb_id') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['description']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">{{ t('Description') }}</label>
                <textarea class="form-control{{ $errors->has('description') ? ' has-error' : '' }}" name="description">{{ $page->description }}</textarea>
                <div class="help-block">@if($errors->has('description')) {{ $errors->first('description') }} @endif</div>
            </div>

            <div class="form-group @if (count($errors->all())) {{$errors->has(['is_earning']) ? 'has-error' : 'has-success'}} @endif">
                <label class="control-label">Is earning or not? <span class="required">*</span></label>
                <div>
                    <label class="radio-inline"><input type="radio" name="is_earning" value="1" @if($page->is_earning == 1) {!! 'checked'!!} @endif ><strong>Yes</strong></label>
                    <label class="radio-inline"><input type="radio" name="is_earning" value="0" @if($page->is_earning == 0) {!! 'checked'!!} @endif ><strong>No</strong></label>
                </div>
                <div class="help-block">@if($errors->has('is_earning')) {{ $errors->first('display_flag') }} @endif</div>
            </div>

            <div class="form-group" >
                <label class="control-label">Access token </label>
                <input type="text" class="form-control" name="access_token" value="">
            </div>
            <p><i>Old long term token: {{ $page->access_token ? $page->access_token : '-' }}</i></p>
            <p><i>Need to update this token every 2 months.</i></p>

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

