@extends('layout')

@section('content')

    <h1>#yegcc Bingo!</h1>

    <div class="card-panel">
        <p>
            #yegcc Bingo is easy to play! Simply enter the link to an Edmonton Journal Article (or select from other submitted ones)
        </p>

        <p>
            <strong>Note:</strong> This tool is very much in beta, and currently only works with the Edmonton Journal.
        </p>

        <p>
            This site was made with 💖 (and sarcasm) by <a href="https://tpavlek.me">Troy Pavlek</a>
        </p>

        <form action="{{ route('bingo.new_article') }}" method="POST" class="col s12">
            {{ csrf_field() }}

            <div class="row">
                <div class="input-field col s8">
                    <input placeholder="Edmonton Journal Article" id="article_url" name="article_url" type="text" class="validate">
                    <label for="article_url">Article URL</label>
                </div>
                <div class="input-field col s4">
                    <button class="waves-effect waves-light btn-large"><i class="material-icons right">play_arrow</i>Play Now</button>
                </div>
            </div>
        </form>
    </div>

    <h1>Some recent articles...</h1>

    <div class="row">
        @foreach ($articles as $article)

                <div class="col s4">
                    <div class="card">
                        <div class="card-image">
                            <img src="{{ $article->image_url }}">

                            <a class="btn-floating btn-large halfway-fab waves-effect waves-light red" href="{{ route('bingo.show', $article->id) }}"><i class="material-icons">play_arrow</i></a>
                        </div>

                        <div class="card-content">
                            <span class="card-title">{{ $article->title }}</span>
                            <p>
                                {{ $article->description }}
                            </p>
                        </div>
                        <div class="card-action">
                            <a href="{{ route('bingo.show', $article->id) }}">Play Article</a>
                        </div>
                    </div>
                </div>

        @endforeach
    </div>

@stop


