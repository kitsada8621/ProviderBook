<!-- Modal Add And Edit -->
<div class="modal fade" id="modalIns" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-ins-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form id="formIns">
                <div class="modal-body">
                    <div class="container-fluid">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group form-b_id">
                                    <label for="b_id">รหัสหนังสือ</label>
                                    <input id="b_id" class="form-control" type="text" name="b_id">
                                </div>    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="p_id">รหัสโครงงาน</label>
                                    <input id="p_id" class="form-control" type="text" name="p_id">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="p_name">ชื่อโครงงาน</label>
                                    <input id="p_name" class="form-control" type="text" name="p_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="type">ประเภทหนังสือ</label>
                                    <select id="type" class="form-control" name="type">
                                        <option value="">เลือกประเภทหนังสือ</option>
                                        @foreach ($type as $row)
                                            <option>{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>  
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


<!-- Modal Delete -->
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
                <div class="text-center">
                    <input type="hidden" name="delid" id="delid" readonly>
                    <span>ต้องการลบข้อมูล ใช่หรือไม่ ?.</span>
                </div>                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-danger submit-delete">ลบข้อมูล</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดหนังสือ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <ul class="list-group">
                    <li class="list-group-item list-styles"><strong class="detail-title">รหัสหนังสือ</strong>:<span class="detail-content b-id"></span></li>
                    <li class="list-group-item list-styles"><strong class="detail-title">ชื่อโครงงาน</strong>:<span class="detail-content p-name"></span></li>
                    <li class="list-group-item list-styles"><strong class="detail-title">ประเภทหนังสือ</strong>:<span class="detail-content category"></span></li>
                    <li class="list-group-item list-styles"><strong class="detail-title">ประเภทโครงงาน</strong>:<span class="detail-content type"></span></li>
                    <li class="list-group-item list-styles"><strong class="detail-title">วันที่จัดทำ</strong>:<span class="detail-content create-date"></span></li>
                    <li class="list-group-item list-styles"><strong class="detail-title">ที่ปรึกษา</strong>:<span class="detail-content adviser"></span></li>
                    <li class="list-group-item list-styles"><strong class="detail-title">ผู้จัดทำ</strong>:<span class="detail-content creator"></span></li>
                    <li class="list-group-item">
                        <div class="container-fluid mb-4">
                            <div class="text-center" style="margin: 5px 0px;">
                                <h5 style="font-size:13px;font-weight:500;">รายละเอียด (โดยย่อ)</h5>
                            </div>
                            <p class="description"  style="text-indent: 2.0rem;font-size:13px; font-weight:300;"></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>