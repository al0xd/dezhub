<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * @param array Format:
 * <pre>
 * array('name' => name of module)
 * </pre>
 * @param Smarty
 */
function smarty_function_loadModule($params, &$smarty)
{
	//use funct;
	 $module = $task = $otherParams = null;
    if(isset($params['name']))
		 $module = $params['name'];
		 
    if(isset($params['task']))
		 $task = $params['task'];
	 if(isset($params['otherParams']))
		 $otherParams= $params['otherParams'];
     loadModule($module, $task, $otherParams);
}

/* vim: set expandtab: */

?>
