<?php

namespace App\Http\Controllers;
use App\Classes\CarCost;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
         $kezdo = date('Y-m-d', strtotime('-12 month'));
         $veg   = date('Y-m-d', strtotime('now'));

       $viewer = CarCost::getHonapKtg($kezdo, $veg);
       $viewer = array_column($viewer, 'osszeg');

       $honap = CarCost::getKtgHonap($kezdo, $veg);
       $honap = array_column($honap, 'nev');


       $osszeg = CarCost::getAutoIdoszakKoltseg($kezdo, $veg);
       $osszeg = array_column($osszeg, 'sum');

        return view('home')->with('viewer',json_encode($viewer,JSON_NUMERIC_CHECK))
                           ->with('honap',json_encode($honap))
                           ->with('osszeg',json_encode($osszeg,JSON_NUMERIC_CHECK));
     }
   }
