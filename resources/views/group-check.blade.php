@extends('layouts.main')
@section('page_title')
    Group Check
@endsection
@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="active">Group</li>
</ul>
@endsection
@section('content')
    <div class="sp-push-form">
        @if (!empty($message))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
        @endif
        

            <div class="row folder">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><b>Group Uid (20 groups)</b></h5>
                            @if(isset($ctn))<h5 class="card-subtitle mb-2 text-muted">Tổng: <b>{{ $ctn }}</b></h5>@endif
                            <div class="form-group">
                                <textarea id="list-group" rows="10" class="form-control" name="groups">{!! $groups ?? '' !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-success" id="btn-save">{{ t('Save') }}</button>
            </div>
        </form>

    </div>
@endsection

@push('scripts')
<script>
    $('body').on('click', '#btn-save', function(e) {
        e.preventDefault();
        let groups = $('#list-group').val().split("\n");
        console.log('groups: ', groups)
        groups.forEach(e => {
            window.open('https://www.facebook.com/groups/' + e + '/')
        })
    });
</script>

@endpush
