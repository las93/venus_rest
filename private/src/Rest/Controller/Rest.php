<?php

/**
 * Controller of RestFull Bundle
 *
 * @category  	src
 * @package   	src\Rest\Controller
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus
 * @link      	https://github.com/las93
 * @since     	1.0
 */

namespace Venus\src\Rest\Controller;

use \Venus\lib\Entity as LibEntity;
use \Venus\lib\Response as Response;
use \Venus\src\Rest\common\Controller as Controller;

/**
 * Controller  of RestFull Bundle
 *
 * @category  	src
 * @package   	src\Rest\Controller
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus
 * @link      	https://github.com/las93
 * @since     	1.0
 */

class Rest extends Controller {

	/**
	 * Constructor
	 *
	 * @access public
	 * @return object
	 */

	public function __construct() {

		parent::__construct();
	}

	/**
	 * The get method for the RestFull Web Service
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */

	public function get($sEntity, $iId) {

		$sClassNameEntity = '\Venus\src\Helium\Entity\\'.$sEntity;
		$sClassNameModel = '\Venus\src\Helium\Model\\'.$sEntity;
		
		if (class_exists($sClassNameEntity)) {
			
			$oClassNameEntity = new $sClassNameEntity;
			$sPrimaryKeyName = LibEntity::getPrimaryKeyName($oClassNameEntity);
			$sMethodName = 'findBy'.$sPrimaryKeyName;
			
			$oClassNameModel = new $sClassNameModel;
			
			$aResults = $oClassNameModel->$sMethodName($iId);
		}
		else {
			
			$aResults = array();
		}

		echo Response::translate($aResults);
	}

	/**
	 * The delete method for the RestFull Web Service
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */

	public function delete($sEntity, $iId = null) {

		;
	}

	/**
	 * The put method for the RestFull Web Service
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */

	public function put($sEntity, $iId = null) {

		;
	}

	/**
	 * The post method for the RestFull Web Service
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */

	public function post($sEntity, $iId = null) {

		;
	}

	/**
	 * The options method for the RestFull Web Service
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */

	public function options($sEntity, $iId = null) {

		;
	}

	/**
	 * The head method for the RestFull Web Service
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */

	public function head($sEntity, $iId = null) {

		;
	}
}