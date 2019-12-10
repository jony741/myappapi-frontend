<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatProviderCountController extends Controller
{
    public function index(Request $request)
    {
        $occ_id = $request->input('occ_id');
        $start = $request->input('start');
        $end = $request->input('end');
        // $justdate = DB::raw('DATE(`created_at`)'); // to get just the date
        // echo "occ:".$occ_id."\r\n";
        // echo "start:".$start."\r\n";
        // echo "end:".$end."\r\n";
        $ava_providers = DB::table('providers')
        ->join('orders', 'providers.id','=','orders.provider_id')
        ->join('events', 'orders.event_id','=','events.id')
        ->select('events.*')
        ->where('events.occ_id', '=', $occ_id)
        ->whereNotBetween('events.event_start', [$start, $end])
        ->whereNotBetween('events.event_end', [$start, $end])
        ->get();

        $result = DB::table('category_provider')
            ->join('providers',  'category_provider.provider_id', '=', 'providers.id')
            ->join('categories', 'categories.id', '=', 'category_provider.category_id')
            ->select('categories.id as cat_id', 'categories.title', 'categories.image', DB::raw("count(providers.id) as providers_count"))
            ->groupBy('category_id')
            ->get();


            return ['ava'=>$ava_providers,'res'=>$result];
    }


}
