<?php

namespace App\Models;

use App\Helpers\Votable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    use Votable;
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        static::created(function (Answer $answer) {
            $answer->question->increment('answers_count');
        });
        static::deleted(function (Answer $answer) {
            $answer->question->decrement('answers_count');
        });
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getBestAnswerStyleAttribute()
    {
        if ($this->id === $this->question->best_answer_id) {
            return "text-success";
        }
        return "text-dark";
    }

    public function getIsBestAnswerAttribute()
    {
        return $this->id === $this->question->best_answer_id;
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function votes()
    {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }
}
