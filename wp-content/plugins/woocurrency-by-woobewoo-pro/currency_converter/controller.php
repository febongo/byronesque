<?php
class currency_converterControllerWcu extends controllerWcu {

	public function drawCurrencyConverterAjax()
	{
		$res = new responseWcu();
        $data = reqWcu::get('post');
        if (isset($data) && $data) {
            $res->setHtml(frameWcu::_()->getModule('currency')->drawModuleAjax('currency_converter', $data, true));
        } else {
			$res->pushError($this->getModule('currency')->getErrors());
			//$res->pushError(__('Empty or invalid data procided', WCU_LANG_CODE));
		}
        $res->ajaxExec();
	}
	public function getPermissions()
    {
        return array(
            WCU_USERLEVELS => array(
                WCU_ADMIN => array('drawCurrencyConverterAjax')
            ),
        );
    }
}
