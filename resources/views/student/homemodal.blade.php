<!-- Modal -->
<div class="modal fade" id="modalBorrow" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">แก้ไขข้อมูลการยืม</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form id="formBorrow">
                <div class="modal-body">
                    @csrf
                    <input type="text" id="br_id" name="br_id" readonly>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="b_id">รหัสโครงงาน</label>
                                <input id="b_id" class="form-control" type="text" name="b_id">
                                <span class="err_book"></span>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="p_name">ชื่อโครงงาน</label>
                                <input id="p_name" class="form-control" type="text" name="p_name">
                                <span class="err_book"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="form-group">
                                <label for="due_date">กำหนดคืนหนังสือ</label>
                                <input id="due_date" class="form-control" type="date" name="due_date" min="{{date('Y-m-d')}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">อัพเดต</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal delete-->
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
                    <input type="text" id="delid" readonly>
                    <p style="font-size:14px;font-weight:300;">ต้องการลบข้อมูล ใช่หรือไม่ ?.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-danger btn-remove">ลบข้อมูล</button>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group .list-group-item {
        font-size: 14px;
        font-weight: 400;
    }
    .list-group-item:nth-of-type(odd) {
        background-color: rgba(230, 230, 242, .5);
        border: none;
    }
    .list-group-item span {
        font-size: 14px;
        font-weight: 300;
    }
</style>

<!-- Modal Details -->
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียด</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body p-0">
                <ul class="list-group">
                    <li class="list-group-item">รหัสหนังสือ&nbsp;:&nbsp;<span class="b-id"></span></li>
                    <li class="list-group-item">ชื่อหนังสือ&nbsp;:&nbsp;<span class="p-name"></span></li>
                    <li class="list-group-item">รหัสผู้ยืม&nbsp;:&nbsp;<span class="std-id"></span></li>
                    <li class="list-group-item">ชื่อผู้ยืม&nbsp;:&nbsp;<span class="std-name"></span></li>
                    <li class="list-group-item">สาขา&nbsp;:&nbsp;<span class="major"></span></li>
                    <li class="list-group-item">วันที่ยืม&nbsp;:&nbsp;<span class="br-date"></span></li>
                    <li class="list-group-item">กำหนดคืน&nbsp;:&nbsp;<span class="due-date"></span></li>
                    <li class="list-group-item">ค่าปรับ&nbsp;:&nbsp;<span class="fine"></span></li>
                    <li class="list-group-item">สถานะ&nbsp;:&nbsp;<span class="status"></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>