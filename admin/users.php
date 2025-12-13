<?php
session_start();
include '../includes/db_connect.php';
include '../includes/functions.php';

check_admin();

// Fetch Current Admin User
$admin_id = $_SESSION['user_id'];
$sql_user = "SELECT full_name, profile_image FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $admin_id);
$stmt_user->execute();
$current_user = $stmt_user->get_result()->fetch_assoc();
$stmt_user->close();

// Fetch Users
$sql = "SELECT * FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users | Footporium Admin</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>

<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand">
                <i class="fas fa-shoe-prints"></i> Footporium
            </a>
        </div>
        <div class="d-flex flex-column gap-2 px-3">
            <a href="dashboard.php" class="nav-link">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="add_product.php" class="nav-link">
                <i class="fas fa-plus-circle"></i> Add Product
            </a>
            <a href="orders.php" class="nav-link">
                <i class="fas fa-box"></i> Orders
            </a>
            <a href="users.php" class="nav-link active">
                <i class="fas fa-users"></i> Users
            </a>
            <hr class="text-white opacity-25">
            <a href="../index.php" class="nav-link">
                <i class="fas fa-external-link-alt"></i> View Website
            </a>
            <a href="../logout.php" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container-fluid">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">User Management</h2>
                    <p class="text-muted">Manage registered users.</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white p-2 rounded shadow-sm">
                        <i class="fas fa-bell text-muted"></i>
                    </div>
                    <a href="../profile.php" class="text-decoration-none">
                        <?php if (!empty($current_user['profile_image'])): ?>
                            <img src="data:image/png;base64,<?php echo base64_encode($current_user['profile_image']); ?>"
                                alt="Admin" width="40" height="40" class="rounded-circle bg-white p-1 shadow-sm"
                                style="object-fit: cover;">
                        <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($current_user['full_name']); ?>&background=800000&color=fff"
                                alt="Admin" width="40" height="40" class="rounded-circle bg-white p-1 shadow-sm">
                        <?php endif; ?>
                    </a>
                </div>
            </div>

            <!-- Users Table -->
            <div class="admin-table-card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Registered</th>
                                <!-- <th class="text-end">Actions</th> // Optional: Add delete/block later -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td>#<?php echo $row['id']; ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <?php if (!empty($row['profile_image'])): ?>
                                                    <img src="data:image/png;base64,<?php echo base64_encode($row['profile_image']); ?>"
                                                        width="40" height="40" class="rounded-circle" style="object-fit:cover;">
                                                <?php else: ?>
                                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($row['full_name']); ?>&background=random"
                                                        width="40" height="40" class="rounded-circle">
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($row['full_name']); ?>
                                                    </h6>
                                                    <small
                                                        class="text-muted"><?php echo htmlspecialchars($row['email']); ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['phone'] ?? 'N/A'); ?></td>
                                        <td>
                                            <?php if ($row['role'] === 'admin'): ?>
                                                <span class="badge bg-danger">Admin</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">User</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">No users found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>