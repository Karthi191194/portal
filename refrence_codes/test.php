<?php 
$msg = "";
if(isset($_POST['save'])){
$field_type = $_POST['type'];
$field_label = $_POST['label'];
$field_placeholder = $_POST['placeholder'];
$required = $_POST['required'];
$field_options = $_POST['options'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cbr_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO portal_fields (field_type, 	field_label, field_placeholder, required, 	field_options)VALUES ('$field_type', '$field_label', '$field_placeholder', '$required', '$field_options' )";

if ($conn->query($sql) === TRUE) {
    $msg = "New record created successfully";
} else {
     $msg = "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

}
?>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php
if(!empty($msg)){ echo $msg; }
?>
<form action="" method="post">
    <div class="form-group">
      <label for="type">Field Type</label>
      <select class="form-control validate" name="type" id="type">
        <option value="">--</option>
        <option value="text">Text</option>
        <option value="textarea">Text Area</option>
        <option value="number">Number</option>
        <option value="radio">Radio</option>
        <option value="checkbox">Checkbox</option>
        <option value="select">Select</option>
      </select>
	</div>  
    <div class="form-group">
      <label for="label">Field Label</label>
      <input type="text" class="form-control validate" id="label" placeholder="Label" name="label">
    </div>
    <div class="form-group">
      <label for="placeholder">Field Placeholder</label>
      <input type="text" class="form-control validate" id="placeholder" placeholder="Placeholder" name="placeholder">
    </div>
    <div class="checkbox">
      <label><input type="checkbox"  id="required" value="1" name="required">Required</label>
    </div>
<div class="form-group field-options" style="display:none;">
  <textarea class="form-control opt-validate" rows="5" id="options" placeholder="Option1| Option2 | Option3" name="options"></textarea>
  <i>Split multiple options with pipe symbol.</i>
</div>
<button type="submit" name="save" class="btn btn-success" id="save">SAVE</button>	
</form>
<script>
$(document).ready(function(jquery){
	jquery("#type").change(function(){
		if(jquery(this).val() == "radio" || jquery(this).val() == "checkbox" || jquery(this).val() == "select"){
			jquery(".field-options").show();
		}else{
			jquery(".field-options").hide();	
		}
	});
	jquery("form").on("submit", function(e){
		jQuery(".error").remove();
		var error = true;	
		jquery(this).find('.validate').each(function(){
			elt = jquery(this)[0];
			elt_id = jQuery(elt).attr('id');
			if(jquery(elt).val() == ""){
				jquery(elt).after("<p class='error'>Please enter field " + elt_id + ".</p>");
				error = false;
				return false;
			}
			else{
				jQuery(elt).siblings('.error').text("");
			}
		});
		//return false;
		if(jquery(".field-options").is(":visible")){
			if(jquery("textarea.opt-validate").val() == ""){
				jquery(".field-options").append("<p class='error'>Please enter field options.</p>");
				error = false;
				return false;
			}
		}
		if(!error){
			return false;
		}
	});
});
</script>
</body>
<html>