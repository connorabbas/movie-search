<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MovieService;

class MovieSearchController extends Controller
{
    public function getMovieDetails(Request $request, MovieService $movieService)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $title = $request->input('title');
        $movieDetails = $movieService->searchMovie($title);

        if (is_array($movieDetails)) {
            $movie_id = $movieDetails['id'];

            // Get Cast Data
            $castData = $movieService->getMovieCast($movie_id);
            $movieDetails['cast'] = $castData;

            // Runtime data
            $runtimeData = $movieService->getMovieRuntime($movie_id);
            $movieDetails['runtime'] = convertToHoursMins($runtimeData); // custom helper function

            // encode
            $movieDetails = json_encode($movieDetails);
        } 

        return $movieDetails;
    }
}
