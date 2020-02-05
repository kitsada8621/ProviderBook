
<!-- Modal Inserting -->
<div class="modal fade" id="modalIns" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title ins-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form id="formIns">
                <div class="modal-body">
                    @csrf
                    <div class="container">
                        <input type="hidden" name="t_id" id="t_id" readonly>
                        <div class="form-group">
                            <label for="t_name">ชื่อ-สกุล</label>
                            <input id="t_name" class="form-control" type="text" name="t_name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-ins-name"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ลบข้อมูล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="delid" id="delid">
                <div class="text-center">
                    <p>ต้องการลบข้อมูล ใช่หรือไม่ ?.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-danger yes-delete">ลบข้อมูล</button>
            </div>
        </div>
    </div>
</div>