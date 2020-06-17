<?php
// select box open tag
$selectBoxOpen = "<select name='stuff'>";
// select box close tag
$selectBoxClose = "</select>";
// select box option tag
$selectBoxOption = '';

// connect mysql server
$con = mysql_connect("yourhostname","yourusername","yourpassword");
if (!$con) {
die('Could not connect: ' . mysql_error());
}

// select database
mysql_select_db("yourdatabase", $con);
// fire mysql query
$result = mysql_query("SELECT stuff FROM stuff");
// play with return result array
while($row = mysql_fetch_array($result)){
$selectBoxOption .="<option value = '".$row['stuff']."'>".$row['stuff']."</option>";
}
// create select box tag with mysql result
$selectBox = $selectBoxOpen.$selectBoxOption.$selectBoxClose;
?>
//Next all you have to do is place your combobox in your form area right click and choose object html, select inside tag* and place the following:
<?php echo $selectBoxOption;?>
