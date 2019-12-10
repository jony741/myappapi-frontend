<?php


namespace App\Helper;


use App\Confirmation;
use App\Mail\ApprovalRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;



class WaitingApprovalHelper
{

    /**
     * Create a new action event instance for a resource creation.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function forResourceCreate($user = NULL, $model)
    {
        $confirmation = New Confirmation();

        $confirmation->batch_id = (string) Str::orderedUuid();
        $confirmation->user_id = $user ==NULL ? NULL:$user->id;
        $confirmation->name = 'Create';
        $confirmation->actionable_type = $model->getMorphClass();
        $confirmation->actionable_id = $model->getKey();

        $confirmation->target_type = $model->getMorphClass();
        $confirmation->target_id = $model->getKey();
        $confirmation->model_type = $model->getMorphClass();
        $confirmation->model_id = $model->getKey();

        $confirmation->fields = '';
        $confirmation->original = null;
        $confirmation->changes = json_encode($model->attributesToArray());
        $confirmation->status = 'finished';
        $confirmation->exception = '';
        $confirmation->save();
        return $confirmation;

    }

    /**
     * Create a new action event instance for a resource update.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function forResourceUpdate($user = NULL,$model,$model2)
    {
        $confirmation = New Confirmation();


        $confirmation->batch_id = (string) Str::orderedUuid();
        $confirmation->user_id = $user ==NULL ? NULL:$user->id;
        $confirmation->name = 'Update';
        $confirmation->actionable_type = $model->getMorphClass();
        $confirmation->actionable_id = $model->getKey();
        $confirmation->target_type = $model->getMorphClass();
        $confirmation->target_id = $model->getKey();
        $confirmation->model_type = $model->getMorphClass();
        $confirmation->model_id = $model->getKey();
        $confirmation->fields = '';
        $confirmation->original = json_encode(array_intersect_key($model->getOriginal(), $model2->getDirty()));
        $confirmation->changes = json_encode($model2->getDirty());
        $confirmation->status = 'finished';
        $confirmation->exception = '';
        $confirmation->save();
        return $confirmation;
    }

}