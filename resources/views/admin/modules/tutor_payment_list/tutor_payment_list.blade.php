@extends('admin.layouts.app')

@section('title','Tutor Payment Management')

@section('links')
@include('admin.includes.links')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection

@section('header')
@include('admin.includes.header')
@endsection

@section('sidebar')
@include('admin.includes.sidebar')
@endsection

@section('content')

<div class="content">
<div class="container">

    <div class="row">
        <div class="col-sm-12">
            <h1 class="page-title">Tutor Payment Management</h1>
        </div>
    </div>

    {{-- ✅ Commission & Filter Bar --}}
    <div class="panel panel-default">
    <div class="panel-body">

        <div class="row" style="margin-bottom:10px;">

            {{-- Commission --}}
            <div class="col-md-6 d-flex align-items-center">
                <form id="commissionForm" method="POST" action="{{ route('admin.set.commission') }}" class="form-inline">
                    @csrf
                    <label style="font-weight:600; margin-right:8px;">Commission %</label>

                    <input type="number"
                           class="form-control input-sm"
                           id="commission"
                           name="commission"
                           min="0" max="100"
                           value="{{ @$admin_commission_management->commission }}"
                           style="width:70px; display:inline-block; margin-right:8px;"
                           required>

                    <button class="btn btn-primary btn-sm" type="submit" style="padding:5px 12px;">
                        Save
                    </button>
                </form>
            </div>

            {{-- Tutor Search --}}
            <div class="col-md-6 text-right">
                <label style="font-weight:600; margin-right:8px;">Tutor</label>

                <input type="text"
                       id="tutor_filter"
                       class="form-control input-sm reset_val"
                       placeholder="Search Tutor"
                       style="width:200px; display:inline-block; margin-right:5px;">

                <button class="btn btn-primary btn-sm search_click" style="padding:5px 12px;">
                    Search
                </button>

                <button class="btn btn-default btn-sm reset_search" style="padding:5px 12px; margin-left:5px;">
                    Reset
                </button>
            </div>

        </div>

    </div>
</div>

    {{-- ✅ Data Table --}}
    <div class="panel panel-default">
        <div class="panel-body">

            <table class="table table-bordered table-striped" id="example">
                <thead>
                <tr>
                    <th>Tutor ID</th>
                    <th>Tutor Name</th>
                    <th>Gross Revenue ($)</th>
                    <th>Commission ($)</th>
                    <th>Net Revenue ($)</th>
                    <th>Total Paid Out</th>
                    <th>Remaining Pay Out</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>

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
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function(){

    let table = $('#example').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        serverMethod: 'POST',
        "language": {
            "emptyTable": "No data available",
            "info": "",
            "infoEmpty": "",
            "infoFiltered": ""
        },

        ajax: {
    url: "{{ route('tutor.payment.list.datatable') }}",
    type: "POST",
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    xhrFields: {
        withCredentials: true  // 🔥 ensures admin session cookies are sent
    },
    data: function(d) {
        d.columns = [
            {},
            {search: {value: $('#tutor_filter').val()}}
        ];
    }
},

        columns: [
            { data: "unique_id" },
            { data: "tutor_name" },
            { data: "gross_revenue" },
            { data: "commission" },
            { data: "net_revenue" },
            { data: "total_paid_out" },
            { data: "remaining_payout" },
        ]
    });

    $('.search_click').click(function(){
        table.ajax.reload();
    });

    $('.reset_search').click(function(){
        $('.reset_val').val('');
        table.ajax.reload();
    });

});
</script>
@endsection
