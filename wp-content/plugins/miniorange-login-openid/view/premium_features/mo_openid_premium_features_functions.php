<?php


function mo_openid_premium_features_action()
{
    $N1 = $_POST["\155\x6f\x5f\x6f\x70\x65\x6e\151\144\x5f\x70\162\145\x6d\151\165\x6d\137\146\145\141\x74\x75\x72\145\x73\137\x6e\157\x6e\143\x65"];
    if (!wp_verify_nonce($N1, "\155\x6f\55\157\160\x65\x6e\x69\144\x2d\160\x72\x65\x6d\x69\x75\155\55\146\x65\x61\x74\x75\x72\145\163")) {
        goto Z6z;
    }
    $QB = $_POST["\x65\x6e\141\x62\154\145\x64"];
    if ($QB == "\164\162\x75\x65") {
        goto ZI5;
    }
    if (!($QB == "\x66\141\x6c\163\x65")) {
        goto f2X;
    }
    update_option($_POST["\146\145\141\x74\165\x72\x65\x5f\x6e\141\155\145"], 0);
    f2X:
    goto Y_X;
    ZI5:
    update_option($_POST["\146\145\141\x74\x75\162\x65\x5f\156\141\155\x65"], 1);
    Y_X:
    goto Utb;
    Z6z:
    wp_die("\x3c\x73\164\162\157\x6e\x67\76\x45\122\122\x4f\122\x3c\57\163\x74\x72\157\x6e\x67\76\72\x20\x49\x6e\x76\x61\x6c\x69\144\40\122\145\x71\x75\145\163\164\x2e");
    Utb:
}
function mo_openid_password_reset_mail($PS)
{
    if (!get_option("\x6d\x6f\137\x6f\x70\145\156\151\x64\x5f\x6e\157\164\151\146\x69\x63\x61\164\151\x6f\156\x5f\x65\155\x61\x69\154")) {
        goto rql;
    }
    wp_new_user_notification($PS, '', "\x75\x73\145\162");
    rql:
}
function mo_openid_activate_account()
{
    update_user_meta($_POST["\165\163\x65\162\x5f\x69\144"], "\x61\143\x74\151\x76\141\164\151\x6f\156\x5f\x73\164\141\x74\x65", "\x30");
    $LJ = get_userdata($_POST["\x75\163\x65\x72\x5f\x69\x64"]);
    $XR = $LJ->user_email;
    $u5 = str_replace("\x68\x74\x74\160\x73\x3a\57\x2f", '', site_url());
    $s5 = "\x41\143\143\x6f\x75\x6e\164\x20\x61\x63\164\151\x76\x61\x74\151\x6f\156\x20\155\x61\151\x6c\x20\146\162\x6f\x6d\x20" . $u5;
    $f3 = "\131\x6f\165\162\x20\x61\x63\143\x6f\165\156\164\x20\x69\163\40\x61\143\x74\x69\166\x61\x74\145\x64\x2e\40\x59\157\165\40\143\141\x6e\40\154\x6f\147\151\156\x20\x74\x6f\40\157\165\x72\40\167\x65\x62\163\x69\164\x65";
    wp_mail($XR, $s5, $f3);
    exit;
}
