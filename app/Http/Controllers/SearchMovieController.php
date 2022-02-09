<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchMovieController extends Controller
{
    public function getMovieDetails(Request $request)
    {
        $movieDetails = [];
        $title = $request->input('title');

        // Get Search Data
        $movieDetails = $this->searchMovie($title);
        if (is_array($movieDetails)) {
            $movie_id = $movieDetails['id'];

            // Get Cast Data
            $castData = $this->getMovieCast($movie_id);
            $movieDetails['cast'] = $castData;

            // Runtime data
            $runtimeData = $this->getMovieRuntime($movie_id);
            $movieDetails['runtime'] = $this->convertToHoursMins($runtimeData);

            // endcode
            $movieDetails = json_encode($movieDetails);
        } 
        return $movieDetails;
    }

    public function searchMovie($searched)
    {
        $response = Http::get('https://api.themoviedb.org/3/search/movie?api_key='.env('MOVIE_API_KEY').'&language=en-US&query='.$searched.'&page=1&include_adult=true');

        // Successfull response from API
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
        } else {
            return 'Failed response';
        }
    }

    public function getMovieCast($movie_id)
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/'.$movie_id.'/credits?api_key='.env('MOVIE_API_KEY'));

        // Successfull response from API
        if ($response->successful()) {
            $decoded = json_decode($response, true);
            return array_slice($decoded['cast'], 0, 10);
            //return $decoded['cast'];
        } else {
            return 'Failed response';
        }
    }

    public function getMovieRuntime($movie_id)
    {
        $response = Http::get('https://api.themoviedb.org/3/movie/'.$movie_id.'?api_key='.env('MOVIE_API_KEY'));

        // Successfull response from API
        if ($response->successful()) {
            $decoded = json_decode($response, true);
            return $decoded['runtime'];
        } else {
            return 'Failed response';
        }
    }

    public function convertToHoursMins($mins) {
        if ($mins < 1) {
            return;
        }
        $hours = floor($mins / 60);
        $minutes = ($mins % 60);
        return sprintf('%02d hour/s %02d minutes', $hours, $minutes);
    }
}
