<!-- Modal Book Returning confirm -->
<div class="modal fade" id="modalReturn" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title return-title">ยืนยันการคืนหนังสือ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form id="formReturn">
                <div class="modal-body p-0">
                    @csrf
                    <div class="">
                        <input type="hidden" name="id" id="id" readonly>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">ผู้ยืม : <span class="student-name"></span></li>
                            <li class="list-group-item">ชื่อหนังสือ : <span class="book-name"></span></li>
                            <li class="list-group-item">วันที่ยืม : <span class="borrow-date"></span></li>
                            <li class="list-group-item">กำหนดคืน : <span class="due-date"></span></li>
                            <li class="list-group-item">ค่าปรับ : <span class="borrow-fine"></span></li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light closed" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary confirm">ยืนยัน</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Fine -->
<div class="modal fade" id="modalFine" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fine-title"></h5>
                    <button type="button" class="close" id="og_close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <button type="button" class="close" id="fine_close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid text-center">
                    <input type="hidden" name="fineid" id="fineid" readonly class="form-control">
                    <strong class="small  fine-message" style="font-size:14px; font-weight:400;"></strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" id="confirm_close" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-success" id="confirm_fine">ยืนยัน</button>
                <button type="button" class="btn btn-light" id="print_close">ไม่พิมพ์</button>
                <button type="button" class="btn btn-info" id="print_confirm">พิมพ์ใบเสร็จ</button>
            </div>
        </div>
    </div>
</div>