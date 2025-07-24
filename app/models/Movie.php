<?php
class Movie {
    public static function getMovieByImdb($imdb_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM movies WHERE imdb_id = ?");
        $stmt->execute([$imdb_id]);
        return $stmt->fetch();
    }

  
}
