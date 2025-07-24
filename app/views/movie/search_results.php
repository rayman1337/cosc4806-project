<?php require_once 'app/views/templates/headerPublic.php'; ?>

<h1>Search Results</h1>
<?php if (!empty($movies)): ?>
    <ul>
        <?php foreach ($movies as $movie): ?>
            <li>
                <a href="/movie/details/<?php echo $movie['imdb_id']; ?>"><?php echo $movie['title']; ?></a> (<?php echo $movie['year']; ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No movies found. Try a different search.</p>
<?php endif; ?>

<a href="/">Back to Home</a>

<?php require_once 'app/views/templates/footer.php'; ?>
