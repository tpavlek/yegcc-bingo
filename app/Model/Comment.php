<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $guarded = [];
    public $incrementing = false;

    public function news_article()
    {
        return $this->belongsTo(NewsArticle::class, 'article_id', 'id');
    }
}
