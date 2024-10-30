<script type="text/javascript">
    jQuery(function(){
        jQuery('#edit_opt_in_form').validate();
    });
</script>

<h2>Edit Opt In user</h2>

<a href="admin.php?page=<?php echo $_GET['page']; ?>">&lt; Back</a>

<?php
if ($sSuccessMessage) {
    ?>
    <div class="updated">
        <p>
            <?php echo $sSuccessMessage; ?>
        </p>
    </div>
    <?php
}

if ($aErrors) {
    ?>
    <div class="error">
        <p>
            <?php echo implode('<br/>', $aErrors); ?>
        </p>
    </div>
    <?php
}
?>
<form method="POST" action="<?php echo "admin.php?page={$_GET['page']}&action=edit&opt_in_id=$opt_in_id"; ?>" class="form" id="edit_opt_in_form">
    <table class="form-table mobilecomply_table">
        <tr>
            <th>
                <label for="opt_in_name">Name<span> *</span>: </label>
            </th>
            <td>
                <input type="text" name="opt_in_name" value="<?php echo $opt_in_name; ?>" class="required" id="opt_in_name"/>
            </td>
        </tr>
 
        <tr>
            <th>
                <label for="opt_in_mobile_number">Mobile Number<span> *</span>: </label>
            </th>
            <td>
                <input type="text" name="opt_in_mobile_number" value="<?php echo $opt_in_mobile_number; ?>" class="required" id="opt_in_mobile_number"/>
            </td>
        </tr>
        
        <tr>
            <th>
                <label for="opt_in_email">Email Address<span> *</span>: </label>
            </th>
            <td>
                <input type="text" name="opt_in_email" value="<?php echo $opt_in_email; ?>" class="required email" id="opt_in_email"/>
            </td>
        </tr>
        
        <tr>
            <th>
                <label for="mobile_offers">Receive Mobile Offers<span> *</span>: </label>
            </th>
            <td>
                <input type="radio" name="receive_mobile_offers" value="0" <?php if (!$receive_mobile_offers) { echo 'checked="checked"'; } ?> id="receive_mobile_offers_no"/> 
                <label for="receive_mobile_offers_no">No</label>
                <input type="radio" name="receive_mobile_offers" value="1" <?php if ($receive_mobile_offers) { echo 'checked="checked"'; } ?> id="receive_mobile_offers_yes"/> 
                <label for="receive_mobile_offers_yes">Yes</label>
            </td>
        </tr>
        
        <tr>
            <td colspan="2">
                <input type="hidden" name="edit_new_opt_in" value=""/>
                <input type="submit" name="edit_new_opt_in" value="Edit" class="button-primary"/>
            </td>
        </tr>
    </table>
</form>