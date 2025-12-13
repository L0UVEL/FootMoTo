<?php include 'includes/header.php'; ?>

<div class="container my-5 text-center">
    <div class="py-5">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
        </div>
        <h1 class="fw-bold mb-3">Thank You for Your Order!</h1>
        <p class="lead text-muted mb-4">Your order has been placed successfully.</p>

        <?php if (isset($_GET['order_id'])): ?>
            <div class="alert alert-secondary d-inline-block px-4 py-2 rounded-pill mb-5">
                Order ID: <strong>#<?php echo str_pad(intval($_GET['order_id']), 5, '0', STR_PAD_LEFT); ?></strong>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-center gap-3">
            <a href="index.php" class="btn btn-outline-primary px-4 py-2">Return Home</a>
            <a href="my_orders.php" class="btn btn-primary-custom px-4 py-2">View My Orders</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>