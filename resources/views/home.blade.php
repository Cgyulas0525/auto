<?php
use App\Classes\CarCost;
use App\Models\Account;

$results = CarCost::getKoltseg();
foreach ($results as $result) {
    $result->osszeg = number_format ( $result->osszeg, 0, ",", "." );
    $arr = array(' ', $result->hatter);
    $result->hatter = join(" ", $arr);
    $picarr = array('public/img/', $result->kep);
    $result->kep = join("", $picarr);
}

$veg   = date('Y-m-d', strtotime('now'));
$kezdo = date('Y-m-d', strtotime('first day of january 2016'));
$ktgtipusmind = CarCost::getEvHonapKtgMindenTipus($kezdo, $veg);

$ktgautomind = CarCost::getKtgAuto($kezdo, $veg);

$frktgs = CarCost::getEvHonapKtgMindenAuto($kezdo, $veg);
$szamlak = Account::SzamlakIdoszak($kezdo, $veg, 10);
foreach ($szamlak as $szamla) {
    $szamla->osszeg = number_format ( $szamla->osszeg, 0, ",", "." );
}
 ?>
 @extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="http://priestago.hu/auto/public/css/datatables.css">
    <link rel="stylesheet" href="http://priestago.hu/auto/public/css/app.css">
    <link rel="stylesheet" href="http://priestago.hu/auto/public/css/Highcharts.css">
    <link rel="stylesheet" href="http://priestago.hu/auto/public/css/panel.css">
@endsection

