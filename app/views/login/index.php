<?php require_once 'app/views/templates/headerPublic.php' ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h1 class="text-center text-primary mb-4">Login</h1>
                    
                    <?php if (!empty($data['error'])): ?>
                        <div class="alert alert-danger"><?= $data['error'] ?></div>
                    <?php endif; ?>
                    
                    <form action="/login/verify" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input required type="text" class="form-control" name="username" id="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input required type="password" class="form-control" name="password" id="password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        No account? <a href="/create">Create one here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php' ?>