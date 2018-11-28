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
        <option value="">--</option>
        <option value="text">Text</option>
        <option value="textarea">Text Area</option>
        <option value="number">Number</option>
        <option value="radio">Radio</option>
        <option value="checkbox">Checkbox</option>
        <option value="select">Select</option>
      </select>
	  </td>
</tr>
<tr>
<th scope="row"><label for="label">Field Label</label></th>
<td><input type="text" name="label" id="label" class="regular-text validate"></td>
</tr>
<tr>
<th scope="row"><label for="placeholder">Field Placeholder</label></th>
<td><input type="text" name="placeholder" id="placeholder" class="regular-text validate"></td>
</tr>
<tr>
<th scope="row">Required</th>
<td><input name="required" type="checkbox" id="required" value="1"></td>
</tr>
<tr class="field-options" style="display:none;">
<th scope="row">Options</th>
<td> <textarea class="opt-validate" rows="5" cols="55" id="options" placeholder="Option1| Option2 | Option3" name="options"></textarea>
<p class="description">Split multiple options with pipe symbol.</p>
</td>
</tr>
<tbody>
<table>
<p class="submit"><input type="submit" name="add" id="submit" class="button button-primary" value="Save Field"></p>
</form>
</div>
<script>
jQuery(document).ready(function(jquery){
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
				jquery(elt).focus();
				jquery(elt).after("<p class='error'>Please enter field " + elt_id + ".</p>");
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
				jquery(".field-options td").append("<p class='error'>Please enter field options.</p>");
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