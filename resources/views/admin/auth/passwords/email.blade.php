<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta name="description" content="V-Tutor  Admin Panel">
        <meta name="author" content="V-Tutor  Admin Panel">

        {{-- <link rel="icon" href="{{ public_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ public_asset('admin/assets/images/favicon.ico') }}" type="image/x-icon" /> --}}
        <link rel="icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{ public_asset('assets/images/favicon.ico')}}" type="image/x-icon" />
        <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="32x32">
        <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="96x96">
        <link rel="icon" href="{{ public_asset('assets/images/favicon.png') }}" sizes="192x192">
        <link rel="apple-touch-icon" href="{{ public_asset('assets/images/favicon.png') }}">
        <meta name="msapplication-TileImage" content="{{ public_asset('assets/images/favicon.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ public_asset('assets/images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ public_asset('assets/images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ public_asset('assets/images/favicon-16x16.png') }}">

        <title>V-Tutor </title>

        <link href="{{ public_asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ public_asset('admin/assets/css/core.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ public_asset('admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ public_asset('admin/assets/css/components.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ public_asset('admin/assets/css/pages.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ public_asset('admin/assets/css/menu.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ public_asset('admin/assets/css/responsive.css') }}" rel="stylesheet" type="text/css">

        <script src="{{ public_asset('admin/assets/js/modernizr.min.js') }}"></script>
        <style type="text/css">
    .alert-success {
    color: #fff;
    background-color: #b80f0a;
    border-color: #b80f0a;
}
.alert .close{color: #fff;}
.toast-container{
  background-color: #d73c5e;
}
.toast-success{
  background-color: #d73c5e;
}
</style>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','../../www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-65046120-1', 'auto');
  ga('send', 'pageview');

</script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->


    </head>
    <body>


        <div class="wrapper-page">
            <div class="panel panel-color panel-primary panel-pages">

                <div class="panel-heading bg-img">
                    <div class="bg-overlay"></div>
                    <h3 class="text-center m-t-10 text-white"> Reset Password </h3>
                </div>

                <div class="panel-body">
                    @include('admin.includes.message')
                 <form method="post" action="{{route('admin.password.email')}}" role="form" id="ForgetForm" class="text-center">
                 @csrf
                    <div class="alert alert-info alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{-- Enter your <b>Email</b> and instructions will be sent to you! --}}
                        Click Reset to send a password reset link
                    </div>
                    <div class="form-group m-b-0">
                        <div class="input-group">
                            <input type="email" class="form-control input-lg required" placeholder="Enter Email" required="" name="email" value="my.vtutor@gmail.com" readonly="">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-lg btn-primary waves-effect waves-light">Reset</button>
                            </span>

                        </div>
                        <div class="error_text"></div>
                    </div>

                </form>

                </div>

            </div>
        </div>


        <script>
            var resizefunc = [];
        </script>

        <!-- Main  -->
        <script src="{{ public_asset('admin/assets/js/jquery.min.js') }}"></script>
        <script src="{{ public_asset('admin/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ public_asset('admin/assets/js/detect.js') }}"></script>
        <script src="{{ public_asset('admin/assets/js/fastclick.js') }}"></script>
        <script src="{{ public_asset('admin/assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ public_asset('admin/assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ public_asset('admin/assets/js/waves.js') }}"></script>
        <script src="{{ public_asset('admin/assets/js/wow.min.js') }}"></script>
        <script src="{{ public_asset('admin/assets/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ public_asset('admin/assets/js/jquery.scrollTo.min.js') }}"></script>

        <script src="{{ public_asset('admin/assets/js/jquery.app.js') }}"></script>
        <script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>
        {{-- <script type="text/javascript">
            $(document).ready(function(){
                $('#ForgetForm').validate({
                    rules: {
                        email: { required: true,email:true}
                    },
                    submitHandler:function(form){

                       form.submit();

                    },
                });
            });

        </script> --}}
        <script type="text/javascript">
            $("#ForgetForm").validate({
        rules:{
            'email':{
                required:true,
                email:true
            }
        },
        messages: {
            email: {
                required: "@lang('validation.required')"
            }
        },
        errorPlacement: function (error, element)
        {
                if (element.attr("name") == "email") {
                    var error = '<label for="fn" generated="true" class="error" style="color:#f85d2c;border:none!important;background:none!important;">'+"This field is required!"+'</label>';
                    $('.error_text').html(error);
                }

            }
        });


        </script>
    </body>
</html>
