<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class GameEvent extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'client_id',
        'team_count',
        'game_code',
        'Status',
        'event_date',
        'company_name',
        'additional_details',
        'player_count',
        'time_limit'
    ];

}

