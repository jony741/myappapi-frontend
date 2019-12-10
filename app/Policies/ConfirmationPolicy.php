<?php

namespace App\Policies;

use App\Confirmation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConfirmationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function viewAny(){
        return TRUE;
    }

    public function create(){
        return FALSE;
    }
    public function update( ){
        return TRUE;

    }
    public function view(){
        return TRUE;
    }

    public function delete(){
        return FALSE;
    }
}
