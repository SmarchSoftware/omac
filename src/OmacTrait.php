<?php

namespace Smarch\Omac;

trait OmacTrait {

	/**
	 * 
	 * @param [boolean] $acl	Whether or not ACL is enabled
	 * @param [string]	$driver Which method of authorization to use
	 * 
	 */
	var $acl = false;
	var $driver = 'laravel';

	/**
	 * Will check user access depending on the driver being used.
	 * Defaults to using laravel Auth Guard driver
	 * 
	 * @param  [string] $permission	Necessary permission to check
	 * @param  [mixed] $arguments	Additional arguments to pass
	 * @return [boolean]
	 */
	protected function checkAccess($permission, $arguments = '') {
		if ( $this->acl === false )
			return true;
			
		$driver = "acl" . ucfirst( $this->driver );

		return $this->$driver($permission, $arguments);
	}


	/**
	 * Using Laravel Authorization Driver
	 * 
	 * @param  [string] $permission
	 * @param  [mixed] $arguments	Additional arguments to pass
	 * @package Laravel\Gate
	 * @return boolean
	 */
	protected function aclLaravel($permission, $arguments) {
		return \Auth::user()->can($permission, $arguments);
	}


	/**
	 * Using Shinobi Authorization Driver
	 * 
	 * @param  [string] $permission
	 * @param  [mixed] $arguments	Additional arguments to pass
	 * @package Caffeinated\Shinobi
	 * @return boolean
	 */
	protected function aclShinobi($permission, $arguments) {
		return \Shinobi::can($permission, $arguments);
	}


	/**
	 * Using Sentinel Authorization Driver
	 * 
	 * @param  [string] $permission
	 * @param  [null] $arguments None. Sentinel doesn't support arguments
	 * @package Cartalyst\Sentinel
	 * @return boolean
	 */
	protected function aclSentinel($permission, $arguments = NULL) {
		return \Sentinel::hasAccess($permission);
	}


	/**
	 * Using Entrust Authorization Driver
	 * 
	 * @param  [string] $permission
	 * @param  [bool] $arguments
	 * @package Zizaco\Entrust
	 * @return boolean
	 */
	protected function aclEntrust($permission, $arguments = false) {
		return \Entrust::can($permission, $arguments);
	}
}