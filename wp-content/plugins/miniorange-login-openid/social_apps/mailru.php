<?php


class mo_mailru
{
    public $color = "\43\x30\x30\64\60\70\x30";
    public $scope = "\165\163\x65\x72\x69\156\x66\x6f";
    public $video_url = '';
    public $instructions = '';
    public function __construct()
    {
        $this->site_url = get_option("\x73\x69\164\x65\165\162\x6c");
        $this->instructions = "\x47\x6f\x20\164\157\x20\x3c\x61\x20\150\x72\145\146\75\x22\150\164\x74\160\x73\72\x2f\57\x6f\62\x2e\155\x61\x69\x6c\56\162\165\57\141\160\160\x22\x20\164\141\162\x67\x65\164\75\42\137\142\154\141\156\x6b\42\76\x68\x74\x74\160\x73\x3a\57\x2f\157\62\56\x6d\x61\151\x6c\x2e\162\165\x2f\141\160\160\x3c\x2f\141\x3e\40\x61\156\x64\x20\163\x69\x67\x6e\x20\151\x6e\x20\x77\151\164\x68\40\171\157\165\162\40\x6d\x61\151\x6c\162\165\40\x64\145\166\145\x6c\157\160\145\162\40\x61\x63\x63\157\165\x6e\164\56\x23\x23\x47\x6f\x20\x74\157\x20\x41\x70\x70\x73\x20\x61\x6e\x64\40\143\154\x69\x63\153\40\157\x6e\40\103\162\x65\141\x74\145\x20\x61\156\x20\x41\x70\160\x6c\x69\x63\x61\164\151\x6f\x6e\56\x23\x23\105\156\x74\145\162\40\101\160\x70\40\156\x61\x6d\x65\40\x69\156\40\120\162\157\x6a\x65\143\x74\40\156\141\155\145\x20\x66\x69\145\x6c\144\x2e\43\x23\105\156\164\145\x72\x20\x3c\142\76\x3c\x63\157\144\145\40\151\144\75\47\x31\x27\x3e" . mo_get_permalink("\155\x61\x69\x6c\162\x75") . "\74\x2f\143\x6f\x64\145\x3e\x3c\151\x20\163\164\x79\x6c\x65\75\x20\x22\x77\x69\x64\164\x68\72\40\x31\x31\160\x78\73\150\x65\x69\x67\150\x74\x3a\40\71\x70\170\73\x70\x61\144\x64\151\x6e\147\55\x6c\x65\x66\164\x3a\62\x70\170\73\160\141\144\x64\151\156\x67\55\164\x6f\160\x3a\63\160\170\42\40\x63\x6c\141\163\x73\x3d\x22\146\141\x20\146\x61\55\x66\167\x20\x66\x61\55\154\147\x20\x66\x61\55\143\x6f\x70\x79\x20\x6d\157\x5f\143\x6f\160\x79\40\x6d\x6f\137\x6f\160\145\156\x69\x64\137\143\x6f\160\171\x74\x6f\x6f\x6c\x74\151\160\42\x20\157\156\143\x6c\151\143\x6b\75\x22\x63\x6f\160\171\124\x6f\103\x6c\151\160\142\x6f\141\162\x64\50\164\x68\x69\x73\x2c\x20\47\43\x31\x27\x2c\40\47\43\163\150\157\x72\x74\143\x6f\x64\145\x5f\x75\x72\x6c\61\137\143\x6f\x70\171\x27\x29\x22\76\x3c\163\160\141\x6e\x20\x69\x64\75\42\x73\x68\x6f\x72\x74\x63\x6f\144\145\137\165\162\154\x31\137\x63\157\x70\x79\x22\40\x63\154\x61\163\163\x3d\42\x6d\x6f\x5f\157\160\x65\156\151\x64\x5f\143\157\160\171\164\x6f\x6f\154\164\151\x70\164\145\x78\x74\x22\76\103\x6f\160\171\40\164\x6f\40\x43\x6c\151\x70\x62\157\x61\x72\x64\74\57\163\160\x61\156\x3e\x3c\x2f\151\76\74\57\142\x3e\40\x69\156\x20\x20\x41\x6c\154\x20\162\145\x64\151\162\x65\x63\164\137\165\x72\x69\40\141\x6e\x64\x20\143\x6c\151\x63\153\x20\157\156\x20\x43\x6f\x6e\156\x65\x63\x74\x20\x53\x69\x74\x65\x2e\43\x23\x20\x20\117\156\40\164\x68\145\x20\x73\x61\155\145\40\x70\x61\x67\145\40\x79\157\x75\x20\x77\151\154\154\x20\x62\145\40\x61\142\154\x65\40\164\157\40\163\145\145\x20\171\x6f\165\x72\40\103\x6c\151\145\x6e\164\x20\x49\x44\x20\141\156\x64\40\103\x6c\151\x65\156\164\x20\x53\x65\143\x72\145\x74\x20\165\x6e\144\x65\x72\x20\164\x68\145\40\105\144\151\x74\x69\156\x67\x20\x74\150\x65\x20\x41\x70\160\x6c\x69\x63\141\164\151\157\156\x20\163\x65\x63\164\x69\x6f\x6e\56\x20\43\x23\103\157\160\171\x20\x74\150\145\163\145\x20\141\156\x64\40\x50\141\163\x74\145\40\164\150\x65\x6d\x20\151\x6e\164\157\40\164\150\x65\x20\146\151\145\154\144\163\x20\141\x62\157\x76\x65\56";
    }
    function mo_openid_get_app_code()
    {
        $i0 = maybe_unserialize(get_option("\155\x6f\137\x6f\160\x65\156\x69\144\137\141\160\x70\163\x5f\x6c\x69\163\x74"));
        $vA = get_social_app_redirect_uri("\155\141\151\x6c\x72\165");
        mo_openid_start_session();
        $_SESSION["\141\160\160\156\x61\155\x65"] = "\155\141\151\154\x72\x75";
        $cS = $i0["\x6d\x61\151\x6c\162\x75"]["\143\154\x69\x65\156\x74\x69\x64"];
        $Ur = "\x68\x74\x74\160\163\x3a\x2f\57\157\x32\x2e\155\x61\x69\154\x2e\162\x75\57\x6c\x6f\x67\x69\156\77\x63\154\x69\x65\x6e\164\137\151\x64\75" . $cS . "\x26\x73\x63\157\160\x65\x3d" . $jI . "\x26\162\145\x64\x69\x72\145\x63\x74\x5f\x75\162\151\75" . $vA . "\46\162\x65\x73\160\x6f\156\163\x65\137\x74\x79\x70\145\75\x63\157\144\x65\x26\x73\x74\141\164\145\x3d\x74\151\155\x65";
        header("\x4c\x6f\x63\141\x74\x69\x6f\156\72" . $Ur);
        exit;
    }
    function mo_openid_get_access_token()
    {
        $Ee = mo_openid_validate_code();
        $vA = get_social_app_redirect_uri("\x6d\141\151\154\162\x75");
        $i0 = maybe_unserialize(get_option("\155\x6f\137\157\x70\x65\x6e\x69\144\x5f\x61\x70\x70\x73\x5f\154\x69\163\164"));
        $cS = $i0["\155\x61\151\154\x72\x75"]["\x63\154\x69\145\x6e\x74\x69\144"];
        $ZA = $i0["\x6d\x61\x69\154\162\165"]["\143\154\151\x65\x6e\x74\x73\x65\143\162\145\164"];
        $Ux = "\x68\164\164\x70\x73\x3a\x2f\x2f" . $cS . "\x3a" . $ZA . "\x40\157\62\56\155\x61\151\154\56\x72\x75\57\164\157\x6b\x65\x6e";
        $K0 = "\x67\x72\141\x6e\164\x5f\x74\171\160\x65\75\x61\165\164\150\x6f\x72\x69\172\x61\164\151\157\x6e\x5f\143\157\x64\x65\46\x63\x6c\151\145\x6e\164\x5f\x69\x64\x3d" . $cS . "\46\143\154\151\145\x6e\164\x5f\163\145\x63\162\145\x74\75" . $ZA . "\x26\143\x6f\x64\145\75" . $Ee . "\x26\162\145\x64\151\x72\x65\143\x74\x5f\165\x72\x69\x3d" . $vA;
        $cb = mo_openid_get_access_token($K0, $Ux, "\x6d\141\151\154\x72\165", $cS, $ZA);
        $UN = isset($cb["\141\143\143\145\x73\163\137\164\157\x6b\x65\156"]) ? $cb["\141\x63\x63\x65\163\x73\x5f\x74\157\153\x65\x6e"] : '';
        mo_openid_start_session();
        $t9 = "\x68\x74\x74\x70\163\72\57\57\157\x32\56\155\x61\151\x6c\56\162\165\x2f\165\x73\x65\162\151\156\146\x6f\77\141\143\x63\145\x73\x73\x5f\x74\x6f\x6b\145\x6e\x3d" . $UN;
        $Er = mo_openid_get_social_app_data($UN, $t9, "\155\x61\151\x6c\162\x75");
        if (!(is_user_logged_in() && get_option("\x6d\x6f\x5f\x6f\x70\x65\x6e\x69\x64\x5f\x74\x65\x73\164\x5f\143\x6f\156\x66\151\147\165\162\x61\x74\151\157\x6e") == 1)) {
            goto ag_;
        }
        mo_openid_app_test_config($Er);
        ag_:
        $l4 = $XL = $SW = $gG = $EK = $Go = $Zo = '';
        $Ku = $Me = $JC = $Du = $u1 = $ww = $QD = '';
        if (!isset($Er["\x6e\141\155\x65"])) {
            goto J3f;
        }
        $gG = isset($Er["\x6e\141\x6d\145"]) ? $Er["\156\x61\155\x65"] : '';
        $Vx = explode("\40", $gG);
        $l4 = isset($Vx[0]) ? $Vx[0] : '';
        $XL = isset($Vx[1]) ? $Vx[1] : '';
        J3f:
        $SW = isset($Er["\145\155\x61\x69\x6c"]) ? $Er["\x65\155\141\x69\x6c"] : '';
        $Zo = isset($Er["\x75\163\145\x72\x5f\x69\144"]) ? $Er["\x75\x73\x65\x72\137\x69\144"] : '';
        $De = array("\x66\x69\162\163\x74\137\156\x61\155\145" => $l4, "\x6c\x61\x73\x74\x5f\x6e\141\x6d\x65" => $XL, "\145\x6d\x61\x69\154" => $SW, "\x75\x73\145\162\x5f\156\141\x6d\x65" => $gG, "\x75\x73\x65\162\x5f\x75\x72\x6c" => $EK, "\x75\163\x65\x72\137\160\151\x63\164\165\x72\145" => $Go, "\163\157\143\x69\141\x6c\x5f\165\x73\x65\162\137\x69\144" => $Zo, "\154\157\x63\141\164\151\x6f\156\x5f\143\x69\164\171" => $Ku, "\x6c\x6f\143\x61\x74\x69\x6f\156\137\x63\x6f\x75\x6e\164\162\x79" => $Me, "\x61\142\x6f\165\x74\x5f\155\x65" => $JC, "\143\157\155\160\141\156\171\x5f\x6e\x61\155\145" => $Du, "\146\x72\151\145\156\x64\x5f\x6e\x6f\x73" => $QD, "\147\x65\x6e\x64\145\x72" => $ww, "\x61\147\145" => $u1);
        return $De;
    }
}
