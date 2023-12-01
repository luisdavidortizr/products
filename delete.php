<?php
$title = "Delete product - ProductsDB";
$description = "";
require 'templates/header.php';
require './inc/database.php';
?>

<main>
<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    echo '<p>To update or delete data, please <a href="signin.php">Sign In ></a></p>';
    echo "<a href='javascript:self.history.back();' class='primary_button'>Go Back</a>";
} else {
    $product_id = $_GET['product_id'];
    if(empty($product_id)) {
        header('location: index.php');
    } else {
        $sql = "DELETE FROM PRODUCTS WHERE product_id = $product_id";
        $result = $database->exec($sql);
        if($result) {
            header('location: index.php');
        } else {
            echo "<p>Could not delete product</p>";
            echo "<a href='javascript:self.history.back();' class='primary_button'>Go Back</a>";
        }
    }
}
?>
</main>

<?php
require 'templates/footer.php';
?>