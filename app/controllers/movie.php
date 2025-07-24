<?php
require_once 'app/core/Controller.php';

class Movie extends Controller {

    private $movieModel;

    public function __construct() {
        $this->movieModel = $this->model('MovieModel');
    }

    public function search() {
        if (!isset($_GET['title']) || empty($_GET['title'])) {
            echo 'No title provided';
            return;
        }
        $movieData = $this->movieModel->fetchMovieFromOmdb($_GET['title']);

        if ($movieData && isset($movieData['Response']) && $movieData['Response'] === "True") {
            $this->view('movie/details', ['movieData' => $movieData]);  
        } else {
            echo 'Movie not found or API error';  
        }
    }

    public function rateMovie($movie_id, $rating) {
        session_start();

        if (!isset($_SESSION['auth'])) {
            echo "You must be logged in to rate movies.";
            return;
        }

        $user_id = $_SESSION['user_id'];
        $this->movieModel->saveRating($movie_id, $user_id, $rating);

        echo "Rating submitted successfully!";
    }

    public function generateReview($movie_id) {
        return "need to implement this";
    }
}