<?php
include('../init.php');if($user->adminLevel<=0) die('Access Denied');define('ADMIN_PATH',dirname(__FILE__));define('TEMPLATE_PATH',dirname(__FILE__));$do=Val('do','GET',0);$dos=array('admin_index','admin_module');if(!in_array($do,$dos)) $do='admin_index';include(ADMIN_PATH.'/source/'.$do.'.php');
?>