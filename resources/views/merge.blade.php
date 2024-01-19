@extends('layouts.main')
@section('page_title')
    Merge files
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Merge file</li>
</ul>
@endsection
@section('content')
    <div class="sp-push-form">
        <form action="{{ route('merge') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group @if (count($errors->all())) {{$errors->has(['folder_path']) ? 'has-error' : 'has-success'}} @endif" >
                <label class="control-label">Path<span class="required">*</span></label>
                <input type="text" class="form-control{{ $errors->has('folder_path') ? ' has-error' : '' }}" name="folder_path" value="{{ old('folder_path') }}">
                <div class="help-block">@if($errors->has('folder_path')) {{ $errors->first('folder_path') }} @endif</div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-success">{{ t('Save') }}</button>
            </div>
        </form>

        @if (!empty($groups))
        <div class="row folder">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Groups</h5>
                        <h6 class="card-subtitle mb-2 text-muted">(Uid|Name)</h6>

                        <div class="form-group">
                            <textarea rows="10" class="form-control" name="d1">{!! $groups !!}</textarea>
                            <p class="card-text">Tổng: <b>{{ $ctn_groups }}</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
@endsection

@push('scripts')

@endpush
