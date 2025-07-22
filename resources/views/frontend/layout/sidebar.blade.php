



    <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar" style="padding-bottom:25px !important; height: 88% !important">
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    {{-- <li class="nav-label">ড্যাশবোর্ড</li> --}}

                    <li>
                      <a href="{{route('user_home')}}" aria-expanded="false">
                          <i class="icon-speedometer menu-icon"></i><span class="nav-text">ড্যাশবোর্ড</span>
                      </a>
                    </li>
                    <li>
                        <a href="{{route('server_copy_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">সার্ভার কপি</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('sign_copy_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">সাইন কপি</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('nid_pdf_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">এন আইডি পিডিএফ</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('nid_userPass_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">এন আইডি ইউজার পাস</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('biometric_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">বায়োমেট্রিক</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('lostNid_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">নাম ঠিকানা দিয়ে এন আইডি </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('passport_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">পাসপোর্ট </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('location_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">নাম্বার টু লোকেশন </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('sms_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">কল/SMS লিষ্ট </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('imei_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">IMEI & NID TO ALL NUMBER </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('nagad_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">নগদ/বিকাশ ইনফো </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('tin_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">টিনের সেবা </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('land_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">ভুমি উন্নয়ন সার্ভিস </span>
                        </a>
                    </li>
                    {{-- <li>
                        <a href="{{route('nagad_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">SSC service </span>
                        </a>
                    </li> --}}
                    <li>
                        <a href="{{route('register_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text"> জন্ম নিবন্ধন সার্ভিস</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('statement_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">নাম্বারের স্টেটমেন্ট</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('vaccine_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">সুরক্ষা সার্ভিস</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('bc_change_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">জন্ম নিবন্ধন নাম্বার চেঞ্জ</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('bmet_index')}}"  aria-expanded="false">
                            <i class="icon-globe-alt menu-icon"></i><span class="nav-text">BMET এর সেবা</span>
                        </a>
                    </li>
                    {{-- <li>
                      <a href="./accessability.html"  aria-expanded="false">
                          <i class="icon-grid menu-icon"></i><span class="nav-text">Accessability</span>
                      </a>
                  </li>
                    <li>
                        <a href="./blog.html"  aria-expanded="false">
                            <i class="icon-note menu-icon"></i><span class="nav-text">Blogs</span>
                        </a>
                    </li>
                    <li>
                      <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                          <i class="icon-envelope menu-icon"></i> <span class="nav-text">Property</span>
                      </a>
                      <ul aria-expanded="false">
                          <li><a href="./add_property.html">Add Property</a></li>
                          <li><a href="./property_list.html">Property List</a></li>

                      </ul>
                  </li>
                    <li>
                        <a href="./banner.html"  aria-expanded="false">
                            <i class="icon-menu menu-icon"></i><span class="nav-text">Banner</span>
                        </a>
                    </li> --}}





                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
