<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class HintLog extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'game_event_id',
        'team_number',
        'puzzle_number',
        'is_opened'
    ];

    public static function getSqlWithBindings($query)
{
    return vsprintf(str_replace('?', '%s', $query->toSql()), collect($query->getBindings())->map(function ($binding) {
        return is_numeric($binding) ? $binding : "'{$binding}'";
    })->toArray());
}

}

