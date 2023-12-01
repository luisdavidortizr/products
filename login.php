<?php
$title = "Sign In to ProductsDB";
$description = "";
require './templates/header.php';
?>

<main>
<?php
require './inc/database.php';

$new_user = $_POST['new_user'];
$username = $_POST['username'];
$password = $_POST['password'];
$ok = true;

if(empty($new_user)) {
    echo '<p>Invalid data</p>';
    $ok = false;
}
if(empty($username)) {
    echo '<p>Username is required</p>';
    $ok = false;
}
if(empty($password)) {
    echo '<p>Password is required</p>';
    $ok = false;
}

if($new_user === 'true') {
    $user_name = $_POST['user_name'];
    if(empty($user_name)) {
        echo '<p>Your name is required</p>';
        $ok = false;
    }
    $confirm_password = $_POST['confirm_password'];
    if(empty($confirm_password)) {
        echo '<p>Password confirmation is required</p>';
        $ok = false;
    } elseif($confirm_password != $password) {
        echo "<p>Password confirmation doesn't match</p>";
        $ok = false;
    }

    if($ok) {
        $hashPassword = hash('sha512', $password);
        $sql = "INSERT INTO USERS (username, user_pwd, user_name)
        VALUES ('$username', '$hashPassword', '$user_name')";
        try {
            $ok = $database->execute($sql);
        } catch (Exception $e) {
            echo '<p>There was an error creating your user: '.$e->getMessage().'</p>';
            echo "<a href='javascript:self.history.back();' class='primary_button'>Go Back</a>";
        }
        echo '<section>';
		echo '<div>';
		echo '<h3>User Created</h3>';
		echo '</div>';
    	echo '</section>';
    }
} elseif($new_user != 'false') {
    echo '<p>Invalid data</p>';
    $ok = false;
}

if($ok) {
    $hashPassword = hash('sha512', $password);
    $sql = "SELECT user_id FROM USERS
    WHERE username = '$username' AND user_pwd = '$hashPassword'";
    try {
        $result = $database->exec($sql);
        $count = $result->num_rows;
        if($count == 1) {
            $row = $result->fetch_assoc();
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            header('location: index.php');
            exit();
        } else {
            echo '<p>Invalid username and/or password</p>';
            echo "<a href='javascript:self.history.back();' class='primary_button'>Go Back</a>";
        }
    } catch (Exception $e) {
        echo '<p>An error occurred: '.$e->getMessage().'</p>';
    }
} else {
    echo '<p>An error occurred</p>';
    echo "<a href='javascript:self.history.back();' class='primary_button'>Go Back</a>";
}
?>
</main>

<?php
require './templates/footer.php';
?>