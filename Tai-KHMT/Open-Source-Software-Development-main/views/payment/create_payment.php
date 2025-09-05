<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../../index.php');
require_once __DIR__ . '/../../functions/booking_functions.php';

// lấy danh sách booking cho dropdown
$bookings = getAllBookings();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Thêm Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3">
    <h3>THÊM PAYMENT</h3>

    <form action="../../handle/payment_process.php" method="POST">
        <input type="hidden" name="action" value="create">

        <div class="mb-3">
            <label for="booking_id" class="form-label">Booking</label>
            <select class="form-select" id="booking_id" name="booking_id" required>
                <option value="">-- Chọn booking --</option>
                <?php foreach ($bookings as $b): ?>
                    <option value="<?= $b['id'] ?>">Booking #<?= $b['id'] ?> - <?= htmlspecialchars($b['customer_name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Số tiền</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Ngày thanh toán</label>
            <input type="datetime-local" class="form-control" id="date" name="date" required>
        </div>

        <div class="mb-3">
            <label for="method" class="form-label">Phương thức</label>
            <select class="form-select" id="method" name="method" required>
                <option value="cash">Tiền mặt</option>
                <option value="bank_transfer">Chuyển khoản</option>
                <option value="credit_card">Thẻ tín dụng</option>
                <option value="online">Online</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Thêm</button>
        <a href="../payment.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>
