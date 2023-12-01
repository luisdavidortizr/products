<?php
$title = "Sign In to ProductsDB";
$description = "";
require 'templates/header.php';
?>

<main>
    <h1>Sign In to ProductsDB</h1>

    <section>
        <h2>Don't have an account? Sign Up here!</h2>
    </section>
    <section class="form_container">
        <form action="login.php" method="post">
            <label for="user_name">Your Name</label>
            <input type="text" name="user_name" id="user_name" required>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <input type="hidden" name="new_user" value="true">
            <input type="submit" value="Sign Up" class="primary_button">
        </form>
    </section>

    <section>
        <h2>Already have an account? Sign In here!</h2>
    </section>
    <section class="form_container">
        <form action="login.php" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <input type="hidden" name="new_user" value="false">
            <input type="submit" value="Sign In" class="primary_button">
        </form>
    </section>
</main>

<?php
require 'templates/footer.php';
?>