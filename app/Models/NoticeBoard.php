<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    protected $table = 'notice_board';
    protected $fillable = ['title', 'notice_date', 'publish_date', 'message', 'created_by'];

    public function recipients()
    {
        return $this->hasMany(NoticeBoardMessage::class, 'notice_board_id');
    }

    public function messages()
{
    return $this->hasMany(NoticeBoardMessage::class, 'notice_board_id');
}

}
