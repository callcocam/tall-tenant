<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Tall\Tenant\Scopes;


use Ramsey\Uuid\Uuid;

trait UuidGenerate
{


    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (is_null($model->id)):
                $model->id = Uuid::uuid4();
            endif;
            if($model->isUser()){
                if(auth()->check()){
                    if (is_null($model->user_id)):
                        $model->user_id = auth()->id();
                    endif;
                }else{
                   // $model->user_id = \App\Models\User::all()->random()->id;
                }
            }
        });
    }
}
