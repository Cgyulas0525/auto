<?php
use App\Classes\CarCost;
use App\Models\Account;

$kezdo = date('Y-m-d', strtotime('-12 month'));
$veg   = date('Y-m-d', strtotime('now'));

$osszktg = CarCost::getIdoszakOsszKtg($kezdo, $veg);
$mindsum = $osszktg;
$osszktg = number_format ( $osszktg, 0, ",", "." );

$tipusKtgs = CarCost::getIdoszakTipusOsszKtg($kezdo, $veg);
foreach ($tipusKtgs as $tipusKtg) {
    $tipusKtg->ktg = number_format ( $tipusKtg->ktg, 0, ",", "." );
}

$autoKtgs = CarCost::getIdoszakAutoOsszKtg($kezdo, $veg);
foreach ($autoKtgs as $autoKtg) {
    $autoKtg->ktg = (int)$autoKtg->ktg / ((int)$mindsum / 100);
    $autoKtg->ktg = number_format ( $autoKtg->ktg, 2, ",", "." );
}

$mk  = date('Y-m-d', strtotime('-2 month'));
$mv = date('Y-m-d', strtotime('last day of this month'));
$szamlak = Account::SzamlakIdoszak($mk, $mv, 5);
foreach ($szamlak as $szamla) {
    $szamla->osszeg = number_format ( $szamla->osszeg, 0, ",", "." );
}

?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">
       <div class="box" height= "600">
         <div class="box-header with-border">
           <h3 class="box-title">Éves számla kimutatás</h3>

           <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
             </button>
             <div class="btn-group">
               <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                 <i class="fa fa-wrench"></i></button>
               <ul class="dropdown-menu" role="menu">
                 <li><a href="{!! route('partners.index') !!}">Partnerek</a></li>
                 <li><a href="{!! route('cars.index') !!}">Autók</a></li>
                 <li><a href="{!! route('costs.index') !!}">Költség típusok</a></li>
                 <li class="divider"></li>
                 <li><a href="{!! route('accounts.index') !!}">Számlák</a></li>
               </ul>
             </div>
             <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
           </div>
         </div>
         <!-- /.box-header -->
         <div class="box-body">
           <div class="row">
             <div class="col-md-8">
               <p class="text-center">
                 <strong>Költség havi bontásban</strong>
               </p>

               <div class="chart">
                 <!-- Sales Chart Canvas -->
                 <canvas id="salesChart" style="height: 180px;"></canvas>
               </div>
               <!-- /.chart-responsive -->
             </div>
             <!-- /.col -->
             <div class="col-md-4">
               <p class="text-center">
                 <strong>Költség összesen: {{$osszktg}}  Ft.</strong>
                 @foreach ($tipusKtgs as $tipusKtg)
                     <div class="progress-group">
                         <span class="progress-text">{{ $tipusKtg->nev }}</span>
                         <span class="progress-number">{{ $tipusKtg->ktg }}  Ft.</span>
                     </div>
                 @endforeach

               </p>
             </div>


             <div class="col-md-12 col-md-12 col-xs-12" style="background-color:lightgray">

                 <h3><p class="text-center"><strong>Az utolsó 5 számla</strong></h3>

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
               </p>
             </div>

             <!-- /.col -->
           </div>
           <!-- /.row -->
         </div>
         <!-- ./box-body -->
           <!-- /.row -->
         </div>
         <!-- /.box-footer -->
    </div>
</div>
