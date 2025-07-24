<?php require_once 'app/views/templates/headerPublic.php' ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h1 class="text-center text-primary mb-4">Create User</h1>

                    <?php if (!empty($data['error'])): ?>
                        <div class="alert alert-danger"><?= $data['error'] ?></div>
                    <?php endif; ?>
                    <?php if (!empty($data['success'])): ?>
                        <div class="alert alert-success"><?= $data['success'] ?></div>
                    <?php endif; ?>

                    <form method="POST" action="/create/register">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Create User</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="/login">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/templates/footer.php' ?>