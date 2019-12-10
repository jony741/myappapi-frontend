<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\BelongsTo;

class Service extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Service';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title'
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
            Text::make('Title', 'title'),
            Text::make('Description', 'description'),
            Text::make('Price', 'price'),
            Image::make('Image', 'image', function () {
                return str_replace('storage', '', $this->image);
            })->disk('public')->path('services/' . ($this->id ?? 'new')),
            // HasMany::make('Service Images', 'images', 'App\Nova\ServiceImage'),
            HasMany::make('Service Options', 'options', 'App\Nova\ServiceOption'),
            // Image::make('Image', 'image', function () {
            //     return str_replace('storage', '', $this->image);
            // })->disk('public')->path('services/' . ($this->id ?? 'new')),
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
