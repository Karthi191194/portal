<div class="wrap">
<h1>Add New Post</h1>
<form method="post" action="">
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
<div id="post-body-content" style="position: relative;">
<div id="titlediv">
<div id="titlewrap">
	<label class="" id="title-prompt-text" for="title">Enter title here</label>
	<input type="text" name="post_title" size="30" value="" id="title" spellcheck="true" autocomplete="off">
</div>
</div>
<h2 class="post-field">Fields</h2>
<i>(Select the fields which needs to be used to this post.)</i>
<table class="post-table">
<tr>
<?php 
$field_count = count($fields); 
$i = 1;
foreach($fields as $field){ ?>
<td>
<label><input type="checkbox"  class="<?php echo $field->field_id; ?>" value="<?php echo $field->field_id; ?>" name="fields['field_id'][]"> <strong>#<?php echo $field->field_id; ?></strong>  <?php echo $field->field_label; ?></label><br>
      <select class="<?php echo $field->field_id; ?>" name="fields['field_position'][]">
        <option value="">Position</option>
		<?php for($j = 1; $j <= $field_count; $j++){ ?>
			<option value="<?php echo $j; ?>"><?php echo $j; ?></option>
		<?php } ?>
      </select>
<td>
<?php if($i % 2 == 0){ ?>
</tr><tr>
<?php }
$i++;
}
?>
</tr>
</table>
<hr>
<h2 class="post-field">Contributors</h2>
<i>(Select the contributors who can access this post.)</i>
</div>
<div id="postbox-container-1" class="postbox-container">
<div id="categorydiv" class="postbox ">
<h2 class="post-hndle"><span>Categories</span></h2>
<div class="inside">
<table>
<tr>
<td>
<label><input type="checkbox"  class="map_fields" value="" name="map_fields[]"> #2</label>
<td>
</tr>
<tr>
<td>
<label><input type="checkbox"  class="map_fields" value="" name="map_fields[]"> #2</label>
<td>
</tr>
</table>
</div>
</div>
</div>
<div id="postbox-container-2" class="postbox-container">
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save"></p>
</div>
</div>
</div>

</form>
</div>