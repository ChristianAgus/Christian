@extends('layouts.office')
@section('title', "CMS My Haldin")
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="content">
    <div class="row">
        <div class="col-12 col-xs-3">
            <div class="block block-content">
                <div class="nav nav-pills push">
                    <li class="nav-item">
                        <a href="{{ route('getMsReservationMobil', 'Pending') }}" class="nav-link {{ request()->is('Car-Reservation/data/Pending') ? 'active' : '' }}">
                            <i class="fa fa-clock mr-2"></i>Pending
                            <span class="badge badge-warning">

                            @if(Auth::user()->id != 106)
                                {{ App\MsReservationMobil::where('status', 'pending')->where('user_id', Auth::user()->id)->count() }}
                            @else
                                {{ App\MsReservationMobil::where('status', 'pending')->count() }}
                            @endif
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('getMsReservationMobil', 'Unapproved') }}" class="nav-link {{ request()->is('Car-Reservation/data/Unapproved') ? 'active' : '' }}">
                            <i class="fa fa-times mr-2"></i>Unapproved
                            <span class="badge badge-danger">
                            @if(Auth::user()->id != 106)
                            {{ App\MsReservationMobil::where('status', 'Unapproved')->where('user_id', Auth::user()->id)->count() }}
                        @else
                            {{ App\MsReservationMobil::where('status', 'Unapproved')->count() }}
                        @endif
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('getMsReservationMobil', 'Approved') }}" class="nav-link {{ request()->is('Car-Reservation/data/Approved') ? 'active' : '' }}">
                            <i class="fa fa-check mr-2"></i>Approved
                            <span class="badge badge-success">
                            @if(Auth::user()->id != 106)
                            {{ App\MsReservationMobil::where('status', 'Approved')->where('user_id', Auth::user()->id)->count() }}
                        @else
                            {{ App\MsReservationMobil::where('status', 'Approved')->count() }}
                        @endif
                            </span>
                        </a>
                    </li>
                    @if(Auth::user()->id == 106)
                        <li class="nav-item">
                            <a href="{{ route('CRReport') }}" class="nav-link {{ request()->is('Car-Reservation/CR-Report') ? 'active' : '' }}">
                                <i class="fa fa-star mr-2"></i>Report
                            </a>
                        </li>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="block block-themed">
        <div class="block" id="blok1">
            <div class="block-content block-content-full">
                <div class="block-header p-0 mb-20">
                    <div class="block-title1">
                    <button type="button" data-toggle="modal" data-target="#addReq" class="btn btn-primary btn-square mr-2"><i class="fa fa-registered mr-2"></i>Request Reservasi Car</button>
                    </div>
                </div>
                <div class="table table-responsive">
                    <table class="table table-bordered table-vcenter" id="dataTable" style="background-color: #fff;width:100%">
                        <thead>
                            <th>Name</th>
                            <th>Reservasi From</th>
                            <th>Reservasi To</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>
            </div> 
        </div> 
    </div>
</div>

