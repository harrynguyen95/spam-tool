<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" >
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wrapper</title>
    <link href="{{cxl_asset('/admin/dist/css/AdminLTE.css')}}" rel="stylesheet">
    <link href="{{cxl_asset('/admin/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">

</head>
<body >
<section class="content" style="color: #555">
    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3>Forbidden (#403)
            </h3>
            <p style="color: red; font-size: 18px">
                You are not allowed to perform this action.            </p>


            <p>
                The above error occurred while the Web server was processing your request.
                Please contact us if you think this is a server error. Thank you.
                Meanwhile, you may <a href='$'>return to dashboard</a> or try using the search
                form.
            </p>


            <p>
                If you can't return to dashboard, please <a href='#'> logout </a>, and login by staff account.
            </p>

            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="Search"/>


                </div>
            </form>
        </div>
    </div>
</section>



</body>
</html>
