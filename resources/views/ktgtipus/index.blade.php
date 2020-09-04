<?php
use App\Classes\CarCost;

$veg   = date('Y-m-d', strtotime('now'));
$kezdo = date('Y-m-d', strtotime('first day of january 2016'));

$sum = CarCost::getTipusOsszKtg($kezdo, $veg);
 ?>


@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
    <link rel="stylesheet" href="http://priestago.hu/auto/public/css/datatables.css">
    <link rel="stylesheet" href="http://priestago.hu/auto/public/css/app.css">
    <link rel="stylesheet" href="http://priestago.hu/auto/public/css/Highcharts.css">
    <link rel="stylesheet" href="http://priestago.hu/auto/public/css/panel.css">
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Költségek költség típusonként</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')

        <div class="clearfix"></div>
        <div class="col-lg-6 col-md-12 col-xs-12">
            <div class="box box-primary">
                <div class="box-body">
                  <div class="table-responsive">
                      <table class="table table-striped table-bordered car-table">
                          <thead>
                              <tr>
                                  <th>Költség típus</th>
                                  <th>Költség</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th></th>
                                  <th>Költség</th>
                              </tr>
                          </tfoot>

                      </table>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-xs-12">
            <figure class="highcharts-figure">
                <div id="ktgtipus"></div>
            </figure>
        </div>

        <div class="text-center">

        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    @include('layouts.highcharts_js')
    <script src="http://priestago.hu/auto/public/js/hspie.js"></script>
    <script src="http://priestago.hu/auto/public/js/combinatedClick.js"></script>
    <script src="http://priestago.hu/auto/public/js/chartupdate.js"></script>
    <script type="text/javascript">

        function currencyFormatDE(num) {
           return (
             num
               .toFixed(0) // always two decimal digits
               .replace('.', ',') // replace decimal point character with ,
               .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
           ) // use . as a separator
         }

        $(function () {

                $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });

                var oTable = $('.car-table').DataTable({
                language: {
                  url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Hungarian.json"
                },
                serverSide: true,
                scrollY: 450,
                order: [[0, 'asc']],
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Mind"]],
                dom: 'B<"clear">lfrtip',
                buttons: [
                        {
                          extend:    'copyHtml5',
                          text:      '<i class="fa fa-files-o"></i>',
                          titleAttr: 'Másolás',
                           exportOptions: {
                               columns: [ ':visible' ]
                           },
                        },

                        {
                            extend: 'csvHtml5',
                            text: '<i class="fa fa-file-code-o"></i>',
                            titleAttr: 'CSV',
                            exportOptions: {
                                columns: [ ':visible' ]
                            },
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fa fa-file-excel-o"></i>',
                            titleAttr: 'Excel',
                            exportOptions: {
                                columns: [ ':visible' ]
                            },
                        },
                        {
                            extend: 'pdfHtml5',
                            text:      '<i class="fa fa-file-pdf-o"></i>',
                            titleAttr: 'PDF',
                            exportOptions: {
                                columns: [ ':visible' ]
                            },
                        }
                    ],

                ajax: "{{ route('ktgtipus.index') }}",
                columns: [
                    {data: 'nev', orderable: false, name: 'nev'},
                    {data: 'osszeg', render: $.fn.dataTable.render.number( '.', ',', 0), sClass: "text-right", orderable: false, searchable: false, name: 'sum'},
                ],

                footerCallback: function ( row, data, start, end, display ) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    // Total over all pages
                    total = api.column( 1 ).data().sum();
                    // Total over this page
                    pageTotal = api.column( 1, {page:'current'} ).data().sum();
                    // Update footer
                    $( api.column( 1 ).footer() ).html(
                        'Összesen: '+ currencyFormatDE(pageTotal)
                    );
                },

            });

            var data_view_sum = <?php echo $sum; ?>;
            var pie_data_sum = [];
            for (i=0; i<data_view_sum.length; i++){
                pie_data_sum.push({name: data_view_sum[i].nev, y: parseInt(Math.round(data_view_sum[i].osszeg).toFixed(0))});
            }
            var ktgtipus = HighChartPie( 'ktgtipus', 'pie', 680, pie_data_sum, 'Költségek', 'Forintban', 'Költség', 400);

            chartSkin(ktgtipus, '#D0E2EA', 25, 'lightgray', 3);
        });
    </script>
@endsection
