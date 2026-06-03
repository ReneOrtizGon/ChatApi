<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['chat_id', 'user_id', 'name', 'is_owner', 'status'])]
#[Hidden([])]
class ChatMember extends Model
{
    use HasFactory,  SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
