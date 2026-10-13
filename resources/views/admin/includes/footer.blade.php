<footer class="footer text-right">
    Copyright &copy; {{ date('Y') }} <a href="{{ route('admin_dashboard') }}">V-Tutor</a>  All rights reserved. 
</footer>
<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="instructionModal">
     <div class="modal-dialog modal-dialog-centered instructionModal">
      <div class="modal-content instructionModal">
        <!-- Modal Header -->
        <div class="modal-header instructionModal">
          <h2 class="modal-title passText">Password Confirmation</h2>
        </div>
        <!-- Modal body -->
        <div class="modal-body instructionModal noinsBodyDev">
          
            <div class="divs">
                <div class="appome_input form_box_area cls1 ">
                    <input type="hidden" name="tName" value="" id="tName">
                    <input type="hidden" name="tFrmId" value="" id="tFrmId">
                    <input type="hidden" name="tId" value="" id="tId">
                    <input type="hidden" name="ajax_url" value="" id="ajax_url">
                    <input type="hidden" name="ajax_data_id" value="" id="ajax_data_id">
                    <input type="hidden" name="type_popup_next" value="" id="type_popup_next">
                    <input type="hidden" name="data_table_data_s" value="" id="data_table_data_s">
                    <div class="appome_input form_box_area cls2">
                        <label> Confirm Password </label>
                        <input type="password" id="verify_password" class="form-control required"  placeholder="Enter Admin Password">
                        <span class="error error_verify_password"></span>
                    </div>
                    <div class="next-btn1">
                        <button type="button" class="btn btn-new btn-danger" id="next" style="color: #b80f0a;">Submit</button>
                    </div>
                </div>
            </div>
          
        </div>
      </div>
</div>

<div class="modal res-modal newqusmo instructionModal adminpasswordPopup" id="admConfirmModal">
     <div class="modal-dialog modal-dialog-centered instructionModal">
      <div class="modal-content instructionModal">
        <!-- Modal Header -->
        <div class="modal-header instructionModal">
          <h4 class="modal-title passText">Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal" onclick="admCloseModel()">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body instructionModal noinsBodyDev">
          
            <div class="divs">
                <div class="appome_input form_box_area cls1 ">
                    <div>
                        <p class="gj_adm_popup_text"></p>
                    </div>
                </div>
            </div>
          
        </div>

        <div class="modal-footer adm_modal_Footer">
            <button type="button" class="btn btn-new btn-danger" id="c_yes" style="color: #b80f0a;" onclick="proceedConfirm()">Yes</button>
            <button type="button" data-bs-dismiss="modal" class="btn btn-new btn-danger" id="c_no" style="color: #b80f0a;" onclick="admCloseModel()">No</button>
        </div>
      </div>
</div>