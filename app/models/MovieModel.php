<?php
class MovieModel {

    public function fetchMovieFromOmdbById($movie_id) {
        $apiKey = getenv('OMDB_API_KEY');
        $url = "https://www.omdbapi.com/?i=" . urlencode($movie_id) . "&apikey=" . $apiKey;

        $response = file_get_contents($url);

        if ($response === FALSE) {
            echo "Error: Could not fetch movie data from OMDB.";
            return [];
        }

        $movieData = json_decode($response, true);

        return $movieData;
    }
    
    public function fetchMovieFromOmdb($title) {
        $apiKey = getenv('OMDB_API_KEY');
        $url = "https://www.omdbapi.com/?t=" . urlencode($title) . "&apikey=" . $apiKey;

        $response = file_get_contents($url);

        if ($response === FALSE) {
            echo "Error: Could not fetch movie data from OMDB.";
            return [];
        }

        $movieData = json_decode($response, true);

        return $movieData;
    }

    public function saveRating($userId, $movieName, $imdbId, $rating) {
        $db = db_connect();

        $statement = $db->prepare("SELECT * FROM ratings WHERE user_id = :user_id AND imdb_id = :imdb_id");
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':imdb_id', $imdbId, PDO::PARAM_STR);
        $statement->execute();
        $existingRating = $statement->fetch(PDO::FETCH_ASSOC);

        if ($existingRating) {
            $statement = $db->prepare("UPDATE ratings SET rating = :rating WHERE user_id = :user_id AND imdb_id = :imdb_id");
            $statement->bindValue(':rating', $rating, PDO::PARAM_INT);
            $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $statement->bindValue(':imdb_id', $imdbId, PDO::PARAM_STR);
        } else {
            $statement = $db->prepare("INSERT INTO ratings (movie_name, imdb_id, user_id, rating) VALUES (:movie_name, :imdb_id, :user_id, :rating)");
            $statement->bindValue(':movie_name', $movieName);
            $statement->bindValue(':imdb_id', $imdbId);
            $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $statement->bindValue(':rating', $rating, PDO::PARAM_INT);
        }

        $statement->execute();
    }

    public function getMovieRatings($imdbId) {
        $db = db_connect();
        $statement = $db->prepare("SELECT AVG(rating) as averageRating FROM ratings WHERE imdb_id = :imdb_id");
        $statement->bindValue(':imdb_id', $imdbId, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserRating($userId, $imdbId) {
        $db = db_connect();
        $statement = $db->prepare("SELECT rating FROM ratings WHERE user_id = :user_id AND imdb_id = :imdb_id");
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':imdb_id', $imdbId, PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
?>
