<?php
namespace App\Classes;
use App\Models\Account;

use DB;

class CarCost{
    public $rendszam = null;
    public $osszeg = null;

    public static function getRendszam($id){
        $car = DB::table('cars')->where('id', '=', $id)->first();
        return $car->rendszam;
    }

    public static function getOsszeg($id){
        $account = Account::where('auto', '=', $id)->whereNull('accounts.deleted_at')->get();
        $osszeg = collect($account)->sum('osszeg');
        return $osszeg;
    }

    public static function getKoltseg(){
        $data = DB::table('accounts')
                    ->join('cars', 'cars.id', '=', 'accounts.auto')
                    ->select('cars.rendszam as rendszam',
                             'cars.karbantarto as karbantarto',
                             'cars.hatter as hatter',
                             'cars.kep as kep',
                             DB::raw('sum(accounts.osszeg) as osszeg'))
                    ->whereNull('accounts.deleted_at')
                    ->groupby('cars.rendszam',
                              'cars.karbantarto',
                              'cars.hatter',
                              'cars.kep')
                    ->get();
        return $data;
    }

    public static function getIdoszakOsszKtg($kezdo, $veg){
        $sum = DB::table('accounts')
                ->whereBetween('datum', [$kezdo, $veg])
                ->whereNull('deleted_at')
                ->sum('osszeg');
        return $sum;
    }

    public static function getIdoszakTipusOsszKtg($kezdo, $veg){
        $ktgs = DB::table('accounts')
                ->join('costs', 'costs.id', '=', 'accounts.tipus')
                ->select('costs.nev', DB::raw('sum(accounts.osszeg) AS ktg'))
                ->whereBetween('accounts.datum', [$kezdo, $veg])
                ->whereNull('accounts.deleted_at')
                ->groupBy('costs.nev')
                ->orderBy('costs.nev')
                ->get();
        return $ktgs;
    }

    public static function getIdoszakAutoOsszKtg($kezdo, $veg){
        $ktgs = DB::table('accounts')
                ->join('cars', 'cars.id', '=', 'accounts.auto')
                ->select('cars.rendszam as rendszam', DB::raw('sum(accounts.osszeg) as ktg'))
                ->whereNull('accounts.deleted_at')
                ->whereBetween('accounts.datum', [$kezdo, $veg])
                ->groupby('cars.rendszam')
                ->orderBy('cars.rendszam')
                ->get();
        return $ktgs;
    }

    public static function getHonapKtg($kezdo, $veg){
        $viewer = Account::selectRaw('month(datum) month, sum(osszeg) as osszeg')
                          ->whereBetween('datum', [$kezdo, $veg])
                          ->whereNull('deleted_at')
                          ->orderBy('month')
                          ->groupBy('month')
                          ->get()->toArray();
        return $viewer;
    }

    public static function getKtgHonap($kezdo, $veg){
        $honap = Account::selectRaw('distinct(month(datum)) as nev')
                           ->whereBetween('datum', [$kezdo, $veg])
                           ->orderBy('nev')
                          ->get()->toArray();
        return $honap;
    }

    public static function getAutoIdoszakKoltseg($kezdo, $veg){
        $data = DB::table('accounts')
                    ->join('cars', 'cars.id', '=', 'accounts.auto')
                    ->select('cars.rendszam as rendszam', DB::raw('sum(accounts.osszeg) as sum'))
                    ->whereBetween('datum', [$kezdo, $veg])
                    ->whereNull('accounts.deleted_at')
                    ->groupby('cars.rendszam')
                    ->get()->toArray();
        return $data;
    }

    public static function getAutoKoltsegIdoszakOsszesen($kezdo, $veg){
        $data = DB::table('accounts')
                ->join('cars', 'cars.id', '=', 'accounts.auto')
                ->join('costs', 'costs.id', '=', 'accounts.tipus')
                ->select('cars.rendszam as rendszam', 'costs.nev as ktg', DB::raw('sum(accounts.osszeg) as sum'))
                ->whereBetween('datum', [$kezdo, $veg])
                ->whereNull('accounts.deleted_at')
                ->groupby('cars.rendszam', 'costs.nev')
                ->orderby('cars.rendszam', 'asc')
                ->orderby('costs.nev', 'asc')
                ->get()->toArray();
        return $data;
    }

    public static function getAutoKoltsegOsszesen(){
        $data = DB::table('accounts')
                ->join('cars', 'cars.id', '=', 'accounts.auto')
                ->join('costs', 'costs.id', '=', 'accounts.tipus')
                ->select('cars.rendszam as rendszam', 'costs.nev as ktg', DB::raw('sum(accounts.osszeg) as sum'))
                ->whereNull('accounts.deleted_at')
                ->groupby('cars.rendszam', 'costs.nev')
                ->orderby('cars.rendszam')
                ->orderby('costs.nev')
                ->get()->toArray();
        return $data;
    }

