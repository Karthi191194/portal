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

$field_values = $_POST;

//select post_fields mapped to post

$id = 14; //get from URL
$contributor_id = 1; // get from session

	$sql = "";
	foreach($field_values as $field_id => $field_value){
		$sql .= "INSERT into portal_fields_value (post_id, field_id, field_value, contributor_id) VALUES ('$id' , '$field_id' , '$field_value', '$contributor_id' );";
	}
	  if (mysqli_multi_query($conn, $sql)) {
    echo "New records created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

$sql = "SELECT * FROM portal_fields_mapped WHERE post_id = '$id' ";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$mapped_fields[] = $row['field_id'];
    }
	//echo "<pre>"; print_r($mapped_fields);
	$fields = array ("text" => "<label for='%s'>%s</label><input type=text class='form-control %s' placeholder='%s' 	id='%s'	name='%s'>",
	"textarea" =>   "<label for='%s'>%s</label><textarea class='form-control %s' rows='5'  placeholder='%s' id='%s' name='%s'></textarea>",
	"number" => "<label for='%s'>%s</label><input type=number class='form-control %s' placeholder='%s' 	id='%s'	name='%s'>"
	);
		echo "<form action='' method='post'>";	
	foreach ($mapped_fields as $field){	
		$id = $field;
		$sql = "SELECT field_id, field_type, field_label, field_placeholder, required, field_options FROM portal_fields WHERE field_id = '$id' ";
		$result1 = $conn->query($sql);

	if ($result1->num_rows > 0) {

		while($row = $result1->fetch_assoc()) {
			$class = $row['required'] == 1 ? "validate" : "no-validate";
			$id = 'field_'.$row['field_id'];
			$label = $row['field_label'];
			$placeholder = $row['field_placeholder'];
			$name = $row['field_id'];	
			printf($fields[$row['field_type']], $id , $label, $class, $placeholder , $id, $name );		
		}
			
	} 
	else {
		echo "0 results";
	} 
	}
} else {
    echo "0 results";
} echo "<button type='submit'>SAVE</button></form>";




$conn->close();
?> 

</body>
</html>