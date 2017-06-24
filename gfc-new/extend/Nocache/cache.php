<?php
namespace Nocache;
/**
 * nosql 基类
 * 抽象类
 */
abstract class cache{
	public $settings = null;
	public $server = null;
	public $connect_failure = null;
	public $livetime = 60;
	public $fake = false;

	//允许不同nosql实例
	static protected $_instance = array();
	abstract function connect();
	abstract function get($prefix, $key);
	abstract function gets($prefix, $keys);
	abstract function set($prefix, $key, $value, $expire = 60);
	abstract function sets($prefix, $data, $expire = 60);
	abstract function delete($prefix, $key);
	abstract function deletes($prefix, $keys);
	abstract function inc($prefix, $key, $step = 1);
	abstract function dec($prefix, $key, $step = 1);
	abstract function close();
}