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
        <h2>Sign Up</h2>
        <form action="includes/signup.inc.php" method="post">
            <input type="text" name="name" placeholder="Full name...">
            <input type="text" name="uid" placeholder="Username...">
            <input type="password" name="pwd" placeholder="Password...">
            <input type="password" name="pwdrepeat" placeholder="Repeat Password...">
            <button type="submit" name="submit">Sign Up</button>
        </form>
        <?php
            if(isset($_GET["error"])) {
                switch($_GET["error"]) {
                    case "emptyinput":
                        echo "<p style='position:fixed; top: 80%; left: 36%; font-size: 50px; color: blue;'>Fill in all fields!</p>";
                        break;
                    case "invaliduid":
                        echo "<p style='position:fixed; top: 80%; left: 36%; font-size: 50px; color: blue;'>Choose a proper username!</p>";
                        break;
                    case "passwordsdontmatch":
                        echo "<p style='position:fixed; top: 80%; left: 36%; font-size: 50px; color: blue;'>Passwords don't match!</p>";
                        break;
                    case "stmtfailed":
                        echo "<p style='position:fixed; top: 80%; left: 36%; font-size: 50px; color: blue;'>Something went wrong, try again!</p>";
                        break;
                    case "usernametaken":
                        echo "<p style='position:fixed; top: 80%; left: 36%; font-size: 50px; color: blue;'>Username already taken!</p>";
                        break;
                    case "none":
                        echo "<p style='position:fixed; top: 80%; left: 36%; font-size: 50px; color: blue;'>You have signed up successfully!</p>";
                        break;
                }
            } 
        ?>
    </section>

<?php
    include_once 'footer.php';
?>