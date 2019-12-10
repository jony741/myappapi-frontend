<?php

namespace App\Nova\Actions;

use App\Confirmation;
use App\Mail\RequestRejected;
use App\User;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Fields\Textarea;
use Illuminate\Support\Facades\Mail;

class Reject extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {

            $confirm = Confirmation::find($model->id);
            $confirm->message = $fields->reason;
            $confirm->is_checked = 2;
            $confirm->save();

            // Mail will be sending to Provider
            // Creating user instance
            $users = User::find($model->user_id);
            Mail::to($users)->send(new RequestRejected($model,$fields->reason));


        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Textarea::make('Reason')->rules('required'),
        ];
    }
}
