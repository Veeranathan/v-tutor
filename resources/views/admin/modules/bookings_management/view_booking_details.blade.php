@extends('admin.layouts.app')
@section('title')
View Booking Details
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
                <h1 class="pull-left page-title">View Booking Details<br/><p class="small_tag">You can find information or view booking details in this section</p></h1>
                <ol class="breadcrumb pull-right">
                    <li><a href="{{ route('booking.management') }}"><i class="fas fa-angle-double-left"></i> Back</a></li>
                    @if(@$bookingDataInformation->booking_status != 'C')
                    <li class="cancel_booking_show_hide"><a class="cancel_booking" href="javascript:void(0);"><i class="fas fa-angle-double-left"></i> Cancel Booking</a></li>
                    @endif
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
                                    {{ @$bookingDataInformation->booking_no }}

                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
                                <div class="form-group"> 
                                    <label for="f_name">Student Name</label> 
                                    <p class="text-muted"> 
                                        {{ @$bookingDataInformation->getStudent->f_name }} {{ @$bookingDataInformation->getStudent->l_name }} 
                                        @if( @$bookingDataInformation->dto_student_from_time && @$bookingDataInformation->dto_student_to_time ) 
                                        ({{ $bookingDataInformation->dto_student_from_time }} - {{ $bookingDataInformation->dto_student_to_time }}) 
                                        @endif 
                                    </p> 
                                </div> 
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
                                <div class="form-group"> 
                                    <label for="f_name">Tutor Name</label> 
                                    <p class="text-muted"> 
                                        {{ @$bookingDataInformation->getTutor->f_name }} {{ @$bookingDataInformation->getTutor->l_name }} 
                                        @if( @$bookingDataInformation->dto_tutor_from_time && @$bookingDataInformation->dto_tutor_to_time ) 
                                        ({{ $bookingDataInformation->dto_tutor_from_time }} - {{ $bookingDataInformation->dto_tutor_to_time }})
                                         @endif 
                                        </p>
                                     </div> 
                                    </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="l_name"> Subject</label>
                                    <p class="text-muted">
                                        {{ @$bookingDataInformation->getSubject->subject }}
                                    </p>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="f_name">Student Grade</label>
                                    <p class="text-muted">
                                        {{ @$bookingDataInformation->getStudentGrade->grade_name }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="grade">Tutor Rate Per Session (30 min)</label>

                                    <p class="text-muted">
                                    ${{ @$bookingDataInformation->hourly_rate }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12"> 
                                <div class="form-group"> 
                                    <label for="email">Booking Date & time</label> 
                                    <p class="text-muted"> 
                                        @if( @$bookingDataInformation->dto_admin_from_datetime && @$bookingDataInformation->dto_admin_to_datetime ) {{ $bookingDataInformation->dto_admin_from_datetime->format('d-m-Y h:i a') }} - {{ $bookingDataInformation->dto_admin_to_datetime->format('h:i a') }}
                                         @else 
                                         - 
                                         @endif 
                                    </p>
                                 </div>
                                 </div>

                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Booking Status</label>
                                    <p class="text-muted booking_status_text">
                                        @if(@$bookingDataInformation->booking_status == 'C')
                                        Cancelled
                                        @elseif(@$bookingDataInformation->booking_status == 'CM')
                                        Completed
                                        @elseif(@$bookingDataInformation->booking_status == 'B')
                                        Booked
                                        @endif
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Amount</label>
                                    <p class="text-muted">
                                        ${{ @$bookingDataInformation->booking_amount }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Transaction Id</label>
                                    <p class="text-muted">
                                        {{ @$bookingDataInformation->getPaymentsInfo->txn_id }}
                                    </p>

                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Payment Status</label>
                                    <p class="text-muted">
                                        @if(@$bookingDataInformation->getPaymentsInfo->status == 'S')
                                        Success
                                        @elseif(@$bookingDataInformation->getPaymentsInfo->status == 'F')
                                        Failed
                                        @elseif(@$bookingDataInformation->getPaymentsInfo->status == 'I')
                                        Initiated
                                        @elseif(@$bookingDataInformation->getPaymentsInfo->status == 'C')
                                        Cancelled
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @if(@$bookingDataInformation->booking_status == 'C')
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Refund id</label>
                                    <p class="text-muted">
                                        @if(@$bookingDataInformation->getPaymentsInfo->refund_id ){{ @$bookingDataInformation->getPaymentsInfo->refund_id }} @else No refund @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Refund amount</label>
                                    <p class="text-muted">
                                        ${{ @$bookingDataInformation->getPaymentsInfo->refund_amount }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Refund amount</label>
                                    <p class="text-muted">
                                        @if(@$bookingDataInformation->getPaymentsInfo->refund_type == '100')
                  Full Refund
                  @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == '75')
                  75% amount refunded
                  @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == '50')
                  50% amount refunded
                  @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == '25')
                  25% amount refunded
                  @elseif(@$bookingDataInformation->getPaymentsInfo->refund_type == 'N')
                  No refund
                  @endif
                                    </p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="gender">Refund Status</label>
                                    <p class="text-muted">
                                        @if(@$bookingDataInformation->getPaymentsInfo->refund_id )
                                        @php
                                        $paidVia = json_decode(@$bookingDataInformation->getPaymentsInfo->refund_response);
                                        @endphp
                                        {{strtoupper(@$paidVia->status)}}
                                        @else
                                        No refund
                                        @endif
                                        {{-- @if(@$bookingDataInformation->getPaymentsInfo->refund_status == 'S')
                                        Success
                                        @elseif(@$bookingDataInformation->getPaymentsInfo->refund_status == 'F')
                                        Failed
                                        @elseif(@$bookingDataInformation->getPaymentsInfo->refund_status == 'I')
                                        Initiated
                                        @elseif(@$bookingDataInformation->getPaymentsInfo->refund_status == 'C')
                                        Cancelled
                                        @endif --}}
                                    </p>
                                </div>
                            </div>
                            @endif
                            @if(@$bookingDataInformation->booking_status != 'C')
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 form-group">
                                <div class="form-group">
                                    <label for="s">Start Session Link</label>
                                    <p class="text-muted overflowtext">
                                        <a id="join_video_link" target="_blank" href="{{ route('class.session.link', ['userid' => @$bookingDataInformation->getStudent->unique_id, 'id' => $bookingDataInformation->booking_no]) }}">{{ route('class.session.link',['userid' => @$bookingDataInformation->getStudent->unique_id, 'id' => @$bookingDataInformation->booking_no]) }}</a><i class="fa fa-clone" id="join_copy_link" aria-hidden="true" title="Copy link" data-toggle="tooltip"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="v">Join Session Link</label>
                                    <p class="text-muted overflowtext">
                                        <a id="share_video_link" target="_blank" href="{{ route('tutor.class.session.link',['userid' => @$bookingDataInformation->getTutor->unique_id, 'id' => @$bookingDataInformation->booking_no]) }}">{{ route('tutor.class.session.link',['userid' => @$bookingDataInformation->getTutor->unique_id, 'id' => @$bookingDataInformation->booking_no]) }}</a><i class="fa fa-clone" id="share_copy_link" aria-hidden="true" title="Copy link" data-toggle="tooltip"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        
                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 form-group">
                                <div class="form-group">
                                    <label>Session Recording Link</label>
                                    <p class="text-muted overflowtext">
                                        @if($bookingDataInformation->recordings && $bookingDataInformation->recordings->count() > 0)
                                            @php
                                                $baseUrl = "https://afored.sharepoint.com/sites/Academics/Shared%20Documents/07%20Interviews%20%26%20Session%20Recordings/Session%20Recordings/";
                                                $displayFolder = "Microsoft/Shared Points/DocumentsLibrary/07 Interviews & Session Recordings/Session Recordings/";
                                              @endphp

                                            @foreach($bookingDataInformation->recordings as $recording)
                                                @if(!empty($recording->file_name))
                                                    @php
                                                        $fileName = $recording->file_name;
                                                        $fileUrl = $baseUrl . rawurlencode($fileName);
                                                    @endphp
                                                    <a target="_blank" href="{{ $fileUrl }}">
                                                        {{ $fileName }}
                                                    </a>
                                                    <div style="font-size:12px; color:#888;">
                                                        {{ $displayFolder . $fileName }}
                                                    </div>
                                                    <br>
                                                @else
                                                    N/A<br>
                                                @endif
                                            @endforeach
                                            @else
                                                N/A
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Student Login Time</label>
                                        <p class="text-muted">
                                            {{ @$bookingDataInformation->dto_admin_student_login_at ?: 'N/A' }}
                                        </p>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label>Tutor Login Time</label>
                                    <p class="text-muted">
                                        {{ @$bookingDataInformation->dto_admin_tutor_login_at ?: 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            @endif
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha256-3blsJd4Hli/7wCQ+bmgXfOdK7p/ZUMtPXY08jmxSSgk=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click",".cancel_booking",function(e){

            var id = {{ @$bookingDataInformation->id }},
            obj = $(this),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'id'    : {{ @$bookingDataInformation->id }}
                }
            };

            if(confirm("Do you want to cancel this booking ?")){
                $.ajax({
                    url:"{{ route('ajax.cancel.booking') }}",
                    dataType: 'json',
                    data: reqData,
                    type: 'post',
                    success:function(resp){
                        if(resp.status == 1){
                            toastr.success(resp.message);
                            $(".booking_status_text").html("Cancelled");
                            $(".cancel_booking_show_hide").hide();
                            location.reload();
                        }else{
                            toastr.error(resp.message);
                        }
                    }
                });
            }
            // isAuthorizedByAdmin(tName,targetId,id);
        });
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
