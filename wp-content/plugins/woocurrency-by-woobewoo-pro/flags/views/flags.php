<?php

class flagsViewWcu extends viewWcu {

	public function getFlagsList($params) {
		$model = $this->getModel();
		$this->assign('params', $params[0]);
		$this->assign('dbPrefix', $this->getModule()->dbPrefix);
		$this->assign('flagsList', $this->getModule()->getFlagsList());
		if (empty($params[1])) {
			parent::display('flags');
		} else {
			parent::display('flagsExample');
		}
	}

	public function getFlagsSetting() {
			$model = $this->getModel();
			$flagsList = frameWcu::_()->getModule('currency')->getModel()->getCurrencies();
			$optionsPro =  frameWcu::_()->getModule('options_pro')->getModel()->getOptionsPro();
			$defFlag = $this->getModule()->getModPath().'img/temp/NONE.png';
			$defModPath = $this->getModule()->getModPath();
			$flagsList = isset($optionsPro['flags']) ? $optionsPro['flags'] : array();
			$this->assign('flagsList', $flagsList);
			$this->assign('defFlag', $defFlag);
			$this->assign('defModPath', $defModPath);
			$this->assign('dbPrefix', frameWcu::_()->getModule('options_pro')->optionsDbOptPro);
			parent::display('flagsSetting');
	}


}
