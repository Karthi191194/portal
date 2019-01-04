<?php 
//echo "<pre>"; print_r($fields); 
$post_fields = array ("text" => "<label for='%s'>%s</label><input type=text class='%s' placeholder='%s' id='%s'	name='%s' data-category='%s' value='%s'>",
"textarea" =>  "<label for='%s'>%s</label><textarea class='form-control %s' rows='5' cols='10' placeholder='%s' id='%s' name='%s' data-category='%s'>%s</textarea>",
);

$table_name = $wpdb -> prefix .'portal_fields_value';
$current_post_id = get_the_ID();
$custompostfield_db_values = $wpdb->get_results( "SELECT field_name, field_value FROM $table_name WHERE post_id = $current_post_id " );
//echo "<pre>"; print_r($custompostfield_db_values);

$prev_dep_category = get_the_terms($current_post_id, 'procurement_dep_category');
if($prev_dep_category ){
	foreach($prev_dep_category as $category){
		$prev_category[] = $category->term_id;
	}
}
//echo "<pre>"; print_r($prev_category);

foreach($custompostfield_db_values  as $custompostfield_value){
	if(is_serialized($custompostfield_value->field_value)){
		$custompostfield_values[$custompostfield_value->field_name]  = unserialize($custompostfield_value->field_value);
	}else{
		$custompostfield_values[$custompostfield_value->field_name]  = $custompostfield_value->field_value;
	}
}
//echo "<pre>"; print_r($custompostfield_values);
?>

<div class="zaccordion_container">
<?php
foreach($fields as $key => $field){ 
			 $class = "form-control";
			 $field_id = $field->field_id;
			 $catgeory_id = $field->category_id;
			 if($catgeory_id == "-1"){ 
				$catgeory_id = "0";
			 }			 
			 $id = 'field_'.$catgeory_id.'_'.$field_id;
			 $checkbox_textarea_id = 'field_'.$catgeory_id.'_'.$field_id.'_1';
			 $label = $field->field_label;
			 $placeholder = $field->field_placeholder;
			 $name = $catgeory_id.'_'.$field_id;
			 $name = "portalcustomfield[$name]";
			 $checkbox_textarea_name = $catgeory_id.'_'.$field_id.'_1';
			 $checkbox_textarea_name = "portalcustomfield[$checkbox_textarea_name]";
			 $field_options = unserialize($field->field_options);
			 $value_name = $catgeory_id.'_'.$field_id;
			 $checkbox_textarea_value_name = $catgeory_id.'_'.$field_id.'_1';
			 if($field->field_type == "checkbox"){
				if(!empty($custompostfield_db_values)){
					if(array_key_exists($value_name, $custompostfield_values)){
						$value = $custompostfield_values[$value_name];
					}else{
						$value = "";
					}
					if(array_key_exists($checkbox_textarea_value_name, $custompostfield_values)){
						$checkbox_textarea_value = $custompostfield_values[$checkbox_textarea_value_name];
					}else{
						$checkbox_textarea_value = "";
					}					
				}else{
					$value = "";
					$checkbox_textarea_value = "";
				}
			 }else{
				if(!empty($custompostfield_db_values) && array_key_exists($value_name, $custompostfield_values)){
					$value = $custompostfield_values[$value_name];
				}else{
					$value = "";
				}
			 }

//for new post
if(get_current_screen()->action == "add"){			 
?>
<div class="accordion_head <?php if($catgeory_id != 0){ echo "post-custom-fields-hidden";} ?>"  data-category-id="<?php echo  $catgeory_id; ?>" >Requirement Category <?php echo $key + 1; if($catgeory_id != "0"){ echo " (".get_term( $field->category_id, 'procurement_dep_category' )->name.")"; } ?><span class="plusminus">+</span></div>
  <div class="accordion_body post-custom-field" data-category-id="<?php echo  $catgeory_id; ?>" style="display: none;">
  		<?php
			if($field->field_type == "checkbox"){  
				echo "<label class='m-b-10'>$label </label>";
				foreach($field_options as $choices){
					echo "<div class='checkbox m-b-10'><label><input type='checkbox' name='".$name."[]' value='$choices[0]'>$choices[1]</label></div>";
				}
				echo "<textarea class='form-control' rows='5' cols='10' id='$checkbox_textarea_id' name='$checkbox_textarea_name' ></textarea>";
			}else{			
				printf($post_fields[$field->field_type], $id , $label, $class, $placeholder , $id, $name, $catgeory_id,  $value ); 
			}			
		?>
</div>
<?php }else{ //for existing post ?>
	<div class="accordion_head <?php if($catgeory_id == 0 || in_array($catgeory_id, $prev_category )){ echo "post-custom-fields";}else{ echo "post-custom-fields-hidden"; } ?>"  data-category-id="<?php echo  $catgeory_id; ?>" >Requirement Category <?php echo $key + 1; if($catgeory_id != "0"){ echo " (".get_term( $field->category_id, 'procurement_dep_category' )->name.")"; } ?><span class="plusminus">+</span></div>
  <div class="accordion_body post-custom-field" data-category-id="<?php echo  $catgeory_id; ?>" style="display: none;">
  		<?php
			if($field->field_type == "checkbox"){ 
				echo "<label class='m-b-10'>$label </label>";
				foreach($field_options as $choices){
					if(is_array($value) && !empty($value)){
						if(in_array($choices[0], $value )){ 
							$checked = "checked";
						}else{
							$checked = "";
						}
					}else{ 
						$checked = "";
					}
					echo "<div class='checkbox m-b-10'><label><input type='checkbox' name='".$name."[]' value='$choices[0]'  $checked  >$choices[1]</label></div>";
				}
				echo "<textarea class='form-control' rows='5' cols='10' id='$checkbox_textarea_id' name='$checkbox_textarea_name' >$checkbox_textarea_value</textarea>";
			}else{			
				printf($post_fields[$field->field_type], $id , $label, $class, $placeholder , $id, $name, $catgeory_id, $value ); 				
			}	
		?>
</div>
<?php }
} 
?>
</div>

<script>
$(document).ready(function() {
  //toggle the component with class accordion_body
  $(".accordion_head").click(function() {
    if ($('.accordion_body').is(':visible')) {
      $(".accordion_body").slideUp(300);
      $(".plusminus").text('+');
    }
    if ($(this).next(".accordion_body").is(':visible')) {
      $(this).next(".accordion_body").slideUp(300);
      $(this).children(".plusminus").text('+');
    } else {
      $(this).next(".accordion_body").slideDown(300);
      $(this).children(".plusminus").text('-');
    }
  });
  $("#procurement_dep_categorychecklist").on("click", "input[type='checkbox']", function(){
	  var id = $(this).attr("value");
	   if ($(this).is(":checked")) {
			  $(".zaccordion_container .accordion_head[data-category-id='"+ id +"']").show();
			 // $(".zaccordion_container .accordion_body[data-category-id='"+ id +"']").show();
		}else{
			  $(".zaccordion_container .accordion_head[data-category-id='"+ id +"']").hide();			
			  $(".zaccordion_container .accordion_body[data-category-id='"+ id +"']").hide();
			  $(".zaccordion_container .accordion_body[data-category-id='"+ id +"']").find("input[type=checkbox]").prop('checked',false);
			  $(".zaccordion_container .accordion_body[data-category-id='"+ id +"']").find("input[type=text],textarea").val("");			
		}
  });
});
</script>