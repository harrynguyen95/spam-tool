@extends('layouts.main')
@section('page_title')
    Shuffer
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Shuffer</li>
</ul>
@endsection
@section('content')
    <div class="sp-push-form">
        @if (!empty($message))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        
        <form action="{{ route('shuffer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row folder">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><b>Text</b></h5>
                            @if(isset($ctn))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn }}</b></h5>@endif
                            <div class="form-group">
                                <textarea rows="10" class="form-control" name="groups">{!! $groups ?? '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                @if (!empty($output))
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><b>Shuffer </b> (Remove duplicate & shuffer)</h5>
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
