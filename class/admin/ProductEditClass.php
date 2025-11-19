<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class ProductEditClass extends DataBaseClass {
    
    protected function getSanPham($id){
        $conn = $this->connect();
        $sql = "SELECT * FROM sanpham WHERE MaSP = '$id'";

        return mysqli_query($conn, $sql);
    }

    protected function getNameCategory($id){
        $conn = $this->connect();
        $sql = "SELECT TenLoaiSP FROM loaisanpham WHERE MaLoaiSP = '$id'";

        return mysqli_query($conn, $sql);
    }

    protected function getOtherCategories($id){
        $conn = $this->connect();
        $sql = "SELECT * FROM loaisanpham WHERE MaLoaiSP <> '$id'";

        return mysqli_query($conn, $sql);
    }
    
    protected function updateProduct($maSP, $maLoaiSP, $tenSP, $gia, $moTa, $anh, $trangThai){
        $conn = $this->connect();

        $sqlCheck = "SELECT MaSP FROM sanpham WHERE TenSP = ? AND MaSP != ?";
        $stmtCheck = $conn->prepare($sqlCheck);

        $stmtCheck->bind_param("si", $tenSP, $maSP);
        $stmtCheck->execute();

        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            $stmtCheck->close();
            header("Location: /web/view/admin/admin.product-edit.php?id=" . $maSP . "&error=nameProductTaken");
            exit();
        }
        $stmtCheck->close();

        $sql = "UPDATE sanpham SET MaLoaiSP = ?, TenSP = ?, DonGia = ?, MoTa = ?, HinhAnh = ?, TrangThai = ? WHERE MaSP = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("isissii",$maLoaiSP, $tenSP, $gia, $moTa, $anh, $trangThai, $maSP);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>