<?php
if(isset($_POST['wpjmsq_license_key'])){
    if(wp_verify_nonce($_POST['_wpnonce'])){
        $liscense_key = esc_attr($_POST['wpjmsq_license_key']);
        update_option('wpjmsq_license_key',$liscense_key);
    }
}
$liscense = get_option('wpjmsq_license_key');
?>
<div class="wrap">
    <h2>Settings</h2>
    
    <form method="post" action="">
                <?php wp_nonce_field(); ?>
				<table class="form-table">
				<tbody>
				<tr valign="top" class="">
                    <th scope="row">
                    <label for="setting-wpjmsq_license_key">License Key</label>
                    </th>
                    
                    <td>
                    <input 
                           id="setting-wpjmsq_license_key" 
                           class="regular-text" 
                           type="text" name="wpjmsq_license_key" 
                           value="<?php if($liscense){ echo $liscense;} ?>"> 

                    <p class="description">
                    <strong style="color: red" ;="">Invalid license</strong>
                        , Enter the license key from your purchase receipt.</p>
                    </td>
                </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="button button-primary">
                                Submit
                            </button>
                        </td>
                    </tr>
                </tbody>
                </table>
	</form>
</div>