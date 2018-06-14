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



    /**Start
     * Работа с Админкой
     */

    //разрешить комментарий
    public function allow()
    {
        $this->status = 1;
        $this->save();
    }

    //НЕ разрешить комментарий
    public function disAllow()
    {
        $this->status = 0;
        $this->save();
    }

    //разрешить запрещать
    public function toggleStatus()
    {
        if($this->status == 0)
        {
            return $this->allow();
        }

        return $this->disAllow();
    }

    //удалить комментарий
    public function remove()
    {
        $this->delete();
    }

    /**End
     * Работа с Админкой
     */

}
