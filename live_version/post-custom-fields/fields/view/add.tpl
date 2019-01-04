<div class="wrap">
<h1>Add New Field</h1>
<?php
if(isset($insert_status)){ 
$error = $insert_status;
include(MSG);  
} ?>
<form method="post" action="">
<table class="form-table">
<tbody>
<tr>
<th scope="row"><label for="type">Field Type</label></th>
<td><select class="validate" name="type" id="type">
        <option value=""></option>
        <option <?php if(isset($data) && $data['type'] == "text"){ echo "selected";} ?> value="text">Text</option>
        <option <?php if(isset($data) && $data['type'] == "textarea"){ echo "selected";} ?> value="textarea">Text Area</option>
        <option <?php if(isset($data) && $data['type'] == "checkbox"){ echo "selected";} ?> value="checkbox">Checkbox</option>
      </select>
	  </td>
</tr>
<tr>
<th scope="row"><label for="label">Field Label</label></th>
<td><textarea name="label" id="label" rows="5" cols="53" class="validate"><?php if(isset($data)){ echo $data['label'];} ?></textarea></td>
</tr>
<tr>
<th scope="row"><label for="placeholder">Field Placeholder</label></th>
<td><input type="text" name="placeholder" id="placeholder" class="regular-text validate" value="<?php if(isset($data)){ echo $data['placeholder'];} ?>"></td>
</tr>
<tr class="field-options" style="<?php if(isset($data) && $data['type'] == "checkbox"){ echo 'display:table-row';}else{ echo 'display:none'; } ?>">
<th scope="row">Options</th>
<td> <textarea class="opt-validate" rows="5" cols="54" id="options" placeholder="" name="options"></textarea>
<p class="description">Please specify both a value and label for each option. eg:- red : Red</p>
<p class="description">Split multiple options with pipe symbol. eg:- red : Red | blue : Blue</p>
<p class="description">Please avoid adding pipe symbol at the end of last option and duplicate option values.</p>
</td>
</tr>
<tbody>
</table>
<h3>Categories</h3>
<?php  $args = array(  'taxonomy' => 'procurement_dep_category', 'orderby' => 'name','order'   => 'ASC', "hide_empty" => 0 );
$default = array ( 0 => array('term_id' => -1, 'name' => 'Default'));
$categories = get_categories($args); 
$all_categories = array_merge($default, $categories );
?>
<table class="post-table">
<tr>
<?php $i = 1; foreach($all_categories as $key => $categories){

 ?>
<td>
<?php if($key == 0){?>
	<label><input type="checkbox" name="categories[]" checked value="<?php echo $categories['term_id']; ?>"><strong><?php echo $categories['name']; ?></strong></label>
<?php }else{ ?>
	<label><input type="checkbox" name="categories[]" value="<?php echo $categories->term_id; ?>"><strong><?php echo $categories->name; ?></strong></label>
<?php } ?>
</td>
<?php  if($i % 3 == 0){ echo "</tr><tr>"; } $i++; } ?>
</table>
<p class="submit"><input type="submit" name="add" id="submit" class="button button-primary" value="Save Field"></p>
</form>
<div id="" role="">
		<p id="" class="">*<i>Fields mapped to the DEFAULT category will be dispalyed on all the posts.</i></p>
		<p id="" class="">*<i>Navigate to PROCUREMENT FORECASTS > DEPARTMENT to create or delete a category.</i></p>
</div>		
</div>
<script>
jQuery(document).ready(function(jquery){
	jquery("#type").change(function(){
		if(jquery(this).val() == "checkbox"){
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
				jquery(elt).focus();
				jquery(elt).after("<p class='error'>Please enter the field " + elt_id + ".</p>");
				error = false;
				return false;
			}
			else{
				jQuery(elt).siblings('.error').text("");
			}
		});
		if(jquery(".field-options").is(":visible")){
			if(jquery("textarea.opt-validate").val() == ""){
				jquery("textarea").focus();
				jquery(".field-options td").append("<p class='error'>Please enter the checkbox options.</p>");
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