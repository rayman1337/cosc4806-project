<?php require_once 'app/views/templates/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">My Reminders</h2>
        <a href="/notes/create" class="btn btn-primary">+ Add Reminder</a>
    </div>

    <?php if (empty($data['notes'])): ?>
        <div class="alert alert-info">You have no reminders yet.</div>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($data['notes'] as $note): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($note['subject']) ?></strong><br>
                        <small class="text-muted">
                            <?= $note['completed'] ? '<span class="badge bg-success">Completed</span>' : '<span class="badge bg-warning text-dark">Pending</span>' ?>
                        </small>
                    </div>
                    <div>
                        <a href="/notes/edit/<?= $note['id'] ?>" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                        <a href="/notes/delete/<?= $note['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this note?')">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php require_once 'app/views/templates/footer.php'; ?>
