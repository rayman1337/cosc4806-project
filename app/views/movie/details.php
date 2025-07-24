<?php require_once 'app/views/templates/headerPublic.php'; ?>

<h1>Movie Data (Raw)</h1>

<pre>
<?php 
    print_r($movieData);  // This will print the raw movie data array
?>
</pre>

<h1><?php echo htmlspecialchars($movieData['Title']); ?></h1>
<p><strong>Year:</strong> <?php echo htmlspecialchars($movieData['Year']); ?></p>
<p><strong>Genre:</strong> <?php echo htmlspecialchars($movieData['Genre']); ?></p>
<p><strong>IMDB Rating:</strong> <?php echo htmlspecialchars($movieData['imdbRating']); ?></p>
<p><strong>Metascore:</strong> <?php echo htmlspecialchars($movieData['Metascore']); ?></p>
<p><strong>Description:</strong> <?php echo htmlspecialchars($movieData['Plot']); ?></p>

<?php if (isset($_SESSION['auth'])): ?>
    <h3>Rate this movie:</h3>
    <form action="/movie/rate" method="POST">
        <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movieData['imdbID']); ?>">
        <label for="rating">Rating (1 to 5):</label>
        <select name="rating" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <button type="submit">Submit Rating</button>
    </form>
<?php else: ?>
    <p>You must be <a href="/login">logged in</a> to rate this movie.</p>
<?php endif; ?>

<h3>AI-generated Review:</h3>
<p><?php echo htmlspecialchars($aiReview); ?></p>  <!-- Display AI review here -->

<a href="/">Back to Home</a>

<?php require_once 'app/views/templates/footer.php'; ?>
