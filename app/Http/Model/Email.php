<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table='email';
    protected $primaryKey='mail_id';
    public $timestamps=false;
    protected $guarded=[];
}
