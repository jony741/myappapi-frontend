<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;

class Provider extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Provider';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
            Boolean::make('Active', 'accepted'),
            // HasOne::make('User', 'user', 'App\Nova\User'),
            BelongsTo::make('User', 'user', 'App\Nova\User'),
            HasMany::make('Services', 'Services', 'App\Nova\Service'),
            HasOne::make('Location', 'location', 'App\Nova\Location'),
            HasMany::make('Images', 'images', 'App\Nova\ProviderImage'),

            // Image::make('logo','thumbnail', function () {
            //     return str_replace('storage', '', $this->thumbnail);
            // })->disk('public')->path('providers/' . ($this->id ?? 'new')),

            // Image::make('Logo',function () {
            //     return str_replace('storage', '', $this->thumbnail);
            // })->disk('public')->path('providers/' . ($this->id ?? 'new')),

            Image::make('Logo', 'thumbnail')
                ->disk('public')->path('providers/' . ($this->id ?? 'new'))
                ->displayUsing(function () {
                    return str_replace('storage', '', $this->thumbnail);
                }),

            // Image::make('header', function () {
            //     return str_replace('storage', '', $this->header);
            // })->disk('public')->path('providers/' . ($this->id ?? 'new'))
            //     ->hideFromIndex(),

            Image::make('Background', 'header')
                ->disk('public')->path('providers/' . ($this->id ?? 'new'))
                ->displayUsing(function () {
                    return str_replace('storage', '', $this->header);
                })->hideFromIndex(),

            BelongsToMany::make('Service Types', 'category', 'App\Nova\ServiceType')->display('title'),
            
            BelongsToMany::make('Event Types', 'occasion', 'App\Nova\EventType')->display('title'),

            Text::make('Title', 'title'),
            Text::make('Full name', 'full_name'),
            Text::make('Phone', 'phone_number'),
            Text::make('Rate', 'rate')->onlyOnDetail(),
            Text::make('Reviews', 'reviews')->onlyOnDetail(),
            Textarea::make('Description', 'description')->hideFromIndex(),
            // Textarea::make('Overview', 'overview')->hideFromIndex(),
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
