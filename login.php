<?php
    include_once 'header.php';
?>
<?php
    if(isset($_SESSION["useruid"])) {
        header("location: ../index.php");
        exit();
    }
?>
    <section id="signup-form">
        <h2>Login</h2>
        <form action="includes/login.inc.php" method="post">
            <input type="text" name="uid" placeholder="Username...">
            <input type="password" name="pwd" placeholder="Password...">
            <button type="submit" name="submit">Log In</button>
        </form>
        <?php
            if(isset($_GET["error"])) {
                switch($_GET["error"]) {
                    case "emptyinput":
                        echo "<p style='position:fixed; top: 66%; left: 35%; font-size: 50px; color: blue;'>Fill in all fields!</p>";
                        break;
                    case "wronglogin":
                        echo "<p style='position:fixed; top: 66%; left: 35%; font-size: 50px; color: blue;'>Invalid username or password!</p>";
                        break;
                }
            } 
        ?>
    </section>

<?php
    include_once 'footer.php';
?>