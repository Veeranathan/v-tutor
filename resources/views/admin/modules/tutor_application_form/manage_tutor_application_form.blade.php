@extends('admin.layouts.app')

@section('title')
    Manage Tutor Application Forms
@endsection

@section('links')
    @include('admin.includes.links')
    <script src="{{ public_asset('admin/assets/js/modernizr.min.js') }}"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>
   /* Make the Action column right aligned */
#example td:last-child,
#example th:last-child {
    text-align: right !important;
    position: relative !important;
    width: 120px !important;
}

/* Align 3-dots icon to right */
.action-dots {
    float: right !important;
    cursor: pointer;
}

/* Dropdown menu positioning */
.show-actions {
    position: absolute;
    right: 0;                 /* Align to right edge */
    top: 28px;                /* Place below the dots */
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 6px;
    min-width: 130px;
    z-index: 9999;
    padding: 6px 0;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    display: none;            /* always hidden until clicked */
}

/* Remove list bullets */
.show-actions ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.show-actions ul li a {
    display: block;
    padding: 8px 12px;
    text-decoration: none;
    color: #333;
}

.show-actions ul li a:hover {
    background: #f7f7f7;
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
<div class="content">
    <div class="container">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <h1 class="pull-left page-title">Manage Tutor Application Forms</h1>
                <ol class="breadcrumb pull-right"></ol>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading rm02 rm04">

                        {{-- 🔍 Search Filters --}}
                        <form method="get" action="{{ route('tutor.management.list.tab') }}">
                            <div data-column="1" class="form-group">
                                <label for="col1_filter">Name / Email / Phone / Form ID</label>
                                <input type="text" id="col1_filter" name="col1_filter"
                                    class="form-control reset_val" placeholder="Name / Email / Phone / Form ID"
                                    autocomplete="off" readonly
                                    onfocus="this.removeAttribute('readonly');"
                                    onclick="this.removeAttribute('readonly');"
                                    onblur="this.removeAttribute('readonly');">
                            </div>

                            <div data-column="2" class="form-group">
                                <label for="col2_filter">State</label>
                                <select id="col2_filter" name="col2_filter" class="form-control reset_val">
                                    <option value="">Select State</option>
                                    <option value="1">New South Wales</option>
                                    <option value="2">Victoria</option>
                                    <option value="3">Queensland</option>
                                    <option value="4">South Australia</option>
                                    <option value="5">Western Australia</option>
                                    <option value="6">Tasmania</option>
                                    <option value="7">Australian Capital Territory</option>
                                    <option value="8">Northern Territory</option>
                                </select>
                            </div>

                            <div data-column="3" class="form-group">
                                <label for="col3_filter">Status</label>
                                <select id="col3_filter" name="col3_filter" class="form-control reset_val">
                                    <option value="">Select Status</option>
                                    <option value="3">Submitted</option>
                                    <option value="4">Pending</option>
                                    <option value="1">Accepted</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>

                            <div data-column="4" class="form-group">
                                <label for="col4_filter">Search From Date</label>
                                <div class="ui calendar" id="from_date">
                                    <div class="ui input left icon">
                                        <input type="text" id="col4_filter" name="col4_filter"
                                            class="form-control" placeholder="Date apply from"
                                            autocomplete="off" readonly
                                            onfocus="this.removeAttribute('readonly');"
                                            onclick="this.removeAttribute('readonly');"
                                            onblur="this.removeAttribute('readonly');">
                                        <span class="over_llp1">
                                            <img src="{{ public_asset('admin/assets/images/cal.png') }}" alt="">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div data-column="5" class="form-group">
                                <label for="col5_filter">Search To Date</label>
                                <div class="ui calendar" id="to_date">
                                    <div class="ui input left icon">
                                        <input type="text" id="col5_filter" name="col5_filter"
                                            class="form-control" placeholder="Date apply to"
                                            autocomplete="off" readonly
                                            onfocus="this.removeAttribute('readonly');"
                                            onclick="this.removeAttribute('readonly');"
                                            onblur="this.removeAttribute('readonly');">
                                        <span class="over_llp1">
                                            <img src="{{ public_asset('admin/assets/images/cal.png') }}" alt="">
                                        </span>
                                    </div>
                                </div>
                            </div>
<div data-column="6" class="form-group">
    <label for="col6_filter">Subscribed</label>
    <select id="col6_filter" name="col6_filter" class="form-control reset_val">
        <option value="">Select</option>
        <option value="Y">Yes</option>
        <option value="N">No</option>
    </select>
</div>
                            <div class="centerButtons">
                                <div class="rm05">
                                    <button class="btn btn-primary search_click" type="button">Search</button>
                                </div>
                                <div class="rm05">
                                    <button class="btn btn-secondary reset_search" type="button">Reset</button>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="rm05 rightButtons">
    <button class="btn btn-primary waves-effect waves-light w-md download" type="submit" formaction="{{ route('admin_tutor_application_form_list_export') }}">
        Download
    </button>
</div>
                        </form>
                        
                    </div>

                    {{-- 📋 DataTable --}}
                    <div class="panel-body">
                        @include('admin.includes.message')

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="example">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>State</th>
                                        <th>Subscribed</th>
                                        <th>Applied On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

{{-- 🔁 Reopen Modal --}}
<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="reOpenTAFModel">
    <div class="modal-dialog modal-dialog-centered instructionModal">
        <div class="modal-content instructionModal">
            <div class="modal-header instructionModal">
                <h4 class="modal-title passText">Confirmation</h4>
                <button type="button" class="close" onclick="ClosePopupModel(this)" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body instructionModal noinsBodyDev">
                <p>Are you sure you want to re-open this application?</p>
                <input type="hidden" id="taf_id" name="taf_id" value="">
            </div>
            <div class="modal-footer adm_modal_Footer">
                <button type="button" class="btn btn-danger" id="yes_reopen"
                    onclick="yesReopenModal(this)">Yes</button>
                <button type="button" class="btn btn-secondary" onclick="ClosePopupModel(this)">No</button>
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
<script src="{{ public_asset('assets/js/chosen.jquery.js') }}"></script>
<script src="{{ public_asset('assets/js/init.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {

    // 🗓 Date Pickers
    $("#from_date, #to_date").calendar({
        type: 'date',
        formatter: {
            date: function(date) {
                if (!date) return '';
                const d = ('0' + date.getDate()).slice(-2);
                const m = ('0' + (date.getMonth() + 1)).slice(-2);
                const y = date.getFullYear();
                return `${y}-${m}-${d}`;
            }
        }
    });

    // 📊 DataTable Setup
    const table = $('#example').DataTable({
        processing: true,
        serverSide: true,
        serverMethod: 'post',
       ajax: {
    url: "{{ route('admin_tutor_application_form_get_list') }}",
    type: "POST",
    data: function(d) {
        d._token = "{{ csrf_token() }}";
        d.filters = {
            name_email_phone: $('#col1_filter').val(),
            state: $('#col2_filter').val(),
            status: $('#col3_filter').val(),
            date_from: $('#col4_filter').val(),
            date_to: $('#col5_filter').val(),
            subscription: $('#col6_filter').val() // ✅ Added
        };
    },
    dataSrc: res => res.aaData
},
        order: [[6, "desc"]],
        columns: [
            { data: "taf_id", defaultContent: "-" },
            { 
                data: null, 
                render: row => [row.first_name, row.middle_name, row.last_name].filter(Boolean).join(' ') || "-" 
            },
            { data: "primary_email", defaultContent: "-" },
            { data: "primary_phone", defaultContent: "-" },
            { data: "state", defaultContent: "N/A" },
            {
    data: "subscription",
    render: function(data) {
        if (data === "Yes") {
            return '<span class="green_color">Yes</span>';
        } else if (data === "No") {
            return '<span class="red_color">No</span>';
        } else {
            return "N/A";
        }
    }
},

            {
                data: "created_at",
                render: function(date) {
                    if (!date) return "-";
                    const d = new Date(date);
                    return `${('0'+d.getDate()).slice(-2)}-${('0'+(d.getMonth()+1)).slice(-2)}-${d.getFullYear()}`;
                }
            },
            {
                data: "status",
                render: function(status) {
                    const map = {
                        1: '<span class="green_color">Accepted</span>',
                        2: '<span class="red_color">Rejected</span>',
                        3: '<span class="blue_color">Submitted</span>',
                        4: '<span class="orange_color">Pending</span>'
                    };
                    return map[status] ?? "N/A";
                }
            },
            {
    data: "id",
    render: function(id, type, full) {
        let html = `
            <a href="javascript:void(0);" class="action-dots action" data-key="${id}">
                <img src="{{ public_asset('admin/assets/images/action-dots.png') }}" alt="">
            </a>
            <div class="show-actions" id="show-action${id}" style="display:none;">
                <span class="angle">
                    <img src="{{ public_asset('admin/assets/images/angle.png') }}" alt="">
                </span>
                <ul>
                    <li><a href="{{ url('admin/tutor-application-form-view') }}/${id}">View</a></li>`;
        if (full.status == 2 || full.status == 3) {
            html += `<li><a href="javascript:void(0);" data-id="${id}" class="reopen_taf">Re-open</a></li>`;
        }
        html += `</ul></div>`;
        return html;
    }
}
        ]
    });

    // 🔍 Search
    $('.search_click').on('click', function() {
        table.ajax.reload();
    });

    // 🔄 Reset
    $('.reset_search').on('click', function() {
        $('.reset_val').val('');
        table.ajax.reload();
    });

    // ⚙️ Toggle actions
    $(document).on('click', '.action', function() {
        const id = $(this).data('key');
        $(`#show-action${id}`).slideToggle();
    });

    // 📅 Validate dates
    $('#col4_filter, #col5_filter').on('blur', function() {
        const from = $('#col4_filter').val();
        const to = $('#col5_filter').val();
        if (from && to && Date.parse(from) > Date.parse(to)) {
            toastr.warning("To Date cannot be before From Date");
            $('#col4_filter, #col5_filter').val('');
        }
    });

    // 🔁 Reopen modal
    $(document).on('click', '.reopen_taf', function() {
        $('#taf_id').val($(this).data('id'));
        $('#reOpenTAFModel').modal('show');
    });

    // ✅ Confirm reopen
    window.yesReopenModal = function(btn) {
        const id = $('#taf_id').val();
        $.ajax({
            url: "{{ route('admin_tutor_application_form_re_open') }}",
            type: 'POST',
            data: { _token: "{{ csrf_token() }}", id },
            success: function(resp) {
                if (resp == 1) {
                    table.ajax.reload(null, false);
                    $(btn).closest('.modal').modal('hide');
                    toastr.success("Application reopened successfully!");
                } else {
                    toastr.error("Failed to reopen application.");
                }
            },
            error: function() {
                toastr.error("Error reopening application.");
            }
        });
    };

    // ❌ Close modal
    window.ClosePopupModel = function(btn) {
        $(btn).closest('.modal').modal('hide');
    };

});
</script>
@endsection
