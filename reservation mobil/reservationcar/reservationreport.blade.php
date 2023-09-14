@extends('layouts.office')
@section('title', "Reservation Report")
@section('content')
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
            <div class="block">
             <div class="block-content block-content-full form-inline">
                <form  class="form-inline" method="post" id="filter" autocomplete="off">
                    {!! csrf_field() !!}
                    <div class="input-daterange input-group" data-date-format="yyyy-mm-dd" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        <input type="text" class="form-control mb-2 mb-sm-0" id="example-daterange1" name="from" placeholder="Date From" data-week-start="1" data-autoclose="true" data-today-highlight="true" required>
                        <div class="input-group-prepend input-group-append">
                            <span class="input-group-text font-w600">to</span>
                        </div>
                        <input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="example-daterange2" name="to" placeholder="Date To" data-week-start="1" data-autoclose="true" data-today-highlight="true" required>
                    </div>
                    <button type="submit" class="btn btn-alt-primary mr-2"><i class="fa fa-recycle mr-2"></i>Filter</button>
                </form>
                <form method="post" action="{{ route('CRReportExcel') }}" autocomplete="off">
                    {!! csrf_field() !!}
                    <input type="hidden" id="fromExcel" name="fromExcel">
                    <input type="hidden" id="toExcel" name="toExcel">
                    <input type="hidden" id="accExcel" name="account">
                    <button type="submit" class="btn btn-alt-success mr-2"><i class="fa fa-cloud-download mr-2"></i>Excel</button>
                    <input type="button" id="filterReset" class="btn btn-alt-secondary" value="Reset"/>
                </form>
            </div>
        </div>

    <div class="block block-themed" id="table-block" style="display: none">
        <div class="block">        
            <div class="block-content block-content-full">
            <table class="table table-bordered table-vcenter" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width:110px;">Name Reservation</th>
                            <th style="width:220px;">Destination & Date</th>
                            <th style="width:190px;">Deskripsi</th>
                            <th style="width:190px;">Car Load</th>
                            <th style="width:190px;">Feedback</th>
                        </tr>
                    </thead>
                </table>
                </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection


@section('script')
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script>jQuery(function(){ Codebase.helpers(['datepicker']); });</script>
<script>
    $(document).ready(function() { 
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    $("#example-daterange1").change(function(){
        var from = $('#example-daterange1').val();
        $('#fromExcel').val(from);
    });
    $("#example-daterange2").change(function(){
        var to = $('#example-daterange2').val();
        $('#toExcel').val(to);
    });
  

    $("#filterReset").click(function () {
        $('#example-daterange1').val(null);
        $('#example-daterange2').val(null);
    });
    $('#filter').submit(function(e) {
        $('#table-block').hide();
        e.preventDefault();
        var table = null;
        var url = '{!! route('CRReportPOST') !!}';
        table = $('#dataTable').DataTable({
            processing: true,
            ajax: {
                url: url + "?" + $("#filter").serialize(),
                type: 'POST',
                dataType: 'json',
                dataSrc: function(res) {
                    $('#table-block').show();
                    return res.data;
                },error: function (data) {
                    $('#table-block').hide();
                },
            },
            columns: [
                { data: 'name', name: 'name'},
                { data: 'destination', name: 'destination'},
                { data: 'description', name: 'description'},
                { data: 'car_load', name: 'car_load'},
                { data: 'feedback', name: 'feedback'}
            ],
            bDestroy: true
        });
    });
</script>
@endsection