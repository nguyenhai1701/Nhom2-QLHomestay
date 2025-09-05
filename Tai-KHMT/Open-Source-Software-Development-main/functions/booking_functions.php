<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách booking
 * @return array Danh sách bookings
 */
function getAllBookings() {
    $conn = getDbConnection();

    $sql = "SELECT b.id, c.name AS customer_name, r.name AS room_name, b.checkin, b.checkout, b.status
            FROM bookings b
            JOIN customers c ON b.customer_id = c.id
            JOIN rooms r ON b.room_id = r.id
            ORDER BY b.id DESC";
    $result = mysqli_query($conn, $sql);

    $bookings = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $bookings[] = $row;
        }
    }

    mysqli_close($conn);
    return $bookings;
}

/**
 * Thêm booking mới
 */
function addBooking($customer_id, $room_id, $checkin, $checkout, $status = 'pending') {
    $conn = getDbConnection();

    $sql = "INSERT INTO bookings (customer_id, room_id, checkin, checkout, status)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        mysqli_close($conn);
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iisss", $customer_id, $room_id, $checkin, $checkout, $status);
    $ok = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    return $ok;
}

/**
 * Lấy thông tin booking theo ID
 */
function getBookingById($id) {
    $conn = getDbConnection();

    $sql = "SELECT * FROM bookings WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $booking = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $booking;
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
    return null;
}

/**
 * Cập nhật thông tin booking
 */
function updateBooking($id, $customer_id, $room_id, $checkin, $checkout, $status) {
    $conn = getDbConnection();

    $sql = "UPDATE bookings SET id = ?, id = ?, checkin = ?, checkout = ?, status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iisssi", $customer_id, $room_id, $checkin, $checkout, $status, $id);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}

/**
 * Xóa booking theo ID
 */
function deleteBooking($id) {
    $conn = getDbConnection();

    $sql = "DELETE FROM bookings WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}
?>
