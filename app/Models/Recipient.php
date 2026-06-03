<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['chat_id', 'user_id','message_id', 'is_seen', 'status'])]
#[Hidden([])]
class Recipient extends Model
{
    use HasFactory,  SoftDeletes;


}
