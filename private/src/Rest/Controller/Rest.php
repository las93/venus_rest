<?php

/**
 * Controller of RestFull Bundle
 *
 * @category  	src
 * @package   	src\Rest\Controller
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus_rest/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus_rest
 * @link      	https://github.com/las93
 * @since     	1.0
 */
namespace Venus\src\Rest\Controller;

use \Venus\core\Config as Config;
use \Venus\lib\Entity as LibEntity;
use \Venus\lib\Http as Http;
use \Venus\lib\Response as Response;
use \Venus\src\Rest\common\Controller as Controller;

/**
 * Controller  of RestFull Bundle
 *
 * @category  	src
 * @package   	src\Rest\Controller
 * @author    	Judicaël Paquet <judicael.paquet@gmail.com>
 * @copyright 	Copyright (c) 2013-2014 PAQUET Judicaël FR Inc. (https://github.com/las93)
 * @license   	https://github.com/las93/venus_rest/blob/master/LICENSE.md Tout droit réservé à PAQUET Judicaël
 * @version   	Release: 1.0.0
 * @filesource	https://github.com/las93/venus_rest
 * @link      	https://github.com/las93
 * @since     	1.0
 */
class Rest extends Controller
{    
	/**
	 * Constructor
	 *
	 * @access public
	 * @return object
	 */
	public function __construct() 
	{
		parent::__construct();
	}

	/**
	 * The get method for the RestFull Web Service
	 *   http://localhost:83/user/2 (HTTP GET) > to select one user
	 *   http://localhost:83/user   (HTTP GET) > to select all user
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */
	public function get($sEntity, $iId = 0) 
	{
	    $oAccessConfig = Config::get('Access');
	    $oDbConfig = Config::get('Db')->configuration;
	    $sBundleName = Config::getBundleLocationName('Db');
	    
		$sClassNameEntity = '\Venus\src\\'.$sBundleName.'\Entity\\'.$sEntity;
		$sClassNameModel = '\Venus\src\\'.$sBundleName.'\Model\\'.$sEntity;

		if (isset($oAccessConfig->allowed) && isset($oAccessConfig->allowed->$sEntity)
            && in_array('select', $oAccessConfig->allowed->$sEntity, true) && class_exists($sClassNameEntity)) {
   
			$oClassNameEntity = new $sClassNameEntity;
			$sPrimaryKeyName = LibEntity::getPrimaryKeyName($oClassNameEntity);
			$sMethodName = 'findBy'.$sPrimaryKeyName;
	
			$oClassNameModel = new $sClassNameModel;
			
			if ($iId > 0) {
			
			    $aResults = $oClassNameModel->$sMethodName($iId);
			}
			else {

			    $aResults = $oClassNameModel->findAll();
			}
			
			if (count($aResults) > 0) { Http::setStatus(200); }
			else { Http::setStatus(204); }
		}
		else {
			
			$aResults = array();
			Http::setStatus(403);
		}

		echo Response::translate($aResults);
	}

	/**
	 * The delete method for the RestFull Web Service
	 *   http://localhost:83/user/2 (HTTP DELETE) > to delete one user
	 *   http://localhost:83/user   (HTTP DELETE) > to truncate table
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */
	public function delete($sEntity, $iId = null) 
	{
	    $oAccessConfig = Config::get('Access');
	    $oDbConfig = Config::get('Db')->configuration;
	    $sBundleName = Config::getBundleLocationName('Db');
	    
		$sClassNameEntity = '\Venus\src\\'.$sBundleName.'\Entity\\'.$sEntity;
		$sClassNameModel = '\Venus\src\\'.$sBundleName.'\Model\\'.$sEntity;
		
		if (isset($oAccessConfig->allowed) && isset($oAccessConfig->allowed->$sEntity)
            && in_array('delete', $oAccessConfig->allowed->$sEntity, true) && class_exists($sClassNameEntity)) {
			
			if ($iId > 0) {

			    $oClassNameEntity = new $sClassNameEntity;
			    $sPrimaryKeyName = LibEntity::getPrimaryKeyName($oClassNameEntity);
			    $sMethodName = 'set_'.$sPrimaryKeyName;

			    $oClassNameEntity->$sMethodName($iId)
			                     ->remove();
			    
			    $bReturn = true;
			    Http::setStatus(200);
			}
			else {
			    
			    $oClassNameModel = new $sClassNameModel;
		        $oClassNameModel->truncate();
			    $bReturn = true;
                Http::setStatus(200);
			}
		}
		else {
			
			$bReturn = false;
            Http::setStatus(403);
		}

		echo Response::translate($bReturn);
	}

