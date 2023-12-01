<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('location: index.php');
    exit();
}
$title = "Create Product - ProductsDB";
$description = "";
require 'templates/header.php';
?>

<main>
    <?php
    include_once("./inc/validate.php");
    include_once("./inc/database.php");

    $validator = new Validate();

    $product_name = $_POST['name'];
    $product_description = $_POST['description'];
    $product_price = $_POST['price'];
    $product_id = $_POST['id'];

    $msg = $validator->check_empty($_POST, array('name', 'price'));
    if($msg != null) {
        echo $msg;
        echo "<a href='javascript:self.history.back();' class='primary_button'>Go Back</a>";
    } else {
        $product_price = floatval($product_price);

        $product_image = "";
        $error = false;
        try {
            $filename = $_FILES['image']['name'];
            $target_file = './uploads/'.$filename;
            $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
            $file_extension = strtolower($file_extension);
            $valid_extensions = array("png","jpeg","jpg");
            if(in_array($file_extension, $valid_extensions)) {
                if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $product_image = $target_file;
                } else {
                    echo '<p>Error uploading file</p>';
                    $error = true;
                }
            }
        } catch {}

        $sql = "UPDATE PRODUCTS
        SET 
        product_name = '$product_name', 
        product_description = '$product_description', 
        product_price = $product_price,
        product_image = '$product_image'
        WHERE product_id = '$product_id'";
        if(!$error) {
            try {
                $result = $database->execute($sql);
            } catch (Exception $e) {
                echo "<p>Error: ".$e->getMessage()."</p>";
            }
        }
        if($result) {
            header('location: index.php');
        } else {
            echo "<p>There was a problem updating your product!</p>";
            echo "<a href='javascript:self.history.back();' class='primary_button'>Go Back</a>";
        }
    }
    ?>
</main>

<?php
require 'templates/footer.php';
?>