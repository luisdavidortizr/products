<?php
$title = "Create Product - ProductsDB";
$description = "";
require 'templates/header.php';
include_once("./inc/validate.php");
include_once("./inc/database.php");
?>

<main>
    <?php
    if(!empty($_POST['submit'])) {
        $validator = new Validate();

        $product_name = $_POST['name'];
        $product_description = $_POST['description'];
        $product_price = $_POST['price'];

        $msg = $validator->check_empty($_POST, array('name', 'price'));
        if($msg != null) {
            echo $msg;
        } else {
            $product_price = floatval($product_price);
            $product_image = "";
            $file_error = false;
            
            try {
                $filename = uniqid().'_'.basename($_FILES['image']['name']);
                $target_file = './uploads/'.$filename;
                $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
                $file_extension = strtolower($file_extension);
                $valid_extensions = array("png","jpeg","jpg","pdf");
                if(in_array($file_extension, $valid_extensions)) {
                    if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                        $product_image = $target_file;
                    } else {
                        echo '<p>Error uploading file</p>';
                        $file_error = true;
                    }
                } else { 
                    echo '<p>Invalid file extension: .'.$file_extension.'</p>';
                }
            } catch(Exception $e) {}

            $sql = "INSERT INTO PRODUCTS (product_name, product_description, product_price, product_image) VALUES ('$product_name', '$product_description', '$product_price', '$product_image')";
            if(!$file_error) {
                try {
                    $result = $database->execute($sql);
                } catch (Exception $e) {
                    echo "<p>Error: ".$e->getMessage()."</p>";
                }
            }
            if($result) {
                header('location: index.php');
            } else {
                echo "<p>There was a problem creating your product!</p>";
            }
        }
    }
    ?>

    <section class="form_container">
        <form action="" method="post" enctype='multipart/form-data'>
            <div>
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name">
            </div>
            <div>
                <label for="description">Product Description</label>
                <textarea name="description" id="description"></textarea>
            </div>
            <div>
                <label for="price">Product Price</label>
                <input type="text" name="price" id="price">
            </div>
            <div>
                <label for="image">Product Image</label>
                <input type="file" name="image" id="image" accept="image/*">
            </div>
            <input type="submit" name="submit" value="Create" class="primary_button">
        </form>
    </section>
</main>

<?php
require 'templates/footer.php';
?>