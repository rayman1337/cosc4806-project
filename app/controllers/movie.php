<?php

class Movie extends Controller {
    private $movieModel;
    private $geminiModel;

    public function __construct() {
        $this->movieModel = $this->model('MovieModel');
        $this->geminiModel = $this->model('GeminiModel');
    }

    public function search() {
        if (isset($_GET['title']) && !empty($_GET['title'])) {
            $title = $_GET['title'];

            $movieData = $this->movieModel->fetchMovieFromOmdb($title);
            
            if ($movieData && isset($movieData['Response']) && $movieData['Response'] === "True") {
                $averageRating = $this->movieModel->getMovieRatings($movieData['imdbID']);
                $userRating = isset($_SESSION['user_id']) ? $this->movieModel->getUserRating($_SESSION['user_id'], $movieData['imdbID']) : null;
                $showSuccessMessage = isset($_GET['action']) && $_GET['action'] === 'rateing_completed';
                echo $showSuccessMessage;

                $data = [
                    'movie' => $movieData,
                    'averageRating' => $averageRating ? $averageRating['averageRating'] : null,
                    'userRating' => $userRating ? $userRating['rating'] : null,
                    'isAuthenticated' => isset($_SESSION['auth']) && $_SESSION['auth'] == 1,
                    'query' => $title,
                    'showSuccessMessage' => $showSuccessMessage
                ];

                $this->view('movie/details', $data);
            } else {
                $this->view('movie/details');
            }
        } else {
            echo 'No title provided';
        }
    }

    public function rateMovie() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['auth'])) {
            $movie_id = $_POST['movie_id'];
            $movie_name = $_POST['movie_name'];
            $rating = $_POST['rating'];
            $user_id = $_SESSION['user_id'];

            $this->movieModel->saveRating($user_id, $movie_name, $movie_id, $rating);
            header("Location: /movie/search?title=" . urlencode($movie_name) . "&action=rating_completed");
            exit();
        } else {
            echo "You must be logged in to rate movies.";
        }
    }

    public function generateReview() {
        if (!isset($_SESSION['auth'])) {
            echo 'You must be logged in to generate a review.';
            return;
        }

         $movie_name = $_POST['query'];
        
        if (!isset($movie_name)) {
            echo 'No movie title provided';
            return;
        }

        $movieData = $this->movieModel->fetchMovieFromOmdb($movie_name);

        if ($movieData && isset($movieData['Response']) && $movieData['Response'] === "True") {
            $averageRating = $this->movieModel->getMovieRatings($movieData['imdbID']);
            $averageRatingNumericalValue = $averageRating ? $averageRating['averageRating'] : null;

            
            $prompt = $averageRatingNumericalValue ? 
            "Please give a review for " . $movieData['Title'] . " that has an average rating of " . round($averageRatingNumericalValue, 1) . " out of 5." :
            "Please give a review for " . $movieData['Title'];

            $response = $this->geminiModel->ask($prompt);

            $data = [
                'aiReview' => $response,
                'movie' => $movieData,
                'averageRating' => $averageRating ? $averageRating['averageRating'] : null,
                'userRating' => $userRating ? $userRating['rating'] : null,
                'isAuthenticated' => isset($_SESSION['auth']) && $_SESSION['auth'] == 1,
                'query' => $movie_id, 
            ];

            $this->view('movie/details', $data);
        } else {
            echo 'Movie not found or API error';
        }
    }

}
