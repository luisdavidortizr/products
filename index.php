<?php
$title = "ProductsDB, a place to save your products";
$description = "In ProductsDB you will save all your product's information online with ease!";
require 'templates/header.php';
session_start();
?>
<main>
    <h1>
        Products
    </h1>

    <section>
        <p><a href="create.php" class="primary_button">Add Product</a></p>
    </section>

    <section>
        <?php
        if(!isset($_SESSION['user_id'])) {
            echo '<p>To update or delete data, please <a href="signin.php" class="link">Sign In ></a></p>';
        }
        ?>
    </section>
    <section>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <?php
                    if(isset($_SESSION['user_id'])) {
                        echo "<th>Edit</th>";
                        echo "<th>Delete</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                require './inc/database.php';
                require './inc/validate.php';
                $validator = new Validate();
                try {
                    $sql = "SELECT * FROM PRODUCTS";
                    $result = $database->getData($sql);
                    if($result) {
                        foreach($result as $row) {
                            echo "<tr>
                                <td class='text-center align-middle'>".$row['product_name']."</td>
                                <td class='text-center align-middle'>".$row['product_description']."</td>
                                <td class='text-center align-middle'>$ ".$validator->format_price($row['product_price'])."</td>";
                            if(!empty($row['product_image'])) {
                                echo '<td><img src="'.$row['product_image'].'" alt="Product Image"></td>';
                            } else {
                                echo '<td></td>';
                            }
                            if(isset($_SESSION['user_id'])) {
                                echo "<td class='text-center align-middle'><a href='./edit.php?product_id=".$row['product_id']."'>
                                    <img src='img/edit.png'>
                                </a></td>
                                <td class='text-center align-middle'><a href='./delete.php?product_id=".$row['product_id']."'>
                                    <img src='img/delete.png'>
                                </a></td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td>No data to show</td></tr>";
                    }
                } catch (Exception $e) {
                    echo "<tr><td>Error: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</main>
<?php
require 'templates/footer.php';
?>