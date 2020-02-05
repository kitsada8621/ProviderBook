<!-- Modal Borrowing  -->
<div class="modal fade" id="modalBorrowing" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title borrow-title">ยืมหนังสือโครงงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form id="formBorrow">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="b_id" id="b_id" readonly>
                    <div class="err-message" style="display:none;">
                        <div class="d-flex justify-content-between align-items-center">
                        <span style="font-size:14px; font-weight:300;" class="err-message-detail"></span>
                        <a href="#" class="err-close" style="font-size:10px;"><i class="fas fa-times"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="std_id">รหัสนักศึกษา</label>
                                <input id="std_id" class="form-control" type="text" name="std_id" readonly value="{{Auth::guard('students')->user()->std_id}}">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="std_name">ชื่อนักศึกษา</label>
                                <input id="std_name" class="form-control" type="text" name="std_name" readonly value="{{Auth::guard('students')->user()->std_name}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="br_date">วันที่ยื่นคำร้อง</label>
                                <input id="br_date" class="form-control" type="date" name="br_date" readonly value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="due_date">กำหนดคืน</label>
                                <input id="due_date" class="form-control" min="{{date('Y-m-d')}}" type="date" name="due_date">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-borrow">ยืนยัน</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Details -->
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ข้อมูลหนังสือ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body p-0">
                <ul class="list-group">
                    <li class="list-group-item border-0">รหัสหนังสือ&nbsp;:&nbsp;<span class="b-id"></span></li>
                    <li class="list-group-item border-0">ชื่อหนังสือ&nbsp;:&nbsp;<span class="p-name"></span></li>
                    <li class="list-group-item border-0">ประเภทหนังสือ&nbsp;:&nbsp;<span class="type"></span></li>
                    <li class="list-group-item border-0">ประเภทโครงงาน&nbsp;:&nbsp;<span class="category"></span></li>
                    <li class="list-group-item border-0">สถานะหนังสือ&nbsp;:&nbsp;<span class="status"></span></li>
                    <li class="list-group-item border-0">
                        <div class="text-center">
                            <h5 class="description-title">รายละเอียดโครงงาน (โดยย่อ)</h5>
                        </div>
                        <p class="description-text"></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>