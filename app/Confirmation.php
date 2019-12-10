<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    const PROVIDER_IMAGE = 'provider.image',
        PROVIDER_BACKGROUND = 'provider.background',
        SERVICE_EDIT = 'service.edit',
        SERVICE_NEW = 'service.new',
        OPTION_NEW = 'service_option.new',
        OPTION_EDIT = 'service_option.edit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resource_id',
        'type',
        'image',
        'data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    public function resource()
    {
        // if ($this->type === self::SERVICE_EDIT) {
        //     return $this->belongsTo(Service::class, 'resource_id');
        // } 
        
        if (in_array($this->type, [
            self::SERVICE_EDIT,
            self::OPTION_NEW
        ])){
            return $this->belongsTo(Service::class, 'resource_id');
        }
        elseif ($this->type === self::OPTION_EDIT){
            return $this->belongsTo(ServiceOption::class, 'resource_id');
        }
        elseif (in_array($this->type, [
            self::PROVIDER_IMAGE,
            self::PROVIDER_BACKGROUND,
            self::SERVICE_NEW
        ])) {
            return $this->belongsTo(Provider::class, 'resource_id');
        }
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