<div class="modal fade" id="addReq" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-gd-sea p-10">
                    <h3 class="block-title"><i class="fa fa-registered mr-2"></i>Request Reservasi Mobil</h3>
                </div>
            </div>
            <form method="post" action="{{ route('add.reservation') }}" id="test">
                {{ csrf_field() }}
                <div class="block-content">
                    <div id="alert3" class="alert alert-info" style="display:none;"></div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                    <div class="input-group-append">
                                       <span class="input-group-text" title="User"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input class="form-control"  value="{{ Auth::user()->name }}" readonly >
                             </div>  
                        </div>
                        <div class="form-group col-md-6">
                             <div class="input-group">
                                 <div class="input-group-append">
                                  <span class="input-group-text" title="Departemen"><i class="fa fa-building"></i></span>
                                 </div>
                                  <input type="text" class="form-control depart" id="addDepart" name="department" maxlength="20" required readonly>
                             </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Company<span style="color: blue;"> *</span></label>
                                <select class="form-control" id="addCompany" name="company" required>
                                    <option value="" disabled selected>Please select</option>
                                    <option value="Haldin">Haldin</option>
                                    <option value="Talasi">Talasi</option>
                                    <option value="Toya">Toya</option>
                                    
                                </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Cost Center<span style="color: blue;"> *</span></label>
                            <select class="form-control js-select2-company" style="width:100%;" id="costcenter" name="cost_center" required>
                                <option value="" disabled selected>--Pilih Cost Center--</option>
                                @foreach(App\MsCostCenter::orderBy('name', "ASC")->get() as $data)
                                <option value="{{ $data->code }}">{{ $data->name }} - {{ $data->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>reservation from date<span style="color: blue;"> *</span></label>
                            <input type="date" class="form-control Tanggalfrom" id="addTanggalfrom" name="date_from"required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Start Time<span style="color: blue;"> *</span></label>
                                    <select class="form-control js-select2 ftimefromadd" name="time_from" style="width:100%;" required>
                                        <option value="" disabled selected>Please select start time to reservation car</option>
                                        <?php
                                        $start_time = strtotime('00:00');
                                        $end_time = strtotime('23:00');
                                        $interval = 30 * 60; 

                                        while ($start_time <= $end_time) {
                                            $jam = date('H:i', $start_time);
                                            echo "<option value=\"$jam\">$jam</option>";
                                            $start_time += $interval;
                                        }
                                        ?>
                                    </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>reservation to date<span style="color: blue;"> *</span></label>
                            <input type="date" class="form-control Tanggalto" id="addTanggalTo" name="date_to"required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>End Time<span style="color: blue;"> *</span></label>
                                    <select class="form-control js-select2 ftimetoadd" name="time_to" style="width:100%;" required>
                                        <option value="" disabled selected>Please select end time to reservation car</option>
                                        <?php
                                        $start_time = strtotime('00:00');
                                        $end_time = strtotime('23:00');
                                        $interval = 30 * 60; 

                                        while ($start_time <= $end_time) {
                                            $jam = date('H:i', $start_time);
                                            echo "<option value=\"$jam\">$jam</option>";
                                            $start_time += $interval;
                                        }
                                        ?>
                                    </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Plant<span style="color: blue;"> *</span></label>
                                <select class="form-control" id="addplant" name="plant" required>
                                    <option value="" disabled selected>Please select</option>
                                    <option value="Cibitung">Cibitung</option>
                                    <option value="Cikarang">Cikarang</option>
                                    <option value="Setu">Setu</option>
                                    <option value="Bella Tera">Bella Tera</option>
                                    <option value="Menteng">Menteng</option>
                                    <option value="sentul">Sentul</option>
                                </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Destination<span style="color: blue;"> *</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control destination" placeholder="Tempat tujuan / Daerah Tujuan"  id="addDesteny" name="destination" required maxlength="20" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="height: 100%;"><i class="fas fa fa-window-restore"></i></span>
                                </div>
                                <textarea class="form-control" name="description"   placeholder="Tujuan Kunjungan Or Description *" required></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="height: 100%;"><i class="fas fa fa-archive"></i></span>
                                </div>
                                <textarea class="form-control load" name="car_load" id="addCarLoad"  placeholder="Car load : Jelaskan kendaraan yang dibutuhkan. Ex Butuh mobil untuk 5 orang atau muat barang ukuran 30*30 *" required></textarea>
                            </div>
                        </div>
                        <input type="text" value="pending" class="form-control status" id="addstatus" name="status" style="display: none;">
                        <input style="display: none;" name="user_id" value="{{ Auth::user()->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-alt-primary" id="htmlbtn">Submit</button>
                    <button type="button" style="display:none;" class="btn btn-alt-primary" id="progbtn"><i class="fa fa-spinner fa-spin"></i></button>
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editReq" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-gd-sea p-10">
                    <h3 class="block-title"><i class="fa fa-file-text-o mr-2"></i>Edit Reservasi Mobil </h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
            </div>
            <form method="post" autocomplete="off" action="{{ route('edit.reservation') }}"  id="test1">
                {!! csrf_field() !!}
                @method('PUT')
                <div class="block-content">
                    <input type="hidden" name="id" class="docID">
                    <div class="row">
                        <div class="form-group col-md-6">
                          <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input class="form-control"  value="{{ Auth::user()->name }}" readonly disabled>
                        </div>  
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-building"></i></span>
                            </div>
                            <input type="text" class="form-control depart" id="editDepart"  name="department" maxlength="20" required readonly>
                        </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Company<span style="color: blue;"> *</span></label>
                                <select class="form-control" id="editCompany" name="company" required>
                                    <option value="" disabled selected>Please select</option>
                                    <option value="Haldin">Haldin</option>
                                    <option value="Talasi">Talasi</option>
                                    <option value="Toya">Toya</option>
                                    
                                </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Cost Center<span style="color: blue;"> *</span></label>
                            <select class="form-control js-select2-company1" style="width:100%;" id="editcostcenter" name="cost_center" required>
                                <option value="" disabled selected>--Pilih Cost Center--</option>
                                @foreach(App\MsCostCenter::orderBy('name', "ASC")->get() as $data)
                                <option value="{{ $data->code }}">{{ $data->name }} - {{ $data->code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>reservation from date<span style="color: blue;"> *</span></label>
                            <input type="date" class="form-control Tanggalfrom" id="editTanggalfrom" name="date_from"required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Start Time<span style="color: blue;"> *</span></label>
                                    <select class="form-control js-select2 ftimefromedit" id="editTimefrom" name="time_from" style="width:100%;" required>
                                        <option value="" disabled selected>Please select start time to reservation car</option>
                                        <?php
                                        $start_time = strtotime('00:00');
                                        $end_time = strtotime('23:00');
                                        $interval = 30 * 60; 

                                        while ($start_time <= $end_time) {
                                            $jam = date('H:i', $start_time);
                                            echo "<option value=\"$jam\">$jam</option>";
                                            $start_time += $interval;
                                        }
                                        ?>
                                    </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>reservation to date<span style="color: blue;"> *</span></label>
                            <input type="date" class="form-control Tanggalto" id="editTanggalTo" name="date_to"required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>End Time<span style="color: blue;"> *</span></label>
                                <div class="input-group">
                                    <select class="form-control js-select2 ftimetoedit" id="editTimeto" name="time_to" style="width:100%;" required>
                                        <option value="" disabled selected>Please select end time to reservation car</option>
                                        <?php
                                        $start_time = strtotime('00:00');
                                        $end_time = strtotime('23:00');
                                        $interval = 30 * 60; 

                                        while ($start_time <= $end_time) {
                                            $jam = date('H:i', $start_time);
                                            echo "<option value=\"$jam\">$jam</option>";
                                            $start_time += $interval;
                                        }
                                        ?>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Plant<span style="color: blue;"> *</span></label>
                                <select class="form-control" id="editPlant" name="plant" required>
                                    <option value="" disabled selected>Please select</option>
                                    <option value="Cibitung">Cibitung</option>
                                    <option value="Cikarang">Cikarang</option>
                                    <option value="Setu">Setu</option>
                                    <option value="Cibitung">Cibitung</option>
                                    <option value="Bella Tera">Bella Tera</option>
                                    <option value="Menteng">Menteng</option>
                                    <option value="sentul">Sentul</option>
                                </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Destination<span style="color: blue;"> *</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control destination"  id="editDestination" name="destination" required maxlength="20" required>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="height: 100%;"><i class="fas fa fa-window-restore"></i></span>
                                </div>
                                <textarea class="form-control" id="editDescription" name="description"  placeholder="Tujuan Kunjungan Or Description *" required></textarea>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="height: 100%;"><i class="fas fa fa-archive"></i></span>
                                </div>
                                <textarea class="form-control load" name="car_load" id="editCarLoad"  placeholder="Car load : Jelaskan kendaraan yang dibutuhkan. Ex Butuh mobil untuk 5 orang atau muat barang ukuran 30*30 *" required></textarea>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-alt-primary" id="btnSubmit1">Save</button>
                <button type="button" style="display:none;" class="btn btn-alt-primary" id="btnLoading1"><i class="fa fa-spinner fa-spin"></i></button>
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailreservation" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-gd-sea p-10">
                    <h3 class="block-title"><i class="fa fa-users mr-2"></i>Data Reservation</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="background: #f0f0f1;">
                        <th>Department</th>
                        <th>Time Reservation</th>
                        <th>Cost Center</th>
                        <th>Destination</th>
                        <th>Car Load</th>
                        <th>Feedback</th>
                    </thead>
                    <tbody id="list">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



@endsection


@section('css')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
<style>
    @media (max-width: 768px) {
        /* Styling for mobile */
        .input-group select {
            width: 100%; /* Set the select element to full width */
        }
    }
</style>
@endsection

@section('script')
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/select2-handler.js') }}"></script>
<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
       $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(".js-select2-company").select2({
                minimumInputLength: 2,
                allowClear: true,
                dropdownParent: $('#addReq .modal-content'),
                placeholder: "Find data min 2 character or numeric"
            });
            $(".js-select2-company1").select2({
                minimumInputLength: 2,
                allowClear: true,
                dropdownParent: $('#editReq .modal-content'),
                placeholder: "Find data min 2 character or numeric"
            });
            var userId = $('input[name="user_id"]').val();

            var currentURL = window.location.href;

            var pendingURL = "{{ route('getMsReservationMobil', 'Pending') }}";

            if (currentURL === pendingURL) {
                $(".block-title1").html('<button type="button" data-toggle="modal" data-target="#addReq" class="btn btn-primary btn-square mr-2"><i class="fa fa-registered mr-2"></i>Request Reservasi Car</button>');
            } else {
                $(".block-title1").html('');
            }

            $.ajax({
                url: '/Car-Reservation/url_get_deapt/' + userId, 
                method: 'GET',
                success: function(response) {
                    $('#addDepart').val(response.divisi);
                }
            });
            $('.Tanggalfrom').attr('min', new Date().toISOString().split('T')[0]);
            $('.Tanggalfrom').change(function() {
                var fromDate = new Date($(this).val());
                var toDateInput = $('.Tanggalto');
                toDateInput.attr('min', $(this).val());
                var toDate = new Date(toDateInput.val());
                if (toDate < fromDate) {
                    toDateInput.val($(this).val());
                }
            });
            $('.ftimefromadd').select2({
             dropdownParent: $('#addReq')
            });
            $('.ftimetoadd').select2({
             dropdownParent: $('#addReq')
            });
            $('.ftimefromedit').select2({
             dropdownParent: $('#editReq')
            });
            $('.ftimetoedit').select2({
             dropdownParent: $('#editReq')
            });
            $('.delete-btn').click(function() {
            var brandId = $(this).data('id');
            $.ajax({
                url: 'delete',
                type: 'DELETE',
                success: function(response) {
                    console.log(response);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
            });
          $("#dataTable").DataTable({
                drawCallback: function(){
                    $('.delete-btn').on('click', function(){
                        var routers = $(this).data("url");
                        swal({
                            title: 'Anda Yakin?',
                            text: 'Data yang dihapus tidak dapat dikembalikan lagi!',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d26a5c',
                            confirmButtonText: 'Iya, hapus!',
                            html: false,
                            preConfirm: function() {
                                return new Promise(function (resolve) {
                                    setTimeout(function () {
                                        resolve();
                                    }, 50);
                                });
                            }
                        }).then(function(result){
                            if (result.value) {
                                $.ajax({
                                    url: routers,
                                    type: 'GET',
                                    success: function (data) {
                                        $("#dataTable").DataTable().ajax.reload();
                                    }, error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                        alert(errorThrown);
                                    },    
                                    cache: false,
                                    contentType: false,
                                    processData: false
                                });
                            } else if (result.dismiss === 'cancel') {
                                swal('Cancelled', 'Your data is safe :)', 'error');
                                        }
                                    });
                                });
                               $('.js-swal-delete2').on('click', function () {
                                var button = $(this);
                                var id = button.data("id");
                                var status = button.data("status");
                                var statusSelected = false;
                                var dateFrom = button.data("datefrom");
                                var dateTo = button.data("dateto");
                                if ({{ Auth::user()->id }} === 106) {
                                swal({
                                    title: 'Change Status',
                                    text: 'Select the new status:',
                                    type: 'info',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d26a5c',
                                    confirmButtonText: 'Next',
                                    cancelButtonText: 'Cancel',
                                    html: '<select id="statusSelect" class="form-control">' +
                                        '<option value="" disabled selected>Please select</option>' +
                                        '<option value="Approved">Approved</option>' +
                                        '<option value="Unapproved">Unapproved</option>' +
                                        '</select>',
                                    preConfirm: function () {
                                        statusSelected = true;
                                    }
                                }).then(function () {
                                    if (statusSelected) {
                                        var newStatus = $('#statusSelect').val();
                                        var dataToSend = {
                                            _method: 'PUT',
                                            status: newStatus,
                                            id: id
                                        };

                                        if (newStatus === 'Approved') {
                                            swal({
                                                title: 'Change Status',
                                                text: 'Enter additional information:',
                                                type: 'info',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d26a5c',
                                                confirmButtonText: 'Submit',
                                                cancelButtonText: 'Cancel',
                                                html: '<label>Konfirmasi Tanggal<span style="color: blue;"> *</span></label>' +
                                                    '<input id="FromInput" type="date" class="form-control" value="' + dateFrom + '">' +
                                                    ' <small class="form-text text-muted">Jika diperlukan, masukkan tanggal baru pada bagian Reservasi From.<span style="color: blue;"> *</span></small>' +
                                                    '<br>' + '<label>Sampai Tanggal<span style="color: blue;"> *</span></label>' +
                                                    '<input id="ToInput" type="date" class="form-control" value="' + dateTo + '">' +
                                                    ' <small class="form-text text-muted">Jika diperlukan, masukkan tanggal baru pada bagian Reservasi To.<span style="color: blue;"> *</span></small>' +
                                                    '<br>' +
                                                    '<textarea id="feedbackInput" class="form-control"  placeholder="Feedback"></textarea>',
                                                preConfirm: function () {
                                                    dataToSend.date_from = $('#FromInput').val();
                                                    dataToSend.date_to = $('#ToInput').val();
                                                    dataToSend.feedback = $('#feedbackInput').val();

                                                    $.ajax({
                                                        url: '/Car-Reservation/update-reservation-details', 
                                                        method: 'PUT',
                                                        data: dataToSend,
                                                        success: function (response) {
                                                            $("#dataTable").DataTable().ajax.reload();
                                                            swal("Success", response.message, "success");
                                                        },
                                                        error: function (error) {
                                                            swal("Error", "An error occurred while updating reservation details.", "error");
                                                        }
                                                    });
                                                }
                                            });
                                        } else if (newStatus === 'Unapproved') {
                                            swal({
                                                title: 'Change Status',
                                                text: 'Enter feedback:',
                                                type: 'info',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d26a5c',
                                                confirmButtonText: 'Submit',
                                                cancelButtonText: 'Cancel',
                                                html:  '<input style="display: none;" id="FromInput" type="date" class="form-control" value="' + dateFrom + '">' +
                                                    '<input style="display: none;" id="ToInput" type="date" class="form-control" value="' + dateTo + '">' +
                                                    '<textarea id="feedbackInput" class="form-control" placeholder="Feedback"></textarea>',
                                                preConfirm: function () {
                                                    dataToSend.date_from = $('#FromInput').val();
                                                    dataToSend.date_to = $('#ToInput').val(); 
                                                    dataToSend.feedback = $('#feedbackInput').val();

                                                    $.ajax({
                                                        url: '/Car-Reservation/update-reservation-details', 
                                                        method: 'PUT',
                                                        data: dataToSend,
                                                        success: function (response) {
                                                            $('#dataTable').DataTable().ajax.reload();
                                                            swal("Success", response.message, "success");
                                                        },
                                                        error: function (error) {
                                                            swal("Error", "An error occurred while updating reservation details.", "error");
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    }
                                });
                            } else {
                                    swal("Unauthorized", "You do not have permission to perform this action.", "error");
                                }
                            });
                            },
                            scrollX: true,
                            processing: true,
                            serverSide: true,
                            ajax: "{{ route('getMsReservationMobil', $status) }}",
                            columns: [
                            { data: 'user_id', name: 'user_id' },
                            { data: 'date_from', name: 'date_from' },
                            { data: 'date_to', name: 'date_to' },
                            { data: 'description', name: 'description' },
                            { data: 'operations', name: 'operations' },
                            { data: 'action', name: 'action' }
                        ],
                    });
                });
                function openDetailModal(data) {
                    $('#detailreservation').modal('show');
                    $('#list').html(`
                        <tr>
                            <td>${data.department}</td>
                            <td>${data.time_from} - ${data.time_to} </td>
                            <td>${data.company}<br>${data.cost_center}</td>
                            <td>${data.destination}</td>
                            <td>${data.car_load}</td>
                            <td>${data.feedback}</td>
                        </tr>
                    `);
                }
                $(document).on('submit', '#test', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var data = new FormData(form[0]);
                var inputValues = {};
                form.find('input, select, textarea').each(function() {
                    inputValues[$(this).attr('name')] = $(this).val();
                });
                $.ajax({
                    url: url,
                    type: method,
                    data: data,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.btn-alt-primary').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan');
                    },
                    success: function(response) {
                        console.log(response);
                        $('#addReq').modal('hide');
                        $('#dataTable').DataTable().ajax.reload();
                        form.find('input, select, textarea').each(function() {
                            var name = $(this).attr('name');
                            if (inputValues.hasOwnProperty(name)) {
                                $(this).val(inputValues[name]);
                            }
                        });
                        $('.btn-alt-primary').attr('disabled', false).html('Add');
                        Swal.fire({
                            title: 'Sukses',
                            text: 'Data berhasil ditambahkan.',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        console.log(err);
                        
                        if (err.errors && err.errors.title) {
                            var errorMessage = err.errors.title[0];
                            Swal.fire({
                                title: 'Warning',
                                text: errorMessage,
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else if (err.errors && err.errors.file) {
                            var errorMessage = err.errors.file[0];
                            Swal.fire({
                                title: 'Warning',
                                text: errorMessage,
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            Swal.fire({
                                title: 'Warning',
                                text: 'Terjadi kesalahan.',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                        $('.btn-primary').attr('disabled', false).html('Add');
                    }
                });
            });
            function editReq1(json) {
            $('#editReq').modal('show');
            $('.docID').val(json.id);
            $('#editTanggalfrom').val(json.date_from);
            $('#editTanggalTo').val(json.date_to);
            $('#editTimefrom').val(json.time_from).trigger('change');
            $('#editTimeto').val(json.time_to).trigger('change');
            $('#editCompany').val(json.company).trigger('change');
            $('#editcostcenter').val(json.cost_center).trigger('change');
            $('#editTimeto').val(json.time_to);
            $('#editPlant').val(json.plant);
            $('#editDestination').val(json.destination);
            $('#editDescription').val(json.description);
            $('#editCarLoad').val(json.car_load);
            $('#editDepart').val(json.department);
            }
                    $("#test1").submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $("#btnLoading1").show();
                    $("#btnSubmit1").hide();
                    $("#alert1").removeClass('alert alert-danger');
                    $("#alert1").removeClass('alert alert-primary');
                    $("#alert1").html('');
                    $("#alert1").hide();
                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        success: function(data) {
                            console.log(data.type);
                            $("#btnSubmit1").show();
                            $("#btnLoading1").hide();
                            if (data.type == "info") {
                                $("#alert1").addClass('alert alert-primary');
                                $("#alert1").show();
                                $("#alert1").html(data.message);
                                $("#editReq").animate({scrollTop: $("#editReq").offset().top});
                                $("#editReq").modal('hide');
                                $("#dataTable").DataTable().ajax.reload();
                            } else {
                                $("#editReq").animate({scrollTop: $("#editReq").offset().top});
                                $("#alert1").addClass('alert alert-danger');
                                $("#alert1").show();
                                $("#alert1").html(data.message);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            $("#editReq").animate({scrollTop: $("#editReq").offset().top});
                            $("#alert1").addClass('alert alert-danger');
                            $("#alert1").show();
                            $("#alert1").html("<i class='em em-email mr-2'></i>" + xhr.responseText);
                            
                            $("#btnSubmit1").show();
                            $("#btnLoading1").hide();
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                });
</script>
@endsection