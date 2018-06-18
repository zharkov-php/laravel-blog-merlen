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

        <!-- Default box -->
        <div class="box">
            <form class="form-horizontal" method="POST" action="{{ route('categories.store') }}">
                {{ csrf_field() }}
            <div class="box-header with-border">
                <h3 class="box-title">Добавляем категорию</h3>
            </div>
                @include('admin.errors')
            <div class="box-body">
                <div class="col-md-6">
                    <div class="form-group">

                        <label for="exampleInputEmail1">Название</label>
                        <input type="text" class="form-control" id="exampleInputEmail" placeholder="" name="title">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <a href="{{route('categories.index')}}"> <button class="btn btn-default">Назад</button></a>
                <button class="btn btn-success pull-right">Добавить</button>
            </div>
            <!-- /.box-footer-->
            </form>
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection