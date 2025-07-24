<?php

class movie extends Controller {

    public function search() {
        $title = $_GET['title'];  

        $movieData = Movie::fetchMovieFromOmdb($title);

        if ($movieData['Response'] === "True") {
            $movie = Movie::getMovieByImdb($movieData['imdbID']);

            if (!$movie) {
                Movie::saveMovie([
                    'title' => $movieData['Title'],
                    'year' => $movieData['Year'],
                    'genre' => $movieData['Genre'],
                    'imdb_id' => $movieData['imdbID'],
                    'metascore' => $movieData['Metascore'],
                    'imdb_rating' => $movieData['imdbRating'],
                    'description' => $movieData['Plot']
                ]);
            }

            include 'views/movie/details.php';
        } else {
            echo "Movie not found!";
        }
    }

    public function rateMovie($movie_id, $rating) {
        session_start();

        if (!isset($_SESSION['auth'])) {
            echo "You must be logged in to rate movies.";
            return;
        }

        $user_id = $_SESSION['user_id'];
        Movie::saveRating($movie_id, $user_id, $rating);
        echo "Rating submitted successfully!";
    }

    public function generateReview($movie_id) {
        return "need to implement this";  
    }
}
