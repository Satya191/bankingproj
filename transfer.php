<?php
    include_once 'header.php';
?>
<?php
    if(!isset($_SESSION["useruid"])) {
        header("location: ../index.php");
        exit();
    }
    include_once 'includes/bankstuff.inc.php';
?>
    <div id="bankacc_info">
        <?php
        echo "<h1 style='color:black; font-size: 50px;'>Hello " . $_SESSION["useruid"] . "</h1>";
        echo "<p style='color:red; font-size: 40px;'>Account Balance: $" . $_SESSION["userBalance"] . "</p>";
        ?>
        <ul id="signup-form" style="position: fixed; top:63%; left:17%; list-style-type: none;">
            <li style="display:inline-block; margin-left: 120px;">
                <h2 style="position: fixed; left: 27%; top: 56%;">Transfer Money</h2>
                <form action="includes/transfer.inc.php" method="post">
                    <input type="text" name="uid" placeholder="Username...">
                    <input type="text" name="amt" placeholder="Amount...">
                    <button type="submit" name="submit">Deposit</button>
                </form>
            </li>
        </ul>
        <?php
            if(isset($_GET["error"])) {
                switch($_GET["error"]) {
                    case "emptyinput":
                        echo "<p style='position:fixed; top: 81%; left: 33%; font-size: 50px; color: blue;'>Fill in all fields properly!</p>";
                        break;
                    case "invalidinput":
                        echo "<p style='position:fixed; top: 81%; left: 33%; font-size: 50px; color: blue;'>Invalid input entered!</p>";
                        break;
                    case "notenoughmoney":
                        echo "<p style='position:fixed; top: 81%; left: 33%; font-size: 50px; color: blue;'>The amount of money you are trying to withdraw exceeds the amount of money in your bank account!";
                        break;
                    case "lessthanzero":
                        echo "<p style='position:fixed; top: 81%; left: 33%; font-size: 50px; color: blue;'>Enter a value greater than 0!";
                        break;
                    case "usernotfound":
                        echo "<p style='position:fixed; top: 81%; left: 33%; font-size: 50px; color: blue;'>User not found in database!";
                        break;
                    case "none":
                        echo "<p style='position:fixed; top: 81%; left: 33%; font-size: 50px; color: blue;'>The money was successfully deposited!</p>";
                        break;
                }
            } 
        ?>
    </div>

<?php
    include_once 'footer.php';
?>