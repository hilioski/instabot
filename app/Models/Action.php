<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'actions';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'display_name',
        'is_active'
    ];

    // Relations
    public function rules(){
        return $this->hasMany(Rule::class);
    }
}
