<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    // use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'tasks';
    protected $fillable = [
        'userid',
        'description',
        'link',
        'sm',
        'type',
        'limit',
        'amount'
    ];
}
