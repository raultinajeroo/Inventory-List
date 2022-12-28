<?php 
    session_start(); 
	if (!isset($_SESSION['items'])) {
		// $_SESSION['items'] = array();
        $_SESSION['items'] = array(
            'Rambutan'=>'453',
            'Pineapple'=>'528',
            'Kiwi'=>'947'
        );
		// $_SESSION['imgs'] = array();
		$_SESSION['imgs'] = array(
            'Rambutan'=>'https://traicayvietflorida.com/wp-content/uploads/2021/09/rambutan-traicayvietflorida-scaled.jpeg',
            'Pineapple'=>'https://www.meijer.com/content/dam/meijer/product/0002/40/0005/98/0002400005988_1_A1C1_0600.png',
            'Kiwi'=>'https://images.immediate.co.uk/production/volatile/sites/30/2020/02/Kiwi-fruits-582a07b.jpg?quality=90&resize=661%2C600'
        );
        $_SESSION['common'] = array();
        $_SESSION['alias'] = array();
	}
?>

<html>
<body>
    <h1>Inventory</h1>
    <?php 
        $items = $_SESSION['items'];
        $imgs = $_SESSION['imgs'];

        if (isset($_POST['log_out'])) {
            unset($_SESSION['manager']);
            header("Location: index.php");
            exit();
        }

        if (isset($_POST['name']) && isset($_POST['plu'])) { // Processes new items
            if (!array_key_exists($_POST['name'], $items) && !in_array($_POST['plu'], $items)) {
                $items[$_POST['name']] = $_POST['plu']; // Assigns item PLU
                if (isset($_POST['img']) && strlen($_POST['img']) > 1) {
                    $imgs[$_POST['name']] = $_POST['img']; // Assigns item image
                }
                $_SESSION['items'] = $items;
                $_SESSION['imgs'] = $imgs;
            }
            else {
                echo "Error adding new item.<br>";
            }
        }

        if (isset($_POST['alias'])) { // Processes aliases
            if (array_key_exists($_POST['name'], $items)) {
                $_SESSION['alias'][$_POST['name']] = $_POST['alias'];
            }
            else {
                echo "Error adding alias.<br>";
            }
        }
        
        if(isset($_POST['new_common']) && !empty($_POST['common'])){ // Processes checked items
            foreach($_POST['common'] as $val){
                $_SESSION['common'][$val] = $items[$val];
            }
        }
    ?>

    <?php if ($_SESSION['manager']) { // ADD NEW ITEM / ALIAS
        echo "Add new item: "; ?>
        <form action="interface.php", method=post>
            <input type="text" name="name" placeholder="Item Name">
            <input type="number" name="plu" placeholder="PLU">
            <input type="text" name="img" placeholder="Image URL">
            <p/>
            <input type="submit" name="new_item" value="Add to list">
        </form>
        <?php echo "Add alias to an item: "; ?>
        <form action="interface.php", method=post>
            <input type="text" name="name" placeholder="Item Name">
            <input type="text" name="alias" placeholder="Alias">
            <p/>
            <input type="submit" name="new_alias" value="Add alias">
        </form>
    <?php } ?>
    
    <form action="interface.php", method=post>    
        <?php // Prints inventory and allows to push items to the top
            ksort($items);
            $print_Arr = array("Commonly Encountered"=>$_SESSION['common'], "Items"=>$items);
            
            foreach ($print_Arr as $echo => $arr) { // Goes through both lists of items
                if (count($arr) > 0) {
                    echo "<b>$echo:</b>\n";
                    foreach ($arr as $item => $plu) {
                        $extra = "";
                        if (array_key_exists($item, $_SESSION['alias'])) { // Adds alias to item echo
                            $alias = $_SESSION['alias'][$item];
                            $extra .= "<p style=\"background-color:#DAF7A6;\">$alias</p>";
                        }
                        if (array_key_exists($item, $imgs)) { // Adds image to item echo
                            $img = $imgs[$item];
                            $extra .= "<br><img src=$img width=\"100\" height=\"100\" />";
                        }
                        echo "<br><input type='checkbox' name='common[]' value='$item'/> $item ($plu) $extra<br>";
                    }
                }
            }
        ?>
        <p/>
        <?php if (count($items) > 0) { ?>
            <input type="submit" name="new_common" value="Move Checked Items to Top">
        <?php } ?>
    </form>
    
    
    <form action="interface.php", method=post>    
        <input type="submit" name="log_out" value="Log Out">
    </form>
</body>
</html>