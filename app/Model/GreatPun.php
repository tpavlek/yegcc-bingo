<?php

namespace App\Model;

class GreatPun extends BingoWord
{

    public function __construct($words)
    {
        $collection = collect($words)->shuffle();

        $this->word = $collection->first();
        $this->synonyms = $collection->slice(1)->all();
    }


}
