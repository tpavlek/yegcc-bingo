@extends('layout')

@section('content')

<h1>
    <a href="{{ $article->url }}">
        {{ $article->title }}
    </a>
</h1>
<h2>{{ $article->description }}</h2>

<style>

    .bingo-board {
        display: flex;
        text-align: center;
        margin: 0 auto;
        justify-content: center;
        flex-flow: row wrap;
    }

    .bingo-item {
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        align-items: center;
        width: 4em;
        max-width: 8em;
        height: 5em;
        background: lightgray; padding: 1em; border: 1px solid black; flex-basis: 20%; font-size: 2em;
    }

    .bingo-item:hover {
        cursor: pointer;
    }

    .bingo-item.marked { background: #125e03;}

    .comment-section {
        width: 100%;
        text-align: center;
    }
    .comment { display: none; padding: 1rem; max-width: 30rem; border: 1px solid black; margin: 0 auto; background: white;}
</style>

<a href="{{ route('home') }}" class="button button-lg">Play Again</a>

<div class="bingo-board">
    @foreach ($words as $word)
        <div class="bingo-item @if($word['comments']->count()) marked @endif" data-word="{{ $word['word']->slug() }}">
             {{ $word['word']->toString() }}
        </div>
    @endforeach
</div>

<br />

<div class="comment-section">
    @foreach($words as $word)
        @foreach ($word['comments'] as $comment)
            <div class="comment whitecard" data-bingo-cue="{{ $word['word']->slug() }}">
                <h3>{{ $comment->author_name }} says...</h3>
                {{ $comment->message }}
            </div>
        @endforeach
    @endforeach
</div>

<br />

<script>
    $('.bingo-item').click(function() {
        $('.comment').hide('fast');

        var bingoWord = $(this).data('word');

        $('.comment[data-bingo-cue=' + bingoWord + ']').show('fast');
        $('html, body').animate({
            scrollTop: $('.comment[data-bingo-cue=' + bingoWord + ']').offset().top
        }, 500);
    })
</script>
@stop


