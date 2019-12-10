<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;

class Location extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Location';
    public static $displayInNavigation = false;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'full_address';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'full_address'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            BelongsTo::make('Provider', 'provider', 'App\Nova\Provider')->display('title'),
            Number::make('Lat')->step(0.000001)->withMeta($this->lat ? [] : ["value" => 24.466667]),
            Number::make('Lng')->step(0.000001)->withMeta($this->lng ? [] : ["value" => 54.366669]),
            Text::make('Full Address')->withMeta($this->full_address ? [] : ["value" => "United Arab Emirates, Abu Dhabi, Al Mushrif"]),
            Text::make('Street Name')->withMeta($this->street_name ? [] : ["value" => "Al Muroor St."]),
            Text::make('Building No.')->withMeta($this->building_no ? [] : ["value" => "10"]),
            // HasMany::make(__('ServiceImages'), 'images', 'App\Nova\ServiceImage'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param Request $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param Request $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
