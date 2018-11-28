<div class="wrap">
<h1>Add New Category</h1>
<?php
if(isset($insert_status)){ 
$error = $insert_status;
include(MSG);
} ?>
<form method="post" action="">
<table class="form-table">
<tbody>
<tr>
<th scope="row"><label for="cat-name">Category Name</label></th>
<td><input type="text" name="cat_name" id="cat-name" class="regular-text"></td>
</tr>
<tbody>
<table>
<p class="submit"><input type="submit" name="add" id="add" class="button button-primary" value="Save Category"></p>
</form>
</div>
<script>
jquery(document).ready(function(){

});
</script>