  <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('frontend/images/logo2.png')}}">
    <!-- Pignose Calender -->
    {{-- <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet"> --}}
    <!-- Chartist -->
    <link rel="stylesheet" href="{{asset('frontend/plugins/chartist/css/chartist.min.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('frontend/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.cs')}}s"> --}}
    <!-- Custom Stylesheet -->
    <link href="{{asset('frontend/css/style.css')}}" rel="stylesheet">

<style>
.whatsapp-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #25D366;
    color: white;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    text-align: center;
    font-size: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.whatsapp-button:hover {
    background-color: #128C7E;
    color: #fff;
    transform: scale(1.1);
}
.nk-sidebar .metismenu > li.active > a{
    background: #4d7cff!important;
}
.nk-sidebar .metismenu > li.active > a > i{
    color: #fff!important;
}
.nk-sidebar .metismenu > li.active > a > .nav-text{
    color: #fff!important;
}
.nk-sidebar .metismenu > li.active > a > .nav-text> i{
    color: #fff!important;
}
::-webkit-scrollbar {
  width: 10px;               /* width of vertical scrollbar */
  height: 10px;              /* height of horizontal scrollbar */
}

::-webkit-scrollbar-track {
  background: #f1f1f1;        /* Track color */
  border-radius: 10px;        /* Rounded track */
}

::-webkit-scrollbar-thumb {
  background: linear-gradient(180deg, #4e73df, #4d7cff); /* Thumb color */
  border-radius: 10px;        /* Rounded thumb */
  border: 2px solid #f1f1f1;  /* Adds space around thumb */
}

::-webkit-scrollbar-thumb:hover {
  background: linear-gradient(180deg, #224abe, #1e3a8a); /* On hover */
}

</style>
