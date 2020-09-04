<?php
namespace App\Classes;
use App\Models\Partner;
use App\Models\Cost;
use App\Models\Car;
use App\Models\User;
use DB;

class SendMail{

    public static function AccountMail($account){

        $felhasznalo = Car::getCarFelhasznalo($account->auto);
        $email = User::getUserEmail($felhasznalo);

        $details = [
            'title' => 'Email a priestago.hu/auto alkalmazásból',
            'body' => 'Az Ön autójához kapcsolódó számlát rögzítettek rendszerünkben',
            'partner' => Partner::getParnerName($account->partner),
            'tipus' => Cost::getCostName($account->tipus),
            'osszeg' => number_format ( $account->osszeg, 0, ",", "." ),
            'bizszam' => $account->bizszam,
            'datum' => $account->datum
        ];

        \Mail::to($email)->send(new \App\Mail\AccountMail($details));

        return;
    }
}
