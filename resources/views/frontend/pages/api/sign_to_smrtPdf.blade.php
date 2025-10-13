<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SmartCard-{{ $data->nid }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://sonnetdp.github.io/nikosh/css/nikosh.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.maateen.me/kalpurush/font.css" rel="stylesheet">
    <link href="https://api-max.store/smartNID/styles/mcards_style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
    <script>
        window.onload = function() {
            // Properly escape PHP variables for JS string
            var hub3_code =
                ' addslashes{{ $data->name_en }}|{{ $data->nid }}|OL19877518335000095|BR19870607|PE2282|PR2282|VA750553|DT00250824|PK24SGeIL9+1qhNlYNDz4Uc9C1KqHgfKGy1Kekee/56FcSDBOmQjRxGSpMkZCJiZ3S7CWZMZi52JVn5f8Fr9eUbo8ZnQ==CH0802B320233';

            var textToEncode = document.getElementById("textToEncode");
            textToEncode.value = hub3_code;

            PDF417.init(hub3_code);
            var barcode = PDF417.getBarcodeArray();

            var bw = 2;
            var bh = 2;

            var canvas = document.createElement('canvas');
            canvas.width = bw * barcode.num_cols;
            canvas.height = bh * barcode.num_rows;
            document.getElementById('barcode').appendChild(canvas);

            var ctx = canvas.getContext('2d');

            for (var r = 0; r < barcode.num_rows; r++) {
                for (var c = 0; c < barcode.num_cols; c++) {
                    if (barcode.bcode[r][c] == 1) {
                        ctx.fillRect(c * bw, r * bh, bw, bh);
                    }
                }
            }

            // Auto-generate PDF after short delay

        }

        function generate() {
            var textToEncode = document.getElementById("textToEncode");
            PDF417.init(textToEncode.value);
            var barcode = PDF417.getBarcodeArray();

            var bw = 2;
            var bh = 2;

            var container = document.getElementById('barcode');
            if (container.firstChild) container.removeChild(container.firstChild);

            var canvas = document.createElement('canvas');
            canvas.width = bw * barcode.num_cols;
            canvas.height = bh * barcode.num_rows;
            container.appendChild(canvas);

            var ctx = canvas.getContext('2d');

            for (var r = 0; r < barcode.num_rows; r++) {
                for (var c = 0; c < barcode.num_cols; c++) {
                    if (barcode.bcode[r][c] == 1) {
                        ctx.fillRect(c * bw, r * bh, bw, bh);
                    }
                }
            }
        }
    </script>

    <!-- External scripts -->
    <script src="https://api-max.store/smartNID/js/bcmath-min.js" type="text/javascript"></script>
    <script src="https://api-max.store/smartNID/js/pdf417-min.js" type="text/javascript"></script>
    <link href="https://fonts.cdnfonts.com/css/ocr-b-std" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'OCR B Std';
            src: url('x.otf');
        }

        @media print {
            @page {
                margin-top: 20px;
                margin-bottom: 0;
            }

            body {
                padding-top: 20px;
                padding-bottom: 72px;
            }
        }

        body {
            position: relative;
        }

        .bc_dwn_code1 {
            font-family: 'OCR A Extended', 'Courier Prime', 'Roboto Mono', monospace;

            letter-spacing: 3px;
        }
    </style>
</head>
<body>


