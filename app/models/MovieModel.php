<?php
class MovieModel {
    public function getMovieByImdb($imdb_id) { 
        $db = db_connect();
        $stmt = $db->prepare("SELECT * FROM movies WHERE imdb_id = ?");
        $stmt->execute([$imdb_id]);
        return $stmt->fetch();
    }

    public function saveMovie($data) {
        $db = db_connect();
        $stmt = $db->prepare("INSERT INTO movies (title, year, genre, imdb_id, metascore, imdb_rating, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['title'], $data['year'], $data['genre'], $data['imdb_id'], $data['metascore'], $data['imdb_rating'], $data['description']]);
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

        if (isset($movieData['Response']) && $movieData['Response'] == 'False') {
            echo "Movie not found!";
            return [];
        }

        return $movieData;
    }


    public function saveRating($movie_id, $user_id, $rating) { 
        $db = db_connect();
        $stmt = $db->prepare("INSERT INTO ratings (movie_id, user_id, rating) VALUES (?, ?, ?)");
        return $stmt->execute([$movie_id, $user_id, $rating]);
    }

    public function saveReview($movie_id, $review) { 
        $db = db_connect();
        $stmt = $db->prepare("INSERT INTO reviews (movie_id, review) VALUES (?, ?)");
        return $stmt->execute([$movie_id, $review]);
    }
}