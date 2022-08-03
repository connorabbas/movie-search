<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MovieService
{
    public function searchMovie($searched)
    {
        $response = Http::get('https://api.themoviedb.org/3/search/movie?api_key='.env('MOVIE_API_KEY').'&language=en-US&query='.$searched.'&page=1&include_adult=true');

        if ($response->successful()) {
            if (count($response['results']) && isset($response['results'][0])) {
                $data = $response['results'][0];
                $released = $data['release_date'];
                $released_formatted = date("F jS, Y", strtotime($released));
                $data['release_date'] = $released_formatted;
                return $data;
            } else {
                return 'No results';
            }
        }

        return 'Failed response';
    }

    public function getMovieCast($movie_id)
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/'.$movie_id.'/credits?api_key='.env('MOVIE_API_KEY'));

        if ($response->successful()) {
            $decoded = json_decode($response, true);
            return array_slice($decoded['cast'], 0, 10);
        } 

        return 'Failed response';
    }

    public function getMovieRuntime($movie_id)
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/'.$movie_id.'?api_key='.env('MOVIE_API_KEY'));

        if ($response->successful()) {
            $decoded = json_decode($response, true);
            return $decoded['runtime'];
        }

        return 'Failed response';
    }
}