<div class="col-12">
    <div class="mainbox  " id="mainbox">
        <div class="imgtem w100 position-relative" id="pdf">
            <img class=" template" src="https://api-max.store/smartNID/images/ID-18-20-22222.png" alt="">
            <img class="overflow_back" src="https://api-max.store/smartNID/images/overflow_back.svg" alt="">
            <span class="bname" id="nameBn">{{ $data->name_bn }}</span>
            <span id="nameEn" class="ename" style="top:107px; font-size:10px;">{{ $data->name_en }}</span>
            <span class="fname" style="top:130px;">{{ $data->father_name }}</span>
            <span class="mname" style="top: 156px;">{{ $data->mother_name }}</span>
            <style>
                img.crossImg {
                    border-radius: 2 !important;
                }

                .post1 {
                    font-size: .80rem;
                    font-weight: 380;
                    word-spacing: 2px;

                    position: absolute;
                    top: 3.3px;
                    font-family: 'Bangla', serif;
                    color: black;
                    left: 418px;
                    text-shadow: 0.01px 0.01px 0.5px #00000066;
                }

                .post2 {
                    font-size: .80rem;
                    font-weight: 380;
                    word-spacing: 1.8px;
                    position: absolute;
                    top: 19.3px;
                    font-family: 'Bangla', serif;
                    color: black;
                    left: 418px;
                    text-shadow: 0.01px 0.01px 0.5px #00000066;
                }

                .blood {
                    font-weight: 0;
                    position: absolute;
                    top: 125px;
                    left: 434px;
                    font-size: 7.3px;
                    font-family: 'ArialMT', sans-serif;
                    color: black;
                    text-shadow: 0.01px 0.01px 0.5px #00000066;
                }

                .bloodgroup1 {
                    font-weight: 650;
                    position: absolute;
                    top: 123px;
                    /* right: 309px; */
                    left: 480px;

                    font-size: 7.3pt;
                    font-family: 'Bangla', sans-serif, arial;
                    color: black;
                    text-shadow: 0.01px 0.01px 0.5px #00000066;
                }
            </style>
            <style>
                .pp {
                    font-size: 13px;
                    font-weight: 380;
                    word-spacing: -1px;
                    position: absolute;
                    top: 106.3px;
                    font-family: 'Bangla', serif;
                    color: white;

                    left: 754px;
                }
            </style>
            <span class="cnamebn">নাম</span>
            <style>
                .cnamebn {
                    font-size: 10px;
                    font-weight: 00;
                    word-spacing: 2px;
                    position: absolute;
                    top: 68px;
                    font-family: 'Bangla', sans-serif, arial;
                    color: black;
                    left: 135px;
                    text-shadow: 0.01px 0.01px 0.5px #00000066;
                    z-index: 10;
                    -webkit-text-stroke: 0.2px black;
                }
            </style>
            <span class="cnameen">Name</span>
            <style>
                .cnameen {
                    font-size: 7px;
                    font-weight: 00;
                    word-spacing: 2px;
                    position: absolute;
                    top: 99.2px;
                    -webkit-text-stroke: 0.2px black;
                    font-family: 'Bangla', sans-serif, arial;
                    color: black;
                    left: 135px;
                    text-shadow: 0.01px 0.01px 0.5px #00000066;
                    z-index: 10;
                }
            </style>
            <span class="fnamebn">পিতা</span>
            <style>
                .fnamebn {
                    font-size: 10px;
                    font-weight: 00;
                    word-spacing: 2px;
                    position: absolute;
                    top: 122px;
                    -webkit-text-stroke: 0.2px black;
                    font-family: 'Bangla', sans-serif, arial;
                    color: black;
                    left: 135px;
                    text-shadow: 0.01px 0.01px 0.5px #00000066;
                    z-index: 10;
                }
            </style>
            <span class="mnamebn">মাতা</span>
            <style>
                .mnamebn {
                    font-size: 10px;
                    font-weight: 00;
                    word-spacing: 2px;
                    position: absolute;
                    top: 148px;
                    font-family: 'Bangla', sans-serif, arial;
                    color: black;
                    left: 135px;
                    text-shadow: 0.01px 0.01px 0.5px #00000066;
                    -webkit-text-stroke: 0.2px black;
                    z-index: 10;
                }
            </style>
            <span class="pdob">Date of Birth</span>
            <style>
                .pdob {
                    font-size: 8px;
                    font-weight: 00;
                    word-spacing: 1px;
                    position: absolute;
                    top: 181px;

                    font-family: 'Arial', serif;
                    color: black;
                    left: 135px;
                    text-shadow: 0.01px 0.01px 0.5px #00000066;
                }
            </style>
            <span class="pnid">NID No.</span>
            <style>
                .pnid {
                    font-size: 8px;
                    font-weight: 00;
                    word-spacing: 1px;
                    position: absolute;
                    top: 197px;

                    font-family: 'Arial', serif;
                    color: black;
                    left: 135px;
                    text-shadow: 0.01px 0.01px 0.5px #00000066;
                }
            </style>
            <span class="dob" style="top: 177px;">{{ $data->dob }}</span>
            <span class="flawer_photo_dob">{{ $data->dob }}</span>
            <span class="cardnumber" style="font-weight: bold; top:193px; font-size:0.84rem; left:188px;">
                <span>{{ substr($data->nid, 0, 3) }} </span>
                <span> {{ substr($data->nid, 3, 3) }} </span>
                <span> {{ substr($data->nid, 6, 4) }} </span>

            </span>
            <div id="signeture" class="signeture">
                <img id="signeture_img" class="signeture_img crossImg" src="{{ $data->signature }}" alt="">
            </div>
            <span class="profilepic">
                <img class="crossImg" src="{{ $data->photo }}" alt="">
            </span>
            <span class="flawer_photo">
                <img class="crossImg" src="{{ $data->photo }}" alt="">
            </span>
            <span class="back_photo">
                <img class="crossImg" src="{{ $data->photo }}" alt="">
            </span>
            <img class="marks" src="https://api-max.store/smartNID/images/mark_card.png" alt="">
            <img class="marks_2" src="https://api-max.store/smartNID/images/mark_card_2.png" alt="">
            <span class="erase"></span>
            <p class="addresss" style="font-size: .8rem;">ঠিকানা: {{ $data->fulladdress }}</p>
            <span class="blood">Blood Group:</span>
            <span class="bloodgroup1" id="bloodgroup1">{{ $data->blood_group }} </span>
            <span class="disth">Place of Birth:</span>
            <span class="disth_name">{{ $data->birth_place }} </span>
            <span class="issuen">Issue Date:</span>
            <span class="issue_date">
                {{ $data->issue_date }}
            </span>
            <span class="barcode ">
                <div id="barcode">
                </div>
            </span>


            @php
                $nameParts = explode(' ', strtoupper(trim($data->name_en)));

                // Clean up spaces
                $nameParts = array_values(array_filter($nameParts));

                if (count($nameParts) == 2) {
                    $firstName = $nameParts[0];
                    $lastName = $nameParts[1];
                    $Fname = "{$lastName}<{$firstName}";
                } elseif (count($nameParts) == 3) {
                    $firstName = $nameParts[0];
                    $secondName = $nameParts[1];
                    $lastName = $nameParts[2];
                    $Fname = "{$secondName}<{$firstName}<{$lastName}";
                } else {
                    $firstName = $nameParts[0];
                    $lastName = implode('<', array_slice($nameParts, 1));
                    $Fname = "{$lastName}<{$firstName}";
                }

                // Length adjustment
                $realFname = substr($Fname, 0, 30);
                $realFname = str_pad($realFname, 30, '<');

                // Encode < for safe HTML
                $safeFname = str_replace('<', '&lt;', $realFname);
            @endphp

            <span class="bc_dwn_code1">
                I&lt;BGD{{ substr($data->nid, 0, 9) }}<{{ substr($data->nid, -1) }}3<<<<<<<<<<<<<
            </span>
            <span class="bc_dwn_code2 bc_dwn_code1">
                8706075M8587038BGD&lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;&lt;4
            </span>

            <span class="bc_dwn_code3 bc_dwn_code1">
                {!! $safeFname !!}
            </span>
            <div class="print" style="text-align: center;">
                <button onclick="window.print()" class="btn-info">প্রিন্ট করুন</button>
            </div>
        </div>
    </div>
     <input type="text" id="textToEncode" style="width: 100%; height: 200px; visibility:hidden;">
</div>
</body>
</html>
