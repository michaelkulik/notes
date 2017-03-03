@extends('layout::layout')

@section('head')
    {{-- Scripts for datepicker for datetime input --}}
    <script type="text/javascript" src="/notes/js/moment-with-locales.min.js"></script>
    <script type="text/javascript" src="/notes/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="/notes/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/notes/css/style.css">
@endsection

@section("breadcrumbs")
    <li>
        <a href="{{action('\Pinerp\Notes\NotesController@index')}}">{{ trans('notes::notes.all_notes') }}</a>
    </li>
    <li>
        <a href="{{action('\Pinerp\Notes\NotesController@create')}}">{{ trans('notes::notes.create') }}</a>
    </li>
@endsection

@section('content')
    {{-- Display top menu of actions --}}
    @include('notes::actions_menu')
    <br>

    <div class="row">
        <div class="col-md-12">
            <h3>Создание новой заметки</h3>
            <br>

            <!-- Display Validation Errors -->
            {{--@include('notes::common.errors')--}}

            {!! Form::open(['route' => 'erp.notes.store']) !!}
            <div class="form-group row">
                {!! Form::label('title', trans('notes::notes.fields.title'), ['class' => 'col-sm-4 form-control-label require_label']) !!}
                <div class="col-sm-8 input-group">
                    {!! Form::text('title', '', ['required' => 'required','class' => 'form-control', 'placeholder' => trans('notes::notes.fields.title')]) !!}
                </div>
            </div>

            <div class="form-group row">
                {!! Form::label('content', trans('notes::notes.fields.content'), ['class' => 'col-sm-4 form-control-label']) !!}
                <div class="col-sm-8 input-group">
                    {!! Form::textarea('content', null, ['class' => 'form-control', 'rows' => '3', 'placeholder' => trans('notes::notes.fields.content')]) !!}
                </div>
            </div>

            @if(can('notes.note.create_notify'))
            <div class="form-group row">
                <label for="notify_datetime" class="col-sm-4 form-control-label">{{ trans('notes::notes.fields.notify_time') }}</label>
                <div class='col-sm-2 input-group date'>
                    {!! Form::text('notify_datetime', '', ['id' => 'notify_datetime','class' => 'form-control', 'placeholder' => trans('notes::notes.fields.set_notify_time')]) !!}
                    {{--<span class="input-group-addon">--}}
                        {{--<span class="glyphicon glyphicon-calendar"></span>--}}
                    {{--</span>--}}
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-3 input-group">
                    <div class="alert alert-info">
                        {{ trans('notes::notes.info') }}
                    </div>
                </div>
            </div>
            @endif

            <script type="text/javascript">
                $(function () {
                    //Установим для виджета русскую локаль с помощью параметра language и значения ru
                    $('#notify_datetime').datetimepicker(
                            {language: 'ru'}
                    );
                });
            </script>

            <div class="form-group row">
                <div class="col-sm-3 col-sm-offset-4 input-group">
                    {!! Form::submit(trans('layout::common.button.create'), ['class' => 'btn btn-success']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <a href="{{ action('\Pinerp\Notes\NotesController@index') }}" class="btn btn-default">{{ trans('notes::notes.button.back') }}</a>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
