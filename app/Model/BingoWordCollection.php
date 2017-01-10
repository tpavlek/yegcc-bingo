<?php

namespace App\Model;

use Illuminate\Support\Collection;
use Traversable;

class BingoWordCollection implements \IteratorAggregate
{

    private $words;

    public function __construct(Collection $bingoWords, Collection $comments)
    {
        $this->words = new Collection();

        foreach ($bingoWords as $word) {
            /** @var BingoWord $word */
            $this->words->put($word->slug(), [ 'word' => $word, 'comments' => $word->matchesComments($comments) ]);
        }
    }

    public function getIterator()
    {
        return $this->words->getIterator();
    }
}
