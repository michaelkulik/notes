<?php

namespace Pinerp\Notes;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Pinerp\Staff\Models\User;

class Note extends Model
{
    protected $table = 'notes_notes';

    protected $fillable = ['title', 'content', 'notify_datetime'];

    public $timestamps = true;

    public function User()
    {
        return $this->belongsTo('Pinerp\Staff\Models\User');
    }
}