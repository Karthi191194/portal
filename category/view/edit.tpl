<div class="wrap">
<h1>Edit Category</h1>
<?php
if(isset($update_status)){ 
$error = $update_status;
include(MSG);
} ?>
<form method="post" action="">
<table class="form-table">
<tbody>
<tr>
<th scope="row"><label for="cat-name">Category Name</label></th>
<td><input type="text" name="cat_name" id="cat-name" class="regular-text" value="<?php echo $cat_name; ?>"></td>
</tr>
<tbody>
<table>
<p class="submit"><input type="submit" name="update" id="update" class="button button-primary" value="Update Category"></p>
</form>
</div>