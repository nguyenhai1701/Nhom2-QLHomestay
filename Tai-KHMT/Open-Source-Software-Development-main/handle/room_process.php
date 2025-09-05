<?php
require_once __DIR__ . '/../functions/room_functions.php';

// Kiểm tra action được truyền qua URL hoặc POST
$action = '';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action'])) {
    $action = $_POST['action'];
}

switch ($action) {
    case 'create':
        handleCreateRoom();
        break;
    case 'edit':
        handleEditRoom();
        break;
    case 'delete':
        handleDeleteRoom();
        break;
}

/**
 * Lấy tất cả danh sách phòng
 */
function handleGetAllRooms() {
    return getAllRooms();
}

/**
 * Lấy thông tin phòng theo ID
 */
function handleGetRoomById($id) {
    return getRoomById($id);
}

/**
 * Xử lý tạo phòng mới
 */
function handleCreateRoom() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/room.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_POST['name']) || !isset($_POST['type']) || !isset($_POST['price']) || !isset($_POST['status'])) {
        header("Location: ../views/room/create_room.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $price = trim($_POST['price']);
    $status = trim($_POST['status']);
    
    // Validate dữ liệu
    if (empty($name) || empty($type) || empty($price) || empty($status)) {
        header("Location: ../views/room/create_room.php?error=Vui lòng điền đầy đủ thông tin");
        exit();
    }
    
    if (!is_numeric($price) || $price <= 0) {
        header("Location: ../views/room/create_room.php?error=Giá phòng không hợp lệ");
        exit();
    }
    
    // Gọi hàm thêm phòng
    $result = addRoom($name, $type, $price, $status);
    
    if ($result) {
        header("Location: ../views/room.php?success=Thêm phòng thành công");
    } else {
        header("Location: ../views/room/create_room.php?error=Có lỗi xảy ra khi thêm phòng");
    }
    exit();
}

/**
 * Xử lý chỉnh sửa phòng
 */
function handleEditRoom() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: ../views/room.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_POST['id']) || !isset($_POST['name']) || !isset($_POST['type']) || !isset($_POST['price']) || !isset($_POST['status'])) {
        header("Location: ../views/room.php?error=Thiếu thông tin cần thiết");
        exit();
    }
    
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $price = trim($_POST['price']);
    $status = trim($_POST['status']);
    
    // Validate dữ liệu
    if (empty($name) || empty($type) || empty($price) || empty($status)) {
        header("Location: ../views/room/edit_room.php?id=" . $id . "&error=Vui lòng điền đầy đủ thông tin");
        exit();
    }

    if (!is_numeric($price) || $price <= 0) {
        header("Location: ../views/room/edit_room.php?id=" . $id . "&error=Giá phòng không hợp lệ");
        exit();
    }
    
    // Gọi function để cập nhật phòng
    $result = updateRoom($id, $name, $type, $price, $status);
    
    if ($result) {
        header("Location: ../views/room.php?success=Cập nhật phòng thành công");
    } else {
        header("Location: ../views/room/edit_room.php?id=" . $id . "&error=Cập nhật phòng thất bại");
    }
    exit();
}

/**
 * Xử lý xóa phòng
 */
function handleDeleteRoom() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        header("Location: ../views/room.php?error=Phương thức không hợp lệ");
        exit();
    }
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header("Location: ../views/room.php?error=Không tìm thấy ID phòng");
        exit();
    }
    
    $id = $_GET['id'];
    
    // Validate ID là số
    if (!is_numeric($id)) {
        header("Location: ../views/room.php?error=ID phòng không hợp lệ");
        exit();
    }
    
    // Gọi function để xóa phòng
    $result = deleteRoom($id);
    
    if ($result) {
        header("Location: ../views/room.php?success=Xóa phòng thành công");
    } else {
        header("Location: ../views/room.php?error=Xóa phòng thất bại");
    }
    exit();
}
?>
