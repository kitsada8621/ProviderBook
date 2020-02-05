<!-- Modal Insert and Update-->
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
                @csrf
                <div class="modal-body">
                    <div class="container-fluid">
                        <input type="hidden" name="id" id="id" readonly>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="name">ชื่อ-สกุล</label>
                                    <input id="name" name="name" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="email">อีเมลล์</label>
                                    <input id="email" class="form-control" type="email" name="email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="position">ตำแหน่ง</label>
                                    <select id="position" class="form-control" name="position">
                                        <option value="">เลือกตำแหน่ง</option>
                                        <option value="1">Manager</option>
                                        <option value="2">Admin</option>
                                    </select>
                                </div>
                            </div>                  
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="username">ชื่อผู้ใช้</label>
                                    <input id="username" class="form-control" type="text" name="username">
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
                                <div class="form-group">
                                    <label for="conformpassword">ยืนยัน รหัสผ่าน</label>
                                    <input id="conformpassword" class="form-control" type="password" name="conformpassword">
                                </div>
                            </div>
                        </div>
                        <style>
                            input[type=file] {
                                color: #71748d;
                                background-color: #fff !important;
                                border-color: #fff;
                                outline: 0;
                                box-shadow: none;
                            }
                        </style>
                        <div class="row">
                            <div class="col-12">
                                <div class="text-left mb-2 poin-profile">
                                    <div class="img-profile"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">รูปประจำตัว</label>
                                  <input type="file" class="form-control-file form-file" name="image" id="image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
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
                <h5 class="modal-title del-title">ลบข้อมูล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="delid" id="delid" readonly>
                <div class="text-center">
                    <p class="dels-message">ต้องการลบข้อมูล ใช่หรือไม่.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                <button type="button" data-token="{{ csrf_token() }}" class="btn btn-danger btn-dels">ลบข้อมูล</button>
            </div>
        </div>
    </div>
</div>