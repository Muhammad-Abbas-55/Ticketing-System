<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'image',
        'user_id',
        'agent_id',
        'comment',
    ];

    /**
     * A ticket belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function logs()
    {
        return $this->hasMany(TicketLog::class)->latest();
    }
}
