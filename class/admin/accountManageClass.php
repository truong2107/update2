<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class AccountManageClass extends DatabaseClass {


    protected function getUsers() {
        $conn = $this->connect();
        $timkiem=$_GET["searchTen"]?? "";
        $tuNgay=$_GET["tuNgay"]?? "";
        $denNgay=$_GET["denNgay"]?? "";
        $link="";
        if($timkiem!=""){
            $link= $link." AND tenDangNhap='".$timkiem."'";
        }
        if($tuNgay!=''&&$denNgay!=''){
            $link= $link." AND ngay_tao >='".$tuNgay." 00:00:00 AM' AND ngay_tao<='".$denNgay." 23:59:59 AM'";
        }
              $sql = "SELECT * FROM nguoidung WHERE vaiTro = 'user' $link ORDER BY id_nguoidung DESC";

        
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();


        $users = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        
        return $users;
    }
}
?>