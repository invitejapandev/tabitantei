<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PianoAnswer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'game_event_id',
        'player_name',
        'team_number',
        'selected_color',
        'is_validated'
    ];

}

