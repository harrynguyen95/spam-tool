@extends('layouts.main')
@section('page_title')
    Caption
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Caption</li>
</ul>
@endsection
@section('content')
    <div class="sp-push-form">
        @if (!empty($message))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        
        <form action="{{ route('caption.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row folder">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Captions: </h5>
                            @if(isset($ctn))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn }}</b></h5>@endif
                            <div class="form-group">
                                <textarea rows="10" class="form-control" name="captions">{!! $captions ?? '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                </br>
                @if (!empty($output))
                    <div class="col-md-12">
                        <p>----------------------------------------------------------------------------------------------------------------</p>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Formatted captions: </h5>
                                <h5 class="card-title">(Xoá dấu nháy kép, "like", "share", "click" & thêm [r8])</h5>
                                @if(isset($ctn_output))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn_output }}</b></h5>@endif
                                <div class="form-group">
                                    <textarea rows="10" class="form-control" name="xxx">{!! $output ?? '' !!}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">{{ t('Save') }}</button>
            </div>
        </form>

    </div>
@endsection

@push('scripts')

@endpush
