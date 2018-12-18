<!DOCTYPE html>
<html>
<body>

<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cbr_portal";

$msg = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

//insert map fields
if(isset($_POST['save'])){
//$map_fields = serialize ($_POST['map_fields']);
$post_name = "karthick";

$sql = "INSERT INTO portal_posts(post_name)VALUES('$post_name' )";

if ($conn->query($sql) === TRUE) {
	  $post_id = $conn->insert_id;
    //$msg = "New record created successfully";
	$map_fields = $_POST['map_fields'];
	$sql = "";
	foreach($map_fields as $field){
		$sql .= "INSERT into portal_fields_mapped (post_id, field_id) VALUES ('$post_id' , '$field' );";
	}
	  if (mysqli_multi_query($conn, $sql)) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
} else {
     $msg = "Error: " . $sql . "<br>" . $conn->error;
}

echo $msg;
}
//select all field_id


$sql = "SELECT field_id, field_type, field_label, field_placeholder, required, field_options FROM portal_fields";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	echo "<form method='post' action=''>";
    while($row = $result->fetch_assoc()) {
		echo '<label><input type="checkbox"  class="map_fields" value="'.$row['field_id'].'" name="map_fields[]"> #'.$row['field_id'].'</label>';
    }
	echo '<button type="submit" name="save" class="btn btn-success" id="save">SAVE</button>';
	echo "</form>";
} else {
    echo "0 results";
}

$conn->close();
?> 

</body>
</html>