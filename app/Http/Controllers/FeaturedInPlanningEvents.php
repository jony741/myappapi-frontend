<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeaturedInPlanningEvents extends Controller
{
    //
    public function index($type){
        $featured = Provider::with('location')
        ->join('promo_providers', 'promo_providers.provider_id', '=', 'providers.id')
        ->join('promotions', 'promo_providers.promotion_id', '=', 'promotions.id')
            //  ->join('promo_providers', 'promo_providers.promotion_id', '=', 'promotions.id')
            // ->join('providers', 'providers.id', '=', 'promo_providers.provider_id')
            ->select('providers.*','promotions.price')
            ->where('promotions.id', '=', $type)
            ->get();
        return $featured;
        // return ['featured_vendors'=>$featured_vendors,'featured_offers'=>$featured_offers];
    }
}
