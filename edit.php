<?php
$title = "Delete product - ProductsDB";
$description = "";
require 'templates/header.php';
require './inc/database.php';
require './inc/validate.php';
?>

<main>
    <?php
    session_start();
    if(!isset($_SESSION['user_id'])) {
        echo '<p>To update or delete data, please <a href="signin.php">Sign In &gt;</a></p>';
        echo "<a href='javascript:self.history.back();' class='primary_button'>Go Back</a>";
    } else {
        $product_id = $_GET['product_id'];
        if(empty($product_id)) {
            header('location: index.php');
        } else {
            if(!empty($_POST['submit'])) {
                $validator = new Validate();

                $product_name = $_POST['name'];
                $product_description = $_POST['description'];
                $product_price = $_POST['price'];

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
                        $valid_extensions = array("png","jpeg","jpg","pdf");
                        if(in_array($file_extension, $valid_extensions)) {
                            if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                                $product_image = $target_file;
                            } else {
                                echo '<p>Error uploading file</p>';
                                $error = true;
                            }
                        }
                    } catch(Exception $e) {}

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
            }

            $sql = "SELECT product_name, product_description, product_price 
            FROM PRODUCTS 
            WHERE product_id = $product_id
            LIMIT 1";
            $result = $database->exec($sql);
            if($result) {
                $row = $result->fetch_assoc();
                $product_name = $row['product_name'];
                $product_description = $row['product_description'];
                $product_price = $row['product_price'];
                echo '<section class="form_container">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" id="name" value="'.$product_name.'">
                        <label for="description">Product Description</label>
                        <textarea name="description" id="description">'.$product_description.'</textarea>
                        <label for="price">Product Price</label>
                        <input type="text" name="price" id="price" value="'.$product_price.'">
                        <label for="image">Product Image</label>
                        <input type="file" name="image" id="image" accept="image/*">
                        <input type="hidden" name="id" value="'.$product_id.'">
                        <input type="submit" name="submit" value="Update" class="primary_button">
                    </form>
                </section>';
            } else {
                echo "<p>Product doesn't exist</p>";
                echo "<a href='javascript:self.history.back();' class='primary_button'>Go Back</a>";
            }
        }
    }
    ?>
</main>

<?php
require 'templates/footer.php';
?>