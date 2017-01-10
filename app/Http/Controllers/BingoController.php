<?php

namespace App\Http\Controllers;

use App\Model\BingoWord;
use App\Model\BingoWordCollection;
use App\Model\NewsArticle;
use Illuminate\Http\Request;

class BingoController extends Controller
{

    public function home()
    {
        $articles = NewsArticle::with('comments')->get()->sortByDesc(function ($newsArticle) {
            return $newsArticle->comments->count();
        })->slice(0, 5);
        return view('index')->with('articles', $articles);
    }

    public function newArticle(Request $request)
    {
        $url = $request->get('article_url');

        $article = NewsArticle::forUrl($url);

        return redirect()->route('bingo.show', $article->id);
    }

    public function show(NewsArticle $article)
    {
        $bingos = [
            BingoWord::initialize('NDP'),
            BingoWord::initialize('Rachel Notley', 'Notley'),
            BingoWord::initialize('Pot Hole', 'pothole', 'pot holes', 'potholes'),
            BingoWord::initialize('Bridge'),
            BingoWord::initialize('Photo Radar'),
            BingoWord::initialize('Cash Grab', 'cash cow'),
            BingoWord::initialize('Bike Lanes', 'bike lane', 'bikelane'),
            BingoWord::initialize('Tax Dollars', 'taxes'),
            BingoWord::initialize('Carbon Tax'),
            BingoWord::initialize('iveRson'),
            BingoWord::initialize('Pet Projects', 'pet project'),
            BingoWord::initialize('LRT', 'metro line'),
            BingoWord::initialize('As a Taxpayer', 'I pay taxes'),
            BingoWord::initialize('Free Parking', 'parking'),
            BingoWord::initialize('Raise Speed Limits', 'higher speeds', 'higher speed', 'more speed', 'faster'),
            BingoWord::initialize('Lower Speed Limits', 'lower speeds', 'lower speed', 'less speed', 'slower'),
            BingoWord::initialize('Government Pigs', 'trough', 'oink'),
            BingoWord::initialize('Wasteful spending', 'wasting money', 'wasting tax', 'wasting dollars'),
            BingoWord::initialize('Big Silver Balls', 'silver balls', 'talus dome'),
            BingoWord::initialize('Jaywalkers', 'jaywalk', 'jaywalking', 'distracted walkers', 'glued to phone')
        ];

        shuffle($bingos);

        $words = new BingoWordCollection(collect($bingos), $article->comments);

        return view('bingo.show')->with('article', $article)->with('words', $words);
    }

}
