<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchMovieController extends Controller
{
    public function searchMovie(Request $request)
    {
        // Added time for loader
        //sleep(1);

        $title = $request->input('title');
        $response = Http::get('https://api.themoviedb.org/3/search/movie?api_key='.env('MOVIE_API_KEY').'&language=en-US&query='.$title.'&page=1&include_adult=true');

        // Successfull response from API
        if ($response->successful()) {
            if (count($response['results']) && isset($response['results'][0])) {

                $data = $response['results'][0];
                $movie_id = $data['id'];
                $released = $data['release_date'];
                $released_formatted = date("F jS, Y", strtotime($released));
                $data['release_date'] = $released_formatted;

                // Get Cast Data
                $castData = $this->getMovieCast($movie_id);
                $data['cast'] = $castData;

                return json_encode($data);

            } else {
                return 'No results';
            }
        } else {
            return 'Failed response';
        }
    }

    public function getMovieCast($movie_id)
    //public function getMovieCast(Request $request)
    {
        //$movie_id = $request->input('id');
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
}
