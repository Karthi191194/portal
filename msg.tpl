<?php
if($error['status']== 1){
?>
<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
<p><strong><?php echo $error['msg']; ?></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
<?php } 
elseif($error['status'] == 0){
?>
<div id="setting-error-settings_updated" class="error settings-error notice is-dismissible"> 
<p><strong><?php echo $error['msg']; ?></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>
<?php }