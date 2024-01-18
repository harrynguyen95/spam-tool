@extends('layouts.main')
@section('page_title')
    Merge file
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
            <div class="form-group @if (count($errors->all())) {{$errors->has(['file_merge']) ? 'has-error' : 'has-success'}} @endif">
                <label for="exampleInputFile">Zip file input<span class="required">*</span></label>
                <input name="file_merge" type="file" id="exampleInputFile">

                <div class="help-block">@if($errors->has('file_merge')) {{ $errors->first('file_merge') }} @endif</div>
            </div>

            <br>
            <div class="form-group">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}" />
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
