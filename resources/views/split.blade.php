@extends('layouts.main')
@section('page_title')
    Split text
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Split text</li>
</ul>
@endsection
@section('content')
    <div class="sp-push-form">
        <form action="{{ route('split') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row folder">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group @if (count($errors->all())) {{$errors->has(['columns']) ? 'has-error' : 'has-success'}} @endif" >
                                <label class="control-label">Số columns<span class="required">*</span></label>
                                <input type="text" class="form-control{{ $errors->has('columns') ? ' has-error' : '' }}" name="columns" value="{{ $columns ?? (old('columns') ?? '2') }}">
                                <div class="help-block">@if($errors->has('columns')) {{ $errors->first('columns') }} @endif</div>
                            </div>
                
                            <div class="form-group @if (count($errors->all())) {{$errors->has(['separate']) ? 'has-error' : 'has-success'}} @endif" >
                                <label class="control-label">Dấu phân cách<span class="required">*</span></label>
                                <input type="text" class="form-control{{ $errors->has('separate') ? ' has-error' : '' }}" name="separate" value="{{ $separate ?? (old('separate') ?? '|') }}">
                                <div class="help-block">@if($errors->has('separate')) {{ $errors->first('separate') }} @endif</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group @if (count($errors->all())) {{$errors->has(['data']) ? 'has-error' : 'has-success'}} @endif" >
                                <label class="control-label">Data <span class="required">*</span></label>
                                <textarea rows="10" class="form-control{{ $errors->has('data') ? ' has-error' : '' }}" name="data">{!! $data ?? old('data') !!}</textarea>
                                <div class="help-block">@if($errors->has('data')) {{ $errors->first('data') }} @endif</div>
                            </div>
                            <h5 class="card-title">Tổng: {{ $ctn_data ?? 0 }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">{{ t('Save') }}</button>
            </div>
        </form>

        @if (!empty($splits))
        <div class="row">
            @foreach($splits as $key => $value)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Cột số {{ $key + 1 }}</h5>

                            <div class="form-group">
                                <textarea rows="10" class="form-control">{!! $value !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

    </div>
@endsection

@push('scripts')

@endpush
