<?php


class mo_social_update_framework
{
    private $current_version;
    private $update_path;
    private $plugin_slug;
    private $slug;
    private $plugin_file;
    private $new_version_changelog;
    public function __construct()
    {
        add_action("\x61\x64\x6d\151\x6e\137\151\156\x69\x74", [$this, "\155\x6f\137\x6f\164\x70\x5f\165\x70\x64\141\164\x65"]);
        add_filter("\x70\162\x65\x5f\x73\145\x74\x5f\x73\x69\x74\x65\x5f\x74\x72\141\156\163\x69\145\x6e\x74\x5f\x75\160\144\141\x74\x65\x5f\160\154\x75\147\151\x6e\163", array(&$this, "\155\157\x5f\x6f\x74\160\x5f\x63\x68\x65\143\153\137\x75\160\x64\141\164\x65"));
        add_filter("\x70\154\x75\x67\x69\x6e\x73\x5f\141\160\151", array(&$this, "\x6d\157\137\x73\157\143\151\x61\x6c\x5f\x63\150\145\x63\153\137\x69\x6e\146\157"), 10, 3);
        $this->initializeValues();
    }
    public function initializeValues()
    {
        $VT = "\150\x74\x74\160\163\72\57\57\154\x6f\x67\151\x6e\x2e\170\x65\x63\165\162\x69\146\x79\x2e\143\157\x6d";
        $IT = get_option("\x6d\x6f\x5f\x6f\160\x65\156\x69\x64\137\x73\x6f\143\x69\x61\154\137\154\157\x67\151\x6e\137\166\x65\x72\163\151\157\x6e");
        $t7 = $VT . "\x2f\155\157\x61\163\x2f\x61\x70\x69\57\x70\154\165\x67\151\x6e\57\155\x65\x74\141\x64\x61\x74\141";
        $pe = "\x6d\151\156\151\157\x72\141\x6e\147\x65\x2d\154\x6f\x67\x69\x6e\x2d\157\x70\145\x6e\151\144\57\x6d\x69\156\x69\x6f\162\141\156\x67\x65\137\x6f\x70\x65\x6e\151\144\x5f\163\163\x6f\x5f\163\145\x74\164\x69\x6e\147\x73\56\x70\x68\x70";
        $this->current_version = $IT;
        $this->update_path = $t7;
        $this->plugin_slug = $pe;
        list($Jk, $D3) = explode("\57", $pe);
        $this->slug = $Jk;
        $this->plugin_file = $D3;
    }
    public function mo_otp_check_update($ym)
    {
        if (!empty($ym->checked)) {
            goto KpM;
        }
        return $ym;
        KpM:
        $bU = $this->getRemote();
        if ($bU["\163\164\x61\164\165\163"] == "\x53\125\x43\x43\105\123\x53") {
            goto a51;
        }
        if (!($bU["\163\164\x61\x74\165\x73"] == "\x44\105\116\111\105\104")) {
            goto TrH;
        }
        if (!version_compare($this->current_version, $bU["\156\145\x77\x56\x65\162\x73\x69\157\156"], "\74")) {
            goto rsX;
        }
        $hW = new stdClass();
        $hW->slug = $this->slug;
        $hW->new_version = $bU["\x6e\x65\167\x56\x65\162\x73\x69\157\156"];
        $hW->url = "\x68\164\164\x70\163\x3a\x2f\57\x6d\x69\x6e\151\157\162\x61\x6e\147\x65\x2e\143\x6f\x6d";
        $hW->plugin = $this->plugin_slug;
        $hW->tested = $bU["\143\155\x73\103\157\x6d\x70\x61\x74\x69\x62\x69\x6c\x69\x74\171\x56\x65\162\x73\151\x6f\x6e"];
        $hW->icons = array("\x31\x78" => $bU["\x69\143\157\156"]);
        $hW->status_code = $bU["\163\x74\x61\x74\x75\163"];
        $hW->license_information = $bU["\x6c\x69\x63\145\x6e\163\x65\x49\156\x66\157\x72\155\x61\164\151\x6f\x6e"];
        update_option("\155\157\x5f\157\164\x70\137\154\x69\x63\x65\156\x73\x65\137\x65\170\x70\151\x72\x79\x5f\x64\141\x74\x65", $bU["\154\151\x63\x65\156\x65\105\x78\160\x69\x72\171\104\141\164\145"]);
        $ym->response[$this->plugin_slug] = $hW;
        $Ed = true;
        update_option("\155\157\137\163\157\143\151\141\x6c\137\163\154\x65", $Ed);
        set_transient("\165\160\144\x61\x74\145\x5f\x70\x6c\165\x67\151\156\x73", $ym);
        return $ym;
        rsX:
        TrH:
        goto i7T;
        a51:
        $Ed = false;
        update_option("\155\157\x5f\163\157\143\151\141\x6c\137\x73\x6c\x65", $Ed);
        if (!version_compare($this->current_version, $bU["\x6e\x65\167\126\145\162\x73\x69\157\x6e"], "\74")) {
            goto Uyg;
        }
        ini_set("\155\x61\170\137\145\x78\145\x63\x75\x74\151\x6f\x6e\x5f\164\x69\x6d\145", 600);
        ini_set("\x6d\145\155\x6f\x72\171\137\154\x69\155\151\164", "\61\60\x32\64\x4d");
        $mQ = plugin_dir_path(__FILE__);
        $mQ = rtrim($mQ, "\x2f");
        $mQ = rtrim($mQ, "\134");
        $Sj = $mQ . "\x2d\160\x72\145\x6d\x69\165\x6d\55\142\x61\143\153\x75\160\x2d" . $this->current_version . "\56\172\x69\160";
        $this->mo_social_create_backup_dir();
        $Co = $this->getAuthToken();
        $ss = round(microtime(true) * 1000);
        $ss = number_format($ss, 0, '', '');
        $hW = new stdClass();
        $hW->slug = $this->slug;
        $hW->new_version = $bU["\156\x65\x77\x56\x65\162\163\x69\x6f\156"];
        $hW->url = "\x68\x74\x74\160\x73\x3a\x2f\57\155\x69\x6e\x69\x6f\162\141\156\x67\145\56\x63\x6f\x6d";
        $hW->plugin = $this->plugin_slug;
        $hW->package = "\150\x74\x74\160\163\72\x2f\57\154\157\x67\151\x6e\56\x78\x65\143\165\x72\x69\x66\x79\x2e\x63\157\155\x2f\x6d\157\141\x73\x2f\160\x6c\x75\147\151\x6e\x2f\144\157\167\156\154\x6f\x61\x64\55\165\160\x64\x61\x74\x65\77\x70\154\x75\147\x69\156\123\154\x75\147\75" . $this->plugin_slug . "\46\154\151\143\x65\156\163\145\x50\x6c\141\x6e\x4e\141\155\x65\x3d\x77\160\x5f\x73\x6f\143\151\x61\x6c\x5f\x6c\157\x67\151\x6e\x5f\x70\162\x65\x6d\151\165\155\137\160\154\x61\156\x26\x63\x75\163\x74\x6f\x6d\x65\162\x49\x64\x3d" . get_option("\x6d\157\x5f\157\160\145\x6e\x69\x64\x5f\x61\x64\x6d\x69\156\137\143\x75\x73\x74\157\x6d\x65\x72\137\x6b\x65\171") . "\x26\154\151\143\145\x6e\x73\145\x54\x79\x70\x65\x3d\127\120\137\x53\x4f\103\x49\101\114\137\x4c\117\x47\x49\116\x5f\x50\122\x45\x4d\x49\125\x4d\137\120\114\125\x47\111\116\x26\141\x75\x74\x68\124\157\153\145\x6e\75" . $Co . "\46\x6f\164\160\x54\x6f\153\x65\x6e\75" . $ss;
        $hW->tested = $bU["\x63\155\x73\x43\x6f\x6d\160\x61\164\151\x62\x69\x6c\x69\x74\x79\126\x65\162\x73\x69\157\156"];
        $hW->icons = array("\x31\x78" => $bU["\x69\x63\157\x6e"]);
        $hW->new_version_changelog = $bU["\x63\x68\141\156\147\x65\x6c\157\147"];
        $hW->status_code = $bU["\x73\164\x61\164\165\x73"];
        update_option("\x6d\157\x5f\x6f\x74\160\x5f\x6c\151\x63\x65\156\163\x65\x5f\x65\170\160\x69\162\171\x5f\144\141\x74\145", $bU["\154\x69\x63\x65\156\145\105\170\160\151\x72\171\x44\x61\x74\145"]);
        $ym->response[$this->plugin_slug] = $hW;
        set_transient("\165\x70\x64\141\x74\145\x5f\160\x6c\x75\x67\151\156\x73", $ym);
        return $ym;
        Uyg:
        i7T:
        return $ym;
    }
    public function mo_social_check_info($hW, $c9, $wa)
    {
        if (!(($c9 == "\161\x75\x65\162\x79\137\160\154\x75\x67\x69\x6e\x73" || $c9 == "\160\154\165\147\x69\x6e\x5f\151\156\146\157\x72\x6d\x61\x74\x69\x6f\x6e") && isset($wa->slug) && ($wa->slug === $this->slug || $wa->slug === $this->plugin_file))) {
            goto CII;
        }
        $s7 = $this->getRemote();
        remove_filter("\160\154\165\x67\x69\156\x73\137\141\x70\151", array($this, "\x6d\157\x5f\163\157\143\151\x61\x6c\137\143\150\145\143\x6b\x5f\x69\156\146\157"));
        $HY = plugins_api("\160\x6c\x75\x67\151\x6e\x5f\x69\x6e\x66\x6f\162\x6d\x61\164\x69\x6f\156", array("\x73\154\165\147" => $this->slug, "\x66\x69\145\x6c\144\x73" => array("\141\143\x74\x69\166\145\137\x69\156\x73\164\x61\154\154\163" => true, "\156\x75\x6d\x5f\x72\141\164\x69\x6e\x67\x73" => true, "\x72\x61\164\151\x6e\147" => true, "\x72\x61\164\151\x6e\147\x73" => true, "\x72\x65\166\151\145\167\x73" => true)));
        $C2 = false;
        $RV = false;
        $aK = false;
        $sP = false;
        $sk = '';
        $VZ = '';
        if (is_wp_error($HY)) {
            goto G0Y;
        }
        $C2 = $HY->active_installs;
        $RV = $HY->rating;
        $aK = $HY->ratings;
        $sP = $HY->num_ratings;
        $sk = $HY->sections["\144\x65\x73\143\162\x69\160\x74\x69\157\x6e"];
        $VZ = $HY->sections["\x72\x65\x76\x69\145\167\x73"];
        G0Y:
        add_filter("\x70\154\165\147\151\156\163\x5f\141\x70\151", array($this, "\155\157\x5f\x73\x6f\x63\151\x61\154\137\143\x68\145\143\x6b\x5f\x69\x6e\x66\157"), 10, 3);
        if ($s7["\163\x74\x61\x74\x75\163"] == "\x53\125\x43\x43\105\x53\x53") {
            goto n2T;
        }
        if (!($s7["\163\x74\x61\x74\165\x73"] == "\x44\105\116\111\x45\104")) {
            goto ZQi;
        }
        if (!version_compare($this->current_version, $s7["\x6e\145\167\x56\145\162\x73\x69\x6f\156"], "\74")) {
            goto XIv;
        }
        $qp = new stdClass();
        $qp->slug = $this->slug;
        $qp->plugin = $this->plugin_slug;
        $qp->name = $s7["\160\x6c\x75\x67\151\x6e\116\x61\x6d\x65"];
        $qp->version = $s7["\156\145\x77\126\x65\162\x73\x69\157\x6e"];
        $qp->new_version = $s7["\156\145\167\x56\x65\162\x73\151\x6f\x6e"];
        $qp->tested = $s7["\143\x6d\x73\x43\x6f\155\x70\x61\164\151\142\x69\x6c\151\x74\171\126\145\x72\x73\x69\x6f\x6e"];
        $qp->requires = $s7["\143\x6d\163\115\x69\156\x56\145\162\163\x69\157\156"];
        $qp->requires_php = $s7["\x70\x68\x70\115\x69\x6e\126\145\162\163\x69\157\x6e"];
        $qp->compatibility = array($s7["\x63\x6d\x73\x43\x6f\x6d\x70\x61\164\x69\x62\x69\x6c\x69\x74\x79\126\145\x72\x73\151\x6f\156"]);
        $qp->url = $s7["\143\155\163\120\154\x75\x67\151\x6e\x55\162\154"];
        $qp->author = $s7["\160\x6c\165\x67\151\x6e\x41\x75\x74\150\x6f\162"];
        $qp->author_profile = $s7["\160\x6c\165\x67\151\x6e\101\x75\164\x68\x6f\x72\120\162\157\x66\x69\154\145"];
        $qp->last_updated = $s7["\x6c\x61\x73\x74\x55\160\x64\141\164\x65\x64"];
        $qp->banners = array("\154\157\167" => $s7["\x62\141\156\156\145\162"]);
        $qp->icons = array("\61\x78" => $s7["\x69\143\157\x6e"]);
        $qp->sections = array("\143\x68\141\156\x67\145\x6c\x6f\x67" => $s7["\x63\150\x61\156\147\145\x6c\x6f\147"], "\154\151\x63\145\156\163\145\137\151\156\x66\157\x72\x6d\x61\164\x69\x6f\156" => _x($s7["\x6c\x69\x63\x65\x6e\x73\x65\111\x6e\146\x6f\162\x6d\141\x74\151\x6f\156"], "\120\154\165\x67\x69\x6e\x20\151\156\163\x74\141\x6c\154\x65\x72\x20\163\145\x63\x74\x69\x6f\x6e\x20\x74\151\x74\154\145"), "\x64\x65\x73\143\x72\x69\x70\164\x69\157\x6e" => $sk, "\122\145\x76\x69\x65\x77\163" => $VZ);
        $qp->external = '';
        $qp->homepage = $s7["\x68\157\155\x65\x70\141\x67\145"];
        $qp->reviews = true;
        $qp->active_installs = $C2;
        $qp->rating = $RV;
        $qp->ratings = $aK;
        $qp->num_ratings = $sP;
        update_option("\155\157\137\157\164\x70\x5f\154\x69\x63\145\x6e\x73\x65\137\145\x78\x70\x69\162\171\137\x64\141\164\x65", $s7["\x6c\151\143\145\156\x65\105\170\160\x69\x72\x79\104\x61\164\145"]);
        return $qp;
        XIv:
        ZQi:
        goto H8H;
        n2T:
        $Ed = false;
        update_option("\x6d\x6f\x5f\163\x6f\143\x69\141\154\137\163\x6c\x65", $Ed);
        if (!version_compare($this->current_version, $s7["\156\x65\167\126\x65\x72\163\151\157\x6e"], "\74\75")) {
            goto MyU;
        }
        $qp = new stdClass();
        $qp->slug = $this->slug;
        $qp->name = $s7["\160\154\165\147\x69\x6e\x4e\x61\155\145"];
        $qp->plugin = $this->plugin_slug;
        $qp->version = $s7["\x6e\x65\167\126\145\162\x73\x69\x6f\156"];
        $qp->new_version = $s7["\x6e\145\x77\126\145\162\163\151\157\156"];
        $qp->tested = $s7["\x63\155\163\x43\157\x6d\160\x61\x74\x69\142\x69\x6c\x69\164\x79\x56\x65\x72\163\x69\x6f\x6e"];
        $qp->requires = $s7["\143\x6d\x73\x4d\x69\156\126\145\x72\163\151\157\156"];
        $qp->requires_php = $s7["\160\x68\x70\x4d\x69\x6e\x56\x65\162\163\151\157\x6e"];
        $qp->compatibility = array($s7["\x63\155\163\103\x6f\x6d\x70\141\x74\151\142\x69\154\x69\164\x79\x56\145\x72\x73\151\157\156"]);
        $qp->url = $s7["\x63\155\x73\120\x6c\x75\147\x69\x6e\x55\x72\154"];
        $qp->author = $s7["\160\x6c\165\147\151\156\x41\165\164\x68\157\x72"];
        $qp->author_profile = $s7["\x70\x6c\x75\x67\151\x6e\x41\x75\164\x68\x6f\162\120\x72\157\146\151\154\x65"];
        $qp->last_updated = $s7["\x6c\x61\x73\x74\x55\160\x64\x61\x74\x65\144"];
        $qp->banners = array("\x6c\157\167" => $s7["\142\141\x6e\156\145\x72"]);
        $qp->icons = array("\x31\170" => $s7["\151\143\157\x6e"]);
        $qp->sections = array("\143\x68\x61\156\x67\x65\x6c\x6f\x67" => $s7["\143\150\x61\156\147\145\154\x6f\147"], "\x6c\x69\143\145\x6e\x73\145\137\x69\x6e\146\x6f\162\155\141\x74\151\x6f\156" => _x($s7["\x6c\151\x63\145\x6e\163\145\111\x6e\x66\x6f\x72\x6d\x61\x74\x69\x6f\156"], "\x50\x6c\165\x67\151\156\x20\x69\x6e\x73\164\x61\x6c\154\x65\x72\40\x73\145\x63\164\151\x6f\x6e\x20\164\151\164\x6c\x65"), "\x64\145\163\143\162\x69\160\164\x69\157\156" => $sk, "\x52\x65\166\151\145\167\163" => $VZ);
        $Co = $this->getAuthToken();
        $ss = round(microtime(true) * 1000);
        $ss = number_format($ss, 0, '', '');
        $qp->download_link = "\x68\x74\164\160\x73\x3a\57\57\154\x6f\147\x69\156\x2e\x78\x65\x63\x75\x72\x69\146\171\56\x63\157\x6d\57\x6d\157\x61\163\x2f\160\x6c\165\147\151\156\57\x64\157\167\x6e\154\157\141\144\x2d\165\160\x64\x61\x74\x65\x3f\x70\154\x75\147\151\156\123\x6c\x75\x67\x3d" . $this->plugin_slug . "\x26\154\151\x63\145\156\x73\145\x50\154\x61\x6e\116\141\x6d\145\x3d\167\160\x5f\x73\x6f\143\151\x61\x6c\x5f\x6c\x6f\x67\x69\x6e\x5f\160\x72\145\x6d\x69\165\155\137\x70\x6c\141\156\46\143\x75\x73\x74\x6f\x6d\145\x72\x49\144\x3d" . get_option("\x6d\x6f\x5f\157\160\145\156\151\144\137\x61\144\x6d\151\x6e\137\143\x75\163\164\x6f\x6d\x65\162\x5f\x6b\145\x79") . "\46\x6c\x69\143\x65\156\x73\x65\x54\x79\160\x65\x3d\x57\x50\137\x53\x4f\x43\x49\101\x4c\137\x4c\x4f\107\111\x4e\137\x50\122\x45\115\111\x55\x4d\137\120\114\x55\x47\x49\116\x26\141\x75\x74\150\x54\x6f\x6b\x65\156\75" . $Co . "\46\x6f\164\x70\x54\x6f\153\145\156\75" . $ss;
        $qp->package = $qp->download_link;
        $qp->external = '';
        $qp->homepage = $s7["\150\x6f\x6d\145\x70\141\x67\x65"];
        $qp->reviews = true;
        $qp->active_installs = $C2;
        $qp->rating = $RV;
        $qp->ratings = $aK;
        $qp->num_ratings = $sP;
        update_option("\x6d\x6f\137\157\164\160\137\154\x69\143\x65\x6e\163\145\137\145\x78\x70\x69\x72\x79\137\x64\141\x74\145", $s7["\154\151\143\145\x6e\145\105\x78\x70\x69\x72\171\104\141\x74\x65"]);
        return $qp;
        MyU:
        H8H:
        CII:
        return $hW;
    }
    private function getRemote()
    {
        $l2 = get_option("\155\x6f\x5f\x6f\160\145\156\x69\144\137\141\x64\155\151\x6e\137\143\165\x73\x74\x6f\x6d\x65\162\137\x6b\145\171");
        $NZ = get_option("\x6d\157\137\x6f\160\145\156\151\x64\137\x61\x64\155\x69\156\x5f\x61\160\x69\x5f\153\x65\171");
        $ss = round(microtime(true) * 1000);
        $dE = $l2 . number_format($ss, 0, '', '') . $NZ;
        $Co = hash("\163\150\141\x35\x31\x32", $dE);
        $ss = number_format($ss, 0, '', '');
        $JE = array("\x70\154\x75\147\x69\x6e\x53\154\165\x67" => $this->plugin_slug, "\154\x69\143\145\x6e\x73\145\x50\154\141\x6e\x4e\x61\x6d\145" => "\167\160\x5f\163\x6f\x63\151\141\154\x5f\154\157\x67\151\x6e\137\160\162\x65\155\151\x75\155\x5f\x70\154\x61\x6e", "\143\x75\163\164\157\155\x65\x72\x49\x64" => $l2, "\x6c\151\143\x65\156\x73\x65\124\x79\160\145" => "\x57\120\x5f\123\x4f\103\x49\x41\114\x5f\x4c\117\x47\x49\116\137\120\122\x45\x4d\111\125\x4d\x5f\x50\114\125\107\x49\116");
        $ZF = array("\x68\145\x61\x64\145\x72\163" => array("\x43\x6f\156\x74\x65\x6e\164\55\124\171\160\145" => "\x61\160\x70\154\x69\x63\141\164\151\x6f\156\57\152\163\x6f\x6e\73\x20\143\150\x61\x72\163\145\x74\75\165\164\x66\55\70", "\103\x75\x73\164\x6f\x6d\x65\x72\x2d\x4b\145\x79" => $l2, "\124\x69\x6d\145\163\164\141\155\160" => $ss, "\101\x75\164\150\x6f\x72\x69\x7a\x61\x74\151\x6f\x6e" => $Co), "\x62\x6f\x64\x79" => json_encode($JE), "\155\x65\x74\x68\157\x64" => "\x50\x4f\123\124", "\x64\x61\x74\141\137\146\x6f\162\x6d\141\164" => "\142\157\x64\x79", "\x73\x73\x6c\166\145\x72\x69\146\x79" => false);
        $Mb = wp_remote_post($this->update_path, $ZF);
        if (!(!is_wp_error($Mb) || wp_remote_retrieve_response_code($Mb) === 200)) {
            goto za9;
        }
        $Af = json_decode($Mb["\x62\157\144\171"], true);
        return $Af;
        za9:
        return false;
    }
    private function getAuthToken()
    {
        $l2 = get_option("\x6d\x6f\x5f\157\x70\145\x6e\151\x64\137\x61\x64\x6d\151\156\137\143\x75\163\x74\157\155\145\x72\137\x6b\x65\171");
        $NZ = get_option("\x6d\157\x5f\157\160\x65\x6e\x69\144\137\x61\x64\x6d\151\x6e\x5f\x61\x70\x69\x5f\153\145\171");
        $ss = round(microtime(true) * 1000);
        $dE = $l2 . number_format($ss, 0, '', '') . $NZ;
        $Co = hash("\163\150\141\65\61\x32", $dE);
        return $Co;
    }
    function zipData($yU, $wP)
    {
        if (!(extension_loaded("\x7a\151\x70") && file_exists($yU) && count(glob($yU . DIRECTORY_SEPARATOR . "\x2a")) !== 0)) {
            goto Jqt;
        }
        $yS = new ZipArchive();
        if (!$yS->open($wP, ZIPARCHIVE::CREATE)) {
            goto gNb;
        }
        $yU = realpath($yU);
        if (is_dir($yU) === true) {
            goto xru;
        }
        if (!is_file($yU)) {
            goto SR5;
        }
        $yS->addFromString(basename($yU), file_get_contents($yU));
        SR5:
        goto sWn;
        xru:
        $GB = new RecursiveDirectoryIterator($yU);
        $GB->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
        $PI = new RecursiveIteratorIterator($GB, RecursiveIteratorIterator::SELF_FIRST);
        foreach ($PI as $Tq) {
            $Tq = realpath($Tq);
            if (is_dir($Tq) === true) {
                goto VfX;
            }
            if (!(is_file($Tq) === true)) {
                goto Hsh;
            }
            $yS->addFromString(str_replace($yU . DIRECTORY_SEPARATOR, '', $Tq), file_get_contents($Tq));
            Hsh:
            goto Z63;
            VfX:
            $yS->addEmptyDir(str_replace($yU . DIRECTORY_SEPARATOR, '', $Tq . DIRECTORY_SEPARATOR));
            Z63:
            DFL:
        }
        w4p:
        sWn:
        gNb:
        return $yS->close();
        Jqt:
        return false;
    }
    function mo_social_plugin_update_message($L9, $Mb)
    {
        if (array_key_exists("\163\164\x61\164\165\x73\137\x63\x6f\x64\145", $L9)) {
            goto F2c;
        }
        return;
        F2c:
        if ($L9["\x73\164\x61\x74\165\163\x5f\x63\157\x64\145"] == "\123\125\103\x43\x45\123\x53") {
            goto XaI;
        }
        if (!($L9["\163\x74\141\164\165\x73\137\143\157\144\x65"] == "\104\105\x4e\x49\x45\104")) {
            goto CMC;
        }
        echo sprintf(__($L9["\154\x69\143\145\156\163\x65\137\151\156\x66\x6f\162\x6d\141\x74\151\x6f\x6e"]));
        CMC:
        goto xFI;
        XaI:
        $hv = wp_upload_dir();
        $di = $hv["\142\x61\x73\145\x64\151\162"];
        $hv = rtrim($di, "\57");
        $mQ = $hv . DIRECTORY_SEPARATOR . "\x62\x61\143\153\x75\160";
        $Sj = "\155\x69\156\x69\157\x72\x61\156\147\x65\55\154\157\147\151\x6e\55\157\x70\x65\156\x69\x64" . $this->current_version;
        $cX = explode("\x3c\x2f\x75\154\76", $L9["\x6e\x65\x77\x5f\x76\x65\162\x73\151\x6f\156\x5f\x63\150\141\156\x67\x65\x6c\x6f\147"]);
        $yg = $cX[0];
        $v3 = $yg . "\x3c\x2f\165\154\76";
        echo "\x3c\x64\151\166\x3e\x3c\x62\76" . __("\x3c\142\162\x20\x2f\x3e\x41\156\x20\x61\165\164\157\x6d\x61\164\x69\x63\x20\x62\141\x63\x6b\x75\x70\40\157\146\x20\143\x75\x72\162\145\156\x74\40\166\x65\x72\x73\151\x6f\156\40" . $this->current_version . "\40\150\x61\x73\40\142\x65\145\156\40\143\162\145\141\x74\x65\144\x20\x61\164\40\164\x68\145\x20\154\157\x63\141\x74\x69\x6f\x6e\x20" . $mQ . "\x20\x77\151\164\150\x20\164\150\145\40\x6e\x61\x6d\x65\40\x3c\163\160\141\156\x20\163\x74\x79\154\x65\75\42\x63\157\154\x6f\162\x3a\43\x30\60\67\63\x61\141\x3b\42\x3e" . $Sj . "\74\57\163\160\141\x6e\x3e\x2e\x20\x49\156\40\x63\141\163\x65\x2c\x20\x73\157\x6d\x65\164\150\x69\156\x67\x20\x62\x72\145\141\153\163\40\x64\165\x72\x69\x6e\147\40\164\x68\145\x20\165\x70\x64\141\x74\x65\54\40\x79\x6f\x75\x20\143\141\156\40\x72\x65\x76\145\162\x74\x20\164\x6f\x20\x79\157\x75\162\40\143\165\x72\x72\145\x6e\x74\x20\x76\x65\x72\x73\151\157\156\40\142\x79\x20\x72\x65\160\x6c\141\x63\151\156\147\x20\x74\x68\x65\40\142\141\x63\153\x75\160\40\x75\163\151\156\147\x20\x46\124\x50\40\x61\x63\x63\x65\163\x73\x2e", "\x6d\151\156\151\157\x72\141\x6e\147\145\x2d\154\x6f\147\x69\156\55\x6f\x70\x65\x6e\151\x64") . "\x3c\x2f\142\76\74\57\x64\151\x76\76\74\144\x69\x76\x20\163\164\171\154\145\x3d\x22\x63\x6f\154\157\162\72\x20\43\146\60\60\73\42\x3e" . __("\x3c\142\x72\x20\57\76\124\141\153\x65\40\x61\x20\x6d\151\x6e\165\x74\145\x20\164\157\x20\143\150\145\x63\153\x20\164\x68\145\40\x63\x68\x61\x6e\147\145\154\x6f\x67\40\157\146\x20\154\x61\164\x65\163\164\40\166\145\162\163\x69\x6f\x6e\x20\157\146\x20\x74\150\x65\x20\160\x6c\165\x67\151\x6e\x2e\x20\x48\x65\162\145\x27\163\40\167\150\171\x20\x79\x6f\165\40\156\145\x65\x64\40\x74\x6f\x20\165\160\144\x61\x74\145\72", "\155\151\156\x69\x6f\162\x61\156\x67\x65\x2d\x6c\157\147\x69\156\x2d\x6f\160\145\x6e\x69\144") . "\x3c\57\144\151\166\76";
        echo "\74\144\151\x76\40\x73\164\x79\154\x65\x3d\42\x66\157\156\164\55\x77\145\151\147\150\x74\x3a\40\x6e\x6f\162\x6d\x61\154\x3b\x22\x3e" . $v3 . "\x3c\x2f\x64\x69\166\x3e\x3c\x62\x3e\x4e\157\164\145\x3a\74\57\x62\x3e\40\x50\154\145\x61\163\145\x20\x63\x6c\151\x63\x6b\40\157\x6e\x20\74\142\x3e\126\x69\145\x77\x20\126\x65\x72\x73\151\157\x6e\x20\144\x65\x74\141\151\x6c\163\74\57\x62\x3e\40\154\151\x6e\x6b\40\164\157\x20\x67\145\164\x20\x63\x6f\x6d\x70\x6c\x65\x74\145\40\143\150\141\x6e\147\145\154\x6f\147\x20\x61\156\144\40\154\151\x63\x65\x6e\x73\145\x20\151\x6e\146\x6f\162\155\x61\x74\x69\x6f\156\56\40\x43\154\x69\x63\x6b\x20\x6f\x6e\40\x3c\142\x3e\x55\160\x64\141\x74\x65\x20\116\x6f\167\x3c\x2f\142\x3e\x20\154\x69\x6e\153\x20\164\x6f\40\165\x70\x64\x61\164\x65\x20\164\150\145\x20\160\154\165\x67\151\156\40\x74\157\x20\x6c\141\164\x65\x73\164\x20\166\145\x72\163\x69\157\156\56";
        xFI:
    }
    public function mo_social_license_key_notice()
    {
        if (!array_key_exists("\155\x6f\x6f\164\x70\x2d\144\151\x73\x6d\151\x73\x73", $_GET)) {
            goto I1r;
        }
        return;
        I1r:
        if (!(get_option("\x6d\x6f\137\163\x6f\143\x69\x61\154\x5f\163\154\145") && new DateTime() > get_option("\x6d\x6f\55\x6f\x74\160\55\x70\154\165\147\151\156\55\164\151\155\x65\162"))) {
            goto qsU;
        }
        $sM = esc_url(add_query_arg(array("\155\157\157\164\160\55\144\151\163\155\151\163\163" => wp_create_nonce("\157\x74\160\x2d\x64\151\163\155\151\163\x73"))));
        echo "\x3c\163\x63\x72\151\160\164\x3e\15\xa\x9\11\11\11\146\165\156\143\x74\x69\x6f\x6e\x20\x6d\157\157\164\x70\120\x61\171\155\145\156\x74\x53\164\x65\x70\163\50\51\40\x7b\xd\xa\x9\11\x9\x9\11\166\x61\x72\x20\141\164\164\x72\x20\75\40\144\x6f\x63\165\155\x65\x6e\x74\x2e\x67\145\164\105\154\x65\155\x65\x6e\x74\102\171\111\144\50\x22\x6d\157\157\164\x70\160\141\171\155\145\156\164\163\x74\145\160\x73\42\x29\x2e\x73\164\x79\154\x65\x2e\x64\x69\x73\160\154\x61\171\73\15\12\x9\x9\11\11\x9\x69\x66\50\141\x74\164\x72\40\75\x3d\40\x22\156\157\156\145\x22\x29\173\15\xa\11\11\11\x9\11\11\x64\x6f\x63\x75\155\x65\156\x74\x2e\x67\145\164\105\154\x65\x6d\145\156\x74\102\171\x49\x64\x28\x22\x6d\x6f\157\x74\x70\160\141\x79\155\x65\156\164\163\164\145\x70\x73\42\51\x2e\x73\164\x79\x6c\145\56\144\151\x73\160\x6c\x61\171\40\75\40\x22\x62\154\157\x63\x6b\x22\x3b\15\xa\11\11\11\11\11\x7d\145\154\x73\145\173\xd\xa\11\11\x9\x9\11\x9\144\x6f\143\x75\155\x65\156\x74\x2e\147\x65\164\105\x6c\x65\x6d\145\156\164\102\171\111\x64\x28\x22\155\x6f\x6f\x74\x70\x70\141\171\155\x65\156\164\x73\x74\x65\160\x73\x22\51\x2e\x73\164\171\x6c\x65\56\x64\151\x73\x70\x6c\141\x79\x20\75\40\x22\156\157\x6e\145\x22\73\15\12\11\x9\11\x9\11\175\15\12\x9\11\11\x9\175\15\12\11\11\11\x3c\57\x73\x63\162\x69\x70\164\76";
        echo "\74\x64\151\x76\40\151\144\75\x22\155\x65\163\163\141\147\145\42\40\x73\164\x79\154\x65\x3d\42\x70\157\x73\151\164\151\157\x6e\x3a\162\145\x6c\x61\x74\151\166\145\42\x20\x63\x6c\x61\x73\x73\x3d\x22\x6e\x6f\x74\151\x63\x65\x20\x6e\157\164\151\143\x65\40\x6e\x6f\164\151\143\145\55\167\141\x72\x6e\x69\x6e\x67\x22\76\x3c\x62\x72\40\x2f\76\74\x73\160\x61\x6e\x20\x63\x6c\141\x73\163\75\42\x61\x6c\x69\147\x6e\x6c\x65\146\164\42\x20\x73\164\171\x6c\145\x3d\42\143\x6f\x6c\157\162\x3a\43\x61\x30\60\73\146\157\x6e\164\55\146\141\x6d\x69\x6c\171\72\40\x2d\167\145\x62\153\x69\x74\55\160\151\x63\x74\157\x67\162\141\x70\x68\73\146\x6f\x6e\x74\x2d\x73\x69\x7a\x65\x3a\x20\x32\65\x70\170\73\x22\x3e\111\x4d\120\117\x52\124\101\116\x54\41\74\57\163\160\x61\156\x3e\74\142\x72\x20\57\76\74\x69\155\x67\40\x73\162\x63\x3d\x22" . plugin_dir_url(__FILE__) . "\151\x6e\143\154\x75\x64\145\x73\x2f\151\155\x61\x67\x65\x73\57\155\x69\156\x69\117\162\141\156\147\x65\x5f\x6c\x6f\x67\157\56\x70\156\x67" . "\42\40\x63\154\x61\x73\x73\75\42\141\154\151\147\x6e\x6c\x65\146\x74\42\x20\150\145\x69\147\150\164\x3d\x22\x38\x37\x22\40\167\151\x64\164\150\x3d\42\x36\66\42\40\141\154\x74\75\x22\155\x69\156\151\117\x72\x61\x6e\147\x65\x20\154\x6f\147\157\42\40\163\164\171\154\x65\75\42\155\141\x72\147\151\156\72\x31\60\x70\170\x20\x31\60\x70\x78\x20\x31\60\160\x78\40\x30\73\x20\150\x65\151\147\150\164\x3a\x31\62\70\x70\x78\x3b\x20\x77\151\144\x74\150\72\x20\61\62\70\160\170\73\x22\76\x3c\150\63\76\155\x69\156\151\x4f\162\x61\156\x67\145\40\x53\x6f\x63\x69\x61\154\40\114\157\147\151\x6e\x20\123\x75\x70\x70\x6f\x72\164\x20\x26\x20\x4d\141\151\156\164\145\x6e\141\x6e\143\145\40\114\151\x63\x65\156\x73\145\40\105\170\160\x69\162\x65\x64\74\x2f\150\63\x3e\74\160\x3e\x59\157\165\162\x20\155\151\156\151\x4f\162\x61\156\147\x65\x20\123\157\x63\x69\x61\x6c\x20\x4c\x6f\147\x69\156\40\x6c\x69\x63\145\156\x73\x65\40\151\163\x20\145\x78\160\151\x72\145\x64\x2e\40\124\x68\x69\x73\40\x6d\145\x61\156\163\40\x79\157\165\342\200\x99\162\x65\40\155\x69\x73\x73\151\x6e\x67\40\x6f\x75\x74\x20\x6f\156\40\x6c\141\x74\x65\x73\164\40\x73\x65\x63\165\x72\x69\x74\x79\x20\x70\x61\x74\143\150\x65\163\54\x20\x63\x6f\155\160\141\164\151\x62\x69\154\x69\x74\x79\40\x77\151\164\150\x20\164\x68\145\40\x6c\x61\164\x65\163\164\x20\120\110\120\40\166\x65\x72\163\x69\157\156\163\40\x61\156\144\40\127\157\162\x64\x70\162\145\x73\163\56\40\115\x6f\x73\x74\x20\x69\155\160\157\162\164\x61\156\164\154\x79\x20\x79\157\165\342\200\x99\x6c\x6c\40\142\145\x20\155\151\163\163\151\x6e\x67\40\157\165\x74\x20\x6f\156\x20\x6f\x75\162\40\x61\167\x65\163\x6f\x6d\145\40\x73\165\x70\x70\157\162\x74\41\x20\x3c\x2f\160\76\xd\12\x9\11\74\160\x3e\x3c\x61\x20\x68\162\145\x66\75\42\150\164\164\x70\x73\x3a\x2f\57\154\157\147\151\x6e\56\x78\145\143\165\162\x69\x66\171\56\x63\157\x6d\57\155\157\141\x73\57\154\x6f\147\151\156\77\162\145\144\151\x72\145\x63\x74\125\x72\x6c\75\150\164\x74\160\163\x3a\x2f\x2f\154\x6f\x67\151\156\56\x78\145\x63\x75\x72\x69\146\x79\x2e\x63\157\155\x2f\155\x6f\x61\x73\57\x61\x64\x6d\x69\156\x2f\143\x75\163\x74\157\155\x65\x72\x2f\x6c\x69\x63\x65\156\x73\x65\162\x65\x6e\145\x77\x61\x6c\x73\77\x72\x65\156\145\x77\x61\x6c\162\145\161\165\145\163\x74\x3d\x57\x50\137\123\117\x43\111\x41\x4c\x5f\114\117\x47\x49\x4e\137\120\122\x45\115\x49\x55\x4d\137\x50\114\125\x47\x49\x4e\x22\40\143\154\x61\163\x73\x3d\x22\x62\165\164\164\x6f\x6e\x20\x62\165\164\164\157\156\x2d\x70\x72\x69\x6d\x61\162\171\x22\x20\164\141\162\147\145\164\x3d\42\x5f\x62\x6c\141\x6e\x6b\x22\x3e\x52\x65\156\145\x77\x20\x79\157\x75\x72\x20\x73\x75\160\x70\157\x72\164\x20\154\x69\143\x65\156\x73\145\74\x2f\x61\x3e\46\x6e\x62\163\160\x3b\46\x6e\142\163\160\x3b\x3c\142\x3e\74\141\40\150\x72\x65\146\75\x22\x23\42\40\157\156\143\x6c\x69\143\x6b\x3d\42\155\x6f\157\x74\x70\x50\x61\x79\x6d\145\156\x74\x53\164\145\160\163\x28\x29\42\76\103\x6c\x69\143\153\x20\150\x65\x72\145\74\57\141\x3e\40\x74\x6f\x20\x6b\x6e\x6f\x77\40\x68\157\167\40\x74\157\40\x72\x65\x6e\145\x77\x3f\x3c\57\142\76\x3c\x64\x69\x76\x20\151\144\x3d\x22\155\x6f\x6f\164\160\160\x61\x79\155\145\x6e\x74\163\164\145\160\x73\x22\x20\x20\x73\164\171\x6c\x65\x3d\x22\x64\x69\163\160\154\x61\x79\x3a\40\156\x6f\x6e\x65\73\x22\76\74\x62\x72\40\57\x3e\x3c\x75\x6c\x20\163\164\171\x6c\x65\x3d\x22\x6c\151\163\164\55\x73\x74\x79\154\x65\72\40\x64\x69\x73\143\x3b\155\x61\x72\x67\151\x6e\55\154\x65\146\x74\72\x20\x31\x35\x70\170\73\42\76\15\12\74\154\x69\76\x43\x6c\x69\x63\153\x20\157\x6e\40\x61\142\157\166\x65\x20\142\165\164\164\x6f\x6e\40\x74\x6f\40\x6c\x6f\x67\x69\x6e\x20\x69\156\x74\157\x20\155\x69\156\x69\117\162\141\x6e\147\145\x2e\x3c\x2f\154\151\x3e\xd\xa\74\x6c\151\76\x59\x6f\165\40\167\x69\x6c\154\40\x62\x65\x20\x72\x65\144\x69\x72\145\143\164\145\144\x20\x74\157\40\160\x6c\165\x67\x69\x6e\x20\162\145\156\x65\167\x61\x6c\40\160\x61\147\x65\40\x61\146\x74\145\162\x20\x6c\x6f\x67\151\156\56\74\57\154\151\x3e\15\xa\74\154\151\x3e\111\146\40\x74\x68\x65\x20\160\154\x75\147\151\x6e\x20\x6c\151\x63\x65\156\x73\145\x20\x70\154\x61\156\x20\x69\x73\x20\x6e\x6f\x74\40\x73\145\x6c\145\143\x74\x65\x64\x20\x74\150\x65\x6e\x20\143\x68\157\x6f\163\145\x20\x74\x68\145\40\162\151\x67\150\164\40\157\x6e\x65\40\146\x72\x6f\x6d\x20\x74\x68\145\x20\144\x72\157\x70\x64\x6f\x77\156\54\40\x6f\x74\150\145\x72\167\151\163\x65\40\143\x6f\x6e\x74\141\143\164\x20\x3c\142\x3e\x3c\141\40\150\162\x65\x66\75\x22\x6d\141\151\154\164\157\x3a\151\x6e\146\157\x40\x78\145\x63\165\162\151\146\171\56\x63\x6f\x6d\x2e\x63\157\x6d\x22\x3e\151\x6e\146\x6f\100\170\x65\143\165\x72\151\146\x79\x2e\x63\x6f\155\x2e\143\157\x6d\x3c\x2f\141\x3e\74\57\142\76\40\164\x6f\x20\x6b\x6e\x6f\x77\40\141\x62\x6f\165\164\40\x79\x6f\165\x72\x20\x6c\151\x63\x65\x6e\x73\x65\40\160\x6c\141\156\56\74\x2f\154\151\76\xd\12\74\154\151\76\x59\x6f\x75\40\167\x69\154\x6c\40\163\145\x65\x20\164\x68\x65\40\x70\x6c\165\x67\151\x6e\40\162\145\x6e\x65\x77\x61\x6c\40\141\155\157\165\x6e\x74\56\x3c\x2f\154\x69\x3e\xd\12\x3c\154\151\x3e\106\x69\x6c\154\40\x75\x70\x20\171\157\165\162\x20\103\x72\x65\x64\151\x74\40\103\x61\162\x64\40\151\156\x66\x6f\162\155\x61\164\151\157\x6e\40\164\x6f\x20\x6d\141\x6b\x65\x20\x74\x68\x65\x20\x70\141\171\155\x65\156\x74\x2e\74\57\154\x69\x3e\15\xa\74\x6c\151\x3e\x4f\x6e\143\x65\x20\x74\150\145\x20\160\141\x79\x6d\x65\156\164\40\x69\163\40\x64\157\x6e\x65\54\40\x63\x6c\x69\x63\x6b\x20\x6f\156\40\74\x62\x3e\x43\x68\145\143\x6b\x20\101\147\x61\151\x6e\x3c\57\x62\x3e\40\142\165\x74\164\157\156\40\x66\x72\x6f\x6d\40\164\x68\x65\40\106\157\x72\143\145\40\x55\x70\x64\x61\164\x65\x20\x61\162\x65\x61\40\x6f\x66\40\x79\x6f\x75\162\x20\x57\x6f\162\x64\120\x72\145\163\163\x20\x61\144\155\151\156\x20\x64\141\x73\150\x62\157\141\162\144\x20\157\162\40\x77\x61\x69\x74\x20\x66\x6f\162\x20\x61\x20\x64\141\x79\x20\x74\157\x20\x67\145\164\40\x74\150\145\40\141\165\x74\157\155\141\x74\151\143\x20\x75\x70\144\x61\164\145\x2e\74\57\x6c\x69\x3e\xd\12\74\154\x69\76\x43\154\151\x63\x6b\40\x6f\x6e\x20\x3c\142\x3e\x55\x70\144\x61\x74\145\x20\x4e\157\167\x3c\57\x62\x3e\x20\x6c\x69\156\153\x20\x74\157\x20\151\156\163\164\141\x6c\x6c\x20\x74\x68\145\x20\154\x61\164\x65\x73\x74\x20\x76\145\162\x73\x69\157\156\x20\157\146\40\x74\x68\145\40\x70\x6c\x75\x67\x69\156\40\x66\162\x6f\x6d\x20\160\154\165\x67\151\x6e\40\155\x61\156\141\x67\145\162\40\141\x72\145\x61\x20\x6f\146\x20\x79\x6f\x75\x72\40\x61\144\155\151\x6e\x20\x64\x61\163\x68\x62\157\x61\x72\144\x2e\74\57\154\151\x3e\15\12\x3c\57\x75\154\x3e\111\156\x20\x63\141\x73\145\x2c\40\x79\x6f\165\x20\x61\162\x65\40\146\x61\143\151\156\147\40\141\x6e\x79\40\x64\x69\x66\146\x69\x63\x75\x6c\x74\x79\x20\x69\156\40\151\156\x73\x74\141\154\154\x69\156\147\40\x74\150\145\x20\165\160\144\141\x74\145\x2c\x20\160\154\145\141\163\x65\x20\x63\157\156\x74\141\143\x74\40\74\142\x3e\74\x61\x20\150\x72\x65\146\x3d\42\155\x61\151\154\164\x6f\x3a\x69\x6e\x66\157\100\x78\145\x63\x75\162\x69\x66\171\56\x63\157\155\x2e\x63\x6f\x6d\x22\x3e\x69\156\x66\157\100\x78\145\x63\x75\x72\151\146\x79\x2e\143\157\x6d\x2e\143\x6f\155\74\x2f\x61\x3e\74\x2f\142\76\x2e\xd\12\x4f\165\162\40\x53\165\160\x70\157\162\164\x20\105\x78\x65\143\165\x74\151\166\145\40\167\151\x6c\154\x20\141\x73\163\x69\163\x74\x20\171\x6f\x75\x20\x69\x6e\x20\151\156\x73\x74\141\154\154\x69\156\x67\40\x74\150\x65\x20\165\x70\x64\141\x74\x65\163\x2e\74\142\162\40\x2f\x3e\74\151\76\x46\x6f\162\x20\x6d\157\162\x65\40\151\156\x66\x6f\x72\155\x61\x74\x69\x6f\156\x2c\x20\x70\x6c\145\x61\x73\x65\40\143\157\x6e\x74\141\x63\164\x20\x3c\x62\x3e\x3c\141\x20\150\162\x65\x66\75\42\155\x61\151\154\164\x6f\x3a\x69\156\146\x6f\100\170\145\143\x75\162\x69\146\171\x2e\143\x6f\155\x2e\143\x6f\155\42\x3e\x69\156\146\x6f\100\x78\x65\x63\x75\x72\151\x66\x79\x2e\143\x6f\x6d\56\143\157\x6d\x3c\57\141\x3e\74\57\142\x3e\56\74\x2f\151\76\x3c\57\x64\151\166\x3e\74\141\40\150\162\x65\146\x3d\x22" . $sM . "\x22\40\x63\154\x61\163\x73\x3d\x22\141\x6c\x69\147\156\x72\151\x67\150\x74\x20\142\165\164\x74\157\156\40\x62\165\x74\x74\157\x6e\55\154\151\x6e\x6b\x22\76\x44\151\x73\x6d\x69\x73\x73\74\x2f\141\x3e\74\57\x70\x3e\15\12\x9\x9\x3c\144\151\166\x20\143\154\141\x73\x73\x3d\42\x63\154\x65\141\x72\x22\76\x3c\57\x64\x69\x76\76\x3c\57\x64\151\166\x3e";
        qsU:
    }
    public function mo_otp_dismiss_notice()
    {
        if (!empty($_GET["\155\x6f\x6f\164\x70\55\x64\151\x73\x6d\x69\x73\163"])) {
            goto VMp;
        }
        return;
        VMp:
        if (wp_verify_nonce($_GET["\155\x6f\157\x74\160\55\144\151\163\155\151\x73\x73"], "\x6f\164\x70\x2d\x64\x69\163\x6d\x69\163\x73")) {
            goto V7U;
        }
        return;
        V7U:
        if (!(isset($_GET["\x6d\x6f\157\164\160\x2d\x64\151\163\155\x69\163\x73"]) && wp_verify_nonce($_GET["\155\157\157\x74\160\55\144\151\163\155\x69\x73\x73"], "\x6f\164\160\55\144\151\x73\x6d\151\x73\x73"))) {
            goto voT;
        }
        $x6 = new DateTime();
        $x6->modify("\x2b\61\x20\144\141\171");
        update_option("\155\157\55\x6f\164\x70\x2d\160\x6c\x75\147\x69\156\55\164\x69\155\x65\x72", $x6);
        voT:
    }
    function mo_social_create_backup_dir()
    {
        $mQ = plugin_dir_path(__FILE__);
        $mQ = rtrim($mQ, "\57");
        $mQ = rtrim($mQ, "\134");
        $L9 = get_plugin_data(__FILE__);
        $OG = $L9["\x54\x65\170\164\104\157\155\x61\x69\156"];
        $hv = wp_upload_dir();
        $di = $hv["\x62\x61\x73\145\144\x69\162"];
        $hv = rtrim($di, "\x2f");
        $iF = $hv . DIRECTORY_SEPARATOR . "\x62\141\143\153\165\160" . DIRECTORY_SEPARATOR . $OG . "\55\160\x72\145\155\151\x75\155\x2d\x62\141\x63\153\165\160\x2d" . $this->current_version;
        if (file_exists($iF)) {
            goto IhL;
        }
        mkdir($iF, 0777, true);
        IhL:
        $yU = $mQ;
        $wP = $iF;
        $this->mo_social_copy_files_to_backup_dir($yU, $wP);
    }
    function mo_social_copy_files_to_backup_dir($mQ, $iF)
    {
        if (!is_dir($mQ)) {
            goto XSm;
        }
        $mo = scandir($mQ);
        XSm:
        if (!empty($mo)) {
            goto fgP;
        }
        return;
        fgP:
        foreach ($mo as $sg) {
            if (!($sg == "\56" || $sg == "\x2e\56")) {
                goto n46;
            }
            goto Lvn;
            n46:
            $CQ = $mQ . DIRECTORY_SEPARATOR . $sg;
            $cw = $iF . DIRECTORY_SEPARATOR . $sg;
            if (is_dir($CQ)) {
                goto Lwd;
            }
            copy($CQ, $cw);
            goto Ltr;
            Lwd:
            if (file_exists($cw)) {
                goto bJA;
            }
            mkdir($cw, 0777, true);
            bJA:
            $this->mo_social_copy_files_to_backup_dir($CQ, $cw);
            Ltr:
            Lvn:
        }
        Cs0:
    }
    function mo_otp_update()
    {
        if (!true) {
            goto dwD;
        }
        add_action("\151\x6e\137\160\154\x75\x67\x69\156\137\165\x70\x64\x61\164\x65\137\155\x65\x73\163\141\x67\x65\55" . $this->plugin_slug, [$this, "\155\157\x5f\x73\157\143\x69\x61\154\x5f\x70\x6c\165\x67\x69\156\x5f\x75\x70\x64\x61\x74\x65\x5f\155\145\163\163\x61\x67\145"], 10, 2);
        add_action("\141\x64\x6d\151\x6e\x5f\x68\x65\x61\144", [$this, "\155\157\x5f\163\157\x63\151\141\x6c\x5f\x6c\151\x63\145\x6e\163\x65\x5f\x6b\x65\171\137\x6e\157\x74\x69\x63\x65"]);
        add_action("\x61\144\155\x69\156\x5f\156\157\x74\x69\x63\x65\163", [$this, "\155\157\137\157\164\160\137\144\x69\x73\155\151\163\163\x5f\x6e\157\x74\x69\x63\145"], 50);
        if (!get_option("\x6d\x6f\137\163\157\143\151\x61\x6c\x5f\x73\154\x65")) {
            goto kx3;
        }
        update_option("\x6d\157\137\163\x6f\143\151\x61\154\x5f\163\154\x65\137\x6d\x65\x73\x73\141\147\145", "\131\x6f\x75\x72\40\x53\157\143\x69\141\x6c\x20\x6c\x6f\147\x69\156\x20\160\154\165\x67\151\156\40\x6c\x69\143\x65\x6e\163\x65\x20\150\141\x73\145\40\x62\145\145\x6e\x20\145\170\x70\151\x72\x65\x64\56\x20\131\x6f\x75\x20\141\162\x65\x20\155\151\x73\x73\x69\156\147\40\x6f\x75\x74\x20\157\156\x20\165\160\x64\x61\x74\x65\x73\x20\x61\x6e\x64\x20\x73\165\160\160\x6f\x72\x74\x21\x20\120\x6c\145\141\x73\145\x20\74\141\40\x68\x72\145\x66\75\42\x68\164\164\x70\163\x3a\x2f\57\x6c\x6f\x67\151\x6e\56\170\x65\143\165\162\151\146\171\x2e\x63\157\x6d\57\x6d\x6f\x61\x73\x2f\x6c\157\x67\x69\156\77\162\x65\x64\x69\x72\x65\143\x74\x55\162\x6c\x3d\x68\x74\164\160\163\x3a\x2f\x2f\154\157\x67\151\156\x2e\170\x65\x63\165\x72\x69\146\x79\56\x63\x6f\x6d\x2f\x6d\157\141\163\x2f\141\144\x6d\x69\x6e\57\143\165\x73\164\x6f\155\145\x72\x2f\154\151\143\145\x6e\163\x65\162\145\x6e\x65\167\x61\154\163\x3f\x72\x65\x6e\145\167\x61\x6c\162\145\161\165\145\x73\164\75\x57\120\137\x53\117\x43\x49\101\114\x5f\114\117\107\x49\116\137\x50\x52\105\115\x49\x55\x4d\137\120\x4c\125\x47\x49\x4e\x22\x20\164\141\162\x67\x65\164\75\x22\x5f\x62\154\x61\156\x6b\42\76\x3c\142\x3e\103\x6c\151\x63\x6b\40\110\x65\162\x65\74\x2f\142\x3e\x3c\x2f\141\76\x20\x74\x6f\x20\x72\145\x6e\145\x77\x20\x74\x68\x65\x20\123\165\160\x70\157\x72\x74\x20\141\156\x64\x20\x4d\141\x69\156\x74\145\x6e\141\143\145\40\x70\x6c\x61\x6e\x2e");
        kx3:
        dwD:
    }
}
