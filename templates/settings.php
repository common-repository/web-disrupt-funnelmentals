<?php
/**
 * BSP template: Settings
 *
 * This template is for the main admin area settings and controls
 *
 * @since  1.0.0
 *
 */
?>
<link rel="stylesheet" type="text/css" href="<?php echo $style; ?>">
<style>
    .notice-error, div.error, .notice.elementor-message, .update-nag, #wpfooter {
        display: none;
    }
    <?php if($is_free){ echo ".hide_premium{ display:none !important; }"; } ?>
</style>
<div class="wdf-header">
    <div style="display:flex;justify-content:center;align-items:center;">
        <img src="<?php echo $logo; ?>" />
    </div>
    <div class="wdf-body">
        <div class="wdf-title">
            <h1> Funnelmentals Settings </h1>
            <h4> Version: <?php echo $version; ?> Author: <a href="https://webdisrupt.com">Web Disrupt</a> </h4>
        </div>
        <div class="wdf-links">

        </div>
    </div>
</div>


<div class="wdf-main-body">

<!-- Global Settings -->
<div class="wdf-settings wdf-m-tab">
    <?php

    for ($i=0; $i < count($inputs_list); $i++) { 
        wdf_settings_textarea($images, $inputs_list[$i]['icon'], $inputs_list[$i]['label'], $inputs_list[$i]['id'], $inputs_list[$i]['value'], $inputs_list[$i]['style']);
    }

    ?>
<div class="toggle-row">
    <div class="toggle-title"> Remove Elementor Default Extra Padding </div>
    <div class="toggle-control">
        <div class="toggle-wrapper">
            <input class='toggle wdf-checked' type="checkbox" <?php if($data['remove-elementor-bottom-margin'] == 'true' || $data['remove-elementor-bottom-margin'] == ''){ echo 'checked="checked"'; } ?> name="remove-elementor-bottom-margin" id="remove-elementor-bottom-margin">
            <label for="remove-elementor-bottom-margin"></label>
        </div>
    </div>
</div>
<div class="toggle-row hide_premium">
    <div class="toggle-title"> Full Checkout </div>
    <div class="toggle-control">
        <div class="toggle-wrapper">
            <input class='toggle wdf-checked' type="checkbox" <?php if($data['is-full-checkout'] == 'true' || $data['is-full-checkout'] == ''){ echo 'checked="checked"'; } ?> name="is-full-checkout" id="is-full-checkout">
            <label for="is-full-checkout"></label>
        </div>
    </div>
</div>

<div class="description hide_premium"> Gets rid of Woocommerce direct checkout page and empty cart using complicated redirects that allows for full functionality when using the single-page <b>Checkout Pro</b> element. <b> Required for Stripe and other secure checkouts</b></div>
</div>

<!-- Enter License Page -->
<div class="wdf-license wdf-m-tab">
    <div>
    <label class="section-header"> <img src="<?php echo $images; ?>icon-activate.png" /> Activate License: </label>
    
    <?php // require_once $path."includes/wordpress-sdk-master/templates/forms/activate_license.php"; ?>
    
    <iframe id="license-window" scrolling="no" src="<?php echo admin_url('plugins.php'); ?>" ></iframe>
    </div>
</div>

<!-- Buy Pro Sales Page -->
<div class="wdf-get-pro wdf-m-tab"> 
    <div>
    <div class="text-body">

    <h1>Get Funnelmentals Pro Today & Unlock the Power!</h1>
    <h2>Features</h2>
    <div class="pro-feature-contianer">
        <div class="pro-feature">
        <b>Checkout Pro</b> This element allows you to transform the WooCommerce buying process to a single page experience. If you are using WooCommerce, this is a must-have feature. Because the less time it takes your customer to purchase your product the more conversions you will make. So let us help you maximize your conversion today!
        </div><div class="pro-feature">
        <b>Copyright Footer</b> This should be self-explanatory. It is a customizable copyright with current year for the footer of your site. Set it and forget it.
        </div><div class="pro-feature">
        <b>Urgency Countdown</b> This isn't the typical Elementor countdown. This countdown functions precisely as a sales tool. It allows you to assign a base time and add a random amount of time on top of that. It gives the user the impression that a deal or time limit is about to run out. The best part about this time is that it will continue to count down from the same point even on page refresh. This countdown is a must-have for sales pages.
        </div><div class="pro-feature">
        <b>Downloads Pro</b> This Allows you to customize the download page or add a custom download button. You can specify a specific product's downloads or all downloads. You even have you the ability to grab the downloads from a product someone just purchased by placing it on the checkouts Pro Thankyou Page.
        </div><div class="pro-feature"> 
        <b>Shortcodes Pro</b> This element allows you to access some of WooCommerce best shortcodes and use completely redesign them.
        </div><div class="pro-feature">
        <b>Iframe Pro</b> Allows you to iframe element anywhere on any page.
        </div><div class="pro-feature">
        <b>Video Playlist</b> Allows you to create video courses with a playlist of videos which can be entered manually or uploaded with a spreadsheet.
        </div><div class="pro-feature">
        <b>Upsell Button Pro</b> Add simple cart extentions to add upsell products to your shopping cart/checkout process.
        </div><div class="pro-feature">
        <b>User Tasker</b> Allows you to display lessons and checkmark them off as you go.
        </div><div class="pro-feature">
        <b>User Tasker Progress bar</b> Works with user tasker to track the progress of a user.
        </div><div class="pro-feature">
        <b>Elementor Pro Form Actions Extended</b> We have extended Elementor Pro Form action to offer additional features and integrations.
        </div>
    </div>
    The goal of Funnelmentals is not to replace Elementor Pro. Our goal is to enhance it with some cool much-needed funnel features. Your patronage will go a long way to making this plugin even better.
    <a class="professional-upgrade-btn" href="<?php echo $get_pro_link; ?>"> Upgrade to Pro Version </a>

    </div>
