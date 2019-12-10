<?php

namespace App\Nova\Actions;

use App\Service;
use App\Provider;
use App\Confirmation;
use App\ServiceImage;
use App\ServiceOption;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\HasMany;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class ConfirmChanges extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = true;

    /**
     * Perform the action on the given models.
     *
     * @param ActionFields $fields
     * @param Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            switch ($model->type) {
                case Confirmation::PROVIDER_IMAGE:
                    $provider = Provider::find($model->resource_id);
                    if ($provider) {
                        $provider->checkAndDelete($provider->image);
                        $provider->image = $model->image;
                        $provider->save();
                        $model->is_checked = true;
                        $model->save();
                        return Action::message('Confirmed');
                    } else {
                        return Action::danger('Error');
                    }
                    break;
                case Confirmation::PROVIDER_BACKGROUND:
                    $provider = Provider::find($model->resource_id);
                    if ($provider) {
                        $provider->checkAndDelete($provider->background_image);
                        $provider->background_image = $model->image;
                        $provider->save();
                        $model->is_checked = true;
                        $model->save();
                        return Action::message('Confirmed');
                    } else {
                        return Action::danger('Error');
                    }
                    break;
                case Confirmation::SERVICE_EDIT:
                    $service = Service::find($model->resource_id);
                    // $simages = ServiceImage::where('service_id', $service->id)->first();
                    if ($service) {
                        // if ($model->image) {
                        //     $service->checkAndDelete($simages->image);
                        //     $simages->image = $model->image;
                        // }
                        if ($model->image) {
                            $service->checkAndDelete($service->image);
                            $service->image = $model->image;
                        }
                        $service->fill($model->data);
                        $service->save();
                        $model->is_checked = true;
                        $model->save();
                        return Action::message('Confirmed');
                    } else {
                        return Action::danger('Error');
                    }
                    break;
                case Confirmation::SERVICE_NEW:
                    $provider = Provider::find($model->resource_id);
                    if ($provider) {
                        $service = new Service($model->data);
                        // $provider->services()->save($service);
                        if ($model->image) {
                            $service->image = $model->image;
                        }
                        $provider->services()->save($service);
                        // $serviceImage = new ServiceImage();
                        // if ($model->image) {
                        //     $serviceImage->service_id = $service->id;
                        //     $serviceImage->image = $model->image;
                        // }
                        // $service->images()->save($serviceImage);
                        $model->is_checked = true;
                        $model->save();
                        return Action::message('Confirmed');
                    } else {
                        return Action::danger('Error');
                    }
                    break;

                case Confirmation::OPTION_NEW:
                    $service = Service::find($model->resource_id);
                    if ($service) {
                        $serviceOption = new ServiceOption($model->data);
                        $service->options()->save($serviceOption);
                        // $serviceImage = new ServiceImage();
                        if ($model->image) {
                            $serviceOption->image = $model->image;
                            $serviceOption->save();
                        }
                        // $serviceOption->save($serviceImage);

                        $model->is_checked = true;
                        $model->save();
                        return Action::message('Confirmed');
                    } else {
                        return Action::danger('Error');
                    }
                    break;

                case Confirmation::OPTION_EDIT:
                    $serviceOption = ServiceOption::find($model->resource_id);
                    // $simages = ServiceImage::where('service_id',$service->id)->first();
                    if ($serviceOption) {
                        if ($model->image) {
                            $serviceOption->checkAndDelete($serviceOption->image);
                            $serviceOption->image = $model->image;
                        }
                        $serviceOption->fill($model->data);
                        $serviceOption->save();
                        $model->is_checked = true;
                        $model->save();
                        return Action::message('Confirmed');
                    } else {
                        return Action::danger('Error');
                    }
                    break;
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }
}
