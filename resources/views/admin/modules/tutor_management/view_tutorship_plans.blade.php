@extends('admin.layouts.app')
@section('title')
Tutoring Plan
@endsection
@section('links')
@include('admin.includes.links')
<link rel="stylesheet" type="text/css" href="{{ public_asset('admin/assets/libs/css/chosen.css') }}">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.2.1/css/fixedColumns.dataTables.min.css"/>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style type="text/css">
    .buttons-excel { display: none; }

    :root {
        --tw-primary: #d71f3e;
        --tw-primary-soft: #fdebee;
        --tw-ink: #1b2437;
        --tw-muted: #6b7488;
        --tw-border: #e6e9f0;
        --tw-bg: #f6f7fb;
        --tw-radius: 12px;
    }

    .tw-page { background: var(--tw-bg); }

    .tw-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }
    .tw-head h1 { margin: 0; font-size: 26px; font-weight: 700; color: var(--tw-ink); }
    .tw-head .small_tag { margin: 4px 0 0; color: var(--tw-muted); font-size: 13px; }
    .tw-actions { display: flex; flex-wrap: wrap; gap: 8px; }
    .tw-actions .btn {
        border-radius: 8px;
        background: #fff !important;
        color: var(--tw-ink);
        font-weight: 600;
        font-size: 13px;
        padding: 7px 14px;
    }
    .tw-actions .btn:hover { border-color: var(--tw-primary); color: var(--tw-primary); }

    .tw-card {
        background: #fff;
        border: 1px solid var(--tw-border);
        border-radius: var(--tw-radius);
        padding: 20px 22px;
        margin-bottom: 18px;
        box-shadow: 0 1px 2px rgba(27, 36, 55, .04);
    }
    .tw-card-title {
        margin: 0 0 14px;
        font-size: 16px;
        font-weight: 700;
        color: var(--tw-ink);
    }

    .tw-profile { display: flex; align-items: center; flex-wrap: wrap; gap: 20px; }
    .tw-avatar {
        width: 64px; height: 64px;
        border-radius: 50%;
        background: var(--tw-primary-soft);
        color: var(--tw-primary);
        font-weight: 700; font-size: 22px;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; flex-shrink: 0;
    }
    .tw-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .tw-profile-name { margin: 0; font-size: 20px; font-weight: 700; color: var(--tw-ink); }
    .tw-profile-sub { color: var(--tw-muted); font-size: 13px; margin-top: 2px; }
    .tw-meta { display: flex; flex-wrap: wrap; margin-left: auto; }
    .tw-meta-item { padding: 0 24px; border-left: 1px solid var(--tw-border); }
    .tw-meta-item span { display: block; font-size: 12px; color: var(--tw-muted); }
    .tw-meta-item strong { font-size: 14px; color: var(--tw-ink); }

    /* ---------- Layout ---------- */
    .tw-layout { display: flex; gap: 18px; align-items: stretch; }
    .tw-side { width: 250px; flex-shrink: 0; align-self: stretch; }

    .tw-section-title { margin: 0; font-size: 22px; font-weight: 700; color: var(--tw-ink); }
    .tw-section-sub { margin: 4px 0 18px; color: var(--tw-muted); font-size: 13px; }

    .tw-badge {
        display: inline-block;
        margin-left: 8px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px; font-weight: 700;
        background: #eef0f5; color: var(--tw-muted);
    }
    .tw-badge.approved { background: #dcf5e4; color: #1a7a3c; }
    .tw-badge.pending  { background: #fff3d6; color: #a86b00; }
    .tw-badge.rejected { background: #fde2e5; color: #b4152f; }
    .tw-main { flex: 1; min-width: 0; }

    .tw-nav {
        height: 100%;
        min-height: calc(100vh - 280px);
        list-style: none;
        margin: 0; padding: 10px;
        background: #fff;
        border: 1px solid var(--tw-border);
        border-radius: var(--tw-radius);
    }
    .tw-nav li { margin: 0 0 2px; }
    .tw-nav li a {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 13px; font-weight: 600;
        color: var(--tw-ink);
        text-decoration: none;
        border-left: 3px solid transparent;
        transition: background .15s, color .15s;
    }
    .tw-nav li a span { display: inline-flex; width: 18px; }
    .tw-nav li a span img { width: 16px; height: auto; }
    .tw-nav li a .accth { display: none; }
    .tw-nav li a:hover,
    .tw-nav li.active a {
        background: var(--tw-primary-soft);
        color: var(--tw-primary);
        border-left-color: var(--tw-primary);
    }
    .tw-nav li a:hover .actt,
    .tw-nav li.active a .actt { display: none; }
    .tw-nav li a:hover .accth,
    .tw-nav li.active a .accth { display: inline; }

    .tw-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 18px; }
    .tw-grid .tw-card { margin-bottom: 0; }
    .tw-grid-wrap { margin-bottom: 18px; }
    .tw-list { margin: 0; }
    .tw-row {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid var(--tw-border);
        font-size: 14px;
    }
    .tw-row:last-child { border-bottom: 0; }
    .tw-row dt { width: 40%; font-weight: 600; color: var(--tw-ink); }
    .tw-row dd { margin: 0; flex: 1; color: #3b4458; word-break: break-word; }
    .tw-addr { display: grid; grid-template-columns: repeat(2, 1fr); column-gap: 28px; }
    .tw-text { margin: 0; color: #3b4458; line-height: 1.7; font-size: 14px; }

    @media (max-width: 991px) {
        .tw-layout { flex-direction: column; }
        .tw-side { width: 100%; }
        .tw-nav { display: flex; overflow-x: auto; white-space: nowrap; gap: 4px; height: auto; min-height: 0; }
        .tw-nav li { margin: 0; }
        .tw-meta { margin-left: 0; width: 100%; }
        .tw-meta-item:first-child { border-left: 0; padding-left: 0; }
    }
    @media (max-width: 575px) {
        .tw-addr { grid-template-columns: 1fr; }
        .tw-row { flex-direction: column; }
        .tw-row dt { width: 100%; margin-bottom: 2px; }
    }

    .tw-table-card { padding: 8px 18px 18px; }
    .tw-table-card .table-responsive { border: 0; margin-bottom: 0; }
    #example { width: 100% !important; border: 0; margin-bottom: 0; }
    #example thead th {
        background: #eef1f8;
        color: var(--tw-ink);
        font-size: 13px; font-weight: 700;
        border: 0; border-bottom: 1px solid var(--tw-border);
        padding: 12px;
    }
    #example tbody td {
        border: 0; border-bottom: 1px solid var(--tw-border);
        padding: 13px 12px;
        font-size: 14px; color: #3b4458;
        vertical-align: middle;
    }
    #example.table-striped > tbody > tr:nth-of-type(odd) { background: #fafbfd; }
    #example tbody tr:hover { background: var(--tw-primary-soft); }
    .dataTables_wrapper .dataTables_processing {
        border-radius: 8px; border: 1px solid var(--tw-border);
        color: var(--tw-ink); font-weight: 600;
    }
    .dataTables_wrapper .dataTables_paginate { margin-top: 14px; }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important; border: 1px solid var(--tw-border) !important;
        background: #fff !important; color: var(--tw-ink) !important; margin-left: 4px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--tw-primary-soft) !important;
        border-color: var(--tw-primary) !important;
        color: var(--tw-primary) !important;
    }

    .tw-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
        padding: 12px 0 14px;
    }
    .tw-count { font-size: 13px; color: var(--tw-muted); }
    .tw-count strong { color: var(--tw-ink); font-size: 15px; }
    .tw-filters { display: flex; flex-wrap: wrap; gap: 8px; margin-left: auto; justify-content: flex-end; }
    .tw-filters .tw-select {
        height: 34px; min-width: 130px;
        padding: 0 28px 0 12px;
        border: 1px solid var(--tw-border); border-radius: 20px;
        background-color: #f1f4fb; color: #2a3a78;
        font-size: 12px; font-weight: 600;
    }
    .tw-filters .tw-select:focus { border-color: var(--tw-primary); outline: 0; }
    .tw-filters .tw-reset {
        height: 34px; border-radius: 20px;
        border: 1px solid var(--tw-border); background: #fff;
        color: var(--tw-ink); font-size: 12px; font-weight: 600; padding: 0 14px;
    }
    .tw-filters .tw-reset:hover { border-color: var(--tw-primary); color: var(--tw-primary); }
    @media (max-width: 575px) {
        .tw-filters { margin-left: 0; width: 100%; justify-content: flex-start; }
        .tw-filters .tw-select { flex: 1; min-width: 0; }
    }
