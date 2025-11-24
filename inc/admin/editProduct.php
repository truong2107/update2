<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/controller/admin/ProductEditContr.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productContr = new ProductEditContr();

    $id = (int) $_GET['id'];    
    if (isset($id)) {
        $product = $productContr->getSanPhamQuaId($id);

        $ten = $_POST['name'];
        $trangthai = (int) $_POST['status'];
        $giaban = $_POST['price'];
        $loaisp = (int) $_POST['category'];
        $mota = $_POST['description'];

        $imageUploaded = !empty($_FILES['image']['name']);

        if($imageUploaded){
            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $anh = uniqid("img_", true) . "." . $ext;

            $productEdit = new ProductEditContr($id, $loaisp, $ten, $giaban, $mota, $anh, $trangthai);

            if($productEdit->editProduct()){
                move_uploaded_file($_FILES['image']['tmp_name'], "../../view/img/product/" . basename($anh));

                if (file_exists("../../view/img/product/" . $product['HinhAnh'])) {
                    unlink("../../view/img/product/" . $product['HinhAnh']);
                }

                header("Location: ../../view/admin/admin.product.php?act=edit");
                exit(); 
            }
        }
        else {
            $productEdit = new ProductEditContr($id, $loaisp, $ten, $giaban, $mota, $product['HinhAnh'], $trangthai);

            if($productEdit->editProduct()){
                header("Location: ../../view/admin/admin.product.php?act=edit");
                exit(); 
            }
        }
    }
}    
?>