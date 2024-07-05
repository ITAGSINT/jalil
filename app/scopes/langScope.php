<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LangScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (LaravelLocalization::getCurrentLocale() == 'ar')
            $lang = 4;
        else
            $lang = 1;
        $builder->where('language_id',$lang);
    }
}