    public static function getKtgTipusonkent($id){
        $ktg = Account::where('tipus', '=', $id)->whereNull('accounts.deleted_at')->get();
        $osszeg = collect($ktg)->sum('osszeg');
        return $osszeg;
    }

    public static function getKtgTipusIdoszakonkent($kezdo, $veg, $id){
        $ktg = Account::where('tipus', '=', $id)
                        ->whereBetween('datum', [$kezdo, $veg])
                        ->whereNull('accounts.deleted_at')
                        ->get();
        $osszeg = collect($ktg)->sum('osszeg');
        return $osszeg;
    }

    public static function getHonapTipusKtg($kezdo, $veg, $id){
        $viewer = Account::selectRaw('month(datum) month, sum(osszeg) as osszeg')
                          ->whereBetween('datum', [$kezdo, $veg])
                          ->whereNull('deleted_at')
                          ->where('tipus', '=', $id)
                          ->orderBy('month')
                          ->groupBy('month')
                          ->get();
        return $viewer;
    }

    public static function getEvHonapKtgTipus($kezdo, $veg, $id){
        $viewer = Account::select(DB::raw("CONCAT(year(datum), lpad(month(datum), 2, 0)) as month, sum(osszeg) as osszeg"))
                          ->whereBetween('datum', [$kezdo, $veg])
                          ->whereNull('deleted_at')
                          ->where('tipus', '=', $id)
                          ->orderBy('month')
                          ->groupBy('month')
                          ->get();

        return $viewer;
    }

    public static function getFRKTG($kezdo, $veg){
        $viewer = Account::select(DB::raw("CONCAT(year(datum), lpad(month(datum), 2, 0)) as month, sum(osszeg) as osszeg"))
                          ->whereBetween('datum', [$kezdo, $veg])
                          ->whereNull('deleted_at')
                          ->orderBy('month')
                          ->groupBy('month')
                          ->get();

        return $viewer;
    }

    public static function getEvHonapKtgMindenTipus($kezdo, $veg){
        $viewer = DB::table('accounts as t1')
                    ->join('costs as t2', 't2.id', '=', 't1.tipus')
                    ->select('t2.nev as tipus', DB::raw("CONCAT(year(t1.datum), lpad(month(t1.datum), 2, 0)) as month, sum(t1.osszeg) as osszeg"))
                    ->whereBetween('t1.datum', [$kezdo, $veg])
                    ->whereNull('t1.deleted_at')
                    ->orderBy('month', 'asc', 't2.nev', 'asc')
                    ->groupBy('t2.nev', 'month')
                    ->get();

        return $viewer;
    }

    public static function getKtgAuto($kezdo, $veg){
        $viewer = DB::table('accounts as t1')
                    ->join('cars as t2', 't2.id', '=', 't1.auto')
                    ->select('t2.rendszam as nev', DB::raw("sum(t1.osszeg) as osszeg"))
                    ->whereBetween('t1.datum', [$kezdo, $veg])
                    ->whereNull('t1.deleted_at')
                    ->orderBy('t2.rendszam', 'asc')
                    ->groupBy('t2.rendszam')
                    ->get();

        return $viewer;
    }

    public static function getEvHonapKtgMindenAuto($kezdo, $veg){
        $viewer = DB::table('accounts as t1')
                    ->join('cars as t2', 't2.id', '=', 't1.auto')
                    ->select('t2.rendszam as tipus', DB::raw("CONCAT(year(t1.datum), lpad(month(t1.datum), 2, 0)) as month, sum(t1.osszeg) as osszeg"))
                    ->whereBetween('t1.datum', [$kezdo, $veg])
                    ->whereNull('t1.deleted_at')
                    ->orderBy('month', 'asc', 't2.rendszam', 'asc')
                    ->groupBy('t2.rendszam', 'month')
                    ->get();

        return $viewer;
    }

    public static function getTipusOsszKtg(){
        $ktgs = DB::table('accounts')
                ->join('costs', 'costs.id', '=', 'accounts.tipus')
                ->select('costs.nev as nev', DB::raw('sum(accounts.osszeg) AS osszeg'))
                ->groupBy('costs.nev')
                ->orderBy('costs.nev')
                ->get();
        return $ktgs;
    }

    public static function getEgyAutoKoltsegIdoszakOsszesen($kezdo, $veg, $id){
        $data = DB::table('accounts')
                ->join('costs', 'costs.id', '=', 'accounts.tipus')
                ->select('costs.nev as nev', DB::raw('sum(accounts.osszeg) AS osszeg'))
                ->where('accounts.auto', '=', $id)
                ->groupBy('costs.nev')
                ->orderBy('costs.nev')
                ->get();
        return $data;
    }

}
