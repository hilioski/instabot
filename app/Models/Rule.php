<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'rules';

    public $timestamps = true;

    protected $fillable = [
        'action_id',
        'criteria_id'
    ];

    // Relations
    public function action(){
        return $this->belongsTo(Action::class);
    }

    public function criteria(){
        return $this->belongsTo(Criteria::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
