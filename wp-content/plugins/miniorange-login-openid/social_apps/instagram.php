<?php


class mo_instagram
{
    public $color = "\43\65\61\67\106\x41\x36";
    public $scope = "\x75\x73\145\x72\137\x70\162\157\146\151\x6c\x65\x2c\165\x73\x65\x72\x5f\x6d\x65\x64\151\141";
    public $instructions;
    public function __construct()
    {
        if (get_option("\160\x65\162\x6d\x61\x6c\x69\156\x6b\x5f\x73\x74\162\x75\143\x74\165\x72\x65") !== '') {
            goto AM5;
        }
        $this->instructions = "\x3c\x73\x74\162\x6f\156\147\40\x73\164\171\154\145\x3d\47\x63\x6f\x6c\157\x72\x3a\40\162\x65\144\x3b\x66\x6f\x6e\164\x2d\x77\x65\x69\x67\150\x74\72\40\x62\157\154\144\47\x3e\74\x62\162\76\131\x6f\165\x20\150\141\x76\x65\40\163\145\x6c\x65\143\164\145\x64\x20\160\x6c\141\151\x6e\x20\160\x65\x72\x6d\x61\x6c\151\156\153\40\141\156\144\x20\151\156\x73\x74\x61\x67\162\141\x6d\40\x64\x6f\x65\x73\156\157\164\40\163\x75\x70\160\x6f\162\164\40\151\x74\56\x3c\57\x73\x74\x72\157\x6e\147\x3e\x3c\142\162\x3e\x3c\x62\x72\76\40\x50\154\145\x61\x73\145\40\x63\x68\141\156\147\145\40\x74\x68\x65\x20\x70\x65\x72\x6d\x61\154\x69\156\153\40\x74\x6f\40\x63\157\x6e\x74\151\x6e\x75\x65\x20\x66\165\x72\164\150\145\x72\56\x46\x6f\154\154\157\167\x20\164\150\145\x20\x73\x74\x65\x70\163\40\147\151\x76\x65\x6e\x20\x62\x65\154\x6f\167\x3a\74\142\162\76\x31\x2e\x20\x47\x6f\x20\x74\x6f\40\163\x65\164\164\x69\x6e\x67\163\x20\146\162\x6f\155\x20\164\150\x65\40\x6c\x65\146\164\40\160\x61\x6e\x65\x6c\40\141\156\144\40\x73\x65\x6c\x65\143\x74\40\164\150\145\40\160\x65\162\155\141\154\x69\x6e\153\163\x20\157\160\164\x69\x6f\x6e\56\74\x62\x72\76\x32\x2e\x20\120\x6c\x61\151\156\40\160\145\x72\x6d\141\x6c\151\x6e\153\x20\151\163\x20\x73\x65\x6c\x65\143\x74\145\144\40\54\x73\x6f\x20\160\x6c\145\x61\x73\145\40\163\145\x6c\x65\143\164\x20\x61\156\x79\40\157\x74\150\145\x72\40\x70\145\162\155\x61\x6c\x69\156\x6b\x20\x61\x6e\x64\x20\x63\x6c\x69\x63\153\40\x6f\156\x20\163\141\x76\145\x20\142\x75\x74\x74\x6f\156\x2e\x3c\x62\x72\76\40\x3c\163\x74\x72\157\156\147\x20\143\154\141\163\163\x3d\x27\155\157\137\157\x70\145\x6e\151\144\137\x6e\x6f\x74\x65\x5f\163\x74\171\x6c\145\x27\x20\163\x74\171\x6c\145\x3d\47\143\x6f\x6c\x6f\x72\x3a\x20\162\145\144\73\146\157\x6e\164\x2d\x77\x65\151\x67\150\164\x3a\x20\142\157\154\144\x27\76\40\x57\150\145\156\40\x79\157\x75\x20\167\151\154\x6c\x20\143\150\x61\x6e\x67\x65\x20\164\150\x65\x20\160\145\x72\155\x61\x6c\151\156\153\40\54\164\x68\x65\156\x20\x79\157\165\40\150\x61\x76\145\40\164\x6f\40\162\145\55\x63\x6f\x6e\x66\151\147\x75\x72\145\40\x74\x68\145\x20\x61\x6c\x72\x65\x61\x64\x79\x20\x73\145\x74\40\165\x70\x20\x63\165\163\164\157\155\40\141\x70\160\x73\x20\142\145\x63\141\165\x73\x65\x20\x74\150\x61\x74\40\x77\x69\x6c\154\40\143\x68\x61\x6e\147\x65\x20\x74\150\x65\x20\x72\145\144\x69\x72\145\143\x74\x20\125\x52\x4c\x2e\x3c\x2f\163\164\x72\157\x6e\147\76";
        goto CUF;
        AM5:
        $this->site_url = get_option("\x73\151\164\x65\165\x72\x6c");
        $this->instructions = "\107\x6f\x20\164\x6f\40\x64\145\166\145\154\157\x70\x65\162\x73\x2e\x66\141\143\x65\142\x6f\157\153\56\143\157\155\x2c\x20\143\x6c\151\x63\153\x20\x3c\x62\76\x4d\171\40\x41\160\160\x73\x3c\x2f\142\76\x2c\40\141\156\x64\40\x63\x72\x65\141\x74\x65\40\x61\40\156\145\167\40\x61\160\x70\56\40\123\x65\154\x65\x63\164\x20\74\142\x3e\102\165\151\x6c\x64\x20\103\x6f\x6e\156\x65\x63\x74\145\144\40\105\x78\160\x65\x72\151\x65\156\x63\145\x73\x3c\x2f\x62\x3e\40\x6f\162\40\74\142\76\123\157\x6d\145\x74\x68\151\x6e\x67\40\x45\x6c\163\x65\57\x46\x6f\x72\x20\105\166\145\x72\171\164\150\151\x6e\147\x20\x45\x6c\x73\145\x3c\57\x62\x3e\x2e\12\40\40\40\x20\40\40\40\x20\40\x20\40\x20\40\40\x20\x20\x20\40\40\40\40\40\40\x20\40\40\x20\40\x20\40\40\40\40\40\x20\x20\x23\x23\x4f\x6e\143\145\x20\171\x6f\x75\40\x68\x61\x76\x65\40\143\x72\145\141\164\x65\x64\x20\x74\x68\145\x20\x61\160\x70\40\141\x6e\x64\40\x61\162\x65\x20\x69\156\40\x74\x68\x65\x20\101\x70\160\40\x44\141\163\150\x62\157\x61\162\144\x2c\40\x6e\141\166\x69\147\141\x74\x65\x20\x74\x6f\40\x3c\142\76\x53\145\x74\164\x69\156\147\x73\40\x3e\40\x42\141\x73\x69\143\74\57\142\76\54\x20\163\x63\162\157\154\154\40\164\x6f\x20\x74\150\145\x20\x62\157\x74\x74\x6f\155\40\157\146\x20\x70\141\147\145\54\40\x61\156\x64\40\x63\154\151\x63\x6b\x20\x3c\142\x3e\101\144\x64\40\120\154\141\x74\146\157\162\x6d\x3c\57\142\76\x2e\x20\xa\x20\40\x20\x20\40\40\40\x20\40\x20\40\40\x20\40\40\40\x20\40\40\x20\40\40\40\40\x20\x20\40\x20\x20\x20\40\40\40\40\40\x20\43\x23\x43\150\x6f\157\163\x65\x20\74\x62\76\x57\145\x62\x73\151\x74\145\x3c\x2f\x62\x3e\x2c\40\141\144\144\40\171\157\x75\x72\x20\167\x65\142\163\151\x74\145\xe2\x80\231\x73\40\125\122\114\40\141\163\x20\x3c\x62\76\x3c\x63\x6f\x64\x65\40\x69\x64\75\47\71\x27\76" . get_option("\163\151\x74\x65\165\162\x6c") . "\x3c\x2f\x63\157\x64\145\x3e\74\151\40\163\x74\171\x6c\145\x3d\40\x22\167\151\x64\164\x68\72\x20\x31\61\x70\170\73\150\145\x69\147\x68\x74\x3a\40\71\160\170\73\x70\x61\x64\144\151\156\147\x2d\154\145\146\x74\x3a\x32\x70\170\73\160\141\x64\144\151\x6e\147\x2d\164\x6f\160\72\63\x70\x78\42\40\x63\154\141\x73\163\x3d\x22\x66\x61\40\146\x61\55\146\167\40\x66\141\x2d\154\147\40\x66\x61\x2d\x63\157\160\171\40\x6d\x6f\137\x63\x6f\x70\171\40\155\x6f\137\157\x70\145\156\151\x64\137\143\157\160\171\x74\x6f\157\154\164\151\160\42\x20\157\x6e\143\154\151\143\x6b\75\x22\x63\157\x70\171\x54\157\103\x6c\151\160\x62\x6f\x61\162\x64\x28\164\150\151\163\x2c\x20\x27\x23\71\x27\54\x20\x27\43\163\150\x6f\162\164\143\x6f\144\145\137\165\162\x6c\x31\x5f\143\157\160\171\47\51\x22\76\x3c\163\x70\141\x6e\x20\x69\144\75\x22\x73\150\x6f\x72\x74\x63\157\x64\145\137\x75\x72\x6c\61\x5f\143\x6f\x70\171\x22\x20\x63\x6c\x61\x73\x73\x3d\x22\155\157\x5f\157\x70\x65\156\x69\x64\137\143\157\x70\x79\164\x6f\x6f\x6c\x74\151\160\164\x65\x78\x74\42\76\103\x6f\160\x79\x20\164\x6f\40\x43\x6c\x69\x70\x62\157\x61\162\144\74\x2f\163\160\x61\x6e\76\74\57\151\76\x3c\x2f\142\x3e\x20\141\163\40\74\163\x74\x72\157\156\x67\x3e\x77\145\142\163\x69\164\145\40\125\122\114\40\x61\156\144\40\163\x61\166\145\x20\x79\x6f\165\x72\40\143\x68\141\156\147\x65\x73\56\74\57\x73\x74\162\x6f\156\x67\76\xa\40\x20\40\40\x20\x20\40\x20\40\x20\40\x20\x20\40\40\x20\40\40\40\40\x20\x20\40\40\40\40\x20\40\40\40\40\40\40\40\x20\40\x23\43\103\x6c\x69\143\153\x20\x6f\x6e\x20\74\x62\x3e\120\162\157\x64\165\143\x74\x73\74\x2f\142\x3e\x2c\40\x6c\157\143\x61\164\145\x20\164\150\145\40\74\142\76\111\x6e\x73\x74\x61\147\x72\141\x6d\x20\x70\162\x6f\x64\x75\x63\x74\x3c\x2f\x62\76\54\40\x61\156\144\40\143\154\x69\143\153\x20\x3c\142\76\123\145\x74\x20\x55\160\x3c\x2f\142\x3e\x20\164\157\x20\x61\144\144\x20\x69\164\x20\x74\x6f\40\x79\157\x75\162\x20\141\x70\160\56\xa\x20\40\40\x20\x20\40\x20\x20\40\x20\40\x20\40\x20\x20\x20\40\x20\x20\40\x20\40\x20\40\40\x20\x20\40\x20\x20\x20\40\x20\x20\x20\40\x23\43\123\143\162\x6f\154\154\40\164\157\x20\x74\150\145\40\x62\x6f\x74\x74\157\155\x20\157\x66\x20\x74\x68\x65\x20\160\141\147\x65\40\141\x6e\144\40\143\x6c\151\143\153\x20\x3c\142\x3e\103\x72\145\x61\164\145\40\x4e\x65\167\x20\x41\160\160\x3c\57\142\76\56\xa\40\x20\40\x20\x20\x20\x20\40\x20\40\40\x20\40\40\x20\x20\40\40\x20\40\x20\40\40\40\40\40\x20\40\x20\40\40\x20\40\x20\x20\40\43\x23\x45\x6e\164\145\162\x20\164\150\x65\x20\101\x70\160\40\104\x69\x73\x70\154\141\x79\40\116\x61\155\145\56\40\x45\156\164\145\162\x20\x74\150\145\40\162\x65\x64\151\x72\145\x63\x74\x20\125\x52\x4c\x20\x3c\x62\x3e\x3c\143\x6f\144\x65\40\x69\x64\75\x27\61\60\47\x3e" . mo_get_permalink("\151\x6e\x73\x74\141\x67\x72\141\x6d") . "\74\x2f\143\x6f\144\x65\x3e\74\151\40\x73\x74\x79\x6c\145\75\40\x22\167\x69\144\164\150\72\40\x31\x31\x70\170\73\150\x65\x69\x67\150\x74\72\x20\x39\x70\x78\73\160\x61\x64\144\151\x6e\x67\x2d\x6c\145\146\x74\72\x32\160\170\x3b\160\x61\144\144\x69\x6e\x67\x2d\x74\157\x70\x3a\x33\x70\x78\42\x20\x63\154\141\x73\163\x3d\42\146\141\40\146\x61\x2d\x66\x77\40\x66\x61\x2d\x6c\x67\x20\x66\141\55\143\x6f\x70\x79\40\155\x6f\137\x63\157\x70\x79\x20\x6d\x6f\x5f\157\x70\x65\156\x69\x64\x5f\143\x6f\x70\x79\x74\157\x6f\154\164\x69\160\42\40\157\156\143\x6c\x69\143\153\75\x22\143\x6f\x70\x79\124\x6f\x43\154\151\160\142\157\x61\162\144\x28\164\150\x69\163\54\x20\47\43\x31\x30\x27\54\x20\47\43\163\x68\x6f\162\164\x63\157\144\x65\137\x75\162\x6c\x31\x30\137\x63\x6f\x70\171\47\51\42\76\74\163\160\x61\x6e\x20\151\x64\75\x22\163\150\x6f\x72\164\143\157\144\145\x5f\x75\x72\154\61\60\137\143\x6f\x70\x79\x22\40\x63\x6c\x61\163\x73\75\x22\x6d\x6f\137\157\x70\x65\156\151\144\x5f\143\157\x70\171\164\x6f\x6f\x6c\164\x69\160\x74\145\x78\x74\42\x3e\x43\157\x70\x79\40\x74\157\40\x43\154\151\160\x62\x6f\x61\x72\144\74\x2f\x73\x70\141\x6e\76\74\57\151\x3e\74\57\x62\x3e\40\141\x73\40\x3c\163\x74\x72\x6f\x6e\x67\x3e\166\141\154\151\x64\40\162\x65\144\x69\162\x65\143\164\x20\x55\122\111\56\x3c\x2f\163\x74\x72\x6f\x6e\147\x3e\56\40\xa\x20\40\x20\40\40\40\40\x20\40\40\x20\40\40\40\x20\40\x20\40\40\40\40\40\40\40\x20\40\40\40\x20\40\40\40\40\x20\x20\40\43\x23\105\156\x74\x65\x72\40\74\x62\76\74\143\x6f\144\145\40\x69\144\x3d\47\71\47\x3e" . get_option("\163\151\x74\x65\x75\x72\154") . "\74\57\143\157\144\x65\76\x3c\x69\x20\163\164\171\154\x65\75\x20\42\167\x69\144\164\x68\72\40\x31\61\x70\x78\x3b\150\145\x69\x67\x68\x74\72\40\x39\x70\x78\73\x70\x61\144\x64\x69\156\x67\x2d\x6c\x65\146\164\72\62\160\x78\73\x70\x61\144\x64\x69\x6e\x67\x2d\164\x6f\x70\72\63\160\x78\42\40\143\x6c\x61\163\x73\x3d\42\x66\141\40\146\141\x2d\x66\167\x20\x66\x61\x2d\154\147\40\x66\x61\55\x63\157\160\171\40\155\157\137\143\x6f\160\x79\x20\x6d\157\137\157\160\145\x6e\x69\x64\x5f\x63\x6f\x70\x79\x74\157\157\154\x74\x69\160\x22\x20\157\156\143\x6c\x69\x63\x6b\x3d\x22\x63\157\x70\x79\x54\157\103\x6c\x69\x70\x62\x6f\x61\x72\x64\50\164\150\x69\x73\54\x20\x27\43\71\47\54\x20\47\43\163\150\x6f\x72\164\143\157\144\x65\137\x75\162\154\61\137\143\157\160\171\47\51\x22\76\74\x73\160\x61\156\x20\151\x64\x3d\42\163\150\157\162\x74\143\x6f\x64\145\x5f\165\x72\154\61\x5f\143\x6f\160\x79\42\40\x63\154\141\x73\163\x3d\42\x6d\x6f\x5f\157\x70\x65\156\151\144\137\x63\x6f\x70\171\x74\x6f\x6f\x6c\164\x69\160\x74\145\x78\x74\42\x3e\x43\157\160\x79\40\x74\157\x20\x43\154\x69\160\x62\157\141\162\x64\x3c\57\x73\x70\141\x6e\76\74\x2f\x69\x3e\74\57\142\76\40\x61\163\x20\x3c\x73\164\162\x6f\x6e\147\76\40\171\157\x75\x20\74\x62\76\x44\145\141\165\164\x68\x6f\x72\151\172\x65\x20\x43\x61\x6c\x6c\x62\141\x63\153\x20\x55\x52\114\74\57\142\76\40\x61\x6e\144\x20\74\142\76\x44\x61\x74\x61\40\104\x65\x6c\x65\164\151\x6f\x6e\x20\x52\145\x71\x75\145\x73\164\x20\125\x52\114\74\57\x62\76\56\xa\40\x20\x20\40\40\x20\40\40\40\40\40\40\40\40\x20\40\x20\40\40\x20\40\40\40\x20\40\x20\40\x20\x20\40\40\x20\x20\x20\x20\x20\x23\x23\116\x61\x76\151\147\141\164\x65\x20\x74\x6f\40\74\142\x3e\122\157\154\145\x73\74\57\142\76\40\x3e\40\122\x6f\x6c\x65\163\40\x61\156\x64\40\163\x63\162\x6f\x6c\x6c\x20\x64\x6f\167\x6e\40\x74\157\x20\x74\150\145\x20\74\x62\76\111\x6e\x73\164\x61\147\x72\x61\x6d\40\x54\x65\x73\164\145\x72\163\x3c\x2f\x62\76\40\x73\145\x63\x74\151\157\x6e\56\x20\103\154\x69\x63\x6b\40\x3c\x62\x3e\x41\144\x64\x20\x49\x6e\163\x74\141\x67\162\x61\155\40\x54\145\163\x74\145\x72\x73\74\x2f\x62\76\x20\141\156\x64\x20\145\x6e\164\145\x72\x20\x79\157\x75\x72\x20\111\x6e\x73\164\x61\147\162\141\x6d\x20\x61\x63\x63\157\165\x6e\164\342\x80\231\163\x20\165\x73\145\162\156\141\x6d\x65\40\x61\156\x64\x20\x73\x65\x6e\144\x20\164\x68\145\40\151\156\x76\151\164\x61\x74\151\157\x6e\x2e\12\x20\40\40\x20\x20\x20\x20\x20\40\x20\40\x20\x20\40\40\x20\x20\40\x20\40\x20\x20\x20\40\x20\x20\x20\40\x20\40\40\40\x20\x20\x20\40\43\43\x43\x68\x61\x6e\x67\x65\x20\171\x6f\165\162\x20\141\x70\x70\x20\x73\x74\x61\164\165\163\40\x66\x72\157\x6d\40\111\x6e\40\104\145\x76\145\x6c\157\x70\155\x65\x6e\x74\40\x74\x6f\x20\x4c\x69\166\145\40\x62\171\40\143\154\x69\x63\x6b\x69\156\147\x20\x6f\156\40\x4f\106\x46\40\x28\x73\154\x69\x64\x69\x6e\147\x20\142\165\164\164\157\156\51\x20\x62\145\163\x69\x64\x65\40\123\164\x61\164\x75\x73\x20\x6f\x70\x74\151\157\x6e\40\x6f\146\x20\x74\150\145\x20\164\157\160\40\162\151\147\150\x74\40\143\157\x72\x6e\145\x72\x2e\12\40\40\40\x20\x20\x20\40\40\x20\x20\40\x20\x20\x20\40\40\x20\40\40\40\x20\40\x20\40\40\x20\40\40\x20\x20\40\40\40\40\40\40\43\x23\x4f\160\x65\156\40\141\x20\156\145\x77\40\x77\x65\142\40\142\162\x6f\167\163\x65\162\40\141\x6e\x64\40\147\157\x20\x74\x6f\x20\x77\167\167\56\x69\156\163\164\x61\x67\x72\141\155\56\x63\157\x6d\x20\x61\156\144\x20\x73\151\147\x6e\40\x69\x6e\x74\157\40\171\x6f\x75\x72\x20\x49\x6e\x73\x74\x61\147\162\x61\155\x20\x61\143\x63\x6f\165\156\x74\40\x74\150\x61\164\40\171\x6f\165\40\152\x75\x73\x74\x20\151\156\x76\x69\x74\145\144\56\x20\116\141\166\x69\x67\x61\164\145\x20\x74\157\x20\x3c\142\x3e\50\120\x72\x6f\146\151\x6c\x65\40\111\143\157\x6e\51\40\x3e\x20\105\144\x69\x74\x20\120\162\x6f\146\151\x6c\x65\x20\76\40\101\160\160\x73\40\x61\x6e\x64\40\127\x65\x62\x73\x69\x74\x65\x73\40\76\x20\124\x65\x73\x74\x65\162\40\x49\x6e\x76\x69\x74\x65\163\40\x3c\x2f\x62\76\x61\x6e\144\x20\x61\143\x63\145\x70\164\40\164\150\x65\x20\x69\x6e\x76\151\x74\x61\164\151\157\156\56\12\40\40\x20\40\40\x20\40\x20\40\40\x20\40\x20\40\40\40\x20\x20\40\x20\x20\x20\40\x20\x20\x20\40\x20\x20\x20\40\x20\x20\x20\x20\x20\x23\x23\x43\x6c\x69\143\x6b\x20\x6f\156\x20\111\156\x73\164\x61\x67\162\141\x6d\x20\x66\162\157\155\x20\164\150\145\40\x6c\145\x66\x74\40\x6d\x65\156\165\40\x61\x6e\144\40\164\x68\145\x6e\x20\x63\154\151\143\x6b\40\x6f\x6e\40\47\102\141\163\x69\143\40\104\151\x73\x70\154\141\171\x27\40\x6f\160\x74\151\x6f\156\x2c\40\x63\x6f\x70\171\40\x74\150\x65\x20\74\x62\x3e\x69\x6e\163\164\141\147\162\141\155\40\141\x70\x70\40\x49\x44\40\74\x2f\x62\76\x20\x61\x6e\144\x20\74\x62\76\x69\156\163\164\x61\x67\x72\141\155\x20\x61\x70\x70\x20\x73\x65\143\162\145\164\74\57\x62\x3e\40\x66\x72\x6f\155\40\164\150\145\162\x65\x2e";
        CUF:
    }
    function mo_openid_get_app_code()
    {
        $i0 = maybe_unserialize(get_option("\x6d\157\x5f\x6f\x70\x65\x6e\x69\144\x5f\x61\160\160\163\137\154\x69\x73\164"));
        $vA = get_social_app_redirect_uri("\x69\156\x73\x74\x61\x67\x72\141\155");
        mo_openid_start_session();
        $_SESSION["\x61\x70\160\x6e\x61\x6d\145"] = "\151\156\x73\164\x61\x67\162\141\x6d";
        $cS = $i0["\x69\x6e\x73\164\x61\x67\x72\x61\x6d"]["\143\x6c\151\x65\156\x74\x69\x64"];
        $jI = $i0["\151\x6e\x73\164\x61\x67\162\141\x6d"]["\163\x63\x6f\x70\x65"];
        $Ur = "\150\x74\164\x70\163\x3a\57\57\141\x70\x69\56\x69\156\x73\x74\x61\147\162\x61\155\56\x63\x6f\x6d\x2f\157\141\165\x74\x68\x2f\x61\x75\164\150\157\162\151\172\x65\x2f\x3f\143\x6c\x69\x65\156\x74\x5f\151\144\x3d" . $cS . "\46\x72\x65\x64\x69\162\x65\x63\164\137\165\162\x69\75" . $vA . "\x26\x73\143\157\x70\145\75" . $jI . "\46\162\x65\163\160\x6f\156\x73\145\137\x74\171\160\145\x3d\143\157\x64\145";
        header("\114\x6f\x63\141\164\151\x6f\156\x3a" . $Ur);
        exit;
    }
    function mo_openid_get_access_token()
    {
        $Ee = mo_openid_validate_code();
        $vA = get_social_app_redirect_uri("\x69\156\163\164\x61\x67\162\141\x6d");
        $i0 = maybe_unserialize(get_option("\155\x6f\x5f\x6f\x70\145\x6e\x69\144\x5f\x61\x70\160\163\x5f\x6c\151\163\164"));
        $cS = $i0["\151\156\163\x74\x61\x67\162\141\x6d"]["\x63\x6c\151\145\x6e\x74\x69\x64"];
        $ZA = $i0["\151\x6e\x73\164\141\x67\162\141\x6d"]["\x63\x6c\x69\145\156\x74\163\145\x63\x72\x65\x74"];
        $Ux = "\x68\164\164\x70\x73\72\57\57\141\160\151\x2e\151\156\163\164\x61\x67\162\x61\x6d\x2e\143\157\x6d\x2f\157\141\x75\164\150\57\x61\x63\143\145\163\x73\137\x74\x6f\153\x65\156";
        $K0 = "\143\154\x69\145\x6e\164\x5f\151\x64\x3d" . $cS . "\46\143\154\x69\x65\x6e\164\x5f\163\x65\x63\162\x65\164\x3d" . $ZA . "\46\x67\162\x61\156\164\x5f\164\x79\160\145\x3d\x61\x75\164\150\x6f\162\151\172\141\x74\151\157\156\x5f\x63\157\144\x65\x26\162\145\144\151\x72\145\143\x74\x5f\x75\x72\151\x3d" . $vA . "\46\143\157\144\145\x3d" . $Ee;
        $cb = mo_openid_get_access_token($K0, $Ux, "\x69\156\163\164\141\x67\162\x61\155");
        $UN = isset($cb["\141\x63\x63\145\x73\x73\x5f\164\157\x6b\x65\156"]) ? $cb["\x61\x63\x63\145\163\163\x5f\164\x6f\x6b\x65\156"] : '';
        mo_openid_start_session();
        $t9 = "\x68\164\164\160\x73\72\57\x2f\x67\x72\141\x70\150\56\x69\x6e\163\x74\141\x67\x72\141\155\x2e\x63\157\155\57\155\x65\77\146\x69\145\154\144\163\75\151\x64\x2c\x75\x73\145\162\x6e\141\x6d\145\x26\x61\x63\x63\145\163\163\137\x74\157\153\x65\x6e\75" . $UN;
        $Er = mo_openid_get_social_app_data($UN, $t9, "\151\x6e\163\164\141\147\162\141\155");
        mo_openid_start_session();
        if (!(is_user_logged_in() && get_option("\x6d\157\x5f\x6f\x70\x65\156\151\x64\x5f\x74\x65\163\x74\137\x63\157\x6e\146\x69\x67\x75\162\141\164\x69\x6f\156") == 1)) {
            goto rV5;
        }
        mo_openid_app_test_config($Er);
        rV5:
        $l4 = $XL = $SW = $gG = $EK = $Go = $Zo = '';
        $Ku = $Me = $JC = $Du = $u1 = $ww = $QD = '';
        $gG = isset($Er["\x75\x73\x65\162\156\141\155\145"]) ? $Er["\x75\x73\145\162\156\x61\x6d\145"] : '';
        $Zo = isset($Er["\151\x64"]) ? $Er["\x69\x64"] : '';
        $De = array("\x66\x69\x72\163\164\137\156\x61\x6d\145" => $l4, "\x6c\x61\x73\164\137\156\141\x6d\x65" => $XL, "\145\155\141\x69\154" => $SW, "\165\x73\x65\x72\x5f\x6e\x61\x6d\x65" => $gG, "\165\x73\145\x72\x5f\165\162\154" => $EK, "\x75\x73\x65\162\x5f\160\x69\x63\164\165\x72\x65" => $Go, "\163\157\x63\151\x61\154\x5f\165\163\145\162\x5f\x69\144" => $Zo, "\x6c\x6f\x63\x61\164\151\x6f\156\x5f\143\151\x74\171" => $Ku, "\x6c\157\x63\141\164\151\157\x6e\137\143\157\x75\156\164\162\171" => $Me, "\x61\142\x6f\x75\164\x5f\155\145" => $JC, "\143\x6f\x6d\160\141\x6e\x79\x5f\156\x61\155\x65" => $Du, "\x66\x72\x69\145\156\144\x5f\156\x6f\x73" => $QD, "\x67\145\156\144\145\x72" => $ww, "\141\147\x65" => $u1);
        return $De;
    }
}
