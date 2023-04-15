<?php
class custom_cssViewWcu extends viewWcu {

    public function getCustomCss() {
        $customCssSettings = $this->getModel()->getCustomCssSettings();
        if (isset($customCssSettings['custom_css']['field_css'])){
            $this->assign('fieldCss', $customCssSettings['custom_css']['field_css']);
        }
        if (isset($customCssSettings['custom_css']['toggle_css']) && $customCssSettings['custom_css']['toggle_css']) {
            parent::display('customCssStyle');
        }
	}

}
