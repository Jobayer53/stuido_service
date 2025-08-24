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
    </style>
@endsection

@section('content')
    {{-- @include('frontend.layout.floating_text') --}}
    <div class="row mt-3 ">
        <div class="col-lg-6 m-auto ">
            @if ($signToNid->available == 1)
            <div class="card">
                <h5 class="card-header text-center">এক ক্লিকে সাইন টু এনআইডি ডাউনলোড</h5>
                <div class="card-body">
                    <form id="sign_copy_form" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="" class="form-label">সাইন কপি</label>
                            <input type="file" class="form-control" name="sign_copy">

                        </div>
                        <span class="text-danger fw-semibold mb-3" id="sign_copy_error"></span>
                         <div class="mb-1 text-center">
                                <small class="">আপনার একাউন্ট থেকে <span
                                        class="text-danger">{{ number_format($signToNid->cost, 0) }} টাকা</span> কেটে নেয়া
                                    হবে !</small>

                            </div>
                        <div class=" text-center ">
                            <button class="btn btn-primary btn-sm " type="button" id="orderBtn">তথ্য দেখুন</button>
                        </div>

                    </form>
                </div>
            </div>
            @else
                <div class="card">
                    <h5 class="card-header text-center mb-4"> সাইন টু এনআইডি </h5>
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
    <div class="row p-2">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 fw-semibold">এনআইডি তথ্য <span class="text-danger warning float-right d-none"
                            style="font-size: 12px">*পেইজ রিফ্রেশ করলে তথ্য চলে যাবে*</span></h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('api_signToNid_download') }}" id="nid_form" enctype="multipart/form-data"
                        method="POST" target="_blank">
                        @csrf
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="" class="form-label"> ছবি</label>
                                            <input type="file" class="form-control" name="photo" id="photo"
                                                value="">
                                            <input type="hidden" name="photo_url" id="photo_url">
                                        </div>
                                        <div class="col-lg-6">
                                            <img src="" class="img-fluid" alt="" id="photo_preview"
                                                width="100px">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="" class="form-label">সাইন</label>
                                            <input type="file" class="form-control" name="sign" id="sign"
                                                value="">
                                            <input type="hidden" name="sign_url" id="sign_url">
                                        </div>
                                        <div class="col-6">
                                            <img src="" class="img-fluid" alt="" id="sign_preview"
                                                width="100px">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label">এনাইডি নং</label>
                                    <input type="text" class="form-control" name="nid" id="nid"
                                        placeholder="123567890" required value="{{ old('nid') }}">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label">পিন কোড</label>
                                    <input type="text" class="form-control" name="pin" id="pin"
                                        placeholder="1234567890" required value="{{ old('pin') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label">নাম বাংলা</label>
                                    <input type="text" class="form-control" name="name_bn" id="name_bn"
                                        placeholder="নাম বাংলা" required value="{{ old('name_bn') }}">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label">নাম ইংরেজি</label>
                                    <input type="text" class="form-control" name="name_en" id="name_en"
                                        placeholder="নাম ইংরেজি" required value="{{ old('name_en') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="" class="form-label"> পিতার নাম</label>
                                    <input type="text" class="form-control" name="father_name" id="father_name"
                                        placeholder="পিতার নাম" required value="{{ old('father_name') }}">
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label">মাতার নাম</label>
                                    <input type="text" class="form-control" name="mother_name" id="mother_name"
                                        placeholder="মাতার নাম" required value="{{ old('mother_name') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-4">
                                    <label for="" class="form-label">জন্ম তারিখ</label>
                                    <input type="text" class="form-control" name="dob" id="dob"
                                        placeholder="জন্ম তারিখ" required value="{{ old('dob') }}">
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label"> জন্মস্থান</label>
                                    <input type="text" class="form-control" name="birth_place" id="birth_place"
                                        placeholder="জন্মস্থান" required value="{{ old('birth_place') }}">
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label"> ব্লাড গ্রুপ</label>
                                    <input type="text" class="form-control" name="blood_group" id="blood_group"
                                        placeholder="ব্লাড গ্রুপ" value="{{ old('blood_group') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label for="" class="form-label"> ঠিকানা</label>
                                    <textarea name="fulladdress" id="fulladdress" cols="30" rows="5" class="form-control "></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="mb-3 text-center warning d-none">
                            <button type="submit" id="" class="btn btn-primary btn-sm ">ডাউনলোড</button>
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
                $btn.text('অপেক্ষা করুন...');
                $data = $('sign_copy_form').serialize();
                e.preventDefault();
                $.ajax({
                    url: "{{ route('get_nid') }}",
                    method: "POST",
                    data: new FormData($('#sign_copy_form')[0]),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            $('.warning').removeClass('d-none');
                             $btn.text('তথ্য পাওয়া গেছে');
                            $('#photo_url').val(response.data.photo);
                            $('#sign_url').val(response.data.signature);
                            $('#photo_preview').attr('src', response.data.photo);
                            $('#sign_preview').attr('src', response.data.signature);
                            $('#nid').val(response.data.nid);
                            $('#pin').val(response.data.pin);
                            $('#name_bn').val(response.data.name_bn);
                            $('#name_en').val(response.data.name_en);
                            $('#father_name').val(response.data.father_name);
                            $('#mother_name').val(response.data.mother_name);
                            $('#dob').val(response.data.dob);
                            $('#birth_place').val(response.data.birth_place);
                            $('#blood_group').val(response.data.blood_group);
                            $('#fulladdress').val(response.data.fulladdress);
                        } else {
                            $('#sign_copy_error').text(response.message);
                            console.log(response.message);
                             $btn.prop('disabled', false);
                              $btn.text('তথ্য দেখুন');
                        }
                    },
                    error: function(error) {
                        console.log(error);
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
