<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class DeletedScope implements Scope
{
    //This is for global scope
    public function apply(Builder $builder, Model $model){
        if(Auth::check() && Auth::user()->is_admin){
            $builder->withTrashed();
        }
        
    }
}


?>