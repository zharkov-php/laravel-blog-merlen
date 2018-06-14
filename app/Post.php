<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;

    const IS_DRAFT = 0;
    const IS_PUBLIC = 1;

    protected $fillable = ['title','content', 'date', 'description'];


    //у поста может быть только одна категория
    public function category()
    {
        return $this->hasOne(Category::class);
    }

    //у поста может быть только один автор
    public function author()
    {
        return $this->hasOne(User::class);
    }

    //пост имеет множество тегов, но и тег имеет множество постов, (Соединяем МНОГИЕ ко МНОГИМ - belongsToMany)
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
            );
    }


    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }




    /**Start
     * Работа с Админкой
     */

    //создание поста
    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->user_id = Auth::user()->id;
        $post->save();

        return $post;
    }

    //правка поста
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    //удаление поста
    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

    //удаление картинки
    public function removeImage()
    {
        if($this->image != null)
        {
            Storage::delete('uploads/' . $this->image);
        }
    }

    //загрузка картинки
    public function uploadImage($image)
    {
        if($image == null) { return; }

        $this->removeImage();
        $filename = str_random(10) . '.' . $image->extension();
        $image->storeAs('uploads', $filename);
        $this->image = $filename;
        $this->save();
    }

    //заглушка пустой картинкой
    public function getImage()
    {
        if($this->image == null)
        {
            return '/img/no-image.png';
        }

        return '/uploads/' . $this->image;

    }

    //установка категории
    public function setCategory($id)
    {
        if($id == null) {return;}
        $this->category_id = $id;
        $this->save();
    }

    //установка тегов
    public function setTags($ids)
    {
        if($ids == null){return;}

        $this->tags()->sync($ids);
    }

    //работа со статусом
    public function setDraft()
    {
        $this->status = Post::IS_DRAFT;
        $this->save();
    }

    //работа со статусом
    public function setPublic()
    {
        $this->status = Post::IS_PUBLIC;
        $this->save();
    }

    //работа со статусом
    public function toggleStatus($value)
    {
        if($value == null)
        {
            return $this->setDraft();
        }

        return $this->setPublic();
    }

    //работа с рекомендованными
    public function setFeatured()
    {
        $this->is_featured = 1;
        $this->save();
    }

    //работа с рекомендованными
    public function setStandart()
    {
        $this->is_featured = 0;
        $this->save();
    }

    //работа с рекомендованными
    public function toggleFeatured($value)
    {
        if($value == null)
        {
            return $this->setStandart();
        }

        return $this->setFeatured();
    }


    /**End
     * Работа с Админкой
     */
}
