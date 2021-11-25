<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class GameTime extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'puzzle_number',
        'game_time',
        'team_number',
        'game_event_id'
    ];

}

