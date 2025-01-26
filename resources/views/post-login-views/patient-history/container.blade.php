<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding:0">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding-left:0">
        <a href="#modal-applicant-photo" data-toggle="modal" class="thumbnail card" style="margin-bottom:10px">
            <img src="{{ asset('img/default-pp.png') }}" class="img-responsive" style="width:100%" image_download_for_instagram="true">
            <span class="text-center font-12 font-italic col-grey" style="display:block">Klik foto di atas untuk mengganti foto</span>
        </a>
        <div class="card">
            <div class="body bg-pink" style="padding:10px">
                <div class="m-b--35 font-bold" style="border-bottom:solid 1px;text-align:center"><h4>Rekam Medis Pasien</h4></div>
                <ul class="dashboard-stat-list">
                    @foreach ($booking as $databooking)
                        <li class="cursorTab booking-detail"  id="{{ $databooking->code_booking }}">
                           {{ date('l, d M Y', strtotime($databooking->booking_tanggal)) }}
                            <span class="pull-right" style="margin-bottom:3px">
                                <i class="material-icons">check</i>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" style="padding:0">
        <div class="card">
            <div class="header bg-light-blue">
                <div class="row clearfix">
                    <div class="col-xs-12 col-sm-12">
                        <div style="cursor:pointer">
                            <h2 style="float:left"><b>Rekam Medis Pasien: <span id="judul-container"></span></b>
                            
                            <small>Laman ini berisi data informasi pasien</small>
                            </h2>
                        </div>
                    </div>
                </div>

                <ul class="header-dropdown m-r--5">
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a id="link-print" target="_blank">Print</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="body">
                <div class="row" id="container-detail-booking">
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $.identity();
</script>