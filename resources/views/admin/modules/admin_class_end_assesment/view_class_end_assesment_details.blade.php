@extends('admin.layouts.app')
@section('title')
View Class End Assesment Details
@endsection
@section('links')
@include('admin.includes.links')
<style type="text/css">

</style>
@endsection
@section('header')
@include('admin.includes.header')
@endsection
@section('sidebar')
@include('admin.includes.sidebar')
@endsection
@section('content')
<div class="content">
    <div class="wraper container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left page-title">View Class End Assesment Details<br/><p class="small_tag">You can find information or view class end assesment details in this section</p></h1>
                <ol class="breadcrumb pull-right">
                    <li><a href="{{ route('manage.admin.class.end.assesment') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>

                </ol>
            </div>
        </div>

        <!-- Personal-Information -->
        <div class="panel panel-default panel-fill">
            <div class="panel-body rm02 rm04">
                @include('admin.includes.message')

                    <div class="frm_admin">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Booking No</label>
                                    <p class="text-muted">
                                    {{ @$assesmentDetails->bookingInfo->booking_no }}

                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Student Name</label>
                                    <p class="text-muted">
                                        {{ @$assesmentDetails->getUser->f_name }} {{ @$assesmentDetails->getUser->l_name }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Stduent/Tutor</label>
                                    <p class="text-muted">
                                        @if(@$assesmentDetails->getUser->user_type == 'T')
                                        Tutor
                                        @else
                                        Student
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="email">Posted On</label>
                                    <p class="text-muted">
                                        @if(@$assesmentDetails->created_at)
                                         {{ date('Y-m-d',strtotime($assesmentDetails->created_at)) }}
                                         @endif
                                    </p>
                                </div>
                            </div>


                            <div class="clearfix"></div>



                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="table-responsive">
                                    {{-- <div class="table-res"> --}}
                                    <table class="table table-bordered table-striped" id="example">
                                        <thead>
                                            <tr>
                                                <th class="rm07">Question</th>
                                                <th class="rm07">Answer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(@$assesmentQA)
                                                @foreach(@$assesmentQA as $qa)
                                                <tr>
                                                    <td>{{ @$qa->getQuestion->question }}</td>
                                                    <td>@if(@$qa->getQuestion->answer_type == 'radio'){{ @$qa->getAnswer->answer }} @else {{ @$qa->answer }} @endif</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
@include('admin.includes.footer')

@endsection
@section('script')
@include('admin.includes.script')
<script src="{{public_asset('admin/assets/js/jquery.validate.js')}}"></script>
<script src="{{ public_asset('admin/assets/libs/js/chosen.jquery.min.js') }}"></script>
<script src="{{ public_asset('assets/js/chosen.jquery.js') }}" type="text/javascript"></script>
<script src="{{ public_asset('assets/js/init.js') }}" type="text/javascript"></script>
{{-- for datatable --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
{{-- for validation --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha256-3blsJd4Hli/7wCQ+bmgXfOdK7p/ZUMtPXY08jmxSSgk=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $("#example").DataTable();
    $(document).ready(function(){


        function CopyToClipboard(containerid) {
            if (window.getSelection) {
                if (window.getSelection().empty) { // Chrome
                    window.getSelection().empty();
                } else if (window.getSelection().removeAllRanges) { // Firefox
                    window.getSelection().removeAllRanges();
                }
            } else if (document.selection) { // IE?
                document.selection.empty();
            }

            if (document.selection) {
                var range = document.body.createTextRange();
                range.moveToElementText(document.getElementById(containerid));
                range.select().createTextRange();
                document.execCommand("copy");
            } else if (window.getSelection) {
                var range = document.createRange();
                range.selectNode(document.getElementById(containerid));
                window.getSelection().addRange(range);
                document.execCommand("copy");
            }
            toastr.success('Link copied!');
        }
        $('#join_copy_link').click(function() {
            CopyToClipboard('join_video_link')
        });
        $('#share_copy_link').click(function() {
            CopyToClipboard('share_video_link')
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {

    })

</script>
@endsection
