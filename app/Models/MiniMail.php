<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiniMail extends Model
{
    protected $fillable = [
        'from',
        'to',
        'subject',
        'html_content',
        'sent_at',
        'status',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    use HasFactory;

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