</style>
@endsection
@section('header')
@include('admin.includes.header')
@endsection
@section('sidebar')
@include('admin.includes.sidebar')
@endsection
@section('content')
@php
    $activeRoute = 'view.tutor.tutorship.plans';
    $fullName = trim(implode(' ', array_filter([@$user->f_name, @$user->m_name, @$user->l_name])));
    $initials = strtoupper(mb_substr((string) @$user->f_name, 0, 1) . mb_substr((string) @$user->l_name, 0, 1));

    $tutorCode = @$user->tutor_id ?: 'TUT' . str_pad((string) @$user->id, 6, '0', STR_PAD_LEFT);

if ($user->status == 'A' && $user->subscription == 'S' && $user->draft == 'N') {
        $statusLabel = 'Approved';
        $statusClass = 'approved';
    } elseif ($user->status == 'A') {
        $statusLabel = 'Pending';
        $statusClass = 'pending';
    } elseif ($user->status == 'I') {
        $statusLabel = 'Suspended';
        $statusClass = 'suspended';
    } elseif ($user->status == 'R') {
        $statusLabel = 'Rejected';
        $statusClass = 'rejected';
    } else {
        $statusLabel = '—';
        $statusClass = '';
    }
  

    $subjectsText = collect(@$tutor_subjects)->pluck('name')->filter()->implode(', ');

    $availabilityText = @$user->availability_status ? 'Yes' : 'No';

    $navUrl = function ($name) use ($user) {
        return \Illuminate\Support\Facades\Route::has($name) ? route($name, $user->id) : 'javascript:void(0);';
    };
    $navItems = [
        ['Overview',          'view.tutor.overview',             'peri.png', 'perih.png',   false],
        ['Personal Details',  'view.tutor.personal.info.step.1', 'peri.png', 'perih.png',   true],
        ['Tutorship Plan',    'view.tutor.tutorship.plans',      'gar.png',  'garh.png',    false],
        ['Academics',         'view.tutor.academics',            'aca.png',  'acah.png',    false],
        ['Experience',        'view.tutor.experience',           'ex.png',   'exh.png',     false],
        ['Recognitions',      'view.tutor.recognitions',         'rec.png',  'rech.png',    false],
        ['Right to Work',     'view.tutor.right.to.work',        'rec.png',  'rech.png',    false],
        ['Availability',      'view.tutor',                      'rec.png',  'checked.png', false],
        ['Learning Programs', 'view.tutor.learning.programs',    'aca.png',  'acah.png',    false],
        ['Public Profile',    'view.tutor.public.profile',       'peri.png', 'perih.png',   false],
    ];
