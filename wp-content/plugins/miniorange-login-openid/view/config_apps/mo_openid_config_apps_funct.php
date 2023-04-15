<?php


function mo_openid_sso_sort_action()
{
    $N1 = $_POST["\x6d\x6f\x5f\157\160\145\156\151\144\137\163\x73\x6f\137\163\x6f\x72\164\x5f\156\157\x6e\x63\x65"];
    if (!wp_verify_nonce($N1, "\155\157\55\157\x70\x65\156\x69\144\55\163\163\157\x2d\x73\x6f\162\x74")) {
        goto SDi;
    }
    $p0 = $_POST["\163\x65\x71\165\145\156\x63\x65"];
    $J4 = '';
    $Bh = 0;
    foreach ($p0 as $ZQ) {
        if ($Bh == 0) {
            goto vZA;
        }
        $J4 .= "\43" . $ZQ;
        goto CEM;
        vZA:
        $J4 = $ZQ;
        $Bh++;
        CEM:
        zJA:
    }
    kBa:
    update_option("\x61\160\160\x5f\160\157\163", $J4);
    wp_send_json("\x68\145\x6c\154\x6f\x5f\163\157\x72\x74");
    goto l6y;
    SDi:
    wp_die("\x3c\163\164\162\x6f\156\x67\x3e\105\122\x52\117\x52\x3c\57\163\x74\x72\x6f\156\147\x3e\x3a\x20\x49\x6e\x76\141\154\x69\144\x20\122\145\x71\x75\145\x73\164\56");
    l6y:
}
function mo_openid_sso_enable_app()
{
    $N1 = $_POST["\x6d\x6f\137\157\160\145\156\151\144\137\163\x73\x6f\x5f\x65\156\141\142\154\145\137\141\160\160\137\156\x6f\x6e\143\145"];
    if (!wp_verify_nonce($N1, "\155\157\55\157\x70\x65\x6e\x69\144\55\x73\163\x6f\55\x65\x6e\141\x62\x6c\x65\55\x61\160\160")) {
        goto dIC;
    }
    $q6 = $_POST["\145\156\141\x62\x6c\x65\144"];
    if ($q6 == "\x74\x72\165\145") {
        goto xMG;
    }
    if (!($q6 == "\146\x61\x6c\x73\145")) {
        goto EG0;
    }
    update_option("\155\x6f\x5f\x6f\x70\145\156\x69\144\137" . $_POST["\141\160\x70\x5f\156\x61\155\x65"] . "\x5f\145\156\141\x62\154\x65", 0);
    EG0:
    goto CtD;
    xMG:
    update_option("\155\157\137\x6f\x70\145\x6e\x69\x64\x5f" . $_POST["\141\160\x70\137\156\x61\155\x65"] . "\x5f\145\156\141\x62\154\x65", 1);
    CtD:
    goto t1N;
    dIC:
    wp_die("\74\x73\x74\162\x6f\156\147\76\x45\x52\122\x4f\122\74\57\163\164\x72\157\156\147\76\72\x20\x49\x6e\x76\141\154\x69\x64\40\122\145\x71\165\145\163\164\56");
    t1N:
}
function mo_openid_app_instructions_action()
{
    $N1 = $_POST["\x6d\x6f\137\157\160\x65\x6e\x69\144\137\x61\160\x70\x5f\x69\x6e\x73\x74\x72\165\x63\x74\x69\157\156\163\137\156\x6f\156\x63\x65"];
    if (!wp_verify_nonce($N1, "\x6d\157\x2d\157\x70\145\x6e\x69\x64\55\x61\x70\x70\x2d\151\156\x73\164\x72\x75\143\x74\151\x6f\156\163")) {
        goto YxF;
    }
    $C0 = $_POST["\141\x70\x70\137\156\141\x6d\x65"];
    $v9 = plugin_url . $C0 . "\56\x70\x6e\147\x23\x23";
    $i0 = maybe_unserialize(get_option("\155\x6f\x5f\157\160\x65\156\x69\144\x5f\141\160\160\x73\x5f\x6c\151\163\164"));
    if ($i0 != '') {
        goto rJv;
    }
    $v9 .= "\x23\43\43\43\43\43";
    goto Get;
    rJv:
    if (!isset($i0[$C0]["\143\x6c\x69\x65\x6e\x74\x69\144"])) {
        goto bHE;
    }
    $v9 .= $i0[$C0]["\143\x6c\151\145\156\164\x69\x64"] . "\43\43";
    goto cVJ;
    bHE:
    $v9 .= "\x23\x23";
    cVJ:
    if (!isset($i0[$C0]["\x63\154\151\145\156\x74\x73\145\x63\x72\145\164"])) {
        goto EeW;
    }
    $v9 .= $i0[$C0]["\143\154\151\145\156\x74\x73\x65\143\x72\x65\x74"] . "\43\43";
    goto eS4;
    EeW:
    $v9 .= "\43\43";
    eS4:
    if (!isset($i0[$C0]["\141\x70\x70\x6b\x65\x79"])) {
        goto T11;
    }
    $v9 .= $i0[$C0]["\x61\160\x70\153\x65\x79"] . "\x23\x23";
    goto tSP;
    T11:
    $v9 .= "\43\43";
    tSP:
    Get:
    if (get_option("\155\x6f\x5f\x6f\160\x65\x6e\151\x64\137\145\x6e\x61\142\x6c\x65\137\x63\165\163\164\157\x6d\137\x61\160\160\x5f" . $C0)) {
        goto p67;
    }
    if (mo_openid_is_customer_registered() && get_option("\x6d\x6f\x5f\157\x70\x65\x6e\151\x64\x5f" . $C0 . "\x5f\x65\x6e\x61\x62\154\x65")) {
        goto bnT;
    }
    $v9 .= "\60\x23\43";
    goto Q1t;
    p67:
    $v9 .= "\143\165\x73\164\157\x6d\43\43";
    goto Q1t;
    bnT:
    $v9 .= "\x64\145\x66\141\165\154\x74\43\x23";
    Q1t:
    if (get_option("\x6d\x6f\x5f\157\160\145\156\x69\x64\137" . $C0 . "\x5f\145\x6e\x61\142\x6c\145")) {
        goto keg;
    }
    $v9 .= "\x30\43\x23";
    goto s0i;
    keg:
    $v9 .= "\61\43\x23";
    s0i:
    $n0 = plugin_dir_path(dirname(__DIR__));
    $n0 = substr($n0, 0, strlen($n0) - 1) . "\x2f\57\163\157\x63\x69\x61\154\x5f\141\x70\160\x73\57\x2f" . $C0 . "\56\160\x68\160";
    require $n0;
    $rp = "\155\157\x5f" . $C0;
    $C0 = new $rp();
    if (!isset($i0[$_POST["\141\x70\160\137\x6e\x61\155\145"]]["\163\x63\157\160\x65"])) {
        goto Znj;
    }
    $v9 .= $i0[$_POST["\141\x70\160\137\156\141\x6d\x65"]]["\163\143\x6f\x70\x65"] . "\x23\43";
    goto s5Z;
    Znj:
    $v9 .= $C0->scope . "\x23\x23";
    s5Z:
    if (isset($C0->video_url)) {
        goto HAb;
    }
    $v9 .= "\x23\x23";
    goto NWa;
    HAb:
    $v9 .= $C0->video_url . "\x23\x23";
    NWa:
    $v9 .= $C0->instructions;
    wp_send_json($v9);
    goto QyI;
    YxF:
    wp_die("\74\x73\x74\x72\x6f\156\x67\x3e\105\122\x52\x4f\x52\x3c\x2f\163\164\x72\x6f\156\x67\76\72\x20\x49\156\x76\x61\x6c\151\x64\x20\122\x65\x71\x75\145\x73\x74\x2e");
    QyI:
}
function mo_openid_capp_details_action()
{
    $N1 = $_POST["\x6d\157\x5f\x6f\160\145\156\151\144\137\x63\141\160\160\x5f\144\145\164\141\151\x6c\163\137\156\157\x6e\143\145"];
    if (!wp_verify_nonce($N1, "\x6d\x6f\55\x6f\x70\x65\x6e\151\x64\55\x63\x61\160\x70\x2d\x64\x65\164\x61\x69\154\x73")) {
        goto Aok;
    }
    $Gc = stripslashes(sanitize_text_field($_POST["\x61\x70\x70\x5f\x69\x64"]));
    $t8 = stripslashes(sanitize_text_field($_POST["\x61\160\x70\137\163\145\x63\x72\x65\x74"]));
    $jI = stripslashes(sanitize_text_field($_POST["\x61\160\x70\x5f\x73\x63\157\160\145"]));
    $n9 = stripslashes(sanitize_text_field($_POST["\141\x70\x70\x5f\156\x61\155\x65"]));
    $Id = stripslashes(sanitize_text_field($_POST["\x61\160\160\x5f\153\145\x79"]));
    if (get_option("\155\x6f\137\157\160\x65\x6e\x69\144\x5f\141\x70\160\x73\x5f\x6c\151\x73\164")) {
        goto t5B;
    }
    $i0 = array();
    goto fp6;
    t5B:
    $i0 = maybe_unserialize(get_option("\x6d\157\x5f\x6f\160\145\156\x69\144\137\x61\x70\160\x73\137\154\151\x73\164"));
    fp6:
    $Ln = array();
    foreach ($i0 as $Pq => $qP) {
        if (!($n9 == $Pq)) {
            goto nq2;
        }
        $Ln = $qP;
        goto jgy;
        nq2:
        yxZ:
    }
    jgy:
    $Ln["\143\154\x69\145\156\x74\x69\144"] = $Gc;
    $Ln["\x63\x6c\x69\145\x6e\164\x73\x65\143\x72\x65\x74"] = $t8;
    $Ln["\163\143\x6f\160\x65"] = $jI;
    if (!($n9 == "\146\x61\x63\x65\142\157\x6f\x6b")) {
        goto LnK;
    }
    $Ln["\x72\x65\x73\157\x6c\x75\164\x69\x6f\156"] = get_option("\146\141\143\145\142\x6f\157\153\137\x70\x72\x6f\146\x69\154\145\x5f\160\x69\x63\137\162\x65\163\x6f\154\x75\164\151\x6f\156");
    LnK:
    if (!($n9 == "\163\164\141\143\x6b\145\170\143\150\x61\156\x67\x65" || $n9 == "\x6f\x64\156\x6f\153\x6c\x61\x73\x73\x6e\x69\x6b\x69" || $n9 == "\x73\164\x61\143\x6b\157\166\x65\162\x66\x6c\x6f\167")) {
        goto vWg;
    }
    $Ln["\x61\160\160\x6b\x65\x79"] = $Id;
    vWg:
    $i0[$n9] = $Ln;
    update_option("\155\157\x5f\157\x70\145\156\151\144\x5f\x61\160\160\163\137\154\151\163\x74", maybe_serialize($i0));
    update_option("\x6d\157\x5f\157\x70\x65\x6e\x69\144\x5f\145\x6e\141\142\x6c\x65\137\x63\165\163\x74\157\x6d\x5f\x61\x70\160\x5f" . $n9, "\61");
    update_option("\x6d\x6f\x5f\x6f\x70\145\156\151\x64\137" . $n9 . "\x5f\145\156\141\x62\x6c\145", 1);
    goto ZvM;
    Aok:
    wp_die("\x3c\x73\x74\x72\157\156\147\x3e\105\122\122\x4f\x52\x3c\57\163\x74\x72\x6f\x6e\147\x3e\x3a\x20\111\156\x76\x61\x6c\151\144\40\122\145\161\165\145\163\164\x2e");
    ZvM:
}
function mo_openid_capp_delete()
{
    $n9 = stripslashes(sanitize_text_field($_POST["\x61\160\160\137\x6e\x61\155\145"]));
    $i0 = maybe_unserialize(get_option("\155\x6f\137\157\160\x65\156\151\x64\x5f\x61\160\x70\163\x5f\154\151\x73\164"));
    $xP = get_option("\155\x6f\x5f\x6f\x70\145\x6e\x69\144\137\145\156\x61\142\154\145\137\x63\x75\x73\164\157\155\x5f\x61\x70\160\137" . $n9);
    foreach ($i0 as $Pq => $Qd) {
        if (!($n9 == $Pq)) {
            goto W8M;
        }
        unset($i0[$Pq]);
        W8M:
        j3f:
    }
    o7U:
    if (!empty($i0)) {
        goto AEs;
    }
    delete_option("\155\157\137\x6f\160\x65\x6e\151\144\x5f\141\x70\x70\163\137\x6c\x69\x73\164");
    goto zOd;
    AEs:
    update_option("\x6d\157\x5f\x6f\160\145\x6e\x69\x64\137\141\x70\160\163\x5f\x6c\151\x73\x74", maybe_serialize($i0));
    zOd:
    update_option("\x6d\x6f\137\x6f\160\145\156\x69\x64\x5f\145\x6e\141\x62\154\145\x5f\x63\165\x73\164\x6f\x6d\x5f\x61\x70\160\x5f" . $n9, "\x30");
    wp_send_json(["\163\164\141\x74\165\163" => $xP]);
}
function mo_disable_app()
{
    $n9 = $_POST["\141\x70\x70\x5f\x6e\141\155\x65"];
    update_option("\155\157\x5f\x6f\160\x65\156\151\x64\137\145\x6e\141\x62\154\145\x5f\143\x75\163\x74\x6f\x6d\137\141\x70\160\137" . $n9, 0);
    update_option("\x6d\157\x5f\157\160\x65\156\x69\144\x5f" . $n9 . "\137\x65\156\x61\x62\154\x65", 0);
}
function mo_openid_test_configuration_update_action()
{
    update_option("\x6d\157\137\x6f\x70\x65\x6e\151\x64\137\164\x65\163\x74\137\x63\157\x6e\x66\151\x67\165\162\x61\x74\x69\157\156", 1);
}
function attribute_url()
{
    $sM = home_url();
    return $sM;
}
function custom_app_enable_change_update()
{
    $n9 = stripslashes(sanitize_text_field($_POST["\x61\x70\x70\156\141\155\x65"]));
    if ($_POST["\x63\165\163\164\x6f\155\137\141\x70\x70\x5f\145\156\x61\x62\x6c\x65\x5f\143\x68\x61\156\x67\x65"]) {
        goto uHt;
    }
    if (get_option("\x6d\x6f\x5f\x6f\160\145\x6e\151\x64\x5f\x61\x70\160\163\137\x6c\151\163\x74")) {
        goto NE1;
    }
    wp_send_json(["\163\x74\x61\x74\x75\163" => "\x4e\157\137\x63\x75\163\x74\x5f\141\160\160"]);
    goto RhM;
    NE1:
    $i0 = maybe_unserialize(get_option("\155\x6f\137\157\x70\x65\x6e\151\x64\x5f\141\x70\x70\163\137\154\151\x73\164"));
    if (!empty($i0[$n9]["\143\x6c\151\x65\x6e\x74\x69\144"]) && !empty($i0[$n9]["\143\x6c\x69\145\156\x74\163\x65\143\x72\145\x74"])) {
        goto Ij_;
    }
    update_option("\155\x6f\x5f\157\x70\145\156\151\144\137\x65\x6e\x61\x62\154\145\137\143\x75\163\164\x6f\x6d\x5f\x61\160\x70\x5f" . $n9, 0);
    wp_send_json(["\163\164\x61\164\165\163" => "\116\157\137\x63\165\x73\164\137\141\x70\x70"]);
    goto jpD;
    Ij_:
    update_option("\155\x6f\x5f\157\x70\x65\x6e\151\x64\x5f\x65\x6e\x61\x62\x6c\x65\x5f\x63\165\163\x74\x6f\x6d\137\x61\x70\x70\x5f" . $n9, 1);
    wp_send_json(["\x73\x74\141\x74\165\163" => "\x54\x75\x72\x6e\x65\144\137\117\x66\x66"]);
    jpD:
    RhM:
    goto Iwq;
    uHt:
    if (mo_openid_is_customer_registered()) {
        goto sli;
    }
    wp_send_json(["\x73\x74\x61\x74\x75\163" => "\x66\x61\x6c\163\x65"]);
    goto OjI;
    sli:
    update_option("\155\157\x5f\157\x70\x65\x6e\151\x64\137" . $n9 . "\x5f\x65\x6e\x61\x62\x6c\145", $_POST["\143\x75\x73\x74\x6f\155\x5f\x61\160\x70\x5f\x65\156\x61\x62\x6c\145\137\143\x68\141\156\147\x65"]);
    update_option("\x6d\x6f\x5f\x6f\x70\145\x6e\151\144\x5f\x65\156\141\x62\x6c\x65\x5f\143\165\x73\164\157\155\x5f\141\x70\160\137" . $n9, 0);
    wp_send_json(["\163\x74\141\164\x75\163" => "\164\162\165\145"]);
    OjI:
    Iwq:
}
function mo_register_customer_toggle_update()
{
    if (mo_openid_is_customer_registered()) {
        goto Xkz;
    }
    wp_send_json(["\x73\x74\141\x74\x75\x73" => false]);
    goto eTC;
    Xkz:
    wp_send_json(["\x73\x74\141\164\165\163" => true]);
    eTC:
}
function mo_openid_check_capp_enable()
{
    if (get_option("\x6d\x6f\137\x6f\x70\145\x6e\151\x64\x5f\x61\160\x70\163\x5f\x6c\151\163\x74")) {
        goto XUb;
    }
    wp_send_json(["\163\x74\141\164\165\x73" => false]);
    goto QUK;
    XUb:
    $i0 = maybe_unserialize(get_option("\155\157\137\x6f\160\145\156\151\144\x5f\141\160\160\x73\137\154\x69\x73\164"));
    $n9 = stripslashes(sanitize_text_field($_POST["\141\160\x70\x5f\x6e\x61\x6d\145"]));
    if ($n9 == "\x6c\151\x76\145\152\x6f\x75\x72\156\141\154" && !empty($i0[$n9]["\143\154\151\x65\156\164\151\144"])) {
        goto Qh3;
    }
    if (!empty($i0[$n9]["\143\x6c\151\x65\x6e\x74\151\x64"]) && !empty($i0[$n9]["\143\154\x69\x65\156\164\163\145\143\x72\x65\x74"])) {
        goto iAn;
    }
    wp_send_json(["\x73\164\141\164\165\x73" => false]);
    goto sWZ;
    iAn:
    wp_send_json(["\163\164\x61\164\x75\x73" => true]);
    sWZ:
    goto TWz;
    Qh3:
    wp_send_json(["\x73\164\141\x74\165\163" => true]);
    TWz:
    QUK:
}
