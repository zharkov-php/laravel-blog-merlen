<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;


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
}
