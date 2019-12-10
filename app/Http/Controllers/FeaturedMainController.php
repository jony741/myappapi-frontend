<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeaturedMainController extends Controller
{
    //
    public function index(){
        // this will return all fields of all users
        // $result = DB::table('users')->get();
        // return $result;
        $providersMainPage = 1;
        $offeresMainPage = 2;
        $accepted = 1;

        $featured_vendors = Provider::with('location')
        ->join('promo_providers', 'promo_providers.provider_id', '=', 'providers.id')
        ->join('promotions', 'promo_providers.promotion_id', '=', 'promotions.id')
        // DB::table('promotions')
        //      ->join('promo_providers', 'promo_providers.promotion_id', '=', 'promotions.id')
        //     ->join('providers', 'providers.id', '=', 'promo_providers.provider_id')
            ->select('providers.*','promotions.price')
            ->where('providers.accepted','=',$accepted)
            ->where('promotions.id', '=', $providersMainPage)
            ->get();

            $featured_offers = Provider::with('location')
            ->join('promo_providers', 'promo_providers.provider_id', '=', 'providers.id')
            ->join('promotions', 'promo_providers.promotion_id', '=', 'promotions.id')
            // DB::table('promotions')
            //  ->join('promo_providers', 'promo_providers.promotion_id', '=', 'promotions.id')
            // ->join('providers', 'providers.id', '=', 'promo_providers.provider_id')
            ->select('providers.*','promotions.price')
            ->where('providers.accepted','=',$accepted)
            ->where('promotions.id', '=', $offeresMainPage)
            ->get();

        // return $result;
        // $data2[] = [
        //     'label' => $result,
        //     'value' => $result
        // ];
        // return $data2;
        return ['featured_vendors'=>$featured_vendors,'featured_offers'=>$featured_offers];
    }

    // public function featured_vendors(){
    //     echo 'test this';
    //     // $result = DB::table('providers')
    //     //     ->join('promo_providers', 'providers.id', '=', 'promo_providers.provider_id')
    //     //     ->select('providers.*')
    //     //     ->get();

    //     // return $result;
    // }
}
