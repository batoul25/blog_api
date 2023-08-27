<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function updated($model)
    {

        if (Auth::check()) {
            User::create([
                'action'       => 'update',
                'action_model' => $model->getTable(),
                'user_id'      => Auth::user()->id,
            
            ]);
        }
    }

    public function deleted($model)
    {
        if (Auth::check()) {
            User::create([
                'action'       => 'delete',
                'action_model' => $model->getTable(),
                'user_id'      => Auth::user()->id,
            ]);
        }
    }
}
