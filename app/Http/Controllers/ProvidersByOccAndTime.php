<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvidersByOccAndTime extends Controller
{
    public function index(Request $request)
    {
        //post
        //get all providers with occ id that is not within the start and end datetime
        $occ_id = $request->input('occ_id');
        $start = $request->input('start');
        $end = $request->input('end');
        $plannerCatId = 10;
        $accepted = 1;

        $providers = DB::table('providers')
            ->leftjoin('orders', 'providers.id', '=', 'orders.provider_id')
            ->leftjoin('events', 'events.id', '=', 'orders.event_id')
            ->leftjoin('category_provider', 'providers.id', '=', 'category_provider.provider_id')
            ->leftjoin('occasion_provider', 'providers.id', '=',  'occasion_provider.provider_id')
            ->leftjoin('categories', 'category_provider.category_id', '=', 'categories.id')
            ->select(
                'occasion_provider.occasion_id as occ_id',
                'categories.id as cat_id',
                'categories.title as cat_title',
                'categories.image as cat_image',
                DB::raw("count(providers.id) as providers_count")
            )
            ->where('providers.accepted','=',$accepted)
            ->where('occasion_provider.occasion_id', '=', $occ_id)
            ->where('category_provider.category_id', '<>', $plannerCatId)
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
            ->groupBy('cat_id')
            ->get();

        return $providers;

        // $providers = DB::table('providers')
        //     ->leftjoin('orders', 'providers.id', '=', 'orders.provider_id')
        //     ->leftjoin('events', 'events.id', '=', 'orders.event_id')
        //     ->join('providers_cats', 'providers.id', '=',  'providers_cats.provider_id')
        //     ->join('categories', 'categories.id', '=', 'providers_cats.cat_id')
        //     ->select(
        //         'providers.occ_id as occ_id',
        //         // 'events.id as events_id',
        //         // 'events.event_start',
        //         // 'events.event_end',
        //         // 'orders.status as order_status',
        //         'categories.id as cat_id',
        //         'categories.title as cat_title',
        //         'categories.image as cat_image',
        //         DB::raw("count(providers.id) as providers_count")
        //     )
        //     ->where('providers.occ_id', '=', $occ_id)
        //     ->where('categories.id', '<>', $plannerCatId)
        //     ->where(function ($query) use ($start, $end) {
        //         $outOfTime = "
        //         (? < events.event_start and ? <= events.event_start) or 
        //         (? >= events.event_end and ? > events.event_end)";
        //         //(s<=x and e>=y) or (s is between x and y) or (e is between x and y)
        //         $inTime = "(
        //             (? <= events.event_start and ? >= events.event_end) or
        //             (? BETWEEN events.event_start AND events.event_end) or
        //             (? BETWEEN events.event_start AND events.event_end)
        //         )
        //         and orders.status <> 'processing'";
        //         $query->whereRaw($outOfTime, [$start, $end, $start, $end]);
        //         $query->orWhereRaw($inTime, [$start, $end, $start, $end]);
        //         $query->orWhereNull('events.event_start');
        //     })
        //     ->groupBy('cat_id')
        //     ->get();

        // return $providers;
    }
}
