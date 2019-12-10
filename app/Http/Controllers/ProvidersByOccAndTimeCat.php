<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvidersByOccAndTimeCat extends Controller
{
    public function index(Request $request)
    {
        //post
        //get all providers with occ id that is not within the start and end datetime with a given cat_id
        $occ_id = $request->input('occ_id');
        $start = $request->input('start');
        $end = $request->input('end');
        $cat_id = $request->input('cat_id');
        $accepted = 1;

        $providers = Provider::with('location')
            ->leftjoin('orders', 'providers.id', '=', 'orders.provider_id')
            ->leftjoin('events', 'events.id', '=', 'orders.event_id')
            ->leftjoin('category_provider', 'providers.id', '=', 'category_provider.provider_id')
            ->leftjoin('occasion_provider', 'providers.id', '=',  'occasion_provider.provider_id')
            ->leftjoin('categories', 'category_provider.category_id', '=', 'categories.id')
            ->select(
                'providers.*'
            )
            ->where('providers.accepted','=',$accepted)
            ->where('occasion_provider.occasion_id', '=', $occ_id)
            ->where('categories.id', '=', $cat_id)
            ->where(function ($query) use ($start, $end) {
                $outOfTime = "
                (? < events.event_start and ? <= events.event_start) or 
                (? >= events.event_end and ? > events.event_end)";
                //(s<=x and e>=y) or (s is between x and y) or (e is between x and y)
                $inTime = "(
                    (? <= events.event_start and ? >= events.event_end) or
                    (? BETWEEN events.event_start AND events.event_end) or
                    (? BETWEEN events.event_start AND events.event_end)
                )
                and orders.status <> '1'";
                $query->whereRaw($outOfTime, [$start, $end, $start, $end]);
                $query->orWhereRaw($inTime, [$start, $end, $start, $end]);
                $query->orWhereNull('events.event_start');
            })
            // ->groupBy('cat_id')
            ->get();

        return $providers;

        // return ['ava' => $ava_test, 'res' => $result];
    }
}
