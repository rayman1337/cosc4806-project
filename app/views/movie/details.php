<?php require_once 'app/views/templates/headerPublic.php'; ?>

<div class="container mt-5">

    <?php if (isset($showSuccessMessage) && $showSuccessMessage): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your rating has been submitted successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($data['movie'])): ?>
        <div class="row">
            <div class="col-md-3">
                <?php if (!empty($movie['Poster']) && $movie['Poster'] != 'N/A'): ?>
                    <img src="<?php echo htmlspecialchars($movie['Poster']); ?>" class="img-fluid rounded" alt="Movie Poster">
                <?php endif; ?>
            </div>
            <div class="col-md-9">
                <h1><?php echo htmlspecialchars($movie['Title']); ?> (<?php echo htmlspecialchars($movie['Year']); ?>)</h1>
                <p><strong>Year:</strong> <?php echo htmlspecialchars($movie['Year']); ?></p>
                <p><strong>Genre:</strong> <?php echo htmlspecialchars($movie['Genre']); ?></p>
                <p><strong>IMDB Rating:</strong> <?php echo htmlspecialchars($movie['imdbRating']); ?></p>
                <p><strong>Metascore:</strong> <?php echo htmlspecialchars($movie['Metascore']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($movie['Plot']); ?></p>

                <?php if ($isAuthenticated): ?>
                    <?php if (isset($averageRating) && $averageRating !== null): ?>
                        <p>This movie is rated <?php echo round($averageRating, 1); ?>/5 by the users of our website.</p>
                    <?php else: ?>
                        <p>This movie has no ratings yet.</p>
                    <?php endif; ?>

                    <?php if (isset($userRating) && $userRating !== null): ?>
                        <div class="alert alert-info" role="alert">
                            You rated this movie <?php echo htmlspecialchars($userRating); ?>/5.
                        </div>
                    <?php endif; ?>

                    <h3>Rate this movie:</h3>
                    <form action="/movie/rateMovie" method="POST">
                        <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie['imdbID']); ?>">
                        <input type="hidden" name="movie_name" value="<?php echo htmlspecialchars($movie['Title']); ?>">
                        <input type="hidden" name="query" value="<?php echo htmlspecialchars($query ?? ''); ?>">
                        <label for="rating">Rating (1 to 5):</label>
                        <select name="rating" required>
                            <option value="1" <?php echo ($userRating == 1) ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?php echo ($userRating == 2) ? 'selected' : ''; ?>>2</option>
                            <option value="3" <?php echo ($userRating == 3) ? 'selected' : ''; ?>>3</option>
                            <option value="4" <?php echo ($userRating == 4) ? 'selected' : ''; ?>>4</option>
                            <option value="5" <?php echo ($userRating == 5) ? 'selected' : ''; ?>>5</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Submit Rating</button>
                    </form>
                <?php else: ?>
                    <p>You must be <a href="/login">logged in</a> to rate this movie.</p>
                <?php endif; ?>

                <h3>AI-generated Review:</h3>
                <?php if ($isAuthenticated): ?>
                    <form action="/movie/generateReview" method="post">
                        <input type="hidden" name="imdb_id" value="<?php echo htmlspecialchars($movie['imdbID'] ?? ''); ?>">
                        <input type="hidden" name="query" value="<?php echo htmlspecialchars($query ?? ''); ?>">
                        <button type="submit" class="btn btn-primary">Get AI Review</button>

                        
                    </form>
                <?php else: ?>
                    <p>You must be logged in to get an AI-generated review.</p>
                <?php endif; ?>
                <?php if (isset($aiReview)): ?>
                    <h4>Generated Review:</h4>
                    <div class="card bg-light mb-3">
                        <div class="card-header">AI Review</div>
                        <div class="card-body">
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($aiReview)); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger" role="alert">
            No movie found. Please search again.
            <div class="mt-2">
                <a href="/home" class="btn btn-primary">Go Back to Search</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    function updateRatingValue(value) {
        document.getElementById('ratingValue').innerText = value;
    }
</script>

<?php require_once 'app/views/templates/footer.php'; ?>
