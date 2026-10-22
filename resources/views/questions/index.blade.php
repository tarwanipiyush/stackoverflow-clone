@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="d-flex justify-content-end mb-2">
                    <a href="{{ route('questions.create') }}" class="btn btn-outline-primary">Ask a Question!</a>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2>All Questions</h2>
                    </div>
                    @foreach ($questions as $question)
                        <div class="card-body">
                            <div class="media">
                                <div class="mr-4 statistics">
                                    <div class="votes text-center mb-3">
                                        <strong class="d-block">{{ $question->votes_count }}</strong>Votes
                                    </div>
                                    {{--  --}}
                                    <div class="answers text-center mb-3 {{ $question->answer_style }}">
                                        <strong class="d-block">{{ $question->answers_count }}</strong> Answers
                                    </div>
                                    <div class="views text-center mb-3">
                                        <strong class="d-block">{{ $question->views_count }}</strong> Views
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div class="d-flex justify-content-between">
                                        <h4><a href="{{ $question->url }}">{{ $question->title }}</a></h4>
                                        <div>
                                            {{-- @if (auth()->check() &&
    auth()->user()->can('update-question', $question)) --}}
                                            @can('update', $question)
                                                <a href="{{ route('questions.edit', $question->id) }}"
                                                    class="btn btn-sm btn-outline-info">Edit</a>
                                            @endcan
                                            {{-- @endif --}}
                                            @can('delete', $question)
                                                <form action="{{ route('questions.destroy', $question->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                                                </form>

                                            @endcan
                                        </div>
                                    </div>
                                    <p>Asked By: <a href="#">{{ $question->owner->name }}</a>
                                        <span class="text-muted">{{ $question->created_date }}</span>
                                    </p>
                                    <p>{!! Str::limit($question->body, 255, '...') !!}</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="card-footer">
                        {{ $questions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
