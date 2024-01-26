@extends('layouts.main')
@section('page_title')
    Avatar get
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Avatar get</li>
</ul>
@endsection
@section('content')
    <p>from https://thispersondoesnotexist.com</p>
    <br/>
    <div class="sp-push-form">
        @if (!empty($message))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif

        <form action="{{ route('avatar.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row folder">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group @if (count($errors->all())) {{$errors->has(['numb']) ? 'has-error' : 'has-success'}} @endif" >
                                <label class="control-label">Số ảnh (nhỏ hơn 100) <br/>- Nếu bị lỗi 504 Gateway Time-out, thì bấm F5 và enter continue để tiếp tục request render ảnh. Mỗi lần như vậy sẽ được 50~100 ảnh.<span class="required">*</span></label>
                                <input type="text" class="form-control{{ $errors->has('numb') ? ' has-error' : '' }}" name="numb" value="{{ $columns ?? old('numb') }}">
                                <div class="help-block">@if($errors->has('numb')) {{ $errors->first('numb') }} @endif</div>
                            </div>
                
                            <div class="form-group @if (count($errors->all())) {{$errors->has(['path']) ? 'has-error' : 'has-success'}} @endif" >
                                <label class="control-label">Path lưu trữ<span class="required">*</span></label>
                                <input type="text" class="form-control{{ $errors->has('path') ? ' has-error' : '' }}" name="path" value="{{ $separate ?? old('path') }}">
                                <div class="help-block">@if($errors->has('path')) {{ $errors->first('path') }} @endif</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">{{ t('Save') }}</button>
            </div>
        </form>

    </div>
@endsection

@push('scripts')

@endpush