@endphp
<div class="content tw-page">
    <div class="wraper container-fluid">

        <div class="tw-head">
            <div>
                <h1>Tutor Workspace</h1>
                <p class="small_tag">You can find information or view tutor profile in this section</p>
            </div>
            <div class="tw-actions">
                <a class="btn" href="{{ route('tutor.public.profile', $user->slug) }}">
                        <i class="fas fa-external-link-alt"></i> View Public Profile
                </a>
            </div>
        </div>

        @include('admin.includes.message')

        <div class="tw-card">
            <div class="tw-profile">
                <div class="tw-avatar">
                    @if(@$user->profile_pic)
                        <img id="img2" src="{{ URL::to('storage/teacher_profile_pic/'.@$user->profile_pic) }}" alt="{{ $fullName }}">
                    @elseif(@$user->avatar)
                        <img id="img2" src="{{ @$user->avatar }}" alt="{{ $fullName }}">
                    @else
                        {{ $initials ?: '?' }}
                    @endif
                </div>
                <div>
                    <h2 class="tw-profile-name">{{ $fullName ?: '—' }}</h2>
                    <div class="tw-profile-sub">
                        Tutor ID: {{ $tutorCode }}
                        @if($statusLabel)
                            <span class="tw-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        @endif
                    </div>
                </div>
                <div class="tw-meta">
                    <div class="tw-meta-item">
                        <span>Subjects</span>
                        <strong>{{ $branch ?: '—' }}</strong>
                    </div>
                    <div class="tw-meta-item">
                        <span>State</span>
                        <strong>{{ @$user->getState->state_name ?: '—' }}</strong>
                    </div>
                    <div class="tw-meta-item">
                        <span>Availability</span>
                        <strong>{{ $availability }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="tw-layout">

            <aside class="tw-side">
                <ul class="tw-nav">
                    @foreach($navItems as [$label, $routeName, $icon, $iconHover])
                    <li class="{{ $routeName === $activeRoute ? 'active' : '' }}">
                        <a href="{{ $navUrl($routeName) }}">
                            <span><img src="{{ public_asset('admin/assets/images/' . $icon) }}" class="actt"><img src="{{ public_asset('admin/assets/images/' . $iconHover) }}" class="accth"></span>
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </aside>

            {{-- Main content --}}
            <section class="tw-main">

                <h2 class="tw-section-title">Tutorship Plan</h2>
                <p class="tw-section-sub">Teaching grades, subjects and tutor-maintained session rates.</p>

                <div class="tw-card tw-table-card">
                    <div class="tw-toolbar">
                        <div class="tw-count">
                            Total records: <strong id="tw_total">0</strong><span id="tw_filtered"></span>
                        </div>
                        <div class="tw-filters">
                            <select id="col0_filter" class="tw-select tw-filter" data-col="0"><option value="">All Grades</option></select>
                            <select id="col1_filter" class="tw-select tw-filter" data-col="1"><option value="">All Branches</option></select>
                            <select id="col2_filter" class="tw-select tw-filter" data-col="2"><option value="">All Subjects</option></select>
                            <button type="button" id="tw_reset" class="tw-reset">Reset</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="example">
                            <thead>
                                <tr>
                                    <th>Grade</th>
                                    <th>Branch</th>
                                    <th>Subject</th>
                                    <th>Rate per Session</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
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

{{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script> --}}
<script type="text/javascript">

$(document).ready(function(){
    $.validator.setDefaults({ ignore: ":hidden:not(.slct)" });
    var isvalidator = $('#addTutorshipPlans').validate({
        rules: {
            grade_id: { required: true},
            hourly_rate:
            {
                required: true,
                number:true,
                min:10,
                max:100
            },
        },
        messages: {
            grade_id: {
                required: 'Grade required'
            },
            hourly_rate: {
                required: 'Rate per session (30 mins) is required'
            },
        },
        errorPlacement: function (error, element)
        {
            // console.log(element.attr("name"));
            // console.log(error);
            if (element.attr("name") == "subject_id[]") {
                var error = '<label for="fn" generated="true" class="error" style="color:#f85d2c;border:none!important;background:none!important;">'+'Please select atleast one subject!'+'</label>';
                $('.error_subject').html(error);
            }
            if (element.attr("name") == "grade_id") {
                var error = '<label for="fn" generated="true" class="error" style="color:#f85d2c;border:none!important;background:none!important;">'+'This field is required!'+'</label>';
                $('.error_grade').html(error);
            }
            if (element.attr("name") == "hourly_rate") {
                var error = '<label for="fn" generated="true" class="error" style="color:#f85d2c;border:none!important;background:none!important;">'+'Please enter the value between 10 to 100!'+'</label>';
                $('.error_hourly_rate').html(error);
            }

        },
        submitHandler:function(form){
           form.submit();
        },
    });
    $("#edit_tutor_tutorship_plans").click(function(){
        if(isvalidator.form()){
        if(isvalidator.valid()){
            var obj = $("#edit_tutor_tutorship_plans"),
            tId = obj.attr("id"),
            tName = "c_edit_tutor_tutorship_plans",
            tFrmId = "addTutorshipPlans";
            $("#type_popup_next").val("R");
            isAuthorizedByAdmin(tName,tId,tFrmId);
        }else{
            $('#instructionModal').modal('hide');
        }
        }

    });
    $("#example_filter").hide();


    // alert(url);
        function filterColumn ( i ) {
            $('#example').DataTable().column( i ).search(
                $('#col'+i+'_filter').val(),
            ).draw();
        }
        var dataTableObj = {
            // dom: 'Bfrtip',
            // dom: "<div class='table-res'></div>"+'p'+'B',
            // buttons: [
            //     {
            //         extend: 'excelHtml5',
            //         exportOptions: {
            //             columns: [ 0, 1,2 ]
            //         }
            //     },
            //     'colvis'
            // ],
            columnDefs: [ { targets: 0, type: 'natural' } ],
            stateSave: true,
            // "pageLength":2,
            "order": [
                [2, "desc"]
            ],
            "stateLoadParams": function (settings, data) {
                // $('#col1_filter').val(data.search.grade_name);
                if (data.columns) {
                    $.each(data.columns, function (i, col) { col.search.search = ''; });
                }
            },
            stateSaveParams: function (settings, data) {
                // data.search.grade_name = $('#col1_filter').val();
            },
            "processing": true,
            "serverSide": true,
            'serverMethod': 'post',
            "createdRow": function( row, data, dataIndex ) {
                var id = (JSON.stringify(data.id)),
                r = JSON.stringify(dataIndex);
                $(row).addClass("tr_class_"+id);
                $(row).addClass("tr_row_class");
                $(row).children(':nth-child(5)').addClass('rm07');
                $(row).children(':nth-child(5)').attr('data-id',r);
            },
            "ajax": {
                "url": "{{ route('manage.tutorship.plans.data',@$user->id) }}",
                "data": function ( d ) {
                    console.log(d);
                    d.myKey = "myValue";
                    d._token = "{{ @csrf_token() }}";
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // Do something here
                    console.log("'error in datatable");
                }
            },
            'columns': [
            {
                data: "id",
                render: function(data, type, full, meta){
                    if(full.get_grade.grade_name != null){
                        return full.get_grade.grade_name;
                    }else{
                        return "";
                    }
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta){
                    if(full.get_branch.branch_name != null){
                        return full.get_branch.branch_name;
                    }else{
                        return "";
                    }
                }
            },
            {
                data: "id",
                render: function(data, type, full, meta){
                    if(full.get_subject.subject != null){
                        return full.get_subject.subject;
                    }else{
                        return "";
                    }
                }
            },
            {
                data: "hourly_rate",
                render: function(data, type, full, meta){
                    return '$ '+data;
                }
            },
            // {
            //     data: "id",
            //     render: function(data, type, full, meta){
            //     // console.log("print : "+JSON.stringify(meta));
            //         var a='';
            //         // a+= '<a href="javascript:void(0);" class="action-dots action" data-key="'+full.id+'" id="action'+full.id+'"><img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt=""></a>\n\
            //         //     <div class="show-actions" id="show-action'+full.id+'" style="display: none;">\n\
            //         //         <span class="angle"><img src="{{ public_asset('admin/assets/images/angle.png') }}" alt=""></span>\n\
            //         //         <ul>\n\
            //         //             <li><a href="{{ url('admin/update-tutorship-plan').'/' }}'+full.id+'">Edit</a></li>\n\
            //         //             <li><a id="delete_tutor_ship_plan_'+full.id+'" class="delete_tutor_ship_plan" href="javascript:void(0);" data-id="'+full.id+'">Delete</a></li>\n\
            //         //         </ul>\n\
            //         //       </div>';
            //         return a;
            //     }
            // },
            ]
        };
        var table = dataTableCall(dataTableObj,"example");

        var twSeen = {0:{}, 1:{}, 2:{}};
        function twAddOption(col, val){
            if(!val || twSeen[col][val]){ return; }
            twSeen[col][val] = true;
            $('#col'+col+'_filter').append($('<option>').val(val).text(val));
        }
        table.on('draw.dt', function(){
            table.rows().data().each(function(row){
                twAddOption(0, row.get_grade && row.get_grade.grade_name);
                twAddOption(1, row.get_branch && row.get_branch.branch_name);
                twAddOption(2, row.get_subject && row.get_subject.subject);
            });
            var info = table.page.info();
            $('#tw_total').text(info.recordsTotal);
            $('#tw_filtered').text(info.recordsDisplay !== info.recordsTotal
                ? ' · ' + info.recordsDisplay + ' matching filters' : '');
        });
        $(document).on('change', '.tw-filter', function(){
            table.column($(this).data('col')).search($(this).val()).draw();
        });
        $('#tw_reset').on('click', function(){
            $('.tw-filter').val('');
            table.columns().search('').draw();
        });
        // var table = $('#example').DataTable(

        // );
        $("#example_filter").hide();
        $(document).on("click",".action",function(e){
            var id = $(this).data("key");
            $("#show-action"+id).slideToggle();
        });
    // $("#example").DataTable();

        // messages: {
        //         grade_id: {
        //             required: 'Grade required'
        //         },
        //         hourly_rate: {
        //             required: '@lang('validation.required')'
        //         },
        //         internal_order_rate: {
        //             required: '@lang('validation.required')'
        //         },
        //         external_order_rate: {
        //             required: '@lang('validation.required')'
        //         }
        //     },

    $(document).on("change",".required",function(){
        var id = $(this).attr("id");
        if(id == "subject_id"){
            $('.error_subject').html("");
        }
        if(id == "hourly_rate"){
            $('.error_hourly_rate').html("");
        }
        if(id == "grade_id"){
            $('.error_grade').html("");
        }
    });
    $(document).on("keyup",".required",function(){
        var id = $(this).attr("id");
        var value = parseInt($.trim($(this).val()));
        if(id == "hourly_rate"){
            if(value <=10 || value >=100){
                $('.error_hourly_rate').html("Please enter the value between 10 to 100");
            }else{
                $('.error_hourly_rate').html("");
            }

        }

    });
    $('.slct').chosen();
    $(document).on("click",".delete_tutor_ship_plan",function(e){
        var targetId = $(this).attr("id");
            $("#tId").val(targetId);
            $("#type_popup_next").val("A");
            $("#ajax_url").val("{{ route('ajax.delete.tutorship.plan') }}");
            $('#instructionModal').modal('show');
            var id = $(e.currentTarget).data("id"),
            obj = $(this),
            reqData = {
                'jsonrpc' : '2.0',
                '_token'  : '{{csrf_token()}}',
                'data'    : {
                    'id'    : id
                }
            },
            temp = table.row('.tr_class_'+id).data();
            $("#data_table_data_s").val(table);
            $("#ajax_data_id").val(id);
        // var currentObj = $(this),
        // tName = 'delete_tutor_ship_plan',
        // tId = $(this).attr("id");
        // isAuthorizedByAdmin(currentObj,tName,tId);
        // var isAuthorized = isAuthorizedByAdmin();
        // if(isAuthorized == 1){
            // var id = $(e.currentTarget).data("id"),
            // obj = $(this),
            // reqData = {
            //     'jsonrpc' : '2.0',
            //     '_token'  : '{{csrf_token()}}',
            //     'data'    : {
            //         'id'    : id
            //     }
            // },
            // temp = table.row('.tr_class_'+id).data();

            // if(confirm("Do you want to delete this tutorship plan?")){
            //     $.ajax({
            //         url:"{{ route('ajax.delete.tutorship.plan') }}",
            //         dataType: 'json',
            //         data: reqData,
            //         type: 'post',
            //         success:function(resp){
            //             if(resp.status == 1){
            //                 table.row('.tr_class_'+id).remove().draw( false );
            //                 toastr.success(resp.message);
            //             }else{
            //                 toastr.error(resp.message);
            //             }
            //         },
            //         error:function(){
            //             toastr.error("Something went wrong!Ajax error!");
            //         }
            //     });
            // }
        // }else{
            // toastr.error("Password wrong!");
            // $('#instructionModal').modal('hide');
        // }

    });
    $(document).on("change","#grade_id",function(e){
        var grade_id = $.trim($(this).val()),
        obj = $(this),
        reqData = {
            'jsonrpc' : '2.0',
            '_token'  : '{{csrf_token()}}',
            'data'    : {
                'grade_id'    : grade_id,
                'teacher_id'    : {{@$user->id  }}
            }
        };
        $.ajax({
            url:"{{ route('ajax.grade.subject') }}",
            dataType: 'json',
            data: reqData,
            type: 'post',
            success:function(resp){
                if(resp.count <=0){
                    $("#subject_id").html("");
                }else{
                    $("#subject_id").html(resp.html_response);
                }
                $(".slct").val('').trigger("chosen:updated");
            },
            error:function(){

            }
        });

    });
    $("#download").click(function(){
        $(".buttons-excel").trigger("click");
    });
    // $("#example_wrapper div").eq(0).addClass("table-res");
    $("#example_info").remove();
    $("#example_length").remove();
});
</script>
@endsection