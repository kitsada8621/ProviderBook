<!-- Modal Create and Edit -->
<div class="modal fade" id="modalIns" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title Ins-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form id="formIns">
                <div class="modal-body">
                    @csrf
                    <div class="container-fluid">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="std_id">รหัสนักศึกษา</label>
                                    <input id="std_id" class="form-control" type="text" name="std_id">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="std_name">ชื่อ-สกุล</label>
                                    <input id="std_name" class="form-control" type="text" name="std_name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="major">สาขา</label>
                                    <select id="major" class="form-control" name="major">
                                        <option value="">เลือกสาขา</option>
                                        @foreach ($major as $row)
                                            <option value="{{$row->name}}">{{$row->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="email">อีเมลล์</label>
                                    <input id="email" class="form-control" type="text" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label for="tel">เบอร์โทร</label>
                                    <input id="tel" class="form-control" type="text" name="tel">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="password">รหัสผ่าน</label>
                                    <input id="password" class="form-control" type="password" name="password">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="image-profile">
                                    <div class="image-details"></div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmpassword">ยืนยัน รหัสผ่าน</label>
                                    <input id="confirmpassword" class="form-control" type="password" name="confirmpassword">
                                </div>
                            </div>
                        </div>
                        <style>
                            input[type=file] {
                                background-color: #fff;
                                border-color: #fff;
                                box-shadow: none;
                            }
                        </style>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="example-profile">
                                    <div class="img-profile"></div>
                                </div>
                                <div class="form-group">
                                    <label for="image">รูปประจำตัว</label>
                                    <input id="image" class="form-control-file" type="file" name="image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-Ins-name"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal delete -->
<div class="modal fade" id="modalDel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ลบข้อมูล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <form id="formDels">
            <div class="modal-body">
                @csrf
                <input type="hidden" name="des_id" id="des_id" readonly>
                <div class="text-center">
                    <span>ต้องการลบข้อมูลใช่หรือไม่ ?.</span>
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


<!-- Modal details -->
<div class="modal fade" id="modaldetails" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียด</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <ul class="list-group mb-3">
                    <li class="list-group-item">
                        <div class="container-fluid text-center mb-2 mt-3">
                            <h5 style="font-size:13px;font-weight:500;" class="mb-2">รูปประจำตัว</h5>
                            <div class="myprofile"></div>
                        </div>
                        
                    </li>
                    <li class="list-group-item">
                        <span class="detail-title">รหัสนักศึกษา</span>:<span class="std-id detail-content"></span>
                    </li>
                    <li class="list-group-item">
                        <span class="detail-title">ชื่อนักศึกษา</span>:<span class="std-name detail-content"></span>
                    </li>
                    <li class="list-group-item">
                        <span class="detail-title">สาขา</span>:<span class="std-major detail-content"></span>
                    </li>
                    <li class="list-group-item">
                        <span class="detail-title">อีเมลล์</span>:<span class="std-email detail-content"></span>
                    </li>
                    <li class="list-group-item">
                        <span class="detail-title">เบอร์โทร</span>:<span class="std-tel detail-content"></span>
                    </li>            
                </ul>
            </div>
        </div>
    </div>
</div>