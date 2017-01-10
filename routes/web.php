<?php

Route::get('/', 'BingoController@home')->name('home');
Route::post('bingo', 'BingoController@newArticle')->name('bingo.new_article');
Route::get('bingo/{article}', 'BingoController@show')->name('bingo.show');
