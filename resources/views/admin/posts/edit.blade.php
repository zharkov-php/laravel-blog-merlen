@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Изменить статью
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <form class="form-horizontal" method="POST" accept-charset="UTF-8" enctype="multipart/form-data" action="{{ route('posts.update', $post->id) }}">
        @csrf
      {{ method_field('PUT') }}
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Обновляем статью</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Название</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{$post->title}}" name="title">
            </div>
            
            <div class="form-group">
              <img src="{{$post->getImage()}}" alt="" class="img-responsive" width="200">
              <label for="exampleInputFile">Лицевая картинка</label>
              <input type="file" id="exampleInputFile" name="image">

              <p class="help-block">Какое-нибудь уведомление о форматах..</p>
            </div>
            <div class="form-group">
              <label>Категория</label>
              <select class="form-control select2"  data-placeholder="Выберите категорию" name="carlist" form="carform">

                @foreach($categories as $category)
                  <option value="#">{{$category}}</option>
                @endforeach

              </select>
            </div>
            <div class="form-group">
              <label>Теги</label>
              <select class="form-control select2" multiple="multiple" data-placeholder="Выберите тег" name="carlist" form="carform">
                @foreach($tags as $tag)
                  <option value="volvo">{{$tag}}</option>
                @endforeach
              </select>
            </div>
            <!-- Date -->
            <div class="form-group">
              <label>Дата:</label>

              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker" value="{{$post->date}}" name="date">
              </div>
              <!-- /.input group -->
            </div>

            <!-- checkbox -->
            <div class="form-group">
              <label>
                <select class="form-control select2" multiple="multiple" data-placeholder="Выберите тег" name="carlist" form="carform">
                  @foreach($tags as $tag)
                    <option value="volvo">{{$tag}}</option>
                  @endforeach
                </select>
              </label>
              <label>
                Рекомендовать
              </label>
            </div>
            <!-- checkbox -->
            <div class="form-group">
              <label>

                <select class="form-control select2" multiple="multiple" data-placeholder="Выберите тег" name="carlist" form="carform">
                  @foreach($tags as $tag)
                    <option value="volvo">{{$tag}}</option>
                  @endforeach
                </select>              </label>
              <label>
                Черновик
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Описание</label>
              <textarea name="description" id="" cols="30" rows="10" class="form-control" >{{$post->description}}</textarea>
          </div>
        </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Полный текст</label>
              <textarea name="content" id="" cols="30" rows="10" class="form-control">{{$post->content}}</textarea>
          </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button class="btn btn-warning pull-right">Изменить</button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
      </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection