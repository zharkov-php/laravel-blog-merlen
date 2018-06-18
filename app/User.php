<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    const IS_BANNED = 1;
    const IS_ACTIVE = 0;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //Один юзер может иметь множество постов
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //Один юзер может иметь множество комментов
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }



    /**Start
     * Работа с Админкой
     */

//добавить пользователя
    public static function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->save();

        return $user;
    }

    //изменить пользователя
    public function edit($fields)
    {
        $this->fill($fields); //name,email

        $this->save();
    }

    //сгенерировать пароль пользователя
    public function generatePassword($password)
    {
        if($password != null)
        {
            $this->password = bcrypt($password);
            $this->save();
        }
    }

    //удалить пользователя
    public function remove()
    {
        $this->removeAvatar();
        $this->delete();
    }

    //загрузить аватарку пользователя
    public function uploadAvatar($image)
    {
        if($image == null) { return; }

        $this->removeAvatar();

        $filename = str_random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->avatar = $filename;
        $this->save();
    }

    //удалить аватарку пользователя
    public function removeAvatar()
    {
        if($this->avatar != null)
        {
            Storage::delete('uploads/' . $this->avatar);
        }
    }

    //загрузить картинку
    public function getImage()
    {
        if($this->avatar == null)
        {
            return '/img/no-image.png';
        }

        return '/uploads/' . $this->avatar;
    }

    //сделать админом
    public function makeAdmin()
    {
        $this->is_admin = 1;
        $this->save();
    }

    //сделать НЕ админом
    public function makeNormal()
    {
        $this->is_admin = 0;
        $this->save();
    }

    public function toggleAdmin($value)
    {
        if($value == null)
        {
            return $this->makeNormal();
        }

        return $this->makeAdmin();
    }

    //забанить
    public function ban()
    {
        $this->status = User::IS_BANNED;
        $this->save();
    }

    //разбанить
    public function unban()
    {
        $this->status = User::IS_ACTIVE;
        $this->save();
    }

    //подключатель бана
    public function toggleBan($value)
    {
        if($value == null)
        {
            return $this->unban();
        }

        return $this->ban();
    }


    /**END
     * Работа с Админкой
     */
}
