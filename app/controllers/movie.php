<?php

class Movie extends Controller {
    private $movieModel;

    public function __construct() {
        $this->movieModel = $this->model('MovieModel');
    }

    public function search() {
        if (isset($_GET['title']) && !empty($_GET['title'])) {
            $title = $_GET['title'];

            $movieData = $this->movieModel->fetchMovieFromOmdb($title);
            
            if ($movieData && isset($movieData['Response']) && $movieData['Response'] === "True") {
                $averageRating = $this->movieModel->getMovieRatings($movieData['imdbID']);
                $userRating = isset($_SESSION['user_id']) ? $this->movieModel->getUserRating($_SESSION['user_id'], $movieData['imdbID']) : null;

                $data = [
                    'movie' => $movieData,
                    'averageRating' => $averageRating ? $averageRating['averageRating'] : null,
                    'userRating' => $userRating ? $userRating['rating'] : null,
                    'isAuthenticated' => isset($_SESSION['auth']) && $_SESSION['auth'] == 1,
                    'query' => $title,
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


            header("Location: /movie/search?title=" . urlencode($movie_name) . "&");
            exit();
        } else {
            echo "You must be logged in to rate movies.";
        }
    }

    public function generateReview($movie_id) {
        return "Review feature coming soon.";
    }
}
