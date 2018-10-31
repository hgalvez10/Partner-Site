<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'org', 'street', 'city', 'sp', 'voice', 'email', 'status'
    ];

    function address()
    {
    	return ucfirst($this->street).', '.ucfirst($this->city).', '.ucfirst($this->sp);
    }
}
