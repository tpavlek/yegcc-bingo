<?php

namespace App\Model;

use Illuminate\Support\Collection;

class BingoWord
{

    private $word;
    private $synonyms;

    public function __construct($word, $synonyms)
    {
        $this->word = $word;
        $this->synonyms = $synonyms;
    }

    public static function initialize($word, ...$synonyms)
    {
        return new self($word, $synonyms);
    }

    public function comparisonWords()
    {
        return collect($this->synonyms)
            ->map(function ($word) {
                return strtolower($word);
            })
            ->push(strtolower($this->word))
            ->all();
    }

    public function matchesComments(Collection $comments)
    {
        return $comments->filter(function ($comment) {
            return str_contains(strtolower($comment->message), $this->comparisonWords());
        });
    }

    public function slug()
    {
        return str_replace(' ', '-', strtolower($this->word));
    }

    public function toString()
    {
        return $this->word;
    }
}
