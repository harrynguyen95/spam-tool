@extends('layouts.main')
@section('page_title')
    Format Caption
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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><b>Captions: </b></h5>
                            <h5 class="card-title">Xoá dấu nháy kép, "like", "share", "click", thêm [r8] & xoá dòng trùng nhau.</h5>

                            @if(isset($ctn))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn }}</b></h5>@endif
                            <div class="form-group">
                                <textarea rows="10" class="form-control" name="captions">{!! $captions ?? '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><b>Hashtag: </b></h5>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                  Có sử dụng hashtag hay không?
                                  <input type="checkbox" name="has_hashtag" style="margin: 15px 0 0 15px" {{ $has_hashtag ? 'checked' : '' }}>
                                </label>
                            </div>

                            <div class="form-group @if (count($errors->all())) {{$errors->has(['name']) ? 'has-error' : 'has-success'}} @endif" >
                                <label class="control-label">Số hashtag mỗi cap:</label>
                                <input type="text" class="form-control" disabled name="num_hashtag" value="{{ old('num_hashtag') ?? '2' }}">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Hashtags:</label>
                                </br><label class="control-label">(6 hashtag có (5x6)/2 bộ)</label>
                                </br><label class="control-label">(5 hashtag có (5x4)/2 bộ)</label>
                                <textarea rows="3" class="form-control" name="hashtags">{!! $hashtags ?? $defaultHashtags !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            </br>

            @if (!empty($output_pure))
            <div class="row">
                <p>----------------------------------------------------------------------------------------------------------------</p>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><b>A (không hashtag) </b></h5>
                            @if(isset($ctn_output_pure))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn_output_pure }}</b></h5>@endif
                            <div class="form-group">
                                <textarea rows="10" class="form-control" name="xxx">{!! $output_pure ?? '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if (!empty($output))
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><b>B (có hashtag) </b></h5>
                            @if(isset($ctn_output))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn_output }}</b> (Tổng cột A nhân với số bộ hashtag)</h5>@endif
                            <div class="form-group">
                                <textarea rows="10" class="form-control" name="xxx">{!! $output ?? '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            @endif


            <div class="form-group">
                <button type="submit" class="btn btn-success">{{ t('Save') }}</button>
            </div>
        </form>

    </div>
@endsection

@push('scripts')

@endpush
