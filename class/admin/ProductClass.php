<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";
class ProductClass extends DataBaseClass{
    protected function getProductsByStatusAndSearch($status, $search = ''){
        $conn = $this->connect();

        $sql = "SELECT * FROM sanpham WHERE 1";

        if($status !== 'all' && ($status == 0 || $status == 1)){
            $statusInt = intval($status);
            $sql .= " AND TrangThai = $statusInt";
        }

        if(!empty($search)){
            $searchSafe = $conn->real_escape_string($search);
            $sql .= " AND TenSP LIKE '%$searchSafe%'";
        }

        $sql .= " ORDER BY MaSP ASC";

        $result = $conn->query($sql);

        if(!$result){
            die("Lỗi truy vấn: " . $conn->error);
        }

        return $result;
    }

    protected function getAllProductCategories(){   
        $conn = $this->connect();
        $sql = "SELECT * FROM loaisanpham ORDER BY MaLoaiSP ASC";
         
        $result = $conn->query($sql);

        if(!$result){
            die("Lỗi truy vấn: " . $conn->error);
        }

        return $result;
    }
}
?>