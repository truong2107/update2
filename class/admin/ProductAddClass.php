<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class ProductAddClass extends DataBaseClass{

    protected function checkProductExist($tenSP) {
        $conn = $this->connect();
        
        $sql = "SELECT TenSP FROM sanpham WHERE TenSP = ?";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->bind_param("s", $tenSP);
        $stmt->execute();
        $stmt->store_result();
        
        $existProduct = $stmt->num_rows > 0;

        $stmt->close();
        return $existProduct;
    }
    
    protected function insertProduct($maLoaiSP, $tenSP, $gia, $moTa, $anh, $trangthai, $soLuongBan){
        if ($this->checkProductExist($tenSP)) {
            header("Location: /web/view/admin/admin.product-add.php?error=nameProductTaken");
            exit();
        }

        $conn = $this->connect();
        $sql = "INSERT INTO sanpham (MaLoaiSP, TenSP, DonGia, SoLuongBan, MoTa, HinhAnh, TrangThai) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Lỗi SQL: " . $conn->error);
        }

        $stmt->bind_param("isdissi", $maLoaiSP, $tenSP,$gia, $soLuongBan, $moTa, $anh, $trangthai);
        if($stmt->execute()) {
            return true;
        }

        return false;

    }
}

?>