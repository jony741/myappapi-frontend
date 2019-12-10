<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\providers_availability;
use Illuminate\Support\Facades\DB;

class ProvidersAvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::table('providers_cats')
            ->join('providers',  'providers_cats.provider_id', '=', 'providers.id')
            ->join('categories', 'categories.id', '=', 'providers_cats.cat_id')
            ->select('categories.id as cat_id', 'categories.title', 'categories.image', DB::raw("count(providers.id) as providers_count"))
            ->groupBy('cat_id')
            ->get();

            //need more work


        return $result;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\providers_availability  $providers_availability
     * @return \Illuminate\Http\Response
     */
    public function show(providers_availability $providers_availability)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\providers_availability  $providers_availability
     * @return \Illuminate\Http\Response
     */
    public function edit(providers_availability $providers_availability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\providers_availability  $providers_availability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, providers_availability $providers_availability)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\providers_availability  $providers_availability
     * @return \Illuminate\Http\Response
     */
    public function destroy(providers_availability $providers_availability)
    {
        //
    }
}
