<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MsReservationMobil extends Model
{
    protected $table = 'ms_reservasi_mobil';

    protected $fillable = [
        'user_id', 'department', 'status', 'date_from', 'date_to', 'time_from',
        'time_to', 'plant', 'destination', 'description', 'car_load', 'feedback', 'company', 'cost_center'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}