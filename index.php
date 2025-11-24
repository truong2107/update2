<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/SignInContr.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/user/ProductContr.php";
$request = $_SERVER['REQUEST_URI'];
// Kiểm tra đăng nhập
$isLoggedIn = isset($_SESSION['tenDangNhap']);

if($isLoggedIn){
    $vaiTro = $_SESSION['role'];
    
    if($vaiTro == "admin"){
        session_destroy();
        header("location: /web/view/admin/index.php");
        exit();
    } else {
        // AUTO-REFRESH SESSION TỪ DATABASE
        if(isset($_SESSION['id'])){
            $db = new DatabaseClass();
            $conn = $db->connect();
            $userId = $_SESSION['id'];
            
            $sql = "SELECT * FROM nguoidung WHERE id_nguoidung = ?";
            $stmt = $conn->prepare($sql);
            
            if($stmt){
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    
                    // Kiểm tra nếu bị khóa
                    if($row['TrangThai'] == 2){
                        $stmt->close();
                        header("Location:/web/view/user/LogOut.php");
                        exit();
                    }
                    
                    // CẬP NHẬT LẠI SESSION VỚI DỮ LIỆU MỚI
                    $_SESSION['role'] = $row['vaiTro'];
                    $_SESSION['id'] = $row['id_nguoidung'];
                    $_SESSION['tenNguoiDung'] = $row['tenNguoiDung'];
                    $_SESSION['tenDangNhap'] = $row['tenDangNhap'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['sdt'] = $row['sdt'];
                    $_SESSION['diaChi'] = $row['diaChi'];
                    $_SESSION['quan_huyen'] = $row['quan_huyen'];
                    $_SESSION['phuong_xa'] = $row['phuong_xa'];
                    
                } else {
                    // User không tồn tại trong DB -> logout
                    $stmt->close();
                    header("Location:/web/view/user/LogOut.php");
                    exit();
                }
                
                $stmt->close();
            }
        }

        
        // Gán biến để sử dụng trong view
        $tenNguoiDung = $_SESSION['tenNguoiDung'];
        $tenDangNhap = $_SESSION['tenDangNhap']; 
        $email = $_SESSION['email']; 
        $password = $_SESSION['password'];
        $sdt = $_SESSION['sdt'];
        $diaChi = $_SESSION['diaChi'];
        $quan_huyen = $_SESSION['quan_huyen'];
        $phuong_xa = $_SESSION['phuong_xa'];
    }
}

$trangThai = null;
if(isset($email)){
     $checkStatus = new SignInContr($tenDangNhap,$email);
    $trangThai = $checkStatus->kiemTraQuyenTruyCap();  

}

if($isLoggedIn && $trangThai == 2){
    header("Location:/web/view/user/LogOut.php");
    exit();
}

$productController = new ProductContr();
$productList = $productController->showAllProducts();


$productController = new ProductContr();

$item_perpage = !empty($_GET['per_page']) ? intval($_GET['per_page']) : 8;
$current_page = !empty($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($current_page - 1) * $item_perpage;

$search = $_GET['search'] ?? '';
$maLoaiSP = $_GET['MaLoaiSP'] ?? 0;
$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? 100000000;

$totalProducts = $productController->countProducts($search, $maLoaiSP, $min_price, $max_price);
$totalPages = ceil($totalProducts / $item_perpage);

$productList = $productController->getProductsByPage($search, $maLoaiSP, $min_price, $max_price, $item_perpage, $offset);

if(isset($_GET['act'])){
    switch($_GET['act']){
        case 'home':
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Home.php";
            break;
                    
        case 'notSignIn':
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Home.php";
            break;
    
        case 'addToCartSuccess':
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Home.php";
            break;

        case 'viewCart':
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Cart.php";
            break;

        case 'checkOrder':
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/CheckOrder.php";
            break;

        case "payMentSuccess":
            unset($_SESSION['giohang']);
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/OrderSuccess.php";
            break;
        
        case "viewBill":
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Bill.php";
            break;

        case "viewInfo":
            require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Info.php";
            break;            
    }
}else{
    require_once $_SERVER['DOCUMENT_ROOT'] . "/web/view/user/Home.php";
}
?>
