<?php


class mo_windowslive
{
    public $color = "\43\x30\x30\x41\x31\x46\61";
    public $scope = "\x77\x6c\x2e\145\155\141\151\154\163\54\167\154\x2e\142\x61\163\x69\143\54\x77\154\56\160\150\157\164\157\163\54\167\x6c\56\143\x6f\156\164\x61\143\x74\163\x5f\160\x68\x6f\164\x6f\x73";
    public $video_url = "\x68\164\x74\x70\163\72\x2f\x2f\167\167\x77\x2e\171\157\165\164\165\x62\145\56\143\x6f\x6d\57\145\155\x62\x65\144\57\x68\105\172\x67\150\x62\106\112\172\155\70";
    public $instructions;
    public function __construct()
    {
        if (get_option("\160\x65\162\155\x61\154\151\x6e\153\x5f\163\164\162\165\x63\164\165\162\145") !== '') {
            goto zLs;
        }
        $this->instructions = "\x3c\163\164\x72\157\156\x67\x20\x73\x74\x79\x6c\145\75\x27\143\157\154\x6f\162\72\40\x72\x65\x64\73\x66\157\156\x74\55\167\145\151\147\x68\164\72\40\142\157\x6c\144\47\76\74\142\162\x3e\x59\x6f\165\x20\150\x61\166\145\40\163\x65\x6c\145\143\164\x65\144\40\x70\x6c\x61\151\156\40\x70\145\x72\155\x61\154\151\x6e\x6b\x20\x61\x6e\144\40\166\x6b\157\156\164\x61\x6b\x74\145\x20\144\x6f\x65\163\x6e\157\x74\x20\163\165\x70\160\157\162\x74\40\151\164\x2e\74\57\163\164\x72\157\x6e\x67\x3e\74\x62\162\76\x3c\142\x72\x3e\40\x50\x6c\x65\x61\x73\145\x20\143\150\x61\156\x67\x65\40\x74\150\x65\40\160\145\x72\155\x61\154\151\156\x6b\40\x74\x6f\40\143\x6f\156\x74\x69\156\165\x65\40\146\165\x72\164\150\x65\x72\56\106\157\154\x6c\157\167\x20\x74\x68\x65\x20\163\164\x65\160\x73\x20\147\151\x76\145\156\40\142\x65\154\157\167\x3a\x3c\x62\162\x3e\x31\56\x20\107\x6f\40\x74\157\x20\163\x65\164\x74\x69\156\147\x73\x20\x66\x72\x6f\x6d\40\x74\x68\145\x20\154\145\x66\164\40\x70\x61\156\x65\x6c\40\141\x6e\x64\x20\163\x65\154\x65\143\x74\40\164\150\145\x20\160\x65\162\155\x61\154\151\x6e\153\163\40\x6f\x70\164\151\157\156\x2e\74\142\x72\x3e\62\56\x20\120\154\x61\151\x6e\40\x70\145\x72\x6d\x61\x6c\151\156\153\x20\151\x73\40\163\x65\x6c\145\143\x74\145\x64\x20\54\163\157\40\160\154\145\141\163\145\40\x73\x65\x6c\145\143\x74\x20\141\156\171\40\157\164\150\x65\x72\x20\160\145\x72\155\141\x6c\151\x6e\x6b\40\141\156\x64\x20\143\x6c\151\143\153\x20\157\156\x20\163\x61\166\145\x20\x62\165\164\x74\157\x6e\x2e\74\142\x72\76\x20\74\x73\164\x72\x6f\x6e\x67\40\x63\x6c\x61\163\x73\x3d\47\155\157\x5f\x6f\x70\145\x6e\x69\x64\x5f\156\x6f\164\x65\x5f\163\x74\171\x6c\145\x27\40\163\164\x79\154\x65\75\47\143\x6f\x6c\x6f\162\x3a\40\x23\146\x66\60\x30\60\60\x3b\x66\x6f\156\x74\x2d\x77\x65\151\x67\150\164\x3a\x20\x62\x6f\154\144\x27\76\40\x57\150\145\x6e\x20\x79\157\165\40\x77\151\x6c\154\40\143\150\141\x6e\x67\145\x20\164\x68\x65\x20\x70\145\162\x6d\x61\x6c\x69\x6e\153\x20\x2c\164\150\x65\x6e\x20\171\x6f\x75\x20\x68\x61\166\x65\x20\164\x6f\x20\162\145\55\x63\x6f\156\146\x69\147\x75\x72\x65\40\164\x68\145\40\141\x6c\162\145\141\144\x79\x20\x73\x65\164\x20\165\x70\40\143\165\x73\164\x6f\x6d\x20\x61\160\160\163\40\142\x65\143\141\x75\x73\x65\40\x74\150\x61\x74\40\167\x69\x6c\154\x20\x63\150\x61\x6e\x67\145\x20\x74\x68\x65\x20\x72\145\x64\x69\x72\x65\143\x74\x20\125\122\x4c\x2e\x3c\x2f\163\x74\x72\x6f\x6e\x67\x3e";
        goto z5T;
        zLs:
        $this->site_url = get_option("\x73\151\164\x65\165\162\154");
        $this->instructions = "\107\x6f\40\164\157\x20\x3c\141\x20\x68\x72\145\146\75\x22\150\x74\x74\160\x73\x3a\57\x2f\160\x6f\x72\164\x61\x6c\x2e\x61\x7a\x75\x72\x65\x2e\x63\x6f\x6d\57\x23\142\x6c\x61\144\x65\x2f\115\151\x63\x72\157\x73\157\146\164\x5f\x41\101\104\x5f\x52\x65\147\x69\163\164\x65\x72\145\144\x41\x70\160\163\x2f\101\160\160\154\x69\143\x61\x74\151\157\x6e\x73\114\x69\x73\164\102\x6c\x61\144\145\x2f\42\x20\164\x61\162\x67\x65\164\75\42\x5f\142\154\x61\x6e\153\x22\x3e\150\x74\x74\x70\x73\72\57\x2f\160\157\162\164\x61\154\56\141\172\x75\x72\145\56\x63\157\155\x2f\x23\x62\154\x61\x64\x65\57\x4d\151\x63\x72\x6f\163\x6f\x66\164\137\101\x41\104\137\x52\x65\147\151\163\x74\145\162\x65\144\x41\x70\x70\163\57\x41\160\x70\154\151\x63\141\164\x69\157\156\163\x4c\x69\163\164\102\154\x61\144\145\x3c\57\x61\x3e\40\141\x6e\x64\40\163\x69\147\156\x20\151\x6e\x20\x77\151\164\x68\40\171\157\165\162\x20\x4d\x69\x63\x72\x6f\163\157\146\x74\x20\x61\172\x75\x72\145\40\141\143\143\x6f\x75\x6e\164\56\15\12\40\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\40\x20\x20\40\x20\x20\x20\40\40\40\40\40\40\x20\40\x20\x20\40\40\40\x20\40\40\x23\43\103\154\151\x63\x6b\40\157\x6e\40\x3c\x62\x3e\116\x65\167\x20\x52\145\x67\x69\x73\164\x72\141\164\x69\157\x6e\x20\x74\x61\x62\x3c\x2f\142\x3e\56\xd\12\40\40\40\40\x20\40\40\40\x20\x20\40\x20\x20\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\40\x20\x20\x20\40\40\40\x20\40\40\40\x20\x23\x23\116\141\x6d\145\40\171\x6f\x75\162\x20\x6e\145\x77\40\x61\160\x70\40\x61\x6e\144\40\163\x65\154\x65\x63\x74\x20\x41\x63\x63\x6f\x75\156\164\x73\40\x69\156\x20\141\x6e\171\x20\x6f\162\x67\141\156\x69\172\141\164\x69\x6f\x6e\x61\x6c\40\x64\151\162\x65\x63\x74\157\162\171\40\x61\x73\x20\163\x75\x70\160\157\162\x74\x65\x64\x20\x61\143\143\x6f\165\156\164\163\40\164\171\x70\x65\163\x20\56\x20\x63\x6c\151\143\153\x20\157\x6e\x20\74\142\76\122\145\147\151\163\164\x65\x72\74\57\x62\76\56\xd\12\40\40\x20\40\40\40\40\40\40\x20\40\x20\40\40\40\x20\x20\40\40\x20\x20\x20\x20\40\40\x20\40\40\x20\40\40\x20\x20\x20\40\x20\x23\x23\x43\x6c\x69\x63\x6b\x20\x6f\156\x20\x3c\x73\x74\162\157\156\147\x3e\101\x75\x74\150\x65\x6e\164\x69\143\x61\164\151\157\x6e\x3c\57\163\164\162\x6f\x6e\x67\76\40\146\162\x6f\x6d\x20\154\x65\x66\x74\x20\163\151\x64\145\40\155\x65\156\x75\x2e\x20\x20\xd\xa\x20\x20\40\x20\x20\x20\40\40\40\x20\x20\40\x20\x20\40\40\40\x20\40\x20\40\x20\40\40\x20\40\x20\40\x20\x20\x20\40\40\x20\40\40\43\43\x45\x6e\x74\x65\x72\40\74\x62\x3e\x3c\143\157\144\x65\40\x69\144\75\47\61\62\47\x3e" . mo_get_permalink("\x77\x69\x6e\x64\x6f\x77\163\154\x69\x76\145") . "\x3c\x2f\x63\157\144\x65\76\x3c\151\x20\163\x74\171\x6c\145\x3d\40\x22\x77\151\144\x74\x68\72\40\x31\x31\160\x78\x3b\x68\x65\151\147\x68\164\x3a\x20\x39\x70\170\x3b\160\x61\144\144\151\156\x67\x2d\x6c\145\146\x74\x3a\62\160\170\73\x70\141\x64\x64\x69\x6e\x67\x2d\x74\x6f\x70\x3a\x33\x70\x78\42\40\x63\154\141\x73\x73\75\x22\146\141\40\x66\141\x2d\x66\x77\40\146\141\x2d\154\147\x20\x66\141\55\143\157\x70\x79\40\155\157\137\x63\157\160\171\40\155\157\x5f\x6f\x70\x65\x6e\151\x64\137\143\x6f\x70\171\x74\x6f\157\x6c\x74\151\x70\x22\x20\x6f\156\x63\x6c\151\x63\x6b\75\x22\143\x6f\x70\171\124\x6f\103\x6c\151\x70\142\x6f\141\162\x64\x28\x74\x68\x69\163\54\40\47\x23\x31\x32\x27\x2c\x20\47\43\163\150\x6f\x72\164\x63\157\144\x65\x5f\x75\x72\154\137\143\x6f\160\171\x27\x29\42\x3e\x3c\163\x70\141\x6e\40\x69\x64\x3d\42\x73\x68\x6f\x72\164\143\157\x64\x65\x5f\165\x72\154\x5f\x63\157\160\x79\x22\40\x63\x6c\x61\163\163\75\42\155\x6f\x5f\x6f\160\145\x6e\x69\x64\x5f\143\157\x70\171\x74\157\x6f\154\164\x69\160\164\145\170\x74\42\76\x43\157\160\171\40\164\x6f\40\x43\x6c\151\160\x62\x6f\141\x72\144\74\57\163\160\x61\x6e\76\x3c\57\151\76\x3c\x2f\142\76\40\x61\x73\40\x52\x65\x64\151\162\x65\143\164\x20\x55\x52\x4c\x2e\74\163\x74\162\x6f\x6e\x67\x3e\103\157\x70\171\x20\164\150\145\40\x43\154\151\x65\156\164\x20\x49\104\40\146\162\x6f\x6d\40\x74\150\x65\x20\x4f\166\145\x72\166\151\145\x77\40\164\141\142\x2e\x3c\x2f\x73\164\x72\157\156\147\76\56\40\124\x68\151\163\x20\x69\x73\40\x79\157\165\162\40\74\x62\x3e\x43\154\x69\x65\x6e\164\x20\111\x44\40\x3c\57\142\x3e\x2e\15\12\x20\40\40\40\40\40\40\40\x20\40\40\40\40\x20\x20\40\40\x20\40\x20\x20\40\40\40\x20\x20\40\40\x20\40\x20\40\40\40\40\40\x23\43\107\x6f\x20\x74\157\40\103\x65\162\x74\x69\146\x69\x63\141\164\x65\163\x20\141\x6e\x64\x20\123\x65\143\x75\x72\x69\x74\x79\40\164\141\x62\x2e\15\xa\x20\x20\40\40\x20\40\x20\40\x20\40\40\x20\40\x20\x20\40\40\40\x20\40\40\x20\40\x20\x20\40\x20\x20\x20\x20\40\40\x20\40\40\40\43\43\x43\x6c\x69\143\x6b\40\157\156\40\x3c\142\76\x4e\x65\167\40\103\154\x69\x65\156\164\40\123\143\145\x72\x65\164\x3c\x2f\x62\x3e\56\40\103\157\x70\x79\x20\x79\x6f\165\162\x20\160\x61\163\x73\x77\157\162\x64\56\40\x54\x68\151\163\x20\x69\x73\x20\x79\157\165\162\x20\74\142\76\103\x6c\151\145\156\164\40\123\x65\x63\162\145\164\74\57\x62\x3e\x2e\15\xa\x20\40\x20\x20\x20\40\x20\40\x20\40\x20\40\40\x20\x20\40\x20\40\x20\x20\x20\40\x20\x20\x20\40\40\40\40\40\40\x20\40\40\40\x20\43\43\123\x63\x72\x6f\154\154\40\144\x6f\167\x6e\40\x74\157\x20\74\x73\x74\162\x6f\156\147\x3e\x41\144\166\x61\x6e\143\145\144\40\x4f\x70\x74\151\x6f\156\163\x3c\x2f\x73\x74\x72\157\x6e\147\x3e\40\x61\156\x64\40\155\141\153\145\40\x73\x75\162\x65\40\74\163\164\162\157\156\x67\76\x4c\x69\166\x65\40\x53\104\113\x20\x73\165\x70\x70\157\x72\164\x3c\57\x73\164\x72\157\x6e\147\x3e\40\151\x73\x20\143\x68\145\x63\153\145\x64\56\xd\xa\40\x20\40\x20\40\x20\x20\40\x20\40\40\40\x20\x20\x20\40\40\x20\x20\40\40\40\x20\40\x20\x20\x20\x20\x20\40\40\x20\40\x20\40\x20\x23\43\103\x6c\x69\143\153\x20\157\x6e\40\x74\150\x65\40\x53\141\x76\145\40\x62\x75\x74\x74\x6f\x6e\x2e\15\12\x20\40\x20\x20\40\x20\x20\x20\x20\x20\40\x20\x20\40\x20\x20\x20\x20\x20\x20\40\x20\x20\x20\x20\40\40\x20\x20\40\40\x20\40\x20\x20\40\43\x23\x43\x6f\x70\x79\x20\x74\x68\x65\40\x63\x6c\x69\x65\156\x74\40\x49\x44\x20\141\156\144\x20\x63\x6c\x69\145\x6e\164\x20\x73\145\x63\162\x65\x74\x20\x74\157\40\x79\157\165\162\x20\x63\x6c\x69\x70\x62\157\141\162\x64\x2c\x20\141\163\x20\171\157\165\40\167\x69\x6c\x6c\x20\156\145\x65\144\40\x74\150\x65\155\40\x74\x6f\40\x63\157\x6e\146\x69\x67\165\x72\145\40\x61\x62\x6f\166\x65\x2e\x20\15\12\40\x20\40\x20\40\40\40\40\40\x20\x20\x20\x20\x20\x20\x20\x20\40\40\x20\40\x20\40\x20\x20\40\x20\40\40\x20\x20\40\40\x20\x20\x20\x23\x23\103\154\x69\x63\x6b\x20\157\x6e\40\x74\x68\x65\x20\x53\141\166\x65\40\x73\x65\164\164\151\156\147\x73\x20\x62\x75\164\x74\157\156\x2e\15\12\x20\40\x20\40\x20\40\40\40\40\40\40\x20\x20\x20\x20\x20\x20\40\x20\40\x20\40\40\x20\40\40\x20\40\x20\x20\x20\x20\40\40\40\x20\x23\x23\107\157\40\x74\x6f\x20\x53\x6f\143\151\x61\154\x20\x4c\x6f\x67\x69\x6e\40\164\x61\142\x20\164\157\40\143\157\156\146\x69\x67\165\x72\145\40\x74\x68\145\x20\144\151\x73\160\x6c\x61\171\x20\x61\x73\x20\167\x65\154\x6c\40\x61\x73\x20\157\x74\150\145\x72\x20\154\x6f\x67\151\x6e\x20\x73\x65\164\164\151\156\147\163\56";
        z5T:
    }
    function mo_openid_get_app_code()
    {
        $i0 = maybe_unserialize(get_option("\155\157\x5f\157\x70\145\156\151\144\137\141\x70\160\x73\x5f\x6c\x69\x73\164"));
        $vA = get_social_app_redirect_uri("\167\x69\x6e\x64\x6f\x77\163\x6c\151\x76\x65");
        mo_openid_start_session();
        $_SESSION["\141\160\x70\x6e\x61\x6d\145"] = "\167\151\x6e\x64\157\167\x73\x6c\x69\x76\145";
        $cS = $i0["\x77\x69\156\x64\x6f\x77\163\x6c\x69\x76\145"]["\x63\154\151\x65\x6e\164\151\x64"];
        $jI = $i0["\x77\151\156\144\x6f\x77\163\154\151\166\145"]["\163\x63\x6f\x70\x65"];
        $Ur = "\150\164\164\x70\x73\x3a\x2f\x2f\154\x6f\147\151\x6e\x2e\154\x69\166\145\x2e\143\x6f\155\57\157\x61\165\164\150\62\60\x5f\141\x75\x74\150\x6f\162\151\x7a\x65\56\x73\162\x66\77\143\x6c\x69\145\x6e\164\137\x69\144\75" . $cS . "\46\x73\x63\x6f\160\x65\75" . $jI . "\46\162\x65\x73\160\157\156\163\145\x5f\164\171\160\145\x3d\143\x6f\x64\x65\46\162\145\x64\151\162\x65\x63\x74\x5f\165\x72\151\x3d" . $vA;
        header("\x4c\157\143\141\164\x69\157\x6e\x3a" . $Ur);
        exit;
    }
    function mo_openid_get_access_token()
    {
        $Ee = mo_openid_validate_code();
        $vA = get_social_app_redirect_uri("\x77\x69\156\144\x6f\167\163\154\x69\x76\x65");
        $i0 = maybe_unserialize(get_option("\155\157\137\157\160\145\x6e\x69\144\137\141\160\x70\163\x5f\154\151\x73\164"));
        $cS = $i0["\x77\151\x6e\x64\x6f\167\x73\x6c\151\x76\x65"]["\143\x6c\151\x65\156\x74\x69\144"];
        $ZA = $i0["\167\x69\x6e\144\x6f\x77\163\154\x69\x76\145"]["\x63\154\x69\145\156\164\x73\x65\x63\x72\145\164"];
        $Ux = "\150\164\x74\x70\163\x3a\57\57\154\x6f\147\151\156\56\154\x69\x76\x65\x2e\x63\x6f\155\x2f\x6f\x61\165\164\150\x32\x30\x5f\x74\157\x6b\145\156\56\x73\162\x66";
        $K0 = "\147\x72\141\156\x74\x5f\164\171\x70\145\x3d\141\165\164\150\157\x72\151\172\x61\x74\151\157\x6e\x5f\143\x6f\144\145\46\143\x6c\x69\145\x6e\164\x5f\151\x64\x3d" . $cS . "\x26\162\145\144\x69\162\145\143\164\x5f\x75\162\x69\75" . $vA . "\46\143\157\144\145\75" . $Ee . "\x26\143\x6c\151\x65\156\x74\137\163\x65\143\162\x65\x74\75" . $ZA;
        $cb = mo_openid_get_access_token($K0, $Ux, "\x77\x69\x6e\x64\157\x77\163\x6c\x69\x76\145");
        $UN = isset($cb["\x61\x63\x63\145\x73\x73\x5f\164\x6f\x6b\x65\156"]) ? $cb["\x61\x63\143\145\x73\x73\x5f\164\157\153\145\x6e"] : '';
        mo_openid_start_session();
        $t9 = "\150\164\x74\160\x73\72\57\x2f\141\160\151\163\56\154\151\x76\145\x2e\156\x65\164\57\x76\65\x2e\x30\x2f\155\x65\x3f\x61\x63\143\145\163\x73\x5f\x74\x6f\x6b\x65\156\x3d" . $UN;
        $Er = mo_openid_get_social_app_data($UN, $t9, "\167\151\156\144\157\x77\163\154\x69\166\145");
        if (!(is_user_logged_in() && get_option("\x6d\157\x5f\x6f\x70\145\x6e\x69\144\137\x74\x65\163\164\x5f\x63\x6f\x6e\146\x69\x67\165\162\x61\164\x69\x6f\156") == 1)) {
            goto xzu;
        }
        mo_openid_app_test_config($Er);
        xzu:
        $l4 = $XL = $SW = $gG = $EK = $Go = $Zo = '';
        $Ku = $Me = $JC = $Du = $u1 = $ww = $QD = '';
        $l4 = isset($Er["\x66\151\162\x73\x74\x5f\x6e\x61\155\x65"]) ? $Er["\x66\151\162\x73\x74\137\156\x61\x6d\x65"] : '';
        $XL = isset($Er["\154\x61\x73\164\x5f\x6e\141\155\x65"]) ? $Er["\x6c\141\163\164\137\156\x61\155\145"] : '';
        $gG = isset($Er["\156\141\x6d\x65"]) ? $Er["\156\141\155\x65"] : '';
        if (isset($Er["\x65\x6d\x61\151\154\x73"]["\x70\x72\x65\x66\145\162\x72\145\144"])) {
            goto X4s;
        }
        if (isset($Er["\x65\155\141\151\154\163"]["\141\x63\143\157\165\156\164"])) {
            goto e7U;
        }
        if (isset($Er["\x65\155\141\151\154\x73"]["\x70\x65\162\x73\157\156\x61\x6c"])) {
            goto J6N;
        }
        if (!isset($Er["\x65\x6d\141\x69\154\x73"]["\x62\x75\x73\151\156\145\163\163"])) {
            goto TwT;
        }
        $SW = isset($Er["\x65\x6d\x61\x69\x6c\163"]["\x62\x75\x73\x69\156\145\x73\x73"]) ? $Er["\145\155\x61\x69\154\x73"]["\142\x75\x73\x69\x6e\145\163\163"] : '';
        TwT:
        goto fgq;
        J6N:
        $SW = isset($Er["\x65\155\141\151\154\x73"]["\160\145\162\163\x6f\x6e\141\154"]) ? $Er["\145\x6d\x61\151\x6c\x73"]["\x70\145\x72\x73\157\x6e\141\x6c"] : '';
        fgq:
        goto eSH;
        e7U:
        $SW = isset($Er["\145\x6d\141\x69\x6c\163"]["\x61\x63\143\157\x75\156\x74"]) ? $Er["\x65\x6d\x61\151\154\163"]["\x61\143\143\x6f\165\x6e\164"] : '';
        eSH:
        goto vKA;
        X4s:
        $SW = isset($Er["\145\x6d\x61\x69\154\x73"]["\160\x72\145\146\145\x72\x72\145\144"]) ? $Er["\x65\x6d\x61\x69\154\x73"]["\x70\162\x65\146\145\x72\162\145\144"] : '';
        vKA:
        $EK = isset($Er["\x75\162\x6c"]) ? $Er["\165\x72\154"] : '';
        $Go = isset($Er["\x70\162\x6f\x66\151\x6c\145\x5f\x69\155\141\x67\145\137\165\x72\154"]) ? $Er["\160\x72\x6f\x66\x69\x6c\145\137\151\155\141\147\x65\x5f\x75\x72\154"] : '';
        $Zo = isset($Er["\151\x64"]) ? $Er["\x69\144"] : '';
        $ww = isset($Er["\x67\x65\156\x64\145\x72"]) ? $Er["\147\x65\x6e\x64\x65\162"] : '';
        $Me = isset($Er["\154\x6f\143\141\x6c\x65"]) ? $Er["\x6c\x6f\x63\141\154\145"] : '';
        $De = array("\x66\151\162\163\x74\x5f\x6e\x61\155\145" => $l4, "\x6c\141\x73\x74\137\x6e\141\155\145" => $XL, "\x65\x6d\141\x69\154" => $SW, "\x75\163\145\x72\x5f\x6e\141\155\x65" => $gG, "\x75\x73\x65\162\x5f\x75\x72\154" => $EK, "\165\163\145\x72\x5f\160\x69\x63\164\165\162\x65" => $Go, "\163\x6f\143\x69\141\x6c\x5f\165\163\145\162\137\x69\x64" => $Zo, "\x6c\x6f\x63\141\164\151\x6f\x6e\x5f\143\x69\x74\171" => $Ku, "\x6c\x6f\x63\141\164\x69\157\156\x5f\x63\x6f\165\x6e\164\x72\171" => $Me, "\141\142\157\165\164\137\155\145" => $JC, "\x63\157\x6d\x70\x61\156\171\x5f\156\x61\x6d\145" => $Du, "\146\162\x69\x65\156\144\x5f\156\157\x73" => $QD, "\147\x65\x6e\144\145\x72" => $ww, "\x61\x67\145" => $u1);
        return $De;
    }
}
