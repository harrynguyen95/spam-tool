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

            <div class="form-group @if (count($errors->all())) {{$errors->has(['folder']) ? 'has-error' : 'has-success'}} @endif">
                <label for="exampleInputFile">Zip file input<span class="required">*</span></label>
                <input name="folder" type="file" id="exampleInputFile">

                <div class="help-block">@if($errors->has('folder')) {{ $errors->first('folder') }} @endif</div>
              </div>


            <br>
            <div class="form-group">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
                <button type="submit" class="btn btn-success">{{ t('Save') }}</button>
            </div>

        </form>
    </div>
@endsection

@push('scripts')

@endpush
