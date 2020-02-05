<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>พิมพ์บาร์โค้ด</title>
    <style>
        @media screen {
            .container { display: none; }
            .container.show { display: block; }
        }
        @media print {
            .container { display: block !important; }
        }
        @page { size: auto;  margin: 0mm; }
        .container {
            padding:1.7rem;
        }
        .table {
            display: grid;
            grid-template-columns: 1fr 1fr;
            text-align: center;
        }
        .table li {
            list-style: none;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <ul class="table">
            @foreach ($book as $row)
                <li class="barbode">
                    {!!DNS1D::getBarcodeSVG("4445645656", "C39",1,60)!!}
                </li>
            @endforeach
        </ul>
                
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