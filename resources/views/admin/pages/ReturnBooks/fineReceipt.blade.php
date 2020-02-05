<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ใบเสร็จค่าปรับ</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Kanit:200,300,300i,400,500,600&display=swap');
        @page { size: auto;  margin: 0mm; }
        .container {
            padding:1.7rem;
        }
        @media screen {
            .container { display: none; }
            .container.show { display: block; }
        }
        @media print {
            .container { display: block !important; }
        }
        html,body{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
       body {
        font-family: 'Kanit', sans-serif;
       }
        .container {
            padding: 1.7rem 2.5rem;
        }
        .header {
            display: grid;
            grid-template-columns: 1fr 120px;
            padding-bottom: 30px;
        }
        .header-brand {
        }
        .header-brand p {
            font-size: 18px;
            font-weight: 500;
        }
        .header-brand span {
            font-size: 14px;
            font-weight: 300;
        }
        .header-date span {
            font-size: 14px;
        }
        .header-date {
            
        }
        .header-date p {
            font-size: 18px;
            font-weight: 500;
        }
        .student {
            padding: 15px 0px;
            display: grid;
            grid-template-columns: repeat(2,1fr);
            border-top: 1px dashed black;
            border-bottom: 1px dashed black;
        }
        .student span {
            margin-bottom: 10px !important;
        }
        .student-title {
            font-size: 14px; font-weight: 500;
            margin-right: 5px;
            margin-left: 5px;
        }
        .student-list-group {
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .student-list-group-item {
            padding: 3px 0px;
        }
        .student-content {
            margin-left: 5px;
            padding-left: 10px;
            font-size: 14px;
            font-weight: 300;
            width: 100% !important;
            border-width: thin;
            border-bottom: 1px dashed  #000;
        }
        .student-list {
            list-style: none;
        }
        .student-list .student-list-items {
            text-align: center;
            padding: 3px 0px;
        }
        .main {
            background-color: violet;
            margin: 15px 0px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, td ,th {
            border: 1px solid gray;
        }
        table th {
            padding: 15px 0px;
            font-size: 14px;
            font-weight: 500;
        }
        table tbody {
            text-align: center;
        }
        table td {
            padding: 5px 0px;
            font-size: 14px;
            font-weight: 300;
        }
        .fineTotal {
            margin: 30px 0px;
            text-align: right;
        }
        .totle-title {
            font-size: 14px;
            font-weight: 500;
            margin-right: 5px;
        }.totle-price {
            font-size: 14px;
            font-weight: 300;
            margin-left: 5px;
        }.bath {
            margin-left: 5px;
            font-size: 14px;
            font-weight: 500;
        }.verify-oneself {
            display: grid;
            grid-template-columns: repeat(2,1fr);
            margin-top: 100px;
        }.admin-oneself {
            text-align: right;
        }.admin-attribute {
            font-size: 14px;
            font-weight: 400;
        }.admin-cen {
            font-weight: 400;
            margin-right: 17px;
        }
        .student-attribute {
            font-size: 14px;
            font-weight: 400;
        }.student-cen {
            font-weight: 400;
            margin-left: 8px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <div class="header-brand">
                <p>ระบบยืมคืนหนังสือโครงงาน</p>
                <span>สาขา {{$data->major}}</span><br>
                <span>มหาวิทยาลัยราชภัฎอุดรธานี</span><br>
            </div>
            <div class="header-date">
                <p>ใบเสร็จค่าปรับ</p>
                <span><strong>เลขที่</strong> : {{ rand(100000, 1000000) }}</span><br>
                <span><strong>วันที่</strong> :  {{ date('d-m-Y') }}</span><br>
            </div>
        </div>
        <div class="student">
            <div class="student-detailes1">
                <ul class="student-list-group">
                    <li class="student-list-group-item"><strong class="student-title">รหัสนักศึกษา</strong>:<span class="student-content">{{$data->std_id}}</span></li>
                    <li class="student-list-group-item"><strong class="student-title">สาขา</strong>:<span class="student-content">{{$data->major}}</span></li>
                    <li class="student-list-group-item"><strong class="student-title">อีเมลล์</strong>:<span class="student-content">{{$data->email}}</span></li>
                </ul>
            </div>
            <div class="student-detailes2">
                <ul class="student-list-group">
                    <li class="student-list-group-item"><strong class="student-title">ชื่อนักศึกษา</strong>:<span class="student-content">{{$data->std_name}}</span></li>
                    <li class="student-list-group-item"><strong class="student-title">เบอร์โทร</strong>:<span class="student-content">{{$data->tel}}</span></li>
                </ul>
            </div>
            {{-- <ul class="student-list">
                <li class="student-list-items">
                    <span class="student-title">รหัสนักศึกษา</span>:<span class="student-content">name-detailes here write now</span>
                    <span class="student-title">ชื่อนักศึกษา</span>:<span class="student-content">name-detailes here write now</span>
                </li>
                <li class="student-list-items">
                    <span class="student-title">สาขา</span>:<span class="student-content">name-detailes here write now</span>
                </li>
                <li class="student-list-items">
                    <span class="student-title">อีเมลล์</span>:<span class="student-content">name-detailes here write now</span>
                    <span class="student-title">เบอร์โทร</span>:<span class="student-content">name-detailes here write now</span>
                </li>
            </ul> --}}
        </div>
        <div class="main">
            <table>
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>รหัสหนังสือ</th>
                        <th>ชื่อหนังสือ</th>
                        <th>วันที่ยืม</th>
                        <th>กำหนดคืน</th>
                        <th>วันที่คืน</th>
                        <th>ค่าปรับ</th>
                    </tr>
                </thead>
                <tbody>                
                    <tr>
                        <td>1</td>
                        <td>{{$data->b_id}}</td>
                        <td>{{$data->p_name}}</td>
                        <td>{{date('d-m-Y',strtotime($data->br_date))}}</td>
                        <td>{{date('d-m-Y',strtotime($data->due_date))}}</td>
                        <td>{{date('d-m-Y')}}</td>
                        <td>{{ abs( ((strtotime(date('Y-m-d')) - strtotime($data->due_date))/(60*60*24))*5) }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="fineTotal">
                <div class="totle">
                    <span class="totle-title">ยอดรวมทั้งหมด</span>:<span class="totle-price">{{ abs( ((strtotime(date('Y-m-d')) - strtotime($data->due_date))/(60*60*24))*5) }}</span><span class="bath">บาท</span>
                </div>
            </div>
        </div>
        <div class="verify-oneself">
            <div class="student-oneself">
                <span class="student-attribute">ลงชื่อ -------------------------- ผู้ยืม</span><br>
                <span class="student-cen">( -------------------------- )</span>
            </div>
            <div class="admin-oneself">
                <span class="admin-attribute">ลงชื่อ -------------------------- ผู้รับรอง</span><br>
                <span class="admin-cen">( -------------------------- )</span>
            </div>
        </div>
    </div>


    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script>
        $(document).ready(()=>{
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            window.onload = function () {

                let id = "{{$data->br_id}}";
                let token = "{{ csrf_token() }}";

                window.print();
                setTimeout(function(){

                    $.ajax({
                        type: "post",
                        url: "/returns/receipt",
                        data: {id:id,_token:token},
                        dataType: "json",
                        success: function (response) {
                            window.location.href="/returns";
                        }
                    });
                    
                }, 1);
            }
        });
    </script>
</body>
</html>