@extends('layout')

@section('content')

    <h1>#yegcc Bingo!</h1>
    <div class="whitecard">
        <p>
            #yegcc Bingo is easy to play! Simply enter the link to an Edmonton Journal Article (or select from other submitted ones)
        </p>

        <p>
            <strong>Note:</strong> This tool is very much in beta, and currently only works with the Edmonton Journal.
        </p>

        <p>
            This site was made with 💖 (and sarcasm) by <a href="https://tpavlek.me">Troy Pavlek</a>
        </p>
    </div>

    <div class="whitecard">
        <form action="{{ route('bingo.new_article') }}" method="POST">
            {{ csrf_field() }}
            <label for="article_url">Article URL:
                <input type="text" name="article_url" />
            </label>

            <input type="submit" value="Submit" />

        </form>
    </div>

    <div class="whitecard">
        <h2 style="color:black;">Other submitted articles...</h2>
        <hr />
        @foreach ($articles as $article)
            <div>
                <h3><a href="{{ route('bingo.show', $article->id) }}">{{ $article->title }}</a></h3>
                <h4>{{ $article->description }}</h4>
            </div>
            <hr />
        @endforeach
    </div>

@stop


