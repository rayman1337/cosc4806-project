<?php require_once 'app/views/templates/header.php'; ?>

<style>
    .dashboard-header {
        background: #007bff;
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(45deg, #007bff, #0069d9);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .chart-container {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .section-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1.5rem;
        position: relative;
        padding-left: 20px;
    }

    .section-title::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 100%;
        background: linear-gradient(135deg, #007bff, #0069d9);
        border-radius: 2px;
    }

    .reminder-item {
        background: white;
        border: none;
        border-radius: 10px;
        margin-bottom: 0.5rem;
        padding: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .reminder-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .reminder-item.deleted {
        border-left: 4px solid #e74c3c;
        background: linear-gradient(90deg, #fdf2f2 0%, white 100%);
    }

    .reminder-item.active {
        border-left: 4px solid #27ae60;
        background: linear-gradient(90deg, #f0f9f0 0%, white 100%);
    }

    .user-badge {
        background: linear-gradient(45deg, #007bff, #0069d9);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .login-bar {
        background: linear-gradient(90deg, #007bff, #0069d9);
        height: 8px;
        border-radius: 4px;
        transition: width 0.8s ease;
    }

    body {
        background: #f8f9fa;
    }
</style>

<div class="dashboard-header text-center">
    <h1 class="mb-3">
        <i class="fas fa-chart-line me-2"></i>
        Admin Dashboard
    </h1>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="stat-number"><?= count($data['notes']) ?></div>
            <div class="text-muted">Total Reminders</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="stat-number"><?= count($data['deleted']) ?></div>
            <div class="text-muted">Deleted Items</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="stat-number"><?= count($data['logins']) ?></div>
            <div class="text-muted">Active Users</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card text-center">
            <div class="stat-number"><?= $data['mostNotesUser']['total'] ?></div>
            <div class="text-muted">Top User Activity</div>
        </div>
    </div>
</div>

<div class="alert alert-info border-0 shadow-sm mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">
    <div class="d-flex align-items-center">
        <i class="fas fa-trophy text-warning me-3" style="font-size: 1.5rem;"></i>
        <div>
            <strong>Most Active User:</strong> 
            <span class="user-badge"><?= $data['mostNotesUser']['username'] ?></span>
            <span class="ms-2 text-muted">with <?= $data['mostNotesUser']['total'] ?> reminders</span>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-8">
        <div class="chart-container">
            <h4 class="section-title">
                <i class="fas fa-chart-bar me-2"></i>
                User Login Activity
            </h4>
            <canvas id="loginChart" height="100"></canvas>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="chart-container">
            <h4 class="section-title">
                <i class="fas fa-chart-pie me-2"></i>
                Reminder Status
            </h4>
            <canvas id="reminderChart"></canvas>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="chart-container">
            <h4 class="section-title">
                <i class="fas fa-bell me-2"></i>
                Active Reminders
            </h4>
            <div class="reminder-list" style="max-height: 400px; overflow-y: auto;">
                <?php foreach ($data['notes'] as $note): ?>
                    <div class="reminder-item active">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($note['subject']) ?></h6>
                                <small class="text-muted">User ID: <?= $note['user_id'] ?></small>
                            </div>
                            <span class="badge bg-success">Active</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="chart-container">
            <h4 class="section-title">
                <i class="fas fa-trash me-2"></i>
                Deleted Reminders
            </h4>
            <div class="reminder-list" style="max-height: 400px; overflow-y: auto;">
                <?php foreach ($data['deleted'] as $note): ?>
                    <div class="reminder-item deleted">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($note['subject']) ?></h6>
                                <small class="text-muted">User ID: <?= $note['user_id'] ?></small>
                            </div>
                            <span class="badge bg-danger">Deleted</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="chart-container mt-4">
    <h4 class="section-title">
        <i class="fas fa-users me-2"></i>
        User Login Statistics
    </h4>
    <div class="row">
        <?php 
        $maxLogins = max(array_column($data['logins'], 'total_logins'));
        foreach ($data['logins'] as $log): 
            $percentage = ($log['total_logins'] / $maxLogins) * 100;
        ?>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="p-3 border rounded">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <strong><?= $log['username'] ?></strong>
                        <span class="badge bg-primary"><?= $log['total_logins'] ?> logins</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="login-bar" style="width: <?= $percentage ?>%"></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    const loginCtx = document.getElementById('loginChart').getContext('2d');
    const loginChart = new Chart(loginCtx, {
        type: 'bar',
        data: {
            labels: [<?php echo implode(',', array_map(function($log) { return "'" . addslashes($log['username']) . "'"; }, $data['logins'])); ?>],
            datasets: [{
                label: 'Total Logins',
                data: [<?php echo implode(',', array_column($data['logins'], 'total_logins')); ?>],
                backgroundColor: 'rgba(102, 126, 234, 0.8)',
                borderColor: 'rgba(102, 126, 234, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    const reminderCtx = document.getElementById('reminderChart').getContext('2d');
    const reminderChart = new Chart(reminderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Deleted'],
            datasets: [{
                data: [<?= count($data['notes']) ?>, <?= count($data['deleted']) ?>],
                backgroundColor: [
                    'rgba(39, 174, 96, 0.8)',
                    'rgba(231, 76, 60, 0.8)'
                ],
                borderWidth: 3,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
</script>

<?php require_once 'app/views/templates/footer.php'; ?>