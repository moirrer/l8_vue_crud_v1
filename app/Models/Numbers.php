<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Numbers extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'numbers';
    protected $primaryKey = "id";
    protected $fillable   = ['id', 'customer_id', 'number', 'status'];


    public static function boot(){
        
        static::creating(function ($model) {});
        
        static::created(function ($model) {
            $number_preference = new NumberPreferences();
            $number_preference->number_id = $model->id;
            $number_preference->name      = "auto_attendant";
            $number_preference->value     = "1";
            $number_preference->save();

            $number_preference = new NumberPreferences();
            $number_preference->number_id = $model->id;
            $number_preference->name      = "voicemail_enabled";
            $number_preference->value     = "1";
            $number_preference->save();
        });

        static::updating(function ($model) {});
        
        static::updated(function ($model) {});

        static::deleting(function ($model) {});
        
        parent::boot();   
    }
}
