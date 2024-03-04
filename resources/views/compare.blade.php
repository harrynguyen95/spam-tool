@extends('layouts.main')
@section('page_title')
    Compare files
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Compare files</li>
</ul>
@endsection
@section('content')
    <div class="sp-push-form">
        <form action="{{ route('compare') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row folder">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><b>A</b></h5>
                            @if(isset($ctn_part_1))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn_part_1 }}</b></h5>@endif
                            <div class="form-group">
                                <textarea rows="10" class="form-control" name="part_1">{!! $part_1 ?? '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><b>B</b></h5>
                            @if(isset($ctn_part_2))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn_part_2 }}</b></h5>@endif
                            <div class="form-group">
                                <textarea rows="10" class="form-control" name="part_2">{!! $part_2 ?? '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success">{{ t('Save') }}</button>
            </div>
        </form>

        @if (!empty($intersect) || !empty($diff_1) || !empty($diff_2))
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Có trong A, không có trong B</h5>
                        @if(isset($ctn_diff_1))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn_diff_1 }}</b></h5>@endif
                        <div class="form-group">
                            <textarea rows="10" class="form-control" name="diff_1">{!! $diff_1 !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Có trong B, không có trong A</h5>
                        @if(isset($ctn_diff_2))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn_diff_2 }}</b></h5>@endif
                        <div class="form-group">
                            <textarea rows="10" class="form-control" name="diff_2">{!! $diff_2 !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Có trong cả A và B</h5>
                        @if(isset($ctn_intersect))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn_intersect }}</b></h5>@endif
                        <div class="form-group">
                            <textarea rows="10" class="form-control" name="ctn_intersect">{!! $intersect !!}</textarea>
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
