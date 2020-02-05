<!-- Modal  Inserting or editing -->
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
                    <input type="hidden" name="id" id="id" readonly>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="form-group">
                                <label for="p_name">ชื่อโครงงาน</label>
                                <input id="p_name" class="form-control" type="text" name="p_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="category">ประเภทโครงงาน</label>
                                <select id="category" class="form-control" name="category">
                                    <option value="">เลือกข้อมูล</option>
                                    @foreach ($type as $row)
                                        <option>{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="createdate">วันที่จัดทำ</label>
                                <input id="createdate" class="form-control" type="date" name="createdate" max="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="t_id">รหัสอาจารย์</label>
                                <input id="t_id" class="form-control" type="text" name="t_id">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="t_name">ชื่ออาจารย์</label>
                                <input id="t_name" class="form-control" type="text" name="t_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="std_id">รหัสนักศึกษา</label>
                                <input id="std_id" class="form-control" type="text" name="std_id" value="{{ Auth::guard('students')->user()->std_id }}">
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
                            <div class="form-group">
                                <label for="std_name">ชื่อนักศึกษา</label>
                                <input id="std_name" class="form-control" type="text" name="std_name" value="{{ Auth::guard('students')->user()->std_name }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="form-group">
                                <label for="description">รายละเอียดโครงงาน (โดยย่อ)</label>
                                <textarea id="description" class="form-control" name="description" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">ยกเลิก</button>
                    <button type="submit" class="btn btn-primary btn-ins-name">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal detail -->
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รายละเอียดโครงงาน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body p-0 border-bottom-0">
                <ul class="list-group">
                    <li class="list-group-item li-odd border-0">รหัสโครงงาน&nbsp;:&nbsp;<span class="p-id"></span></li>
                    <li class="list-group-item li-odd border-0">ชื่อโครงงาน&nbsp;:&nbsp;<span class="p-name"></span></li>
                    <li class="list-group-item li-odd border-0">ประเภทโครงงาน&nbsp;:&nbsp;<span class="p-type"></span></li>
                    <li class="list-group-item li-odd border-0">วันที่จัดทำ&nbsp;:&nbsp;<span class="p-date"></span></li>
                    <li class="list-group-item li-odd border-0">ผู้จัดทำ&nbsp;:&nbsp;<span class="std-name"></span></li>
                    <li class="list-group-item li-odd border-0">สาขา&nbsp;:&nbsp;<span class="std-major"></span></li>
                    <li class="list-group-item li-odd border-0">ที่ปรึกษา&nbsp;:&nbsp;<span class="t-name"></span></li>
                    <li class="list-group-item border-0">
                        <div class="text-center">
                            <h5 class="description-title">รายละเอียด (โดยย่อ)</h5>
                        </div>
                        <p class="text-description"></p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>