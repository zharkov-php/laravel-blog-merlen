<?php

namespace App;

use Carbon\Carbon;
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
        return $this->belongsTo(Category::class);
    }

    //у поста может быть только один автор
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        //$post->user_id = Auth::user()->id;
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



    public function setDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }

    public function getDateAttribute($value)
    {
        $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');
        return $date;
    }

    public function getCategoryTitle()
    {
        return ($this->category != null)
            ?   $this->category->title
            :   'Нет тут категории';
    }

    public function getTagsTitles()
    {
        return (!$this->tags->isEmpty())
            ?   implode(', ', $this->tags->pluck('title')->all())
            : 'Нет тут тегов';
    }

    public function getDate()
    {
        return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
    }

    public function getCategoryID()
    {
        return $this->category != null ? $this->category->id : null;
    }



    public function hasPrevious()
    {
        return self::where('id', '<', $this->id)->max('id');
    }

    public function getPrevious()
    {
        $postID = $this->hasPrevious(); //ID
        return self::find($postID);
    }

    public function hasNext()
    {
        return self::where('id', '>', $this->id)->min('id');
    }

    public function getNext()
    {
        $postID = $this->hasNext();
        return self::find($postID);
    }

    public function related()
    {
        return self::all()->except($this->id);
    }

    public function hasCategory()
    {
        return $this->category != null ? true : false;
    }


}




