<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ADMIN = 'administrator';
    const KLANT = 'klant';
    const EERSTELIJNS_MEDEWERKER = 'eerstelijns_medewerker';
    const TWEEDELIJNS_MEDEWERKER = 'tweedelijns_medewerker';

    public function users(){
        return $this->hasMany('App\User');
    }
}
