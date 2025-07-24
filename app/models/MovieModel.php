<?php
class MovieModel {

    public function fetchMovieFromOmdb($title) {
        $apiKey = getenv('OMDB_API_KEY'); 
        $url = "https://www.omdbapi.com/?t=" . urlencode($title) . "&apikey=" . $apiKey;

        $response = file_get_contents($url);
        
        if ($response === FALSE) {
            echo "Error: Could not fetch movie data from OMDB.";
            return [];
        }

        $movieData = json_decode($response, true);

        if (isset($movieData['Response']) && $movieData['Response'] == 'False') {
            echo "Movie not found!";
            return [];
        }

        return $movieData;
    }

    public function saveRating($movie_id, $movie_name, $user_id, $rating) {
        $db = db_connect();

        if (!$db) {
            die("Database connection failed.");
        }

        $stmt = $db->prepare("SELECT * FROM ratings WHERE user_id = :user_id AND imdb_id = :imdb_id");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':imdb_id', $movie_id, PDO::PARAM_STR);
        $stmt->execute();
        $existingRating = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRating) {
            $stmt = $db->prepare("UPDATE ratings SET rating = :rating WHERE user_id = :user_id AND imdb_id = :imdb_id");
            $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':imdb_id', $movie_id, PDO::PARAM_STR);
        } else {
            $stmt = $db->prepare("INSERT INTO ratings (movie_name, imdb_id, user_id, rating) VALUES (:movie_name, :imdb_id, :user_id, :rating)");
            $stmt->bindValue(':movie_name', $movie_name);
            $stmt->bindValue(':imdb_id', $movie_id);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':rating', $rating, PDO::PARAM_INT);
        }

        $stmt->execute();
    }
}