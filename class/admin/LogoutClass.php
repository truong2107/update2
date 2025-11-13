<?php
class LogoutClass {
    protected function logUserOut() {
        session_start();
unset($_SESSION['tennguoidungadmin']);
unset($_SESSION['tenDangNhapadmin']);
unset($_SESSION['emailadmin']);
unset($_SESSION['passwordadmin']);
unset($_SESSION['sdtadmin']);
unset($_SESSION['diaChiadmin']);
unset($_SESSION['quan_huyenadmin']);
unset($_SESSION['phuong_xaadmin']);
unset($_SESSION['roleadmin']); 
        header("location: /web/view/admin/index.php");
        exit();
    }
}
?>