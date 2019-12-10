<?php

namespace App;

use App\UploadImage;
use Illuminate\Database\Eloquent\Model;
// $rand = rand(1, 10);
class Provider extends Model
{
    use UploadImage;
        // id int [ref: - users.id]
        // occ_id int [ref: > occasions.id]
        // title varchar
        // full_name varchar
        // description varchar
        // phone_number varchar
        // thumbnail longtext
        // header longtext
        // capacity int
        // location_id int [ref: - locations.id]
        // accepted bool
    protected $primaryKey = 'id';
    // public $incrementing = false; // no auto increaments
    protected $fillable = [
        'user_id',
        'cat_id',
        'title',
        'full_name',
        'description',
        'phone_number',
        // 'location_id',
        // 'providers_availability_id',
        'accepted'
    ];

    protected $appends = ['rating'];

    
    protected $attributes = [
        // 'thumbnail' => 'http://lorempixel.com/400/200/people/',
        'header' => 'http://lorempixel.com/640/480/nightlife/',
    ];

    function getRatingAttribute(){
        $rating = $this->reviews()->avg('rate');
        return $rating ?? 0;
    }

    //one-to-one
    public function user()
    {
        // return $this->hasOne('App\User','id','user_id');
        return $this->belongsTo('App\User');
    }

    //one-to-one
    public function location()
    {
        return $this->hasOne('App\Location');
    }

    //one-to-many inverse
    // public function category()
    // {
    //     return $this->belongsTo('App\Category','cat_id','id');
    //     // return $this->belongsTo(Category::class);
    // }

    // public function provider_occ()
    // {
    //     return $this->belongsToMany(Occasion::class,'provider_occs','provider_id','occ_id');
    // }

    // public function provider_cat()
    // {
    //     // return $this->belongsToMany(Category::class,'provider_cats','provider_id','cat_id');
    //     return $this->belongsToMany(Category::class);
    // }

    public function category()
    {
        // return $this->belongsToMany(Category::class,'provider_cats','provider_id','cat_id');
        return $this->belongsToMany(Category::class);
    }

    public function occasion()
    {
        // return $this->belongsToMany(Category::class,'provider_cats','provider_id','cat_id');
        return $this->belongsToMany(Occasion::class);
    }

    public function services()
    {
        return $this->hasMany('App\Service');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function media()
    {
        return $this->hasMany('App\ProviderMedia');
    }

    public function images()
    {
        return $this->hasMany('App\ProviderImage');
    }

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
}
