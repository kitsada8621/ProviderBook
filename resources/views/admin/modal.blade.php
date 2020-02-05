<!-- Modal Confirm Borrow Book Of Student -->
<div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title borrow-title">อนุมัติการยืม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id" readonly>
                <div class="text-center">
                    <p>อนุมัติการยืมหนังสือโครงงาน ใช่หรือไม่ ?.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-secondary no-confirm-borrow">ปฎิเสธ</button>
                <button type="button" class="btn btn-success yes-confirm-borrow">อนุมัติ</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modaldel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ลบข้อมูล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid text-center">
                    <input type="hidden" id="delid" readonly>
                    <p>ต้องการลบข้อมูล ใช่หรือไม่ ?.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-danger" id="btnRemoves">ลบข้อมูล</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal Details -->
<div class="modal fade" id="modaldetails" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <ul class="list-group">
                    <li class="list-group-item"><strong class="details-title">รหัสหนังสือ</strong>:<span class="details-content b-id"></span></li>
                    <li class="list-group-item"><strong class="details-title">ชื่อโครงงาน</strong>:<span class="details-content p-name"></span></li>
                    <li class="list-group-item"><strong class="details-title">ประเภทหนังสือ</strong>:<span class="details-content type"></span></li>
                    <li class="list-group-item"><strong class="details-title">ผู้ยืม</strong>:<span class="details-content std-name"></span></li>
                    <li class="list-group-item"><strong class="details-title">สาขา</strong>:<span class="details-content major"></span></li>
                    <li class="list-group-item"><strong class="details-title">วันที่ยืม</strong>:<span class="details-content br-date"></span></li>
                    <li class="list-group-item"><strong class="details-title">กำหนดคืน</strong>:<span class="details-content due-date"></span></li>
                    <li class="list-group-item"><strong class="details-title">ค่าปรับ</strong>:<span class="details-content fine"></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>