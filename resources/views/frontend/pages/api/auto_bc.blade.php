@extends('frontend.layout.frontend_app')

@section('style')
    <style>
        .text-container {
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .animated-text {
            /* display: inline-block; */
            /* white-space: nowrap; */
            animation: moveText 8s linear infinite;
        }

        @keyframes moveText {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-45%);
            }
        }

        .spinner {
            border: 2px solid #f3f3f3;
            /* Light gray */
            border-top: 2px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 14px;
            height: 14px;
            animation: spin 1s linear infinite;
            display: inline-block;
            margin-left: 6px;
            vertical-align: middle;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    {{-- @include('frontend.layout.floating_text') --}}
    <div class="row mt-3 px-3 pb-0 pt-3">
        <div class="col-lg-12 m-auto mb-0">
            @if ($service->available == 1)
                <div class="card mb-0">
                    <h5 class="card-header text-center">এক ক্লিকে অটো নিবন্ধন ডাউনলোড</h5>
                    <div class="card-body">
                        <form id="auto_bc_form">
                            @csrf
                            <div class="mb-2">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="" class="form-label text-dark ">BIRTH CERTIFICATE NO</label>
                                        <input type="text" class="form-control" name="brn" id=""
                                            placeholder="123567890" autofocus required value="{{ old('brn') }}">

                                    </div>
                                    <div class="col-6">
                                        <label for="" class="form-label text-dark">Date Of Birth </label>
                                        <input type="text" class="form-control" name="dob" id=""
                                            placeholder="YYYY-MM-DD" autofocus required>
                                    </div>
                                </div>

                            </div>

                            <span class="text-danger fw-semibold mb-3" id="autoBc_error"></span>
                            <div class="mb-1 text-center mt-5  ">
                                <small class="">আপনার একাউন্ট থেকে <span
                                        class="text-danger">{{ number_format($service->cost, 0) }} টাকা</span> কেটে নেয়া
                                    হবে !</small>

                            </div>
                            <div class=" text-center">
                                <button class="btn btn-primary btn-sm " type="submit" id="orderBtn">তথ্য দেখুন</button>
                            </div>

                        </form>
                    </div>
                </div>
            @else
                <div class="card mb-0">
                    <h5 class="card-header text-center mb-4">অটো নিবন্ধন</h5>
                    <div class="card-body">
                        <i class=" text-danger d-flex  justify-content-center mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-clock-pause">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20.942 13.018a9 9 0 1 0 -7.909 7.922" />
                                <path d="M12 7v5l2 2" />
                                <path d="M17 17v5" />
                                <path d="M21 17v5" />
                            </svg>
                        </i>
                        <p class="text-center text-danger">কাজ বন্ধ আছে!</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="row px-3 pb-0 ">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 fw-semibold "><span class="text-danger warning float-right d-none"
                            style="font-size: 12px">*পেইজ রিফ্রেশ করলে তথ্য চলে যাবে*</span></h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('api_autoBc_download') }}" id=""method="POST" target="_blank">
                        @csrf
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark"> Register Office Address </label>
                                    <input type="hidden" class="form-control" name="registerOffice" id="registerOffice"
                                        value="{{ old('registerOffice') }}">
                                    <input type="text" name="registerOfficeEn" id="registerOfficeEn" class="form-control"
                                        value="{{ old('registerOfficeEn') }}" placeholder="রেজিস্টার অফিসের ঠিকানা">
                                         <input type="hidden" name="slug" id="slug">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark"> Upazila/Pourashava/City Corporation,
                                        Zila </label>
                                    <input type="hidden" class="form-control" name="registerOfficeLocation"
                                        id="registerOfficeLocation" value="{{ old('registerOfficeLocation') }}">
                                    <input type="text" class="form-control" name="registerOfficeLocationEn"
                                        id="registerOfficeLocationEn"value="{{ old('registerOfficeLocationEn') }}"
                                        placeholder="উপজেলা/পৌরসভা/সিটি কর্পোরেশন, জেলা">

                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Birth Registration Number </label>
                                    <input type="text" class="form-control" name="brn" id="brn" required
                                        value="{{ old('brn') }}" placeholder="XXXXXXXXXXX">

                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Gender</label>
                                    <input type="text" class="form-control" name="genderEn"
                                        id="genderEn"value="{{ old('genderEn') }}" placeholder="Male/Female">
                                    <input type="hidden" class="form-control" name="gender" id="gender" required
                                        value="{{ old('gender') }}">
                                </div>

                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Date of Registration </label>
                                    <input type="text" class="form-control" name="dateOfRegistration"
                                        id="dateOfRegistration" required value="{{ old('dateOfRegistration') }}"
                                        placeholder="DD/MM/YYYY">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Date of Issuance </label>
                                    <input type="text" class="form-control" name="dateOfIssuance" id="dateOfIssuance"
                                        required value="{{ old('dateOfIssuance') }}" placeholder="DD/MM/YYYY">
                                </div>


                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Date of Birth</label>
                                    <input type="text" class="form-control" name="dateOfBirth" id="dateOfBirth"
                                        required value="{{ old('dateOfBirth') }}" placeholder="DD/MM/YYYY">

                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Date of Birth in Word </label>
                                    <input type="text" class="form-control" name="dateOfBirthEn"
                                        id="dateOfBirthEn"value="{{ old('dateOfBirthEn') }}"
                                        placeholder="Eleven August Two Thousand Three">

                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-6">
                            <label for="" class="form-label text-dark">আজকের তারিখ</label>
                            <input type="text" class="form-control" name="dateOfToday" id="dateOfToday" required
                                value="{{ old('dateOfToday') }}">
                        </div> --}}
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">নাম </label>
                                    <input type="text" class="form-control" name="nameBangla"
                                        id="nameBangla"value="{{ old('nameBangla') }}" placeholder="নাম বাংলা">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Name</label>
                                    <input type="text" class="form-control" name="nameEnglish"
                                        id="nameEnglish"value="{{ old('nameEnglish') }}"
                                        placeholder="Full Name in English">

                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">পিতার নাম </label>
                                    <input type="text" class="form-control" name="fatherName" id="fatherName"
                                        value="{{ old('fatherName') }}" placeholder="পিতার নাম বাংলা">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Father Name</label>
                                    <input type="text" class="form-control" name="fatherNameEn" id="fatherNameEn"
                                        value="{{ old('fatherNameEn') }}" placeholder="Father Name in English">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">পিতার জাতীয়তা </label>
                                    <input type="text" class="form-control"
                                        name="fathersNationality"id="fathersNationality"
                                        value="{{ old('fathersNationality') }}" placeholder="বাংলাদেশী">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Father Nationality</label>
                                    <input type="text" class="form-control"
                                        name="fathersNationalityEn"id="fathersNationalityEn"
                                        value="{{ old('fathersNationalityEn') }}" placeholder="Bangladeshi">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">মাতার নাম </label>
                                    <input type="text" class="form-control" name="motherName" id="motherName"
                                        value="{{ old('motherName') }}" placeholder=" মাতার নাম বাংলা">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Mother Name</label>
                                    <input type="text" class="form-control" name="motherNameEn"
                                        id="motherNameEn"value="{{ old('motherNameEn') }}"
                                        placeholder="Mother Name in English">
                                </div>

                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">মাতার জাতীয়তা </label>
                                    <input type="text" class="form-control"
                                        name="mothersNationality"id="mothersNationality"
                                        value="{{ old('mothersNationality') }}" placeholder="বাংলাদেশী">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">Mother Nationality</label>
                                    <input type="text" class="form-control"
                                        name="mothersNationalityEn"id="mothersNationalityEn"
                                        value="{{ old('mothersNationalityEn') }}" placeholder="Bangladeshi">
                                </div>

                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark"> জন্মস্থান </label>
                                    <input type="text" class="form-control" name="birthPlace" id="birthPlace"
                                        value="{{ old('birthPlace') }}" placeholder=" জন্মস্থান বাংলায়">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark"> Place of Birth</label>
                                    <input type="text" class="form-control" name="birthPlaceEn" id="birthPlaceEn"
                                        value="{{ old('birthPlaceEn') }}" placeholder="Place of Birth in English">

                                </div>

                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label text-dark">স্থায়ী ঠিকানা </label>
                                    <textarea class="form-control" name="address" id="address"cols="30" rows="5"
                                        placeholder="স্থায়ী ঠিকানা বাংলায়" required></textarea>
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label text-dark"> Permanent Address</label>
                                    <textarea class="form-control" name="addressEn" id="addressEn" cols="30" rows="5"
                                        placeholder="Permanent Address in English" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 mt-5 text-center warning d-none">
                            <button type="submit" id="" class="btn btn-info btn-sm ">ডাউনলোড</button>
                        </div>

                </div>
            </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#orderBtn').on('click', function(e) {
                const $btn = $('#orderBtn');

                $btn.prop('disabled', true);
               $btn.html('অপেক্ষা করুন... <span class="spinner"></span>');

                e.preventDefault();
                $.ajax({
                    url: "{{ route('get_autoBc') }}",
                    method: "POST",
                    data: new FormData($('#auto_bc_form')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            $('#autoBc_error').empty();
                            $('.warning').removeClass('d-none');
                            $btn.text('তথ্য পাওয়া গেছে');
                            $('#slug').val(response.slug);
                            $('#nameBangla').val(response.data.nameBangla);
                            $('#nameEnglish').val(response.data.nameEnglish);
                            $('#dateOfBirth').val(response.data.dateOfBirth);
                            $('#dateOfBirthEn').val(response.data.dateOfBirthEn);
                            $('#brn').val(response.data.brn);
                            $('#dateOfToday').val(response.data.dateOfToday);
                            $('#gender').val(response.data.gender);
                            $('#genderEn').val(response.data.genderEn);
                            $('#fatherName').val(response.data.fatherName);
                            $('#fatherNameEn').val(response.data.fatherNameEn);
                            $('#fathersNationality').val(response.data.fathersNationality);
                            $('#fathersNationalityEn').val(response.data.fathersNationalityEn);
                            $('#motherName').val(response.data.motherName);
                            $('#motherNameEn').val(response.data.motherNameEn);
                            $('#mothersNationality').val(response.data.mothersNationality);
                            $('#mothersNationalityEn').val(response.data.mothersNationalityEn);
                            $('#birthPlace').val(response.data.birthPlace);
                            $('#birthPlaceEn').val(response.data.birthPlaceEn);
                            $('#registerOffice').val(response.data.registerOffice);
                            $('#registerOfficeEn').val(response.data.registerOfficeEn);
                            $('#registerOfficeLocation').val(response.data
                                .registerOfficeLocation);
                            $('#registerOfficeLocationEn').val(response.data
                                .registerOfficeLocationEn);
                            // $('#address').val(response.data.address);
                            // $('#addressEn').val(response.data.addressEn);

                            console.log(response.slug);



                        } else {
                            $('#autoBc_error').text(response.message);
                            console.log(response.message);
                            $btn.prop('disabled', false);
                            $btn.text('তথ্য দেখুন');
                        }
                    },
                    error: function(xhr, status, errorThrown) {
                        // xhr.responseJSON will contain your error response
                        let res = xhr.responseJSON;
                        let msg = res && res.message ? res.message : 'সার্ভার সমস্যা হয়েছে';
                        $('#autoBc_error').text(msg);
                        $btn.prop('disabled', false);
                        $btn.text('তথ্য দেখুন');
                        console.log(res);
                    }


                });
            });

        });
        document.getElementById('photo').addEventListener('change', function(event) {
            let file = event.target.files[0];
            if (file) {
                let preview = document.getElementById('photo_preview');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
        document.getElementById('sign').addEventListener('change', function(event) {
            let file = event.target.files[0];
            if (file) {
                let preview = document.getElementById('sign_preview');
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
    </script>
@endsection
