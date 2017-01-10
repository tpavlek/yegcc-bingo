<?php

namespace App\Model;

class OpenGraphRetriever
{

    public static function getArticle($url)
    {
        return app('facebook')->get("?id=$url")->getDecodedBody()['og_object'];
    }

    public static function getComments(NewsArticle $article)
    {
        return app('facebook')->get($article->og_id . "/comments?limit=100")->getDecodedBody()['data'];
    }

}
