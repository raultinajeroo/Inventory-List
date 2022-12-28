<!DOCTYPE html>

<?php
    session_start();
    if (isset($_POST['username']) && isset($_POST['password'])) {
        function check($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    }
?>

<html>
<body>
    <?php
        if (isset($_POST['submitted'])) {
            $username = check($_POST['username']);
            $password = check($_POST['password']);

            if (empty($username)) {
                echo "<b>Invalid Username!</b> \n";
            }
            else if (empty($password)) {
                echo "<b>Invalid Password!</b> \n";
            }
            else {
                $logins = array('drnigel' => 'raulgetsanA');
                if(isset($logins[$username]) && $logins[$username] == $password) {
                    $_SESSION['manager'] = true;
                    header("Location: interface.php");
                    exit();
                }
                else {
                    echo "<b>Please try again...</b> \n";
                }
            }
        }
    ?>

    <form action="index.php", method=post>
        <h1>Log In:</h1>
        <label>Username: </label> <input type="text" name="username" placeholder="username">
        </br>
        <label>Password: </label>  <input type="text" name="password" placeholder="password">
        <p/>
        <input type="submit" name="submitted" value="Log In">
        </br>
    </form>
    
    <form action="interface.php", method=post>
        <?php $_SESSION['manager'] = false; ?>
        <input type="submit" name="guest" value="Cashier View">
    </form>
</body>
</html>