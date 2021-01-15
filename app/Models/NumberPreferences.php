<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NumberPreferences extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table      = 'number_preferences';
    protected $primaryKey = "id";
    protected $fillable   = ['id', 'number_id', 'name', 'value'];


    public static function boot(){
        
        static::creating(function ($model) {});
        
        static::created(function ($model) {});

        static::updating(function ($model) {});
        
        static::updated(function ($model) {});

        static::deleting(function ($model) {});
        
        parent::boot();   
    }
}