	/**
	 * The put method for the RestFull Web Service
	 *   http://localhost:83/user/2 (HTTP PUT) > to insert one user or update if it exists
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */
	public function put($sEntity, $iId) 
	{
	    $_PUT = Http::getPut();
	    
	    if (count($_PUT) > 0) {

    	    $oAccessConfig = Config::get('Access');
    	    $oDbConfig = Config::get('Db')->configuration;
    	    $sBundleName = Config::getBundleLocationName('Db');
    	    
    		$sClassNameEntity = '\Venus\src\\'.$sBundleName.'\Entity\\'.$sEntity;
    		$sClassNameModel = '\Venus\src\\'.$sBundleName.'\Model\\'.$sEntity;
    		
    		if (isset($oAccessConfig->allowed) && isset($oAccessConfig->allowed->$sEntity)
                && in_array('put', $oAccessConfig->allowed->$sEntity, true) && class_exists($sClassNameEntity)) {
    
    		    $oClassNameEntity = new $sClassNameEntity;
    		    $sPrimaryKeyName = LibEntity::getPrimaryKeyName($oClassNameEntity);
    		    $sMethodNameNotUsed = 'set_'.$sPrimaryKeyName;
    		    $oClassNameEntity->$sMethodNameNotUsed($iId);
    		    
    		    foreach ($_PUT as $sKey => $sValue) {
    		        
    		        $sMethodName = 'set_'.$sKey;

    		        if ($sMethodNameNotUsed !== $sMethodName) { $oClassNameEntity->$sMethodName($sValue); }
    		    }
    
    		    $oClassNameEntity->save(true);
    			    
    		    $bReturn = true;
                Http::setStatus(201);
    		}
    		else {
    			
    			$bReturn = false;
                Http::setStatus(403);
    		}
	    }
	    else {

	        $bReturn = false;
            Http::setStatus(403);
	    }

		echo Response::translate($bReturn);
	}

	/**
	 * The post method for the RestFull Web Service
	 *   http://localhost:83/user/2 (HTTP POST) > to update one user
	 *   http://localhost:83/user   (HTTP POST) > to insert one user
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */
	public function post($sEntity, $iId = null) 
	{
	    if (count($_POST) > 0) {

    	    $oAccessConfig = Config::get('Access');
    	    $oDbConfig = Config::get('Db')->configuration;
    	    $sBundleName = Config::getBundleLocationName('Db');
    	    
    		$sClassNameEntity = '\Venus\src\\'.$sBundleName.'\Entity\\'.$sEntity;
    		$sClassNameModel = '\Venus\src\\'.$sBundleName.'\Model\\'.$sEntity;
    		
    		if (isset($oAccessConfig->allowed) && isset($oAccessConfig->allowed->$sEntity)
                && in_array('put', $oAccessConfig->allowed->$sEntity, true) && class_exists($sClassNameEntity)) {
    
    		    if ($iId > 0) {
        		    
        		    $oClassNameEntity = new $sClassNameEntity;
        		    $sPrimaryKeyName = LibEntity::getPrimaryKeyName($oClassNameEntity);
        		    $sMethodName = 'set_'.$sPrimaryKeyName;
        		    $oClassNameEntity->$sMethodName($iId);
        		    
        		    foreach ($_POST as $sKey => $sValue) {
    
        		        $sMethodName = 'set_'.$sKey;
        		        $oClassNameEntity->$sMethodName($sValue);
        		    }
        
        		    $iUpdate = $oClassNameEntity->save();
        		    
         		    if ($iUpdate > 0) { 
         		        
         		        $bReturn = true;
                        Http::setStatus(201);
         		    }
         		    else { 
         		        
         		        $bReturn = false;
                        Http::setStatus(403);
         		    }
    		    }
    		    else {
        		    
        		    $oClassNameEntity = new $sClassNameEntity;
        		    $sPrimaryKeyName = LibEntity::getPrimaryKeyName($oClassNameEntity);
        		    $sMethodNameNotUsed = 'set_'.$sPrimaryKeyName;
        		    
        		    foreach ($_POST as $sKey => $sValue) {

        		        $sMethodName = 'set_'.$sKey;
        		        
        		        if ($sMethodNameNotUsed !== $sMethodName) { $oClassNameEntity->$sMethodName($sValue); }
        		    }
        
        		    $oClassNameEntity->save();

        		    $bReturn = true;
                    Http::setStatus(201);
    		    }
    		}
    		else {
    			
    			$bReturn = false;
                Http::setStatus(403);
    		}
	    }
	    else {

	        $bReturn = false;
            Http::setStatus(403);
	    }

		echo Response::translate($bReturn);
	}

	/**
	 * The options method for the RestFull Web Service
	 *   http://localhost:83/user/2 (HTTP OPTIONS) > send the all method allowed for this entity
	 *
	 * @access public
	 * @param  string $sEntity
	 * @param  int $iId
	 * @return void
	 */
	public function options($sEntity, $iId = null)
	{
	    $oAccessConfig = Config::get('Access');
    	$oDbConfig = Config::get('Db')->configuration;
    	$sBundleName = Config::getBundleLocationName('Db');
    	    
    	$sClassNameEntity = '\Venus\src\\'.$sBundleName.'\Entity\\'.$sEntity;
	    
	    if (isset($oAccessConfig->allowed) && isset($oAccessConfig->allowed->$sEntity) && class_exists($sClassNameEntity)) {
	    
	        $sAllow = '';
	        
	        foreach ($oAccessConfig->allowed->$sEntity as $sOne) {
	            
	            if (($iId > 0 && $sOne === 'put') || $sOne !== 'put') {
	            
	                $sAllow .= ' '.strtoupper($sOne).',';
	            }
	        }

	        if (count($oAccessConfig->allowed->$sEntity) > 0) { $sAllow = substr($sAllow, 0, -1); }
	        
	    }

	    header("Allow: ".$sAllow);
	    Http::setStatus(200);
	}
}