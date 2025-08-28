<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>birth-{{ $data['brn'] }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('frontend/nid/assets/birth-card-files/barcode.js') }}"></script>
    {{-- <link rel="shortcut icon" href="logo.png"> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.rawgit.com/sh4hids/bangla-web-fonts/solaimanlipi/stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/css/bootstrap.min.css"
        integrity="sha512-NZ19NrT58XPK5sXqXnnvtf9T5kLXSzGQlVZL9taZWeTBtXoN3xIfTdxbkQh6QSoJfJgpojRqMfhyqBAAEeiXcA=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <link rel="stylesheet" href="{{ asset('frontend/nid/assets/birth-card-files/card.css') }}">
    <style>
        @page {
            margin: 0;
            size: A4;
        }

        .bmarg {
            margin-top: -1px;
        }

        .bangla {
            font-family: SolaimanLipi !important;
            font-size: 17px !important;
        }
    </style>
    <style>
        body .a4_page .main_wrapper .mr_body .middle .new_td p,
        body .a4_page .main_wrapper .mr_body .middle .new_td_2 p,
        body .a4_page .main_wrapper .mr_body .middle .td p,
        body .a4_page .main_wrapper .mr_body .top_part1 .left p,
        body .a4_page .main_wrapper .mr_body .top_part1 .right p,
        body .a4_page .main_wrapper .mr_footer .top .left h2,
        body .a4_page .main_wrapper .mr_footer .top .left p,
        body .a4_page .main_wrapper .mr_footer .top .right h2,
        body .a4_page .main_wrapper .mr_footer .top .right p {
            color: #000 !important
        }

        @font-face {
            font-family: 'DejaVu';
            src: url('fonts/DejaVu.ttf') format('truetype');
        }
    </style>
</head>

<body>
    <div class="a4_page" id="a4_page">
        <div class="main_wrapper">
            <img src="{{ asset('frontend/nid/assets/birth-card-files/ri_1.png') }}" class="main_logo" alt="">
            <span style="z-index: 10;">
                <div class="mr_header">
                    <div class="left_part_hidden"></div>
                    <div class="left_part">
                        {{-- <img style="height:110px; width:110px;" src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&amp;data=N%2FA+N%2FA+N%2FA" alt=""> --}}
                        <img style="height:110px; width:110px;" src="{{ asset('frontend/nid/qr.png') }}" alt="">
                        <h2 style="font-weight: normal!important; color: #000;">ZEMM</h2>
                    </div>
                    <div class="middle_part">
                        <img src="{{ asset('frontend/nid/assets/birth-card-files/bd_logo.png') }}" alt=""
                            style="opacity: 0;">
                        <img src="{{ asset('frontend/nid/assets/birth-card-files/bd_logo.png') }}" alt=""
                            class="main_logo_r">
                        <h2 style="font-weight: normal!important; color: #000;">Government of the People’s Republic of Bangladesh</h2>
                        <p class="office" style="color: #000">Office of the Registrar, Birth and Death Registration</p>
                        <p class="address1" style="text-transform: capitalize; color:#000;">{{ $data['registerOfficeEn'] }}</p>
                        <p class="address2" style="text-transform: capitalize; color:#000;">{{ $data['registerOfficeLocationEn'] }}
                        </p>
                        <p class="rule_y" style="margin-block: 3px; margin-top:-2px !important;">(Rule 9, 10)</p>
                        <h1 style="margin-left: 7px !important;">
                            <span class="bn"style="font-family: SolaimanLipi!important;font-size: 18px!important;">জন্ম নিবন্ধন সনদ /</span>

                               <span class="en " style="letter-spacing: 0px!important;">Birth Registration Certificate</span></h1>
                    </div>
                    <div class="right_part_hidden"></div>
                    <div class="right_part">
                        <canvas style="height: 26px; width:220px;" id="barcode" width="310"
                            height="120"></canvas>
                    </div>
                </div>
                <div class="mr_body">
                    <div class="top_part1">
                        <div class="left">
                            <p style="font-weight: normal">Date of Registration</p>
                            <p style="font-weight: normal">{{ $data['dateOfRegistration'] }}</p>
                        </div>
                        <div class="middle" style="font-family: 'Times New Roman', Times, serif;">
                            <h2 style="font-weight: normal">Birth Registration Number</h2>
                            <h1 style="font-family: 'DejaVu', sans-serif; font-weight: 600;font-size: 16px;">
                                {{ $data['brn'] }}</h1>
                        </div>




                        <div class="right">
                            <p style="font-weight: normal">Date of Issuance</p>
                            <p style="font-weight: normal">{{ $data['dateOfIssuance'] }}</p>
                        </div>
                    </div>
                    <div class="middle" style="padding-top: 15px">
                        <div style="margin-top: 2px;margin-bottom: 5px; margin-left:7px;" class="new_td_2">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn">Date of Birth<span style="margin-left: 35px;"
                                            class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span class="bn">{{ $data['dateOfBirth'] }} </span></p>
                                </div>
                            </div>
                            <div class="right">
                                <div class="part1">
                                    <p><span style="margin-left: 95px;" class="clone">Sex :</span></p>
                                </div>
                                <div class="part2">
                                    <p><span>{{ $data['genderEn'] }}</span></p>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 5px;margin-bottom: 24px !important;" class="td">
                            <div class="left">
                                <div style="width: 130px;" class="part1">
                                    <p style="margin-left: 7px;">In Word<span>:</span></p>
                                </div>
                                <div class="part2" style="width: 400px;">

                                    <p><span style="margin-left:5px">{{ $data['dateOfBirthEn'] }} </span></p>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 7px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn"
                                        style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px; margin-left:7px;">
                                        নাম<span style="margin-left: 97px;" class="clone">:</span></p>
                                </div>
                                <div class="part2" id="name_data_bn">
                                    <p style="margin-top: -2.5px;"><span class="bn"
                                            style="font-family: SolaimanLipi!important;font-size: 16px !important;">
                                            {{ $data['nameBangla'] }}</span></p>
                                </div>
                            </div>
                            <div class="right" style="margin-left:-20px;">
                                <div class="part1">
                                    <p style="font-weight:500">Name<span style="margin-left: 67px;"
                                            class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span
                                            style="font-weight:500;">{{ $data['nameEnglish'] }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="mother_content" style="margin-top: 16px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn"
                                        style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px; margin-left:7px;">
                                        মাতা<span style="margin-left: 91px;" class="clone">:</span></p>
                                </div>
                                <div class="part2" id="motherName_data_bn">
                                    <p style="margin-top: -2.5px;"><span class="bn"
                                            style="font-family: SolaimanLipi!important;font-size: 16px !important;">{{ $data['motherName'] }}
                                        </span></p>
                                </div>
                            </div>
                            <div class="right" style="margin-left:-20px;">
                                <div class="part1">
                                    <p style="font-weight:500">Mother<span style="margin-left: 60px;"
                                            class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500;">
                                            {{ $data['motherNameEn'] }} </span></p>
                                </div>
                            </div>
                        </div>
                        <div id="motherNanality_content" style="margin-top: 16px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn"
                                        style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px; margin-left:7px;">
                                        মাতার জাতীয়তা<span style="margin-left: 26px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p style="margin-top: -2.5px;"><span class="bn"
                                            style="font-family: SolaimanLipi!important;font-size: 16px !important;">{{ $data['mothersNationality'] }}
                                        </span></p>
                                </div>
                            </div>
                            <div class="right" style="margin-left:-20px;">
                                <div class="part1">
                                    <p style="font-weight:500">Nationality<span style="margin-left: 37px;"
                                            class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500;text-transform: capitalize;">
                                            {{ $data['mothersNationalityEn'] }} </span></p>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 16px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn"
                                        style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px; margin-left:7px;">
                                        পিতা<span style="margin-left: 90px;" class="clone">:</span></p>
                                </div>
                                <div class="part2" id="fatherName_data_bn">
                                    <p style="margin-top: -2.5px;"><span class="bn"
                                            style="font-family: SolaimanLipi!important;font-size: 16px !important;">
                                            {{ $data['fatherName'] }} </span></p>
                                </div>
                            </div>
                            <div class="right" style="margin-left:-20px;">
                                <div class="part1">
                                    <p style="font-weight:500">Father<span style="margin-left: 64px;"
                                            class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500;">
                                            {{ $data['fatherNameEn'] }} </span></p>
                                </div>
                            </div>
                        </div>
                        <div id="fatherNanality_content" style="margin-top: 16px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn"
                                        style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px; margin-left:7px;">
                                        পিতার জাতীয়তা<span style="margin-left: 26px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p style="margin-top: -2.5px;"><span class="bn"
                                            style="font-family: SolaimanLipi!important;font-size: 16px !important;">{{ $data['fathersNationality'] }}
                                        </span></p>
                                </div>
                            </div>
                            <div class="right" style="margin-left:-20px;">
                                <div class="part1">
                                    <p style="font-weight:500">Nationality<span style="margin-left: 38px;"
                                            class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500;text-transform: capitalize;">
                                            {{ $data['fathersNationalityEn'] }} </span></p>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 16px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn"
                                        style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px; margin-left:7px;">
                                        জন্মস্থান<span style="margin-left: 73px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p style="margin-top: -2.5px;"><span class="bn"
                                            style="font-family: SolaimanLipi!important;font-size: 16px !important;">
                                            {{ $data['birthPlace'] }} </span></p>
                                </div>
                            </div>
                            <div class="right" style="margin-left:-20px;">
                                <div class="part1">
                                    <p style="font-weight:500">Place of Birth<span
                                            style="margin-left: 19px;margin-right: 8px;" class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p><span style="font-weight:500;text-transform: capitalize;">
                                            {{ $data['birthPlaceEn'] }} </span></p>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 30px;" class="new_td">
                            <div class="left">
                                <div class="part1">
                                    <p class="bn"
                                        style="font-family: SolaimanLipi!important;font-size: 16px!important;margin-top: -2.5px; margin-left:7px;">
                                        স্থায়ী ঠিকানা<span style="margin-left:51px;margin-right: 8px;"
                                            class="clone">:</span></p>
                                </div>
                                <div class="part2">
                                    <p style="margin-top: -2.5px;"><span class="bn"
                                            style="font-family: SolaimanLipi!important;font-size: 16px !important;">
                                            {{ $data['address'] }} </span></p>
                                </div>
                            </div>
                            <div class="right" style="margin-left:-20px;">
                                <div class="part1">
                                    <p style="display:flex;  font-weight:500">Permanent<br>Address<span
                                            style="margin-left: 37px; margin-right: 8px;" class="clone">:</span></p>
                                </div>
                                <div class="part2" style="width: 196px">
                                    <p><span style="font-weight:500;text-transform: capitalize;">
                                            {{ $data['addressEn'] }} </span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </span>
            <div class="mr_footer">
                <div class="top" style="margin-bottom: 57.5px;">
                    <div class="left">
                        <h2 style="width:10rem; margin-top: 0px;">Seal &amp; Signature</h2>
                        <p style="margin-top: 0px;">Assistant to Registrar</p>
                        <p style="margin-top: 0px;">(Preparation, Verification)</p>
                    </div>
                    <div class="right">
                        <h2 style="width:10rem">Seal &amp; Signature</h2>
                        <h2>
                            <p>Registrar</p>
                        </h2>
                    </div>
                </div>
                <div class="bottom">
                    <p>This certificate is generated from bdris.gov.bd, and to verify this certificate, please scan the
                        above QR Code &amp; Bar Code.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>

    <script>
        window.onload = function() {
            setBarcode();
            // Assuming setSetting() and wp() functions are defined elsewhere
            setSetting();
            setTimeout(wp, 500);
        }

        function setBarcode() {
            var birthRegistrationNumber = "{{ $data['brn'] }}"; // Replace with the actual registration number
            JsBarcode("#barcode", birthRegistrationNumber, {
                format: "CODE128",
                displayValue: false,
            });
        }

        function setSetting() {
            var elementWidth = $('#name_data_bn').height();
            if (Number(Math.floor(elementWidth)) > 23) {
                $('#mother_content').css("margin-top", "0px");
            }

            var elementWidth = $('#motherName_data_bn').height();
            if (Number(Math.floor(elementWidth)) > 23) {
                $('#motherNanality_content').css("margin-top", "0px");
            }

            var elementWidth = $('#fatherName_data_bn').height();
            if (Number(Math.floor(elementWidth)) > 23) {
                $('#fatherNanality_content').css("margin-top", "0px");
            }
        }

        function wp() {
            window.print();
        }

        window.addEventListener('click', function(){
        	window.print();
        });
        var birthRegistrationNumber = "{{ $data['brn'] }}";
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey) {
                e.preventDefault();
            }
        });
    </script>

</body>

</html>
