<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    //у комментария может быть только один пост
    public function post()
    {
        return $this->hasOne(Post::class);
    }

    //у комментария может быть только один автор
    public function author()
    {
        return $this->hasOne(User::class);
    }
}