@section('content')

    @include('layouts.header')
    <!-- Main content -->
    <section class="content">
    <!-- Small boxes (Stat box) -->
        <div class="row">
            @foreach ($results as $result)
                <div class="col-lg-3 col-xs-12">
                    <!-- small box -->
                    <div class="small-box{{$result->hatter}}">
                    <a href="{{ url( $result->karbantarto ) }}"</a>
                    <img src={{$result->kep}} style="width:250px; height:250px">
                    <div class="inner">
                        <p><font color="white">
                        <h3>{{ $result->rendszam }}</h3>
                        <p><h3>{{ $result->osszeg }} Ft.</h3></p>
                        </font></p>
                    </div>
                    <a href="{{ url($result->karbantarto) }}" class="small-box-footer">Tovább <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-xs-12">
                <figure class="highcharts-figure">
                    <div id="ktgtipusmind"></div>
                </figure>
            </div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <figure class="highcharts-figure">
                    <div id="ktgautomind"></div>
                    <p class="highcharts-description">
                    </p>
                    <button id="plain">Egyszerű</button>
                    <button id="inverted">Inverz</button>
                    <button id="polar">Poláris</button>
                </figure>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-xs-12">
                <figure class="highcharts-figure">
                    <div id="ktgautoevho"></div>
                </figure>
            </div>
            <div class="col-lg-6 col-md-12 col-xs-12">
                <h3><p class="text-center"><strong>Az utolsó 10 számla</strong></h3>
                <div class="table-responsive" >
                    <a href="{{ url('/accounts/index') }}"</a>
                    <table class="table" id="visits-table">
                        <thead>
                            <tr>
                                <th>Dátum</th>
                                <th>Autó</th>
                                <th style="text-align: right">Összeg</th>
                                <th>Költség típus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($szamlak as $szamla)
                            <tr>
                                <td>{!! $szamla->datum !!}</td>
                                <td>{!! $szamla->rendszam !!}</td>
                                <td style="text-align: right">{!! $szamla->osszeg !!} Ft.</td>
                                <td>{!! $szamla->ktg  !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
  @include('layouts.dashboard_js')
  @include('layouts.highcharts_js')
  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="http://priestago.hu/auto/public/js/hscolumn.js"></script>
  <script src="http://priestago.hu/auto/public/js/hspie.js"></script>
  <script src="http://priestago.hu/auto/public/js/hsarea.js"></script>
  <script src="http://priestago.hu/auto/public/js/hsline.js"></script>
  <script src="http://priestago.hu/auto/public/js/combinatedClick.js"></script>
  <script src="http://priestago.hu/auto/public/js/chartupdate.js"></script>
  <script type="text/javascript">
      $(function () {

          function kategoriafeltolt(data_viewer) {
              var strev;
              var van;
              var kategoria = [];
              for (i = 0; i < data_viewer.length; i++ ){
                  strev = data_viewer[i].month;
                  if (i == 0){
                      kategoria.push(strev);
                  }else{
                      van = 0;
                      for (j = 0; j < kategoria.length; j++){
                          if ( kategoria[j] == strev){
                              van = 1;
                          }
                      }
                      if (van == 0){
                          kategoria.push(strev);
                      }
                  }
              }
              return kategoria;
          }

          function tipusfeltolt(data_viewer) {
              var tipustomb = [];
              var elemtipus;
              for (i=0; i < data_viewer.length; i++){
                  elemtipus = data_viewer[i].tipus;
                  if (i == 0){
                      tipustomb.push(elemtipus);
                  }else{
                      van = 0;
                      for (j = 0; j < tipustomb.length; j++){
                          if ( tipustomb[j] == elemtipus){
                              van = 1;
                          }
                      }
                      if (van == 0){
                          tipustomb.push(elemtipus);
                      }
                  }
              }
              return tipustomb;
          }

          function osszegfeltolt(tipustomb, kategoria, data_viewer) {
              var elemtomb = [];
              var strev;
              var data_view = [];
              for (j=0; j<tipustomb.length; j++) {
                  elemtomb = [];
                  for (i=0; i<kategoria.length; i++){
                      elemtomb.push(0);
                  }
                  for (i=0; i < data_viewer.length; i++){
                      if (tipustomb[j] == data_viewer[i].tipus){
                          strev = data_viewer[i].month;
                          for (k=0; k < kategoria.length; k++){
                              if (kategoria[k] == strev){
                                  elemtomb[k] = parseInt(data_viewer[i].osszeg);
                              }
                          }
                      }
                  }
                  elemtipus = tipustomb[j];
                  data_view.push({name: elemtipus, data: elemtomb});
              }
              return data_view;
          }

          var data_viewer = <?php echo $ktgtipusmind; ?>;
          var kategoria = kategoriafeltolt(data_viewer);
          var tipustomb = tipusfeltolt(data_viewer);
          var data_view = osszegfeltolt(tipustomb, kategoria, data_viewer);
          var ktgtipusmind = highchart( 'ktgtipusmind', 'area', 600, kategoria, data_view, 'Költségek', 'Hónap/Típus', 'Forint', ' ft');
          chartSkin(ktgtipusmind, '#EDE6E6', 25, 'lightgray', 3);
          ktgtipusmind.setSize(null);

          var data_auto = <?php echo $ktgautomind; ?>;
          var kategoria_m = [];
          var data_m = [];
          for (i=0; i<data_auto.length; i++){
              kategoria_m.push(data_auto[i].nev);
              data_m.push(parseInt(data_auto[i].osszeg));
          }
          var ktgautomind = HighChartColumn('ktgautomind', 'column', kategoria_m, data_m, 600, 25, 'lightgray', 3, 'Költségek autónként', 'Poláris', ' forint', false, true);

          $('#plain').click(function () {
              combinatedClick( ktgautomind, false, false, 'Egyszerű');
          });

          $('#inverted').click(function () {
              combinatedClick( ktgautomind, true, false, 'Inverz');
          });

          $('#polar').click(function () {
              combinatedClick( ktgautomind, false, true, 'Poláris');
          });

          var data_frktgs = <?php echo $frktgs; ?>;
          kategoria = kategoriafeltolt(data_frktgs);
          tipustomb = tipusfeltolt(data_frktgs);
          data_view = osszegfeltolt(tipustomb, kategoria, data_frktgs);
          var ktgautoevho = highchart( 'ktgautoevho', 'area', 475, kategoria, data_view, 'Költségek', 'Hónap/Autó', 'Forint', ' ft');
          chartSkin(ktgautoevho, '#EDE6E6', 25, 'lightgray', 3);
          ktgautoevho.setSize(null);
      });
  </script>
@endsection
