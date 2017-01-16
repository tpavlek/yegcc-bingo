<?php

namespace App\Model;

use Illuminate\Support\Collection;

class OpenGraphRetriever
{

    public static function getArticle($url)
    {
        return app('facebook')->get("?id=$url")->getDecodedBody()['og_object'];
    }

    public static function getComments(NewsArticle $article)
    {
        $comments = new Collection();
        $response = app('facebook')->get($article->og_id . "/?fields=comments{message,from,comments}&limit=100")->getDecodedBody()['comments']['data'];

        collect($response)->each(function ($comment) use ($comments) {
            $comments->push(array_only($comment, [ 'message', 'from', 'id' ]));

            if (isset($comment['comments'])) {
                collect($comment['comments']['data'])->each(function ($comment) use ($comments) {
                    $comments->push(array_only($comment, [ 'message', 'from', 'id' ]));
                });
            }
        });

        return $comments->all();
    }

}
