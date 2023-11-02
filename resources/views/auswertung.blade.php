@extends('layouts.app')

@section('content')
    <div class="container mb-4 pt-5">
        <form action="{{ route('auswertung') }}" method="get">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="bid" class="form-control" placeholder="Buchungsnummer" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" style="padding: 9px; font-size: 12px;">Senden</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>User Name</th>
                <th>Task Name</th>
                <th>Value</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                @php
                    $isNewUser = true;
                @endphp
                @foreach ($user->tasks as $task)
                    <tr @if($isNewUser) style="font-weight: 700;" @endif>
                        <td>{{ $user->name }}</td>
                        <td>
                            @switch($task->task)
                                @case(10)
                                    Teamname
                                    @break
                                @case(20)
                                    Teamfoto
                                    @break
                                @case(30)
                                    Videobotschaft
                                    @break
                                @case(40)
                                    Klassenfoto
                                    @break
                                @case(50)
                                    Erinnerungsvideo
                                    @break
                                @default
                                    Aufgabe {{ $task->task }}
                            @endswitch
                        </td>
                        <td>
                            @if(in_array($task->type, ['video-uploaded', 'image-uploaded', 'audio-recorded']))
                                <a href="{{ asset('uploads/' . $task->value) }}">{{ $task->value }}</a>
                            @else
                                {{ $task->value }}
                            @endif
                        </td>
                    </tr>
                    @php
                        $isNewUser = false;
                    @endphp
                @endforeach
            @endforeach
            </tbody>

        </table>
    </div>
@endsection
