<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <meta name="description" content="<?php echo $description; ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header>
        <h1>ProductsDB</h1>
        <nav>
            <ul>
                <li><a href="./index.php">Products</a></li>
                <?php
                if(!isset($_SESSION['user_id'])) {
                    echo '<li><a href="./signin.php">Sign In</a></li>';
                } else {
                    echo '<li><a href="./signout.php">Sign Out</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>