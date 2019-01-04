<div class="wrap">
<h1>Fields</h1>
<table id="field-list" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#FIELD ID</th>
                <th>FIELD LABEL</th>
                <th>FIELD TYPE</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
		<?php foreach ($fields as $field){ ?>
            <tr>
                <td><?php echo $field->field_id; ?></td>
                <td><?php echo $field->field_label; ?></td>
                <td><?php echo $field->field_type; ?></td>
                <td><a href="<?php echo admin_url().'admin.php?page=edit_field&field='.$field->field_id; ?>" class="button button-primary">Edit</a></td>
                <td><a href="<?php echo admin_url().'admin.php?page=all_fields&field='.$field->field_id.'&action=delete'; ?>" class="button button-primary" onclick="return confirm('Are you sure to delete this field?');">Delete</a></td>
            </tr>
		<?php } ?>           
        </tbody>
    </table>
</div>
<script>
jQuery(document).ready(function() {
   jQuery('#field-list').DataTable();
} );
</script>