<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>พิมพ์บาร์โค้ด</title>
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
        html,body {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Kanit', sans-serif;
        }
        .container {
            padding: 30px 1.7rem;
        }.detail-header {
            padding: 0px 30px;
            text-align: center;
            align-items: center;
        }.detail-header .title {
            font-size: 25px;
            font-weight: 500;
        }.detail-body {
            padding: 0px 60px;
        }.detail-body table {
            width: 100%;
        }
        table tbody tr th {
            font-size: 15px;
            font-weight: 400;
            text-align: left;
            width: 20%;
        }
        table tbody tr td {
            font-size: 15px;
            font-weight: 300;
        }
        table tbody tr:nth-of-type(odd) {
            background-color: rgba(230, 230, 242, .5);
        }.description-details {
        }
        .description-details .description-header {
            text-align: center;
            margin-top: 60px;
        }
        .description-header .description-title {
            font-size: 16px;
            font-weight: 500;
        }.description-content {
            font-size: 14px;
            font-weight: 300;
            text-indent: 2.5rem;
        }.barcode-details {
            margin-top: 60px;
            text-align: center;
        }.barcode-details h5 {
            font-size: 18px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="detail-header">
            <h5 class="title">ข้อมูลหนังสือ</h5>
        </div>
        <div class="detail-body">
            <table>
                <tbody>
                    <tr>
                        <th>รหัสหนังสือ</th>
                        <td>{{$book->b_id}}</td>
                    </tr>
                    <tr>
                        <th>รหัสโครงงาน</th>
                        <td>{{$book->p_id}}</td>
                    </tr>
                    <tr>
                        <th>ชื่อโครงงาน</th>
                        <td>{{$book->p_name}}</td>
                    </tr>
                    <tr>
                        <th>ประเภทโครงงาน</th>
                        <td>{{$book->category}}</td>
                    </tr>
                    <tr>
                        <th>ประเภทหนังสือ</th>
                        <td>{{$book->type}}</td>
                    </tr>
                    <tr>
                        <th>ผู้จัดทำ</th>
                        <td>{{$book->std_id}}&nbsp;{{$book->std_name}}&nbsp;{{$book->major}}</td>
                    </tr>
                    <tr>
                        <th>ที่ปรึกษา</th>
                        <td>{{$book->t_name}}</td>
                    </tr>
                    <tr>
                        <th>วันที่จัดทำ</th>
                        <td>{{$book->createdate}}</td>
                    </tr>
                </tbody>
            </table>
            
            <div class="description-details">
                <div class="description-header">
                    <h5 class="description-title">รายละเอียดโครงงาน</h5>
                </div>
                <p class="description-content">{{$book->description}}</p>
            </div>

            <div class="barcode-details">
                <h5 class="barcode-title">บาร์โค้ดหนังสือ</h5>
                {!!DNS1D::getBarcodeSVG($book->b_id, "C39",2,70)!!}
            </div>

        </div>
    </div>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script>
        $(document).ready(()=>{
            window.onload = function () {
                window.print();
                setTimeout(function(){window.location.href="/book";}, 1);
            }
        });
    </script>
</body>
</html>