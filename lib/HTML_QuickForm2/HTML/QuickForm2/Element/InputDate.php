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
class HTML_QuickForm2_Element_InputDate extends HTML_QuickForm2_Element
{
   /**
    * 'type' attribute should not be changeable
    * @var array
    */
    protected $persistent = true;
    protected $attributes = array('type' => 'text');
    protected $watchedAttributes = array('id', 'name', 'type');
    protected function onAttributeChange($name, $value = null)
    {
        if ('type' == $name) {
            throw new HTML_QuickForm2_InvalidArgumentException(
                "Attribute 'type' is read-only"
            );
        }
        parent::onAttributeChange($name, $value);
    }

    public function getType()
    {
        return $this->attributes['type'];
    }

    public function setValue($value)
    {
        $this->value = $value;
		$this->setAttribute('value', (string)$value);
        return $this;
    }

    public function getRawValue()
    {
        return $this->getAttribute('disabled')? null: $this->getAttribute('value');
    }
    public function __toString()
    {
		if ($this->frozen) {
            return $this->getFrozenHtml();
        } else{
			$str ='
			<input class="span6 m-wrap small mask_date2" '.$this->getAttributes(true).' type="text"  />
			';
			return $str;
		}
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