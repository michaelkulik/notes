<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills">
            <li @lightAction('\Pinerp\Notes\NotesController@create')><a href="{{ action('\Pinerp\Notes\NotesController@create') }}">{{ trans('notes::notes.create_note') }}</a></li>
            <li @lightAction('\Pinerp\Notes\NotesController@index')><a href="{{ action('\Pinerp\Notes\NotesController@index') }}">{{ trans('notes::notes.list_of_all_notes') }}</a></li>
        </ul>
    </div>
</div>