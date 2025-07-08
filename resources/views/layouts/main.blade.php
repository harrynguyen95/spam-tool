<!DOCTYPE html>
<html>

@include('layouts.head')

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- main-header -->
    @include('layouts.main-header')

    <!-- main-sidebar -->
    @include('layouts.main-sidebar')
    <style>
        .content-wrapper {
            background-color: #fff;
            /* min-height: calc(100vh - 50px) !important; */
        }
    </style>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('page_title')
            </h1>

            @yield('breadcrumb')

        </section>

        <!-- Main content -->
        <section class="content">
        @php
            $results = session()->get('results') ?? [];
            $columns = 4;
            $rows = ceil(count($results) / $columns);
            $columnData = array_fill(0, $columns, []);

            foreach ($results as $i => $result) {
                $colIndex = floor($i / $rows);
                $columnData[$colIndex][] = $result;
            }
        @endphp

        @if(count($results) > 0)
            <div class="alert" style="border: 1px solid #ddd; padding: 10px;">
                <div style="display: flex; gap: 20px;">
                    @foreach($columnData as $column)
                        <div style="flex: 1;">
                            @foreach($column as $result)
                                <div class="{{ strpos($result, 'failed') !== false ? 'failed-result' : 'success-result' }}">
                                    {{ $result }}
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err)
                        {{ $err }}<br>
                    @endforeach
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            @endif

            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div id="loading">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>


    @include('layouts.footer')

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ cxl_asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ cxl_asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ cxl_asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ cxl_asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ cxl_asset('backend/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ cxl_asset('backend/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ cxl_asset('backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ cxl_asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<!-- FastClick -->
<script src="{{ cxl_asset('backend/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ cxl_asset('backend/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ cxl_asset('backend/dist/js/demo.js') }}"></script>
<!-- Select2 -->
<script src="{{ cxl_asset('backend/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ cxl_asset('backend/bower_components/ckeditor/ckeditor.js') }}"></script>
<script src="{!! cxl_asset('backend/bower_components/bootstrap-fileinput/js/plugins/piexif.js') !!}"></script>
<script src="{!! cxl_asset('backend/bower_components/bootstrap-fileinput/js/fileinput.js') !!}"></script>
<script src="{!! cxl_asset('backend/bower_components/bootstrap-fileinput/js/plugins/sortable.js') !!}"></script>
<script src="{!! cxl_asset('backend/bower_components/bootstrap-fileinput/js/plugins/purify.js') !!}"></script>

<!-- page script -->
<script>
    $(function () {
        $('.select2').select2({
            placeholder: "Please select...",
            allowClear: true
        });
        $('#datatables').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            "sScrollX"    : "100%",
            "sScrollXInner": "100%",
            "bScrollCollapse": true,
        });

        $('#datepicker').datepicker({
            autoclose: true
        });

    })
</script>

@stack('scripts')
</body>
</html>
