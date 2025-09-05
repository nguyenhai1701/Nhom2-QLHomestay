<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../../index.php');
require_once __DIR__ . '/../../functions/booking_functions.php';
require_once __DIR__ . '/../../functions/customer_functions.php';
require_once __DIR__ . '/../../functions/room_functions.php';

// Lấy danh sách khách hàng và phòng cho dropdown
$customers = getAllCustomersForDropdown();
$rooms = getAllRoomsForDropdown();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Thêm đơn đặt phòng - Homestay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="mt-3 mb-4">THÊM ĐƠN ĐẶT PHÒNG</h3>
                
                <?php
                // Hiển thị thông báo lỗi
                if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ' . htmlspecialchars($_GET['error']) . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
                }
                ?>
                <script>
                // Sau 3 giây sẽ tự động ẩn alert
                setTimeout(() => {
                    let alertNode = document.querySelector('.alert');
                    if (alertNode) {
                        let bsAlert = bootstrap.Alert.getOrCreateInstance(alertNode);
                        bsAlert.close();
                    }
                }, 3000);
                </script>
                
               <form action="../../handle/booking_process.php" method="POST">
    <input type="hidden" name="action" value="create">

    <div class="mb-3">
        <label for="customer_id" class="form-label">Khách hàng</label>
        <select class="form-select" id="customer_id" name="customer_id" required>
            <option value="">-- Chọn khách hàng --</option>
            <?php foreach ($customers as $cus): ?>
                <option value="<?= $cus['id'] ?>">
                    <?= htmlspecialchars($cus['name']) ?>
                    (<?= !empty($cus['email']) ? htmlspecialchars($cus['email']) : 'Không có email' ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="room_id" class="form-label">Phòng</label>
        <select class="form-select" id="room_id" name="room_id" required>
            <option value="">-- Chọn phòng --</option>
            <?php foreach ($rooms as $room): ?>
                <option value="<?= $room['id'] ?>">
                    <?= htmlspecialchars($room['name']) ?>
                    <?= !empty($room['type']) ? ' - ' . htmlspecialchars($room['type']) : '' ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="checkin" class="form-label">Ngày nhận phòng</label>
        <input type="date" class="form-control" id="checkin" name="checkin" required>
    </div>

    <div class="mb-3">
        <label for="checkout" class="form-label">Ngày trả phòng</label>
        <input type="date" class="form-control" id="checkout" name="checkout" required>
    </div>

    <button type="submit" class="btn btn-primary">Đặt phòng</button>
</form>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
