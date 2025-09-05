<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../../index.php');
require_once __DIR__ . '/../../functions/booking_functions.php';
require_once __DIR__ . '/../../functions/customer_functions.php';
require_once __DIR__ . '/../../functions/room_functions.php';

?>
<!DOCTYPE html>
<html>

<head>
    <title>Chỉnh sửa đơn đặt phòng - Homestay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-3">
        <h3 class="mt-3 mb-4 text-center">CHỈNH SỬA ĐƠN ĐẶT PHÒNG</h3>
        <?php
            // Kiểm tra có ID không
            if (!isset($_GET['id']) || empty($_GET['id'])) {
                header("Location: ../booking.php?error=Không tìm thấy đơn đặt phòng");
                exit;
            }
            
            $id = $_GET['id'];
            
            // Lấy thông tin đơn đặt phòng
            require_once __DIR__ . '/../../handle/booking_process.php';
            $bookingInfo = handleGetBookingById($id);

            if (!$bookingInfo) {
                header("Location: ../booking.php?error=Không tìm thấy đơn đặt phòng");
                exit;
            }
            
            // Lấy danh sách khách hàng và phòng cho dropdown
            $customers = getAllCustomersForDropdown();
            $rooms = getAllRoomsForDropdown();
            
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
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="../../handle/booking_process.php" method="POST">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($bookingInfo['id']); ?>">

                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">Khách hàng</label>
                                    <select class="form-select" id="customer_id" name="customer_id" required>
                                        <option value="">-- Chọn khách hàng --</option>
                                        <?php foreach ($customers as $cus): ?>
                                            <option value="<?= $cus['id'] ?>" 
                                                <?= $cus['id'] == $bookingInfo['customer_id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($cus['name']) ?> (<?= htmlspecialchars($cus['email']) ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="room_id" class="form-label">Phòng</label>
                                    <select class="form-select" id="room_id" name="room_id" required>
                                        <option value="">-- Chọn phòng --</option>
                                        <?php foreach ($rooms as $room): ?>
                                            <option value="<?= $room['id'] ?>" 
                                                <?= $room['id'] == $bookingInfo['room_id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($room['name']) ?> - <?= htmlspecialchars($room['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="checkin_date" class="form-label">Ngày nhận phòng</label>
                                    <input type="date" class="form-control" id="checkin_date" name="checkin_date"
                                           value="<?php echo htmlspecialchars($bookingInfo['checkin_date']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="checkout_date" class="form-label">Ngày trả phòng</label>
                                    <input type="date" class="form-control" id="checkout_date" name="checkout_date"
                                           value="<?php echo htmlspecialchars($bookingInfo['checkout_date']); ?>" required>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="../bookings.php" class="btn btn-secondary me-md-2">Hủy</a>
                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
