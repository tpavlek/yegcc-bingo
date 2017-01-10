<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class NewsArticle extends Model
{

    protected $guarded = [];
    public $incrementing = false;

    protected $casts = [
        'last_queried' => 'date'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'article_id', 'id');
    }

    public function containsBingo(BingoWord $bingoWord)
    {
        return $this->comments->first(function (Comment $comment) use ($bingoWord) {
            return str_contains(strtolower($comment->message), $bingoWord->comparisonWords());
        });
    }

    public static function forUrl($url)
    {
        $instance = self::query()->where([ 'url' => $url ])->first();

        if ($instance === null) {
            // We need to determine the opengraph ID for this article
            $article = OpenGraphRetriever::getArticle($url);
            $instance = self::query()->firstOrNew([ 'og_id' => $article['id'] ]);

            if ($instance->id === null) {
                $instance->id = Uuid::uuid4()->toString();
            }

            if ($instance->url === null) {
                $instance->url = $url;
            }

            $instance->title = $article['title'];
            $instance->description = $article['description'];

            $instance->save();
        }

        $instance->syncComments();
        return $instance;
    }

    private function shouldSyncComments()
    {
        return ($this->last_queried === null) || ($this->last_queried->addHour()->lt(Carbon::now()));
    }

    public function syncComments()
    {
        if (!$this->shouldSyncComments()) {
            return;
        }

        $comments = collect(OpenGraphRetriever::getComments($this))
            ->map(function ($comment) {
                $instance = Comment::query()->firstOrNew([ 'fb_id' => $comment['id'], 'article_id' => $this->id ]);

                if ($instance->id === null) {
                    $instance->id = Uuid::uuid4()->toString();
                }

                $instance->message = utf8_encode($comment['message']);
                $instance->author_id = $comment['from']['id'];
                $instance->author_name = $comment['from']['name'];

                $instance->save();
            });

        $this->last_queried = Carbon::now()->toDateTimeString();
        $this->save();
        return;
    }
}
