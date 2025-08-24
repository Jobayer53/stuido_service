<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{$data->nationalId}}</title>


    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>
    <style>
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        @page {
            size: A4;
            margin: 0px;
        }

        body {
            margin: 0;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .background {
            background-color: transparent;
            position: relative;
            width: 1070px;
            height: 1500px;
            margin: auto;
        }

        .crane {
            max-width: 100%;
            height: 100%;
        }

        .topTitle {
            position: absolute;
            left: 21%;
            top: 8%;
            width: auto;
            font-size: 42px;
            color: rgb(255, 182, 47);
        }

        #loadMe {
            visibility: hidden;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
                background-color: #fff !important;
            }

            .print {
                display: none !important;
            }
        }

        #print {
            background: #03a9f4;
            padding: 8px;
            width: 700px;
            height: 40px;
            border: 0px;
            font-size: 25px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 1px 4px 4px #878787;
            color: #fff;
            border-radius: 10px;
            margin: 20px;
            display: none;
        }

        #present_addr,
        #permanent_addr {
            text-align: left;
        }
    </style>
</head>

<body onload="showprint()" style="text-align: center;">
    <div class="background">
        <img class="crane" src="https://i.postimg.cc/zff4mDrk/server.jpg" height="1500px" width="1070px">
        <div
            style="position: absolute; left: 30%; top: 8%;width: auto;font-size: 25.5px;font-family: Arial, Helvetica, sans-serif; color: rgb(255 224 0);">
            <b>National Identity Registration Wing (NIDW)</b></div>
        <div
            style="position: absolute; left: 39%; top: 11%;width: auto;font-size: 18px;font-family: Arial, Helvetica, sans-serif; color: rgb(255, 47, 161);">
            <b>Select Your Search Category</b></div>
        <div
            style="position: absolute; left: 45%; top: 13%;width: auto;font-size: 15px;font-family: Arial, Helvetica, sans-serif; color: rgb(8, 121, 4);">
            Search By NID / Voter No.</div>
        <div
            style="position: absolute; left: 45%; top: 14.4%;width: auto;font-size: 15px;font-family: Arial, Helvetica, sans-serif; color: rgb(7, 119, 184);">
            Search By Form No.</div>
        <div
            style="position: absolute; left: 30%; top: 16.9%;width: auto;font-size: 16px;font-family: Arial, Helvetica, sans-serif; color: rgb(252, 0, 0);">
            <b>NID or Voter No*</b></div>
        <div
            style="position: absolute; left: 45%; top: 17.3%; width: auto; font-size: 12px;font-family: Arial, Helvetica, sans-serif; color: rgb(143, 143, 143);">
            NID</div>
        <div
            style="position: absolute;left: 63.7%;top: 17.3%;width: auto;font-size: 11px;font-family: Arial, Helvetica, sans-serif;color:#ffffff;">
            Submit</div>
        <div
            style="position: absolute;left: 89.6%;top: 11.75%;width: auto;font-size: 11px;font-family: Arial, Helvetica, sans-serif;color: #fff;">
            Home</div>
        <div style="position: absolute; left: 37%; top: 27.4%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">
            <b>জাতীয় পরিচিতি তথ্য</b></div>
        <div style="position: absolute; left: 37%; top: 30%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">জাতীয়
            পরিচয় পত্র নম্বর</div>
        <div id="nid_no"
            style="position: absolute; left: 55%; top: 30.2%; width: auto; font-size: 16.5px;font-family: Arial, Helvetica, sans-serif; color: rgb(7, 7, 7);">
            {{ $data->nationalId ? $data->nationalId : 'N/A' }}</div>

        <div style="position: absolute; left: 37%; top: 32.5%; width: auto; font-size: 18px;color: rgb(7, 7, 7);">নাম
            (বাংলা)</div>
        <div id="nid_father"
            style="position: absolute; left: 55%; top: 32.7%; width: auto; font-size: 16.5px;font-family: Arial, Helvetica, sans-serif; color: rgb(7, 7, 7);">
            {{ $data->nameBangla ? $data->nameBangla : 'N/A' }}
        </div>
        <div style="position: absolute; left: 37%; top: 35.3%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">নাম
            (ইংরেজি)</div>
        <div id="nid_mother"
            style="position: absolute; left: 55%; top: 35.5%; width: auto; font-size: 16.5px;font-family: Arial, Helvetica, sans-serif; color: rgb(7, 7, 7);">
            {{ $data->nameEnglish ? $data->nameEnglish : 'N/A' }} </div>
        <div style="position: absolute; left: 37%; top: 37.8%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">পিতার
            নাম</div>
        <div id="spouse"
            style="position: absolute; left: 55%; top: 38%; width: auto; font-size: 16px;font-family: Arial, Helvetica, sans-serif; color: rgb(7, 7, 7);">
            {{ $data->fatherName ? $data->fatherName : 'N/A' }} </div>
        <div style="position: absolute; left: 37%; top: 40.5%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">মাতার
            নাম</div>

        <div id="voter_area"
            style="position: absolute; left: 55%; top: 40.5%; width: auto; font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: rgb(7, 7, 7);">
            {{ $data->motherName  ? $data->motherName : 'N/A' }} </div>
        <div style="position: absolute; left: 37%; top: 43.5%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">
            <b>ব্যক্তিগত তথ্য</b></div>
        <div style="position: absolute; left: 37%; top: 46%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">ভোটার
            এরিয়া</div>
        <div id="name_bn"
            style="position: absolute; font-weight: bold; left: 55%; top: 46%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">
            <b> {{ $data->voterArea ? $data->voterArea : 'N/A' }} </b></div>
        <div style="position: absolute; left: 37%; top: 48.5%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">
            মোবাইল</div>
        <div id="name_en"
            style="position: absolute; left: 55%; top:48.7%; width: auto; font-size: 18px;font-family: Arial, Helvetica, sans-serif; color: rgb(7, 7, 7);">
            {{ $data->mobile ? $data->mobile : 'N/A' }}</div>
        <div style="position: absolute; left: 37%; top: 51.2%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">জন্ম
            তারিখ</div>
        <div id="dob"
            style="position: absolute; left: 55%; top: 51.4%; width: auto; font-size: 16px; font-family: Arial, Helvetica, sans-serif; color: rgb(7, 7, 7);">
            {{ $data->dateOfBirth ? $data->dateOfBirth : 'N/A' }}</div>
        <div style="position: absolute; left: 37%; top: 53.80%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">জেলা
        </div>
        <div id="fathers_name"
            style="position: absolute; left: 55%; top: 53.80%; width: auto; font-size: 18px; color: rgb(7, 7, 7);"> {{$data->presentDistrict ? $data->presentDistrict : 'N/A'}}
        </div>
        <div style="position: absolute; left: 37%; top: 56.50%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">পিন
        </div>
        <div id="mothers_name"
            style="position: absolute; left: 55%; top: 56.50%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">{{$data->pin ? $data->pin : 'N/A'}}
        </div>
        <div style="position: absolute; left: 37%; top: 59.3%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">
            <b>অন্যান্য তথ্য</b></div>
        <div style="position: absolute; left: 37%; top: 62.2%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">
            স্বামী/স্ত্রীর নাম</div>
        <div id="gender"
            style="position: absolute; left: 55%; top: 62.2%; width: auto; font-size: 18px;font-family: Arial, Helvetica, sans-serif; color: rgb(7, 7, 7);"> {{$data->spouseName ? $data->spouseName : 'N/A'}}
            </div>

        <div style="position: absolute; left: 37%; top: 64.7%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">ভোটার
            এরিয়া কোড</div>
        <div id="mobile_no"
            style="position: absolute; left: 55%; top: 65%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">{{$data->voterAreaCode ? $data->voterAreaCode : 'N/A'}}
        </div>
        <div
            style="position: absolute; left: 37%; top: 67.5%; width: auto; font-size: 18px;font-family: Arial, Helvetica, sans-serif; color: rgb(7, 7, 7);">
            রক্তের গ্রুপ</div>
        <div id="blood_grp"
            style="position: absolute; left: 55%; top: 67.5%; width: auto; font-size: 18px; font-family: Arial, Helvetica, sans-serif; color: red;">
            {{$data->bloodGroup ? $data->bloodGroup : 'N/A'}}</div>
        <div style="position: absolute; left: 37%; top: 70.2%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">
            জন্মস্থান</div>
        <div id="birth_place"
            style="position: absolute; left: 55%; top: 70.5%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">{{$data->birthPlace ? $data->birthPlace : 'N/A'}}
        </div>
        <div style="position: absolute; left: 37%; top: 73.2%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">
            <b>বর্তমান ঠিকানা</b></div>

        <div id="present_addr"
            style="position: absolute; left: 37%; top: 75.5%; width: 48%; font-size: 16px; color: rgb(7, 7, 7);">
            {{$data->preAddress->addressLine  ? $data->preAddress->addressLine  : 'N/A'}} </div>

        <div style="position: absolute; left: 37%; top: 82.1%; width: auto; font-size: 18px; color: rgb(7, 7, 7);">
            <b>স্থায়ী ঠিকানা</b></div>
        <div id="permanent_addr"
            style="position: absolute; left: 37%; top: 84.3%; width: 48%; font-size: 16px; color: rgb(7, 7, 7);">
            {{$data->perAddress->addressLine  ? $data->perAddress->addressLine  : 'N/A'}} </div>

        <div style="position: absolute;top: 92%;width: 100%;font-size: 16px;text-align: center;color: rgb(255, 0, 0);">
            উপরে প্রদর্শিত তথ্যসমূহ জাতীয় পরিচয়পত্র সংশ্লিষ্ট, ভোটার তালিকার সাথে সরাসরি সম্পর্কযুক্ত নয়।</div>
        <div
            style="position: absolute;top: 93.5%;width: 100%;text-align: center;font-size: 14px;font-family: Arial, Helvetica, sans-serif;color: rgb(3, 3, 3);">
            This is Software Generated Report From Bangladesh Election Commission, Signature &amp; Seal Aren't Required.
        </div>

        <div style="position: absolute;  left: 19%; top: 26.7%; width: auto; font-size: 12px; color: rgb(3, 3, 3);">

            <img id="photo" src="{{$data->photo}}" height="150px" width="135px" style="border-radius: 10px">
        </div>

        <div style="position: absolute;  left: 17%; top: 36%; width: auto; font-size: 12px; color: rgb(3, 3, 3);">

            <img id="photo" src="{{$data->sign}}" height="50px" width="auto" style="border-radius: 10px">
        </div>

        <div style="position: absolute;  left: 20%; top: 39.4%; width: auto; font-size: 12px; color: rgb(3, 3, 3);">
            <img id="qr" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=N%2FA+N%2FA+N%2FA"
                height="120px" width="120px" style="position: relative;" />
        </div>

        <div id="name_en2"
            style="position: absolute;font-weight: bold;left: 18%;top: 37.5%;height: 32px;width: 150px;font-size: 13px;font-family: Arial, Helvetica, sans-serif;color: rgb(7, 7, 7);margin: auto;align-items: center;text-align: center!important;"
            align="center"><b></b></div>


</body>
<script>
    // Run when page + resources are fully loaded
    window.onload = function () {
        window.print();
    };

    // Disable right click
    document.addEventListener('contextmenu', function (event) {
        event.preventDefault();
    });

    // Also re-trigger print if user clicks anywhere
    document.addEventListener('click', function () {
        window.print();
    });
</script>

</html>
