<?php
class Movie {
    public static function getMovieByImdb($imdb_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM movies WHERE imdb_id = ?");
        $stmt->execute([$imdb_id]);
        return $stmt->fetch();
    }

    public static function saveMovie($data) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO movies (title, year, genre, imdb_id, metascore, imdb_rating, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['title'], $data['year'], $data['genre'], $data['imdb_id'], $data['metascore'], $data['imdb_rating'], $data['description']]);
    }

    public static function fetchMovieFromOmdb($title) {
        $apiKey = OMDB_API_KEY; 
        $url = "https://www.omdbapi.com/?t=" . urlencode($title) . "&apikey=" . $apiKey;
        $response = file_get_contents($url);
        return json_decode($response, true);
    }

}
