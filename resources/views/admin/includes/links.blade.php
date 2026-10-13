<style type="text/css">

.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
  color:#fff !important;
}
</style>

<link href="{{ public_asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ public_asset('admin/assets/css/semantic.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ public_asset('admin/assets/css/core.css') }}" rel="stylesheet" type="text/css">
<link href="{{ public_asset('admin/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
<link href="{{ public_asset('admin/assets/css/responsive.css') }}" rel="stylesheet" type="text/css">
<script src="https://kit.fontawesome.com/446e463225.js" crossorigin="anonymous"></script>
<link href="{{ public_asset('admin/assets/toastr/build/toastr.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style type="text/css">
.buttons-excel{
    display: none;
}
.rightButtons{
    text-align: right !important;
    width: 100% !important;
}
.modal .modal-dialog .modal-content {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    width: 100% !important;
    pointer-events: auto;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 0.3rem;
    outline: 0;
    padding: 0px !important;
}
.modal .modal-dialog .modal-content .modal-header {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: start;
    -ms-flex-align: start;
    align-items: flex-start;
    -webkit-box-pack: justify;
    -ms-flex-pack: justify;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
    border-top-left-radius: 0.3rem;
    border-top-right-radius: 0.3rem;
}
.modal .modal-dialog .modal-content .modal-header .modal-title {
    position: relative;
}
.modal .modal-dialog .modal-content .modal-header .modal-title::after {
    position: absolute;
    content: "";
    width: 48px;
    height: 4px;
    background: #b80f0a;
    z-index: 9999;
    bottom: -14px;
    left: 0;
}
.modal .modal-dialog .modal-content .modal-header .close {
    padding: 5px;
    font-size: 25px;
    color: black;
    text-shadow: 0 1px 0 #fff;
    opacity: 0.5;
}
.modal .modal-dialog .modal-content .modal-body {
    background: #F3F5F9;
    border-radius: 10px;
    padding: 10px;
}
.modal .modal-dialog .modal-content .modal-body p {
    display: inline-block;
    padding: 8px 17px;
    background: #b8110b0f;
    color: #b8110b;
    border-radius: 6px;
    border: 1px solid #b8110b;
    margin: 30px 0;
    width: 100%;
    line-height: 20px;
}
.modal .modal-dialog .modal-content .modal-footer {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: end;
    -ms-flex-pack: end;
    justify-content: flex-end;
    padding: 1rem;
    border-top: 1px solid #e9ecef;
}
.modal .modal-dialog .modal-content .modal-footer button {
    background: rgba(184, 17, 11, 1) !important;
    border-color: rgba(184, 17, 11, 1);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b8110b', endColorstr='#9c0705', GradientType=0);
    height: 47px;
    border-radius: 6px;
    letter-spacing: 0.5px;
    color: #ffffff;
    margin-bottom: 10px;
    text-transform: capitalize !important;
}
</style>
