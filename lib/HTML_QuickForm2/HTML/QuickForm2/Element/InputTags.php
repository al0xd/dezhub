<?php
/**
	
/**
 * Base class for simple HTML_QuickForm2 elements (not Containers)
 */
require_once 'HTML/QuickForm2/Element.php';

/**
 * Base class for <input> elements
 *
	F: InputStrengPassword
	D: Xay dung form kiem tra do manh cua mat khau
	A: Dinh van Hung
	w: www.dezhub.com
 * @license  http://opensource.org/licenses/bsd-license.php New BSD License
 * @version  Release: 2.0.0
 * @link     http://pear.php.net/package/HTML_QuickForm2
 */
class HTML_QuickForm2_Element_InputTags extends HTML_QuickForm2_Element
{
   /**
    * 'type' attribute should not be changeable
    * @var array
    */
    protected $value = null;
    protected $watchedAttributes = array('id', 'name', 'type');


    public function getType()
    {
        return $this->attributes['type'];
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getRawValue()
    {
        return $this->getAttribute('disabled')? null: $this->getAttribute('value');
    }

    public function __toString()
    {
		$str ='
		<input type="hidden" value="'.$this->value.'" class="span6 select2 inputTags"'.$this->getAttributes(true).'>
		<div class="clearfix"></div><p class="help-block">Nhập từ khóa sau đó ấn <strong>Enter</strong> để xác nhận hoăc chọn từ khóa từ danh sách</p>
		';
		return $str;
    }

   /**
    * Returns the field's value without HTML tags
    * @return string
    */
    protected function getFrozenHtml()
    {
        $value = $this->getAttribute('value');
        return (('' != $value)? htmlspecialchars($value, ENT_QUOTES, self::getOption('charset')): '&nbsp;') .
               $this->getPersistentContent();
    }
}
?>