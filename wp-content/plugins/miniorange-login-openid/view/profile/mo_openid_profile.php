<?php


function mo_openid_profile()
{
    if (!mo_openid_is_customer_registered()) {
        goto x1V;
    }
    if (mo_openid_is_customer_registered() && !mo_openid_is_customer_license_key_verified()) {
        goto jcE;
    }
    echo "\40\40\x20\x20\x20\x20\40\x20\x3c\x64\x69\166\40\x63\x6c\x61\x73\163\75\42\155\x6f\137\157\160\x65\x6e\x69\144\137\164\x61\x62\154\x65\x5f\x6c\141\x79\x6f\x75\x74\42\x3e\xd\xa\x20\x20\x20\x20\x20\40\x20\40\x20\40\40\x20\x3c\150\62\x3e";
    echo mo_sl("\x54\x68\x61\x6e\153\40\171\157\x75\40\x66\x6f\162\x20\x72\x65\x67\x69\x73\164\x65\162\151\156\147\x20\x77\x69\x74\x68\x20\x6d\151\x6e\151\117\162\141\x6e\147\145");
    echo "\56\74\57\150\x32\76\15\xa\x20\x20\40\40\40\x20\40\x20\40\40\x20\40\x3c\x74\141\142\x6c\x65\40\x62\157\x72\144\145\x72\x3d\42\x31\x22\x20\x73\164\x79\154\145\75\42\142\141\x63\x6b\147\162\157\x75\x6e\x64\55\143\x6f\154\157\x72\x3a\43\106\x46\106\106\106\x46\73\40\x62\x6f\x72\x64\145\x72\x3a\61\x70\x78\x20\163\x6f\x6c\151\x64\40\43\103\103\x43\x43\x43\103\73\x20\x62\x6f\x72\x64\x65\162\x2d\143\157\154\x6c\x61\160\x73\145\72\x20\143\x6f\x6c\154\141\x70\163\145\73\40\x70\x61\144\x64\x69\x6e\147\72\x30\160\x78\40\60\x70\x78\x20\x30\160\170\40\x31\x30\160\x78\73\40\155\x61\162\147\151\x6e\72\62\160\x78\73\x20\167\151\x64\x74\x68\72\70\x35\x25\x22\x3e\15\12\40\x20\40\40\40\40\x20\40\40\x20\40\40\40\x20\40\x20\x3c\x74\142\157\x64\171\76\x3c\164\162\76\xd\12\40\x20\x20\40\40\x20\x20\40\40\x20\40\x20\x20\40\x20\40\x20\x20\x20\40\x3c\164\x64\x20\x73\x74\x79\x6c\145\75\x22\167\151\144\164\150\72\64\x35\x25\73\40\x70\x61\144\x64\x69\156\x67\x3a\40\61\x30\x70\170\x3b\42\x3e";
    echo mo_sl("\155\x69\156\x69\117\x72\x61\x6e\147\x65\x20\101\143\143\x6f\165\156\x74\40\x45\x6d\x61\151\154");
    echo "\74\x2f\164\x64\76\15\xa\x20\x20\40\40\x20\x20\x20\40\x20\x20\40\x20\40\x20\40\40\x20\40\x20\x20\74\164\x64\40\x73\164\x79\154\x65\75\x22\x77\151\x64\164\x68\x3a\65\65\x25\x3b\x20\160\141\x64\x64\x69\156\x67\72\x20\x31\60\x70\x78\x3b\42\x3e";
    echo get_option("\155\157\x5f\157\x70\x65\x6e\151\x64\x5f\141\x64\x6d\151\156\137\x65\x6d\x61\151\x6c");
    echo "\x3c\57\164\144\x3e\15\xa\40\40\40\x20\x20\40\x20\x20\x20\x20\40\x20\40\x20\x20\40\x3c\x2f\164\x72\76\xd\12\x20\x20\40\40\x20\x20\x20\40\40\40\40\40\40\40\x20\40\74\164\162\76\xd\xa\40\40\x20\x20\40\x20\x20\40\x20\x20\40\40\40\40\40\x20\x20\40\40\40\74\164\x64\40\x73\x74\171\x6c\145\x3d\42\167\151\144\x74\x68\72\64\x35\x25\x3b\40\x70\x61\144\x64\151\156\x67\x3a\x20\x31\60\160\170\73\x22\x3e";
    echo mo_sl("\x43\x75\163\x74\x6f\155\145\x72\40\x49\104");
    echo "\x3c\57\x74\144\76\15\12\x20\x20\40\40\40\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\40\40\74\164\144\40\x73\x74\x79\x6c\145\75\42\167\x69\144\164\150\x3a\65\x35\x25\73\40\x70\141\x64\144\151\156\x67\72\x20\x31\x30\x70\x78\x3b\x22\x3e";
    echo get_option("\155\x6f\137\157\x70\145\x6e\151\144\x5f\x61\144\155\x69\x6e\x5f\x63\165\163\x74\157\155\145\x72\x5f\153\145\171");
    echo "\74\57\x74\x64\x3e\xd\12\40\40\x20\x20\x20\x20\x20\40\40\x20\40\40\40\40\x20\x20\74\x2f\164\162\x3e\xd\12\x20\x20\x20\x20\40\40\40\40\40\x20\x20\x20\40\40\x20\x20\x3c\57\x74\142\x6f\144\x79\76\xd\12\40\40\40\40\40\40\x20\x20\x20\x20\40\40\74\57\x74\141\142\154\145\76\xd\12\x20\40\x20\40\x20\40\x20\40\40\x20\40\x20\x3c\x62\x72\57\x3e\74\154\141\x62\145\x6c\40\x73\164\171\x6c\x65\x3d\42\143\x75\x72\x73\x6f\162\x3a\40\x61\165\x74\157\42\76\74\141\x20\150\162\145\146\x3d\42";
    echo get_site_url() . "\x2f\167\x70\55\141\x64\155\x69\156\x2f\x61\x64\155\x69\x6e\x2e\x70\150\160\x3f\160\141\x67\x65\75\x6d\x6f\x5f\157\x70\145\x6e\x69\144\x5f\x73\145\x74\164\x69\156\x67\163\x26\164\141\142\x3d\x6c\151\143\145\156\163\x69\156\147\x5f\160\154\141\156\x73";
    echo "\x22\x3e";
    echo mo_sl("\103\154\x69\143\153\x20\x68\x65\162\145\x3c\57\141\x3e\x20\164\157\x20\x63\x68\145\143\x6b\40\x6f\x75\x72");
    echo "\40\x3c\x61\40\163\164\171\154\x65\x3d\42\x6c\x65\x66\x74\x3a\x20\61\x25\73\40\160\x6f\x73\151\x74\151\x6f\156\x3a\x20\x73\164\x61\164\x69\143\73\40\x74\x65\x78\164\x2d\144\x65\143\157\x72\141\x74\151\157\x6e\x3a\x20\156\157\x6e\x65\x22\40\x63\154\x61\x73\163\75\x22\x6d\157\x2d\x6f\x70\145\156\151\144\55\160\x72\x65\x6d\151\x75\155\x22\40\150\162\145\x66\x3d\42";
    echo add_query_arg(array("\x74\x61\142" => "\154\151\143\x65\x6e\163\x69\156\x67\137\x70\x6c\141\x6e\163"), $_SERVER["\x52\105\x51\x55\105\123\x54\137\125\122\111"]);
    echo "\42\x3e\x50\122\x4f\74\57\141\76\40";
    echo mo_sl("\160\x6c\141\x6e\x73");
    echo "\x3c\x2f\154\x61\x62\145\154\76\15\12\40\40\x20\40\x20\40\x20\x20\74\57\144\151\166\x3e\15\xa\x20\x20\x20\40\x20\40\x20\40";
    goto qFM;
    jcE:
    mo_openid_show_verify_license_page("\x67\x65\156\145\162\141\x6c");
    qFM:
    goto D2D;
    x1V:
    mo_openid_show_verify_password_page();
    D2D:
    echo "\40\x20\x20\x20\74\163\143\x72\x69\160\x74\x3e\15\xa\x20\40\40\40\40\x20\x20\40\x2f\x2f\x74\157\40\x73\145\x74\40\x68\145\x61\144\x69\x6e\x67\x20\x6e\141\155\145\15\12\x20\x20\40\x20\x20\40\x20\x20\152\121\x75\x65\x72\x79\50\x27\x23\155\x6f\137\157\x70\x65\156\x69\144\x5f\160\x61\x67\145\x5f\x68\145\x61\x64\x69\156\x67\x27\51\56\x74\x65\x78\x74\50\47";
    echo mo_sl("\x55\x73\x65\162\x20\x50\162\x6f\x66\x69\154\x65\40\x44\145\164\141\151\154\x73");
    echo "\x27\x29\73\15\12\x20\40\40\40\x20\x20\x20\40\x76\141\162\40\x77\151\x6e\137\150\145\x69\147\150\x74\x20\75\40\152\x51\x75\145\x72\x79\x28\47\43\155\157\137\157\160\x65\x6e\151\144\137\x6d\145\x6e\x75\x5f\150\145\151\x67\x68\164\x27\51\x2e\x68\145\x69\147\150\x74\50\x29\x3b\xd\xa\x20\x20\40\40\40\40\40\x20\x2f\x2f\x77\x69\x6e\137\150\145\x69\147\150\x74\75\167\x69\156\x5f\150\145\x69\147\150\x74\x2b\61\x38\73\xd\12\40\x20\x20\x20\x20\40\40\40\x6a\x51\x75\x65\x72\171\50\42\x2e\x6d\x6f\137\143\157\x6e\x74\141\151\x6e\x65\x72\x22\x29\x2e\143\163\x73\50\x7b\150\x65\151\x67\x68\x74\72\x77\151\x6e\137\150\145\151\x67\150\x74\175\x29\73\xd\xa\x20\40\40\x20\x3c\57\163\x63\162\x69\160\x74\x3e\15\xa\40\40\x20\x20";
}
