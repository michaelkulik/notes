@extends('layout::layout')

@section("breadcrumbs")
    <li>
        <a href="{{action('\Pinerp\Notes\NotesController@index')}}">{{ trans('notes::notes.all_notes') }}</a>
    </li>
    <li>
        <a href="{{action('\Pinerp\Notes\NotesController@create')}}">{{ trans('notes::notes.show') }}</a>
    </li>
@endsection

@section('content')
    {{-- Display top menu of actions --}}
    @include('notes::actions_menu')
    <br>

    <div class="row">
        <div class="col-sm-12">
            <h3>{{ trans('notes::notes.show') }} "{{ $note->title }}"</h3>
            <br>

            <div class="row">
                <div class="col-sm-3">{{ trans('notes::notes.fields.content') }}:</div>
                <div class="col-sm-9" style="border-left: 1px solid red;">
                    @if (!empty($note->content)){{ $note->content }}
                    @else {{ trans('notes::notes.empty') }}
                    @endif
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-sm-3">{{ trans('notes::notes.fields.notify_time') }}:</div>
                <div class="col-sm-9" style="border-left: 1px solid red;">
                    @if (!empty($note->notify_datetime)) {{ $note->notify_datetime }}
                    @else {{ trans('notes::notes.empty_notify_datetime') }}
                    @endif
                </div>
            </div>
            <br>

            @if (!empty($note->notify_datetime))
            <div class="row">
                <div class="col-sm-3">
                    <div class="alert alert-info">
                        {{ trans('notes::notes.info') }}
                    </div>
                </div>
            </div>
            @endif

            <div class="row">
                <div class="col-sm-2">
                    <a href="{{ action('\Pinerp\Notes\NotesController@index') }}" class="btn btn-default">{{ trans('notes::notes.button.back') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection