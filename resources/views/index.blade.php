@extends("layout::layout")

{{--@section('title')--}}
    {{--@parent - {{ trans('messages::messages.inbox_messages') }} Заголовок вида заметок--}}
{{--@endsection--}}

@section("breadcrumbs")
    <li>
        <a href="{{action('\Pinerp\Notes\NotesController@index')}}">{{ trans('notes::notes.all_notes') }}</a>
    </li>
@endsection

@section("content")

    {{-- Display top menu of actions --}}
    @include('notes::actions_menu')

    <br>
    <div class="row">
        <div class="col-md-12">

            {{--Current notes--}}
            @if (count($notes) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('notes::notes.all_notes') }}
                    </div>

                    <div class="panel-body ">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ trans('notes::notes.title_of_note') }}</th>
                                    <th>{{ trans('notes::notes.short_content') }}</th>
                                    <th>{{ trans('notes::notes.notify_datetime') }}</th>
                                    <th>{{ trans('notes::notes.actions_with_note') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notes as $note)
                                        <tr>
                                            <td style="max-width: 120px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                                                <a data-toggle="tooltip" title="{{ trans('notes::notes.tooltip.show_details') }}" href="{{ action('\Pinerp\Notes\NotesController@show', ['id' => $note->id]) }}">{{ $note->title }}</a>
                                            </td>
                                            <td style="max-width: 200px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                                                {{ $note->content }}
                                            </td>
                                            <td>{{ $note->notify_datetime }}</td>

                                            <!-- Note Delete / Edit Button -->
                                            <td>
                                                <form action="{{ url('erp/notes/' . $note->id) }}" method="POST" onsubmit="return ConfirmDelete()">
                                                    {{ csrf_field() }}
                                                    {{ method_field('delete') }}

                                                    <a data-toggle="tooltip" title="{{ trans('notes::notes.tooltip.edit') }}" class="btn btn-info" href="{{ action('\Pinerp\Notes\NotesController@edit', ['id' => $note->id]) }}">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                    </a>
                                                    <button data-toggle="tooltip" title="{{ trans('notes::notes.tooltip.delete') }}" type="submit" class="btn btn-danger">
                                                        <i class="glyphicon glyphicon-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        {!! $notes->render() !!}

                        <script>
                            function ConfirmDelete()
                            {
                                var x = confirm("{{ trans('notes::notes.confirm_delete') }}");
                                if (x)
                                    return true;
                                else
                                    return false;
                            }
                            $(function(){
                                $('[data-toggle="tooltip"]').tooltip();
                            });
                        </script>
                    </div>
                </div>
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('notes::notes.current_notes') }}
                    </div>

                    <div class="panel-body ">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>{{ trans('notes::notes.nothing') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            @endif
            {{--Current notes--}}
        </div>
    </div>
@endsection