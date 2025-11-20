<?php
// File: /web/class/admin/ChinhsuaClass.php

require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/DataBaseClass.php";

class InfoClass extends DatabaseClass {


    protected function getUserById($id) {
        $conn = $this->connect();

        $sql = "SELECT * FROM nguoidung WHERE id_nguoidung = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->bind_param("i", $id); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            $stmt->close();
            return false; 
        }
    }


    protected function updateUser($id, $tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa) {
        $conn = $this->connect();


        $sqlCheck = "SELECT id_nguoidung FROM nguoidung WHERE email = ? AND id_nguoidung != ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("si", $email, $id);
        $stmtCheck->execute();
        $stmtCheck->store_result();
        if ($stmtCheck->num_rows > 0) {

            $stmtCheck->close();
            header("Location: /web/view/user/UpdateInfo.php?id=" . $id . "&error=emailtaken");
            exit();
        }
        $stmtCheck->close();
                $sqlCheck2 = "SELECT id_nguoidung FROM nguoidung WHERE tenDangNhap = ? AND id_nguoidung != ?";
        $stmtCheckdn = $conn->prepare($sqlCheck2);
        $stmtCheckdn->bind_param("si", $tenDangNhap, $id);
        $stmtCheckdn->execute();
        $stmtCheckdn->store_result();
                 if ($stmtCheckdn->num_rows > 0) {

            $stmtCheckdn->close();
            header("Location: /web/view/user/UpdateInfo.php?id=" . $id . "&error=usernametaken");
            exit();
        }
        $stmtCheckdn->close();


        $sql = "UPDATE nguoidung SET tenNguoiDung=?, tenDangNhap=?, email=?, password=?, sdt=?, diaChi=?, quan_huyen=?, phuong_xa=? WHERE id_nguoidung=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
        }

        $stmt->bind_param("ssssssssi", $tenNguoiDung, $tenDangNhap, $email, $password, $sdt, $diaChi, $quan_huyen, $phuong_xa, $id);

        if ($stmt->execute()) {
            session_start();
            if ($stmt->execute()) {
                session_start();
                
                $row = $this->getUserById($id);

                if ($row) {
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
                }

                header("location: /web/index.php?act=viewInfo");
                exit();
            }        
        } else {
            die("Lỗi khi cập nhật người dùng: " . $stmt->error);
        }
    }
}
?>