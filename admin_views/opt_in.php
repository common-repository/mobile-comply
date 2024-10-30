<div class="wrap">
    <script type="text/javascript">
        jQuery(function(){
            jQuery('#add_opt_in_form').validate();
        });
    </script>
    <h2>Mobilecomply Opt In</h2>
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
    <h3>Add new Opt In user</h3>
    <form method="POST" action="<?php echo "admin.php?page={$_GET['page']}&action=add_new_opt_in"; ?>" class="form" id="add_opt_in_form">
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
                    <input type="hidden" name="action" value="add_new_opt_in"/>
                    <input type="submit" name="add_new_opt_in" value="Add" class="button-primary"/>
                </td>
            </tr>
        </table>
    </form>
    <br/>
    <a href="admin.php?page=<?php echo $_GET['page']; ?>&action=export_to_csv" class="button-secondary">Export to CSV</a>
    <br/><br/>
    <?php
    if ($bShowPagination) {
        ?>
        <div class="tablenav">
            <div class='tablenav-pages'>
                <?php 
                $oPagination->show();
                ?>
            </div>
        </div>
        <?php
    }
    ?>
    <table class="widefat">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile Number</th>
                <th>Email Address</th>
                <th>Receive Offers?</th>
                <th>Date Added</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Mobile Number</th>
                <th>Email Address</th>
                <th>Receive Offers?</th>
                <th>Date Added</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
        <tbody>
            <?php
            if ($iTotalNumber) {
                foreach ($aOptInRecords as $oOptInRecord) {
                    ?>
                    <tr>
                        <td><?php echo $oOptInRecord->opt_in_name; ?></td>
                        <td><?php echo $oOptInRecord->opt_in_mobile_phone; ?></td>
                        <td><?php echo $oOptInRecord->opt_in_email; ?></td>
                        <td>
                            <?php
                            if ($oOptInRecord->opt_in_receive_mobile_offers) {
                                echo 'Yes';
                            } else {
                                echo 'No';
                            }
                            ?>
                        </td>
                        <td><?php echo $oOptInRecord->opt_in_date; ?></td>
                        <td>
                            <a href="<?php echo "admin.php?page={$_GET['page']}&action=edit&opt_in_id={$oOptInRecord->opt_in_id}"; ?>">Edit</a>
                        </td>
                        <td>
                            <span class="delete">
                                <a href="<?php echo "admin.php?page={$_GET['page']}&action=delete&opt_in_id={$oOptInRecord->opt_in_id}"; ?>">
                                    Delete
                                </a>
                            </span>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="7">
                        No records
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    if ($bShowPagination) {
        ?>
        <div class="tablenav">
            <div class='tablenav-pages'>
                <?php 
                $oPagination->show();
                ?>
            </div>
        </div>
        <?php
    }
    ?>
</div>