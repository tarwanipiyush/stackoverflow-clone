<?php

namespace App\Helpers;

trait Votable
{
    public function vote(int $vote)
    {
        $this->votes()->attach(auth()->id(), ['vote' => $vote]);
        if ($vote < 0) {
            $this->decrement('votes_count');
        } else {
            $this->increment('votes_count');
        }
    }

    public function updateVote(int $vote)
    {
        $this->votes()->updateExistingPivot(auth()->id(), ['vote' => $vote]);
        if ($vote < 0) {
            $this->decrement('votes_count');
            $this->decrement('votes_count');
        } else {
            $this->increment('votes_count');
            $this->increment('votes_count');
        }
    }
}
