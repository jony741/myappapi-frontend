<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class RejectedRequest extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Confirmation';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

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
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [

            BelongsTo::make('User','user')->onlyOnIndex(),
            Text::make('Operation Type','name')->readonly(true),
            Text::make('Model Type','model_type')->resolveUsing(function ($model_type){
                return substr($model_type,4);
            })->readonly(true),
            Text::make('Status','status')->hideFromIndex()->withMeta(['extraAttributes' => [
                'readonly' => true
            ]]),
            Text::make('Message','msg')->hideFromIndex()->withMeta(['extraAttributes' => [
                'readonly' => true
            ]]),

            Image::make('Before Photo','original')->resolveUsing(function ($original) {
                $original = json_decode($original,true);
                if (!empty($original['image'])) {
                    return $original['image'];
                }

            })->hideFromIndex()->readonly(true),

            Image::make('Changes Photo','changes')->resolveUsing(function ($changes) {
                $changes = json_decode($changes,true);
                if (!empty($changes['image'])) {
                    return $changes['image'];
                }

            })->hideFromIndex()->readonly(true),

            KeyValue::make('Before','original')->resolveUsing(function ($original) {
                return json_decode($original,true);
            })->readonly(true),


            KeyValue::make('Changes','changes')->resolveUsing(function ($changes) {
                return json_decode($changes,true);
            })->withMeta(['extraAttributes' => [
                'readonly' => true
            ]]),
            DateTime::make('Created At')->sortable()->withMeta(['extraAttributes' => [
                'readonly' => true
            ]]),

            Select::make('Status','is_checked')->options([
                0 => 'Pending',
                1 => 'Approved',
            ])->displayUsingLabels()->sortable()->onlyOnIndex()->withMeta(['extraAttributes' => [
                'readonly' => true
            ]]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
