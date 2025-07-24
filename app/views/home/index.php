<?php require_once 'app/views/templates/headerPublic.php' ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h1 class="text-center text-primary mb-4">Movie Search</h1>

                    <form action="/movie/search" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="title" class="form-control" placeholder="Search for a movie" required>
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>

                    <?php if ($isLoggedIn): ?>
                        <div class="alert alert-info">
                            Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            <a href="/logout" class="btn btn-sm btn-outline-primary ms-2">Logout</a>
                        </div>
                    <?php else: ?>
                        <div class="text-center">
                            <p>You are not logged in.</p>
                            <a href="/login" class="btn btn-primary me-2">Login</a>
                            <a href="/register" class="btn btn-outline-primary">Register</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php' ?>