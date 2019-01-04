<div class="wrap">
<h1>Edit Field</h1>
<?php
if(isset($update_status)){ 
$error = $update_status;
include(MSG);
} 
if(!empty($field_data[0]->field_options)){
	$options = unserialize($field_data[0]->field_options) ; 
	$checkbox_option = "";
	foreach($options as $key => $option){
		if($key == 0){
			$checkbox_option .=  $option[0] . ":" . $option[1];
		}else{
			$checkbox_option .= "|" . $option[0] . ":" . $option[1];
		}	
	}
}else{
	$checkbox_option = "";
}
?>
<form method="post" action="">
<table class="form-table">
<tbody>
<tr>
<th scope="row"><label for="type">Field Type</label></th>
<td><select class="validate" name="type" id="type" >
        <option value=""></option>
        <option <?php if(isset($field_data) && $field_data[0]->field_type == "text") { echo "selected" ;}?> value="text">Text</option>
        <option <?php if(isset($field_data) && $field_data[0]->field_type == "textarea") { echo "selected" ;}?> value="textarea">Text Area</option>
        <option <?php if(isset($field_data) && $field_data[0]->field_type == "checkbox") { echo "selected" ;}?> value="checkbox">Checkbox</option>
      </select>
	  </td> 
</tr>
<tr>
<th scope="row"><label for="label">Field Label</label></th>
<td><textarea name="label" id="label" rows="5" cols="53" class="validate"><?php if(isset($field_data) && $field_data[0]->field_label != "") { echo $field_data[0]->field_label ;}?></textarea></td>
</tr>
<tr>
<th scope="row"><label for="placeholder">Field Placeholder</label></th>
<td><input type="text" name="placeholder" id="placeholder" class="regular-text validate" value="<?php if(isset($field_data) && $field_data[0]->field_placeholder != "") { echo $field_data[0]->field_placeholder ;}?>"></td>
</tr>
<tr class="field-options" <?php if(isset($field_data) && $field_data[0]->field_type != "checkbox") { echo "style='display:none;'" ;}?>>
<th scope="row">Options</th>
<td> <textarea class="opt-validate" rows="5" cols="54" id="options" placeholder="" name="options"><?php if(isset($field_data) && $field_data[0]->field_options != "") { echo $checkbox_option ;}?></textarea>
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
foreach($field_data as $category){
	$previous_category[] = $category->category_id;
}
?>
<table class="post-table">
<tr>
<?php $i = 1; foreach($all_categories as $key => $categories){

 ?>
<td>
<?php if($key == 0){?>
	<label><input type="checkbox" name="categories[]"  value="<?php echo $categories['term_id']; ?>" <?php if(in_array($categories['term_id'], $previous_category)) echo "checked"; ?>><strong><?php echo $categories['name']; ?></strong></label>
<?php }else{ ?>
	<label><input type="checkbox" name="categories[]" value="<?php echo $categories->term_id; ?>" <?php if(in_array($categories->term_id, $previous_category)) echo "checked"; ?>><strong><?php echo $categories->name; ?></strong></label>
<?php } ?>
</td>
<?php  if($i % 3 == 0){ echo "</tr><tr>"; } $i++; } ?>
</table>
<p class="submit"><input type="submit" name="update" id="submit" class="button button-primary" value="Update Field"></p>
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