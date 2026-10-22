@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>{{ $question->title }}</h1>
                    </div>
                    <div class="card-body">
                        {!! $question->body !!}
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between mr-3">
                            <div class="d-flex">
                                <div class="">
                                    @auth
                                        <form action="{{ route('questions.vote', [$question->id, 1]) }}" method="POST">
                                            @csrf
                                            <button type="submit" title="Up Vote"
                                                class="btn {{ auth()->user()->hasQuestionUpVote($question)
    ? 'text-dark'
    : 'text-black-50' }}">
                                                <i class="fa fa-caret-up fa-3x"></i></button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" title="Up Vote"
                                            class="vote-up d-block text-center text-black-50">
                                            <i class="fa fa-caret-up fa-3x"></i>
                                        </a>
                                    @endauth
                                    <h4 class="votes-count text-muted text-center m-0">{{ $question->votes_count }}</h4>
                                    @auth
                                        <form action="{{ route('questions.vote', [$question->id, -1]) }}" method="POST">
                                            @csrf
                                            <button type="submit" title="Down Vote"
                                                class="btn {{ auth()->user()->hasQuestionDownVote($question)
    ? 'text-dark'
    : 'text-black-50' }}">
                                                <i class="fa fa-caret-down fa-3x"></i></button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" title="Down Vote"
                                            class="vote-down d-block text-center text-black-50">
                                            <i class="fa fa-caret-down fa-3x"></i>
                                        </a>
                                    @endauth
                                </div>
                                {{-- <a href="" title="Mark as Fav" class="favorite d-block text-center text-dark mb-2">

                                </a> --}}
                                <div class="ml-5 mt-3">
                                    @can('markAsFavorite', $question)
                                        <form
                                            action="{{ route($question->is_favorite ? 'questions.unfavorite' : 'questions.favorite', $question->id) }}"
                                            method="POST">
                                            @csrf
                                            @if ($question->is_favorite)
                                                @method('DELETE')

                                            @endif
                                            <button type="submit" class="btn {{ $question->favorite_style }}">
                                                <i class="fa fa-star fa-2x"></i>
                                            </button>
                                        </form>
                                    @else
                                        <i class="far mb-2 fa-star text-success fa-2x d-block"></i>
                                    @endcan
                                    <h4 class="views-count {{ $question->favorite_style }} text-center m-0">
                                        {{ $question->favorites_count }}</h4>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <div class="text-muted mb-2 text-right">
                                    <p>Asked {{ $question->created_date }}</p>
                                </div>
                                <div class="d-flex mb-2">
                                    <div class="">
                                        <img src="{{ $question->owner->avatar }}" alt="">
                                    </div>
                                    <div class="mt-2 ml-2">
                                        <p>{{ $question->owner->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('answers._index')
        @include('answers.create')

    </div>
@endsection
