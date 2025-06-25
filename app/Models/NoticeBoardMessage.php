<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeBoardMessage extends Model
{
    protected $table = 'notice_board_message';
    protected $fillable = ['notice_board_id', 'message_to'];
}
