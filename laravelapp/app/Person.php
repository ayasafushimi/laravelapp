<?php

namespace App;

use App\Scopes\ScopePerson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\builder;

class Person extends Model
{
    protected $guarded = array('id');

    public static $rules = array(
        'name' => 'required',
        'mail' => 'email',
        'age' => 'integer|min:0|max:150'
    );

    public function getData()
    {
        return $this->id . ':' . $this->name .'(' . $this->age . ')';
    }

    public function board()
    {
        return $this->hasOne('App\Board');
    }

}
