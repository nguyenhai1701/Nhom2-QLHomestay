<?php
require_once 'db_connection.php';

/**
 * Lấy tất cả danh sách phòng
 * @return array Danh sách phòng
 */
function getAllRooms() {
    $conn = getDbConnection();

    $sql = "SELECT id, name, type, price, status FROM rooms ORDER BY id";
    $result = mysqli_query($conn, $sql);

    $rooms = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $rooms[] = $row;
        }
    }

    mysqli_close($conn);
    return $rooms;
}

/**
 * Thêm phòng mới
 * @param string $name Tên phòng
 * @param string $type Loại phòng
 * @param float $price Giá phòng
 * @param string $status Tình trạng (available, booked, maintenance...)
 * @return bool True nếu thành công, False nếu thất bại
 */
function addRoom($name, $type, $price, $status) {
    $conn = getDbConnection();

    $sql = "INSERT INTO rooms (name, type, price, status) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssds", $name, $type, $price, $status);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}

/**
 * Lấy thông tin phòng theo ID
 * @param int $id ID phòng
 * @return array|null Thông tin phòng hoặc null nếu không tìm thấy
 */
function getRoomById($id) {
    $conn = getDbConnection();

    $sql = "SELECT id, name, type, price, status FROM rooms WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $room = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            return $room;
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
    return null;
}

/**
 * Cập nhật thông tin phòng
 * @param int $id ID phòng
 * @param string $name Tên phòng
 * @param string $type Loại phòng
 * @param float $price Giá phòng
 * @param string $status Tình trạng
 * @return bool True nếu thành công, False nếu thất bại
 */
function updateRoom($id, $name, $type, $price, $status) {
    $conn = getDbConnection();

    $sql = "UPDATE rooms SET name = ?, type = ?, price = ?, status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssdsi", $name, $type, $price, $status, $id);
        $success = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        return $success;
    }

    mysqli_close($conn);
    return false;
}

/**
 * Xóa phòng theo ID
 * @param int $id ID phòng
 * @return bool True nếu thành công, False nếu thất bại
 */
function deleteRoom($id) {
    $conn = getDbConnection();

    $sql = "DELETE FROM rooms WHERE id = ?";
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
/**
 * Lấy danh sách phòng cho dropdown
 */
require_once __DIR__ . '/db_connection.php';
function getAllRoomsForDropdown() {
    $conn = getDbConnection();  // ✅ Phải mở kết nối trước khi query

    $sql = "SELECT id, name FROM rooms ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);

    $customers = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $customers[] = $row;
        }
    }
    return $customers;
}

?>
