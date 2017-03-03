{{--@if(can('notes.*'))--}}
    <li @lightAction('\Pinerp\Notes\NotesController')>
        <a href="{{ action('\Pinerp\Notes\NotesController@index') }}">
            {{ trans('notes::notes.name') }}
        </a>
    </li>
{{--@endif--}}

