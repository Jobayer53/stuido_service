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
    @include('frontend.layout.floating_text')
    <div class="row mt-3 " style="margin-bottom: 300px">
       <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-body text-center">
                <h5>ট্রেনিং সার্টিফিকেট</h5>
                <p>প্রয়োজনীয় তথ্য দিয়ে এডমিনের সাথে যোগাযোগ করুন</p>
            </div>
        </div>
       </div>
    </div>


@endsection


