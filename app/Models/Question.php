<?php

namespace App\Models;

use App\Helpers\Votable;
// use app\Helpers\Votable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;
    use Votable;
    protected $guarded = ['id'];

    public function getUrlAttribute()
    {
        return "questions/{$this->slug}";
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getAnswerStyleAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "has-best-answer";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getIsFavoriteAttribute()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getFavoriteStyleAttribute()
    {
        if ($this->getIsFavoriteAttribute()) {
            return 'text-success';
        }
        return 'text-black-50';
    }
    /*
    *   MUTATORS
    */
    public function setTitleAttribute(string $title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }
    public function markBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    /*
    * RELATIONSHIP METHODS
    */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function votes()
    {
        return $this->morphToMany(User::class, 'vote')->withTimestamps();
    }
}
