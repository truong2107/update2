<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ProductAddContr.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $tensp = $_POST['name'];
    $trangthai = (int) $_POST['status'];
    $giaban = $_POST['price'];
    $loaisp = (int) $_POST['category'];
    $mota = $_POST['description'];
    
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $anh = uniqid("img_", true) . "." . $ext;

    $product = new ProductAddContr($loaisp, $tensp, $giaban, $mota, $anh, $trangthai, 0);

    if($product->addProduct()){
        move_uploaded_file($_FILES['image']['tmp_name'], "../../view/img/product/" . basename($anh));
        header("Location: ../../view/admin/admin.product.php?act=add");
        exit();     
    }
}

    
?>