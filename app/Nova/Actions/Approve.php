<?php

namespace App\Nova\Actions;

use App\Mail\RequestApproved;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Nova\Fields\Textarea;
use App\Confirmation;
use App\User;
use Illuminate\Support\Facades\Mail;

class Approve extends Action
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

            // Creating user instance
            $users = User::find($model->user_id);

            if ($confirm->name == 'Create') {
                $newModel = new $confirm->model_type;
            }else{
                $newModel = $confirm->model_type::find($confirm->model_id);
            }

            $chaneDataObj = $confirm->changes;

            $changeDataArr = json_decode($chaneDataObj,true);

            foreach ($changeDataArr as $key => $value) {
                $newModel->$key = $changeDataArr[$key];
            }

            $newModel->save();


            // Confirmation table update
            $confirm->message = $fields->comment;
            $confirm->is_checked = 1;
            $confirm->save();


            // Mail will be sending to Provider
            Mail::to($users)->send(new RequestApproved());

            return Action::message('Operation successfully done.');
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
            Textarea::make('Comment')->rules('required'),
        ];
    }
}
