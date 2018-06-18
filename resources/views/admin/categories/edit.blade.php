@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить категорию
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <form method="post" action="{{action('Admin\CategoriesController@update', $id)}}" >
      @csrf
      <!-- Default box -->
        <input name="_method" type="hidden" value="PATCH">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Меняем категорию</h3>
          @include('admin.errors')
        </div>
        <div class="box-body">

          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Название</label>
              <input type="text" class="form-control" id="exampleInputEmail1" name="title" placeholder="" value="{{$category->title}}">
            </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="{{route('categories.index')}}"><button class="btn btn-default">Назад</button></a>
          <a href=""><button class="btn btn-warning pull-right">Изменить</button></a>
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