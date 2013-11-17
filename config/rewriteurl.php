<?php
/*
******************************************************************************************   

  Package            : Dezhub  [ Web Application Framework ]
  Version            : 2.0.1
      
  Lead Architect     : Hung Dinh. [ dinhhungvn@gmail.com ]     
  Year               : 2013 - 2014                                                      

  Site               : http://www.dezhub.com/
  Contact / Support  : dinhhungvn@gmail.com

  Copyright (C) 2013 by Dezhub

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in
  all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
  THE SOFTWARE.
  
******************************************************************************************   
*/

class rewrite_url{
	var $list_url;
	function __construct(){
		$i=0;
		if(checkMultiLang()){
			$langk="[A-z-]+/";
			$langt="&lang=[0]";
			$i=1;
		}
		self::add_rule(array(
			"{$langk}news"=>"mod=post&task=home{$langt}"
		));
		self::add_rule(array(
			"{$langk}product"=>"mod=product"
		));
		self::add_rule(array(
			"{$langk}product/[A-z0-9-]+"=>"mod=product&task=list&post_id=[".($i+1)."]{$langt}"
		));
		self::add_rule(array(
			"{$langk}product/[A-z0-9-]+/page/[A-z0-9-]+"=>"mod=product&task=list&post_id=[".($i+1)."]&page=[".($i+3)."]{$langt}"
		));
		self::add_rule(array(
			"{$langk}product/[A-z0-9-]+/[A-z0-9-]+"=>"mod=product&task=view&gid=[".($i+1)."]&post_id=[".($i+2)."]{$langt}"
		));
		self::add_rule(array(
			"{$langk}contact"=>"mod=contact"
		));
		self::add_rule(array(
			"{$langk}news/[A-z0-9-]+"=>"mod=post&task=list&post_id=[".($i+1)."]{$langt}"
		));
		self::add_rule(array(
			"{$langk}news/[A-z0-9-]+/[0-9]+"=>"mod=post&task=list&post_id=[".($i+1)."]&page=[".($i+2)."]{$langt}"
		));
		self::add_rule(array(
			"{$langk}news/[A-z0-9-]+/[A-z0-9-]+"=>"mod=post&task=view&gid=[".($i+1)."]&post_id=[".($i+2)."]{$langt}"
		));
		
		self::add_rule(array(
			"{$langk}[A-z0-9-]+"=>"mod=page&page_id=[$i]{$langt}"
		));
	}
	
	function add_rule($url=array()){
		$this->list_url[]=$url;
		
	}
	function Navigation(){
		//var_dump($this->list_url);
		$url = $_SERVER['REQUEST_URI'];
		$query = parse_url($url);
		if($query['path']){
			$url = $query['path'];
		}
		$url = preg_replace("/^\//","",$url);
		$url = preg_replace("/\/$/","",$url);
		$_lurl = explode("/",$url);
		
		foreach($this->list_url as $key=> $val){
			$rex = key($val);
			$value = $val[$rex];
			$rex = preg_replace("/\//","\/",$rex);
			if(preg_match("/^{$rex}$/i",$url)){
				parse_str($value,$output);
				foreach($output as $k=>$v){
					if(preg_match("/^\[[0-9]\]/",$v)){
						$index = preg_replace("/[\[\]]/","",$v);
						$v = $_lurl[$index];
					}
					$_GET[$k] = $v;
					$_REQUEST[$k] = $v;
				}
				break;
				
			}
			
		}
		if($query['query']){
			parse_str($query['query'], $output);
			foreach($output as $k=>$v){
				$_GET[$k] = $v;
				$_REQUEST[$k] = $v;
			}
		}
		
	}
}
?>