<!-- Modal  Insert and Edit-->
<div class="modal fade" id="modalIns" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                    <div class="container-fluid">
                        <div class="row">
                            <input type="hidden" name="id" id="id" readonly>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="p_name">ชื่อโครงงาน</label>
                                    <input id="p_name" class="form-control" type="text" name="p_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="category">ประเภทโครงงาน</label>
                                    <select id="category" class="form-control" name="category">
                                        <option value="">เลือกประเภท</option>
                                        @foreach ($type as $row)
                                            <option>{{$row->name}}</option>
                                        @endforeach
                                        {{-- <option>Mobile Application</option>
                                        <option>Web Application</option>
                                        <option>Database Application</option>
                                        <option>อื่นๆ</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="t_id">รหัสอาจารย์(ที่ปรึกษา)</label>
                                    <input id="t_id" class="form-control" type="text" name="t_id">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="adviser">ชื่ออาจารย์(ที่ปรึกษา)</label>
                                    <input id="adviser" class="form-control" type="text" name="adviser">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="std_id">รหัสผู้จัดทำ(นักศึกษา)</label>
                                    <input id="std_id" class="form-control" type="text" name="std_id">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="creator">ชื่อผู้จัดทำ(นักศึกษา)</label>
                                    <input id="creator" class="form-control" type="text" name="creator">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="createdate">วันที่จัดทำ</label>
                                    <input id="createdate" class="form-control" type="date" name="createdate">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="description">รายละเอียดโครงงาน</label>
                                    <textarea id="description" class="form-control" name="description" rows="3"></textarea>
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
            <form id="formDel">
                <div class="modal-body">
                    <div class="container text-center">
                        @csrf
                        <input type="hidden" name="iddel" id="iddel" readonly>
                        <span>ต้องการลบข้อมูล ใช่หรือไม่ ?</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-danger">ลบข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Details -->
<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
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
                    <li class="list-group-item list-items">
                        <strong class="detail-title">รหัสโครงงาน</strong>:<span class="detail-content p-id"></span>
                    </li>
                    <li class="list-group-item list-items">
                        <strong class="detail-title">ชื่อโครงงาน</strong>:<span class="detail-content p-name"></span>
                    </li>
                    <li class="list-group-item list-items">
                        <strong class="detail-title">ประเภทโครงงาน</strong>:<span class="detail-content category"></span>
                    </li>
                    <li class="list-group-item list-items">
                        <strong class="detail-title">ที่ปรึกษา</strong>:<span class="detail-content t-details"></span>
                    </li>
                    <li class="list-group-item list-items">
                        <strong class="detail-title">ผู้จัดทำ</strong>:<span class="detail-content std-details"></span>
                    </li>
                    <li class="list-group-item list-items">
                        <strong class="detail-title">วันที่จัดทำ</strong>:<span class="detail-content create-date"></span>
                    </li>
                    <li class="list-group-item">
                        <div class="container-fluid">
                            <div class="text-center mb-3 mt-2">
                                <strong style="font-size:13px; font-weight:500;">รายละเอียดโครงงาน</strong>
                            </div>
                            <p style="font-size:14px;font-weight:300;" class="description mb-3"></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>