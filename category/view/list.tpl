<div class="wrap">
<h1>Categories</h1>
<table id="category-list" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#CATEGORY ID</th>
                <th>CATEGORY NAME</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
		<?php foreach ($categories as $category){ ?>
            <tr>
                <td><?php echo $category->category_id; ?></td>
                <td><?php echo $category->category_name; ?></td>
                <td><a href="<?php echo admin_url().'admin.php?page=edit_category&category='.$category->category_id; ?>" class="button button-primary">Edit</a></td>
                <td><a href="<?php echo admin_url().'admin.php?page=all_category&category='.$category->category_id.'&action=delete'; ?>" class="button button-primary" onclick="return confirm('Are you sure to delete this category?');">Delete</a></td>
            </tr>
		<?php } ?>           
        </tbody>
    </table>
</div>
<script>
jQuery(document).ready(function() {
   jQuery('#category-list').DataTable();
} );
</script>