</div>
</div>

<!-- Global Buttons -->
<div class="wdf-global-actions">
    <div class="action-bar">
        <div id="wdf-settings-btn" class="wdfa-btn this-active"><i class="fa fa-cog"></i> Settings</div>
        <?php if(!$is_free){ echo '<div id="wdf-license-btn" class="wdfa-btn"><i class="fa fa-key"></i> license</div>'; } ?>
        <?php if($is_free){ echo '<div id="wdf-get-pro-btn" class="wdfa-btn"><i class="fa fa-key"></i> PRO?</div>'; } ?>
    </div>
    <div id="wdf-nonce" style="display:none;" data-value="<?php echo $nonce; ?>"> </div>
    <div id="save-btn"> Save Data <i class="fa fa-save" aria-hidden="true"></i> </div>
    <div> <a href="https://webdisrupt.com">Learn how to maximize your system!</a> </div>
</div>


</div> <!-- Main Body -->





<script>

/* Fire Ajax Events */
jQuery( document ).ready(function($) {


    /* Tabs Buttons */
    $(".wdf-global-actions .action-bar div").click(function(){
        $(".wdf-m-tab").css("display", "none");
        $("."+this.id.replace("-btn", "")).css("display", "flex");
        $(".wdfa-btn").removeClass("this-active");
        $(this).addClass("this-active");
    });

    /* Remove Notice */
    $(".fs-notice").replaceWith("");

    /* License Window Magic */
    var iframeObj = $("#license-window");
    $(iframeObj).load( function () {

        var iframeBody = iframeObj.contents();
        iframeBody.find(".fs-modal.fs-modal-license-activation").addClass("active");
        iframeBody.find(".fs-modal.active .fs-modal-dialog").css('top', '0').css('padding-bottom', '0px').css('padding-left', '0px').css('padding-right', '0px');
        iframeBody.find(".fs-modal-license-activation .fs-modal-header .fs-close, .fs-modal-license-activation .button-close").replaceWith("");
    });
    /* Magic Iframe Resize */
    setInterval(function(){
        $("#license-window").css('height', $("#license-window").contents().find('.active .fs-modal-dialog').height());
    }, 300);
    //;
    /* Save All Settings Data */
    $("#save-btn").click(function(){

        $("#save-btn").html("  Saving... <i class='fa fa-spinner fa-pulse fa-fw'></i>");

        /* Data */
        var request = {
            nonce: $("#wdf-nonce").attr("data-value"),
            data: {}
        }
        $(".wdf-option").each(function(){
            request.data[$(this).attr('id')] = $(this).val();
        });
        $(".wdf-checked").each(function(){
            if ($(this).is(":checked")){
                request.data[$(this).attr('id')] = true;
            } else {
                request.data[$(this).attr('id')] = false;
            }
        });
        console.log(request); 
        /* Save data */
        $.post(ajaxurl, { action : 'save_data_funnelmental_settings', request: request}, function(data) {
            $("#save-btn").html("Task Completed Successfully! <i class='fa fa-check' aria-hidden='true'></i>");
            $("#save-btn").css("background-color", "#090");
            setTimeout(function() {
                $("#save-btn").html(" Save Data <i class='fa fa-save' aria-hidden='true'>");
                $("#save-btn").attr("style", "");
            }, 1400);
       
        });

    });

    $("#wdf-license-btn").click(function(){
        $.post(ajaxurl, { action : 'upgrade_funnelmentals' }, function(data) { console.log(data); });
    });


});

</script>


<?php

function wdf_settings_textarea($images, $icon, $label, $id, $value, $style){
    ?>
    <div>
        <label class="section-header"> <img src="<?php echo $images.$icon; ?>" /> <?php echo $label; ?>: </label>
        <textarea id="<?php echo $id; ?>" type="text" placeholder="copy & paste code here..." class="wdf-option" style="<?php echo $style; ?>" ><?php echo $value; ?></textarea>
    </div>
    <?php
}