@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column is-3">
                @include('trips._sidebar', ['trip' => $day->trip])
            </div>

            <div class="column">
                <h1 class="title">{{ __('Edit a Day') }}</h1>

                <form action="{{ route('days.update', $day) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    {{ csrf_field() }}
                    <div class="field">
                        <label class="label" for="name">{{ __('Name') }}</label>
                        <p class="control">
                            <input type="text" class="input" name="name" id="name" value="{{ old('name', $day->name) }}">
                        </p>
                    </div>
                    <div class="field">
                        <label class="label" for="date">{{ __('Date') }}</label>
                        <p class="control">
                            <input type="date" class="input" name="date" value="{{ old('date', $day->date) }}">
                        </p>
                    </div>

                    <button type="submit" class="button is-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection