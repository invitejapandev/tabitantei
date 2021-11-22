<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class GameProgress extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'game_event_id',
        'puzzle_progress',
        'answered_current',
        'time_answered',
        'teamNumber'
    ];

}

