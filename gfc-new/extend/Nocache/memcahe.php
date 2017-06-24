<?php
namespace  Nocache;
use Nocache\cache;
require_once 'cache.php';
class mcache extends cache{
    public $connected = null;
    public $mcpool = null;
    public $prefix = 'gfc_memcache';
    public function __construct($settings='http://127.0.0.1:11211'){
        $this->settings =  parse_url($settings);
        if(!extension_loaded('Memcache')){
            $this->fake = true;
        }
        $this->connect();
    }
    public function connect(){
        $this->mcpool = new \Memcache();
        $server = $this->settings;
        if(@$this->mcpool->addServer($server['host'],$server['port']) === true){
           return  true;
        }else{
           return false;
        }

    }

    /**
     * 生成前缀
     * @param $prefix
     * @return string
     */
    protected  function  getPrefix($prefix){
        return $this->prefix.'_'.$prefix.'_';
    }

    /**
     * 生成返回结果
     * @param string $result
     * @return bool|string
     */
    protected  function getResult($result = ''){
        if($result){
            return $result;
        }
        return false;
    }

    /**
     * 判断是否可用和连接
     * @return bool
     */
    protected  function can_use(){
        if($this->fake){
            return false;
        }
        if($this->connect()===false){
            return false;
        }
        return true;
    }
    /**
     * 获取
     * @param $prefix
     * @param $key
     * @return bool|string
     */
    public function get($prefix, $key)
    {
        if(!$this->can_use()){
            return false;
        }
        $result = $this->mcpool->get($this->getPrefix($prefix).$key);
        return $this->getResult($result);
    }

    /**
     * 批量获取
     * @param $prefix
     * @param $keys
     * @return bool
     */
    public function gets($prefix, $keys)
    {
        if(!$this->can_use()){
            return false;
        }
        $result = [];
        foreach ($keys as $v){
            $result[] = $this->mcpool->get($this->getPrefix($prefix).$v);
        }
        return  $result;
    }

    /**
     * 设置
     * @param string $prefix 赋值前缀
     * @param $key  key值
     * @param $value
     * @param int $expire 过期时间
     * @return bool
     */
    public function set($prefix='', $key, $value, $expire = 60)
    {

        if(!$this->can_use()){
            return false;
        }
        $result = $this->mcpool->set($this->getPrefix($prefix).$key,$value,false,$expire);
        return $this->getResult($result);
    }

    /**
     * 批量设置
     * @param $prefix
     * @param $data
     * @param int $expire
     * @return bool
     */
    public function sets($prefix, $data, $expire = 60)
    {
        if(!$this->can_use()){
            return false;
        }
        foreach ($data as $k => $v){
           $tmp = @$this->mcpool->set($this->getPrefix($prefix).$k,$v,false,$expire);
        }
        return $this->getResult($tmp);
    }

    /**
     * 删除
     * @param $prefix
     * @param $key
     */
    public function delete($prefix, $key)
    {
        if(!$this->can_use()){
            return false;
        }
        $result = $this->mcpool->delete($this->getPrefix($prefix).$key);
        return $this->getResult($result);
    }

    /**
     * 批量删除
     * @param $prefix
     * @param $keys
     * @return bool|string
     */
    public function deletes($prefix, $keys)
    {
        if(!$this->can_use()){
            return false;
        }
        foreach ($keys as $v){
            $tmp = $this->mcpool->delete($this->getPrefix($prefix).$v);
        }
        return $this->getResult($tmp);
    }

    /**
     * 自增
     * @param $prefix
     * @param $key
     * @param int $step
     */
    public function  inc($prefix, $key, $step = 1)
    {
        if(!$this->can_use()){
            return false;
        }
        $result = $this->mcpool->increment($this->getResult($prefix).$key, $step);
        return $this->getResult($result);
    }

    /**
     * 自减
     * @param $prefix
     * @param $key
     * @param int $step
     */
    public function dec($prefix, $key, $step = 1)
    {
        if(!$this->can_use()){
            return false;
        }
        $result = $this->mcpool->decrement($this->getResult($prefix).$key, $step);
        return $this->getResult($result);
    }

    public  function close()
    {

    }

    /**
     * 清空
     * @return bool
     */
    public function flush() {
        if(!$this->can_use()){
            return false;
        }
        return $this->mcpool->flush();
    }

    /**
     * 获取状态值
     * @return bool
     */
    public function getStats() {
        if(!$this->can_use()){
            return false;
        }
        return $this->mcpool->getStats();
    }

}