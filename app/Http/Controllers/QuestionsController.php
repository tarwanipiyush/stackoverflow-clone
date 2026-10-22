<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\CreateQuestionRequest;
use App\Http\Requests\Question\UpdateQuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuestionsController extends Controller
{



    public function __construct()
    {
        $this->middleware(['auth'])->only('create', 'store', 'edit', 'update', 'destroy');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::with('owner')->latest()->paginate(10);
        return view('questions.index', compact(['questions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (app()->bound('debugbar')) {
            app('debugbar')->disable();
        }
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateQuestionRequest $request)
    {
        auth()->user()->questions()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        session()->flash('success', 'Question has been added successfully!');
        return redirect(route('questions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views_count');
        return view('questions.show', compact(['question']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        // if (Gate::allows('update-question', $question)) {
        //     return view('questions.edit', compact(['question']));
        // }
        if ($this->authorize('update', $question)) {
            return view('questions.edit', compact(['question']));
        }
        abort(403, 'Access Denied');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        // if (Gate::allows('update-question', $question)) {
        // $question->update([
        //     'title' => $request->title,
        //     'body' => $request->body
        // ]);
        // session()->flash('success', 'Question updated successfully');
        // return redirect(route('questions.index'));
        // }
        if ($this->authorize('update', $question)) {
            $question->update([
                'title' => $request->title,
                'body' => $request->body
            ]);
            session()->flash('success', 'Question updated successfully');
            return redirect(route('questions.index'));
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        // if (auth()->user()->can('delete-question', $question)) {
        //     $question->delete();
        //     session()->flash('success', 'Question deleted!');
        //     return redirect(route('questions.index'));
        // }
        if ($this->authorize('delete', $question)) {
            $question->delete();
            session()->flash('success', 'Question deleted!');
            return redirect(route('questions.index'));
        }
        abort(403);
    }
}
