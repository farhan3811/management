<section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info" style="height:85px;padding-top:20px">
                <div class="image" style="position:relative;float:left">
                    <img src="{{ asset('adminbsb/images/user.png') }}" width="48" height="48" alt="User" />
                </div>
                <div class="info-container" style="top:5px">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Session::get('nama') }}</div>
                    <div class="email">{{ \Auth::user()->roles()->get(array('display_name'))->first()->display_name }}</div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            {{-- <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">group</i>Followers</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">shopping_cart</i>Sales</a></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">favorite</i>Likes</a></li>
                            <li role="seperator" class="divider"></li> --}}
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="material-icons">input</i>Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            @php $firstsegment = explode('/', '-'.parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) @endphp
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="{{ $firstsegment[1] == 'home'? ' active ' : ''}}" >
                        <a href="{{ route('home') }}">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
                    </li>
                    @role(['admin', 'pemeriksa'])
                        <li class="{{ $firstsegment[1] == 'visus'? ' active ' : ''}}">
                            <a href="{{ route('visus') }}">
                                <i class="material-icons">face</i>
                                <span>Pemeriksaan</span>
                            </a>
                        </li>
                    @endrole     
                    
                    @role(['admin', 'docter', 'main_docter'])   
                     <!--   <li class="{{ $firstsegment[1] == 'konsultasi'? ' active ' : ''}}">
                            <a href="{{ route('konsultasi') }}">
                                <i class="material-icons">queue_play_next</i>
                                <span>Konsultasi Dokter</span>
                            </a>
                        </li> -->
                    @endrole   

                    @role(['admin', 'laborant'])   
                        <li class="{{ $firstsegment[1] == 'req_lab'? ' active ' : ''}}">
                            <a href="{{ route('req_lab') }}">
                                <i class="material-icons">insert_invitation</i>
                                <span>Laboratorium</span>
                            </a>
                        </li>
                    @endrole   

                    @role(['admin', 'surgeon'])   
                        <li class="{{ $firstsegment[1] == 'operasi'? ' active ' : ''}}">
                            <a href="{{ route('operasi') }}">
                                <i class="material-icons">remove_red_eye</i>
                                <span>Operasi</span>
                            </a>
                        </li>
                    @endrole   

                    @role(['admin', 'cashier'])   
                        <li class="{{ $firstsegment[1] == 'kasir'? ' active ' : ''}}">
                            <a href="{{ route('kasir') }}">
                                <i class="material-icons">alarm_add</i>
                                <span>Kasir & Tambah Obat</span>
                            </a>
                        </li>
                    @endrole   
                   
                    @role(['admin', 'main_docter', 'docter'])  
                    <li >
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">assignment</i>
                            <span>Laporan</span>
                        </a>
                        @role(['admin', 'main_docter', 'docter'])   
                        <ul class="ml-menu">
                            <li class="{{ $firstsegment[1] == 'report'? ' active ' : ''}}">
                                <a href="{{ route('reports.medical_records') }}"><i class="material-icons" style="margin-top:-2px;margin-right:7px">chrome_reader_mode</i> Laporan Rekam Medis</a>
                            </li>
                        </ul>
                        @endrole
                    </li>
                    @endrole
                    @role(['admin', 'operator', 'laborant'])   
                    <li class="{{ $firstsegment[1] == 'master'? ' active ' : ''}}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">view_module</i>
                            <span>Master</span>
                        </a>
                        <ul class="ml-menu">
                             @role(['admin', 'cashier'])   
                                <li class="{{ $firstsegment[1] == 'obat'? ' active ' : ''}}">
                                    <a href="{{ route('obat') }}"><i class="material-icons" style="margin-top:-2px;margin-right:7px">link</i> Obat-obatan</a>
                                </li>
                            @endrole
                            @role(['admin', 'laborant'])   
                                <li class="{{ $firstsegment[1] == 'lab'? ' active ' : ''}}">
                                    <a href="{{ route('lab') }}"><i class="material-icons" style="margin-top:-2px;margin-right:7px">link</i> Laboratorium</a>
                                </li>
                            @endrole
                             @role(['admin', 'cashier'])   
                                <li class="{{ $firstsegment[1] == 'price'? ' active ' : ''}}">
                                    <a href="{{ route('price') }}"><i class="material-icons" style="margin-top:-2px;margin-right:7px">link</i> Harga Pelayanan</a>
                                </li>
                            @endrole
                        </ul>
                    </li>
                    @endrole
                    @role(['admin', 'operator'])   
                    <li class="{{ $firstsegment[1] == 'users'? ' active ' : ''}}">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">account_circle</i>
                            <span>User Management</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="{{ $firstsegment[1] == 'users'? ' active ' : ''}}">
                                <a href="{{ route('users') }}"><i class="material-icons" style="margin-top:-2px;margin-right:7px">link</i> Users</a>
                            </li>
                        </ul>
                    </li>   
                    @endrole                
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <?php /*<div class="legal">
                <div class="copyright">
                    &copy; 2016 - 2017 <a href="javascript:void(0);">Rajonet Indonesia</a>.
                </div>
                <!--<div class="version">
                    <b>Version: </b> 1.0.5
                </div>-->
            </div> */ ?>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red" class="active">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>GENERAL SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Report Panel Usage</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Email Redirect</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>SYSTEM SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Notifications</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Auto Updates</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                        <p>ACCOUNT SETTINGS</p>
                        <ul class="setting-list">
                            <li>
                                <span>Offline</span>
                                <div class="switch">
                                    <label><input type="checkbox"><span class="lever"></span></label>
                                </div>
                            </li>
                            <li>
                                <span>Location Permission</span>
                                <div class="switch">
                                    <label><input type="checkbox" checked><span class="lever"></span></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>