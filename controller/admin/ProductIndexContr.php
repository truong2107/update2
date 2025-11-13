<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/web/class/admin/ProductClass.php"; 

class ProductIndexContr extends ProductClass{
    public function showAllProducts(){
        $status = isset($_GET['status']) ? $_GET['status'] : 'all';

        $result = $this->getProductsByStatus($status);

        if($result && $result->num_rows > 0){
            $products = [];
            while($row = $result->fetch_assoc())
                $products[] = $row;
        } else {
            $products = [];
        }

        return $products;
    }

    public function showAllProductCategories(){
        $result = $this->getAllProductCategories();

        if($result && $result->num_rows > 0){
            $productCategories = [];
            while($row = $result->fetch_assoc())
                $productCategories[] = $row;
        }else{
            echo "Truy vấn SQL thất bại";
            exit();
        }

        return $productCategories;
    }
}

?>