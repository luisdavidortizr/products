<?php
$title = "Oops, We have a problem - ProductsDB";
$description = "We can't find the page you are looking for";
require 'templates/header.php';
?>
<main>
    <section>
        <h2>Oops, We have a problem!</h2>
        <p>The page you are looking for could not be found on our site, we apologize for any inconvenience</p>
        <p>Click the button to return to the homepage</p>
        <a href="index.php" class="primary_button">Go Back</a>
    </section>
</main>
<?php
require 'templates/footer.php';
?>