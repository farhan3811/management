<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active">
            <a href="#subpage1" data-toggle="tab" style="padding:10px 14px">
                <i class="material-icons">home</i> Booking
            </a>
        </li>
        <li role="presentation">
            <a href="#subpage2" data-toggle="tab" style="padding:10px 14px">
                <i class="material-icons">face</i> Visus
            </a>
        </li>
        <li role="presentation">
            <a href="#subpage4" data-toggle="tab" style="padding:10px 14px">
                <i class="material-icons">voicemail</i> Kacamata
            </a>
        </li>
        <li role="presentation">
            <a href="#subpage3" data-toggle="tab" style="padding:10px 14px">
                <i class="material-icons"> queue_play_next</i> Dokter
            </a>
        </li>
        <li role="presentation">
            <a href="#subpage5" data-toggle="tab" style="padding:10px 14px">
                <i class="material-icons">link</i> Obat
            </a>
        </li>
        <li role="presentation">
            <a href="#subpage6" data-toggle="tab" style="padding:10px 14px">
                <i class="material-icons">insert_invitation</i> Lab
            </a>
        </li>
        <li role="presentation">
            <a href="#subpage7" data-toggle="tab" style="padding:10px 14px">
                <i class="material-icons">remove_red_eye</i> Operasi
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade in active" id="subpage1">
            <b>Booking Content</b>
            <p id="paragraf-booking"></p>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="subpage2">
            <b>Visus Results</b>
            <p id="paragraf-visus"></p>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="subpage3">
            <b>Docter Results</b>
            <p id="paragraf-dokter"></p>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="subpage4">
            <b>Glasses Content</b>
            <p id="paragraf-kacamata"></p>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="subpage5">
            <b>Medicine Content</b>
            <p id="paragraf-obat"></p>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="subpage6">
            <b>Laboratorium Results</b>
            <p id="paragraf-lab"></p>
        </div>
        <div role="tabpanel" class="tab-pane fade" id="subpage7">
            <b>Operation Results</b>
            <p id="paragraf-operation"></p>
        </div>
    </div>         
</div>


<script>
    $.paragraf_booking();
    $.paragraf_visus();
    $.paragraf_dokter();
    $.paragraf_kacamata();
    $.paragraf_obat();
    $.paragraf_lab();
    $.paragraf_operation();
</script>