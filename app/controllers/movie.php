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
            $aiReview = "AI review coming soon..."; 

            $this->view('movie/details', [
                'movieData' => $movieData,
                'aiReview' => $aiReview
            ]);  
        } else {
            echo 'Movie not found or API error';  
        }
    }

    public function rateMovie() { 
        session_start();
        
        if (!isset($_SESSION['auth'])) {
            echo "You must be logged in to rate movies.";
            return;
        }

 
        if (!isset($_POST['movie_id']) || !isset($_POST['rating'])) {
            echo "Missing required data.";
            return;
        }

        $movie_id = $_POST['movie_id'];
        $rating = $_POST['rating'];
        $user_id = $_SESSION['user_id'];
        $movie_name = $_POST['movie_name'];

        $this->movieModel->saveRating($movie_id,$movie_name, $user_id, $rating);
        echo "Rating submitted successfully!";

    }

    public function generateReview($movie_id) {
        return "need to implement this";
    }
}