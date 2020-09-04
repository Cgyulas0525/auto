<?php
use App\Classes\CarCost;

$veg   = date('Y-m-d', strtotime('now'));
$kezdo = date('Y-m-d', strtotime('first day of january 2016'));
$ntv = CarCost::getEgyAutoKoltsegIdoszakOsszesen($kezdo, $veg, 1);
$rvp = CarCost::getEgyAutoKoltsegIdoszakOsszesen($kezdo, $veg, 3);
$rxe = CarCost::getEgyAutoKoltsegIdoszakOsszesen($kezdo, $veg, 4);
$nes = CarCost::getEgyAutoKoltsegIdoszakOsszesen($kezdo, $veg, 5);

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
        <h1 class="pull-left">Költségek autónként</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="panel-body">
            <form id="search-form" class="form-inline">
                <div class="form-group text-center">
                    <label for="title">Autó:</label>
                    {!! Form::select('rendszam', [""] + \App\Models\Car::get()->sortby('rendszam')->pluck('rendszam', 'rendszam')->toArray(), null,['class'=>'select2 form-control', 'id' => 'rendszam', 'style=width:180px']) !!}
                    <button type="submit" class="btn btn-primary" title="Szűrés" ><i class="fa  fa-filter"></i></button>
                </div>
            </form>
        </div>


        @include('flash::message')
        <div class="col-lg-6 col-md-12 col-xs-12">
            <div class="clearfix"></div>
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered car-table">
                          <thead>
                              <tr>
                                  <th>Rendszám</th>
                                  <th>Költség típus</th>
                                  <th>Költség</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                              <tr>
                                  <th></th>
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
                <p class="highcharts-description">
                </p>
                <button id="plain">Egyszerű</button>
                <button id="inverted">Inverz</button>
                <button id="polar">Poláris</button>
            </figure>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    @include('layouts.highcharts_js')
    <script src="http://priestago.hu/auto/public/js/hscolumn.js"></script>
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
                scrollY: 400,
                order: [[0, 'asc'], [1, 'asc']],
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

                ajax: "{{ route('autokoltseg.index') }}",
                columns: [
                    {data: 'rendszam', name: 'rendszam'},
                    {data: 'ktg', orderable: false, name: 'ktg'},
                    {data: 'sum', render: $.fn.dataTable.render.number( '.', ',', 0), sClass: "text-right", orderable: false, searchable: false, name: 'sum'},
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
                    total = api.column( 2 ).data().sum();
                    // Total over this page
                    pageTotal = api.column( 2, {page:'current'} ).data().sum();
                    // Update footer
                    $( api.column( 2 ).footer() ).html(
                        'Összesen: '+ currencyFormatDE(pageTotal)
                    );
                },

            });

            $('#search-form').on('submit', function(e) {
                var rendszam = $('#rendszam').val();
                if (rendszam != '0'){
                    oTable.column(0).search(rendszam).draw();
                    if (rendszam == 'NTV495'){
                        chartUpdate(ktgtipus, 'NTV495 Költségek típusonként', data_ntv);
                    }else if (rendszam == 'RVP859'){
                        chartUpdate(ktgtipus, 'RVP859 Költségek típusonként', data_rvp);
                    }else if (rendszam == 'RXE970'){
                        chartUpdate(ktgtipus, 'RXE970 Költségek típusonként', data_rxe);
                    }else if (rendszam == 'NES893'){
                        chartUpdate(ktgtipus, 'NES893 Költségek típusonként', data_nes);
                    }
                }else {
                    oTable.rows.remove().draw();
                    chartUpdate(ktgtipus, 'Költségek típusonként', data_sum);
                }
                e.preventDefault();
            });

            /* grafikon */
            function tombfeltolt(melyik){
                var tomb = [];
                for (i=0; i < melyik.length; i++){
                    tomb.push(parseInt(melyik[i].osszeg));
                }
                console.log(tomb);
                return tomb;
            }

            var sum = <?php echo $sum; ?>;
            var ntv = <?php echo $ntv; ?>;
            var rvp = <?php echo $rvp; ?>;
            var rxe = <?php echo $rxe; ?>;
            var nes = <?php echo $nes; ?>;

            var kategoria = [];
            for (i=0; i < sum.length; i++){
                kategoria.push(sum[i].nev);
            }
            var data_sum = tombfeltolt(sum);
            var data_ntv = tombfeltolt(ntv);
            var data_rvp = tombfeltolt(rvp);
            var data_rxe = tombfeltolt(rxe);
            var data_nes = tombfeltolt(nes);

            var ktgtipus = HighChartColumn('ktgtipus', 'column', kategoria, data_sum, 600, 25, 'lightgray', 3, 'Költségek típusonként', 'Poláris', ' forint', false, true);

            $('#plain').click(function () {
                combinatedClick( ktgtipus, false, false, 'Egyszerű');
            });

            $('#inverted').click(function () {
                combinatedClick( ktgtipus, true, false, 'Inverz');
            });

            $('#polar').click(function () {
                combinatedClick( ktgtipus, false, true, 'Poláris');
            });
        });
    </script>
@endsection
