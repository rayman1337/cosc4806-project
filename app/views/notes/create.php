<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Create Reminder</h2>

    <form method="POST" action="" class="w-50 mx-auto">
        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="/notes/index" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
