<?php
class flagsControllerWcu extends controllerWcu {
	public function saveCustomFlag() {
		$res = new responseWcu();
        $data = reqWcu::get('post');
		$buttonName = $data['buttonName'];
		$file = reqWcu::getVar(''.$buttonName.'', 'file');
		$curName = array_pop(explode('wcuUploadFlagButton_',$buttonName));

		if(empty($file) || empty($file['size'])) {
			$res->pushError (__('Missing File', WCU_LANG_CODE));
		}
		if(empty($file) || empty($file['size'])) {
			$res->pushError (__('Missing File', WCU_LANG_CODE));
		}
		if(!empty($file['error'])) {
			$res->pushError (sprintf(__('File uploaded with error code %s', $file['error'])));
		}
	    if(!$res->error()) {
			$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
			$extArray = array(
				'.ico',
				'.jpg',
				'.jpeg',
				'.png',
				'.gif',
				'.ICO',
				'.JPG',
				'.JPEG',
				'.PNG',
				'.GIF',
			);
			if ( in_array('.'.$ext, $extArray) ) {
				$uploaddir = frameWcu::_()->getModule('flags')->getModDir()."img/temp";
				$file_name = $curName.'.'.$ext;
				$pathToFile = $uploaddir.'/'.$curName;
				foreach ($extArray as $ext) {
					unlink($pathToFile.$ext);
				}
				if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
					$done_files[] = realpath( "$uploaddir/$file_name" );
				}
				if ($done_files) {
					$res->addData( array('name' => $file_name) );
					$res->addData( array('button' => $buttonName) );
				} else {
					$res->pushError (__('File not saved', WCU_LANG_CODE));
				}
			} else {
				$res->pushError (__('Bad file format', WCU_LANG_CODE));
			}
		}
        $res->ajaxExec();
	}

	public function removeCustomlag() {
		$res = new responseWcu();
		$data = reqWcu::get('post');
		$data = $data['data'];
		$uploaddir = frameWcu::_()->getModule('flags')->getModDir()."img/temp";

		foreach ($data as $img) {
			$imageName = $img;
			$pathToFile = $uploaddir.'/'.$imageName;
			if (!unlink($pathToFile)) {
				$res->pushError (__('Cannot unlink custom image flag', WCU_LANG_CODE));
			}
		}

		$res->ajaxExec();
	}

	public function getPermissions() {
		return array(
			WCU_USERLEVELS => array(
				WCU_ADMIN => array('removeCustomlag', 'saveCustomFlag')
			),
		);
	}
}
