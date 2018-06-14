<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    /**Start
     * Работа с Админкой
     */
    //создать подписчика
    public static function add($email)
    {
        $sub = new static;
        $sub->email = $email;
        $sub->save();

        return $sub;
    }

    //генерация токкена
    public function generateToken()
    {
        $this->token = str_random(100);
        $this->save();
    }

    //удаление подписчика
    public function remove()
    {
        $this->delete();
    }

    /**End
     * Работа с Админкой
     */

}
