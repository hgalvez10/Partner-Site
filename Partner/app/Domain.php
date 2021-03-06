<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'domainName', 'sld', 'tld', 'ns', 'registrant_id', 'admin_contact_id', 'billing_contact_id', 'tech_contact_id', 'renew_date', 'expirate_date', 'terminate_date', 'authinfo', 
    ];
}
