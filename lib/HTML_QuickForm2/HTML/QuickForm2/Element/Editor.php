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
class HTML_QuickForm2_Element_Editor extends HTML_QuickForm2_Element
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
        return $this->getAttribute('disabled')? null: $this->value;
    }

    public function __toString()
    {
		$sURL = SITE_URL."lib/";
		$bbcode = "";

		if($this->attributes['data-bbcode']==true){
			$bbcode = ",bbcode";
		}
	$skin='moono';

		if($this->attributes['data-type']=='small'){

			$str="<textarea cols=\"30\" id=\"{$this->attributes['name']}_editor\" name=\"{$this->attributes['name']}\" rows=\"10\">{$this->value}</textarea>
			<script>
	
				// Replace the <textarea id=\"editor\"> with an CKEditor
				// instance, using default configurations.
				CKEDITOR.replace( '{$this->attributes['name']}_editor', {
					toolbar: [
						[ 'Bold', 'Italic','RemoveFormat'],
						[ 'Font','FontSize' ],
						['Link','Unlink'],
						['Paste','PasteText','PasteFromWord'],
						['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
						[ 'UIColor' ], ['Maximize']
					]
				});
		
	
			</script>";

		}
		else{
		$str="<textarea cols=\"200\" id=\"{$this->attributes['name']}_editor\" name='{$this->attributes['name']}' class=\"ckeditor\"  rows=\"10\">{$this->value}</textarea>";
		$str.="	<script type=\"text/javascript\">

			//<![CDATA[



				// This call can be placed at any point after the

				// <textarea>, or inside a <head><script> in a

				// window.onload event handler.



				// Replace the <textarea id=\"editor\"> with an CKEditor

				// instance, using default configurations.

			CKEDITOR.replace( '{$this->attributes['name']}_editor',
			
{
filebrowserBrowseUrl : '{$sURL}ckfinder/ckfinder.html',

filebrowserImageBrowseUrl : '{$sURL}ckfinder/ckfinder.html?type=Images',

filebrowserFlashBrowseUrl : '{$sURL}ckfinder/ckfinder.html?type=Flash',

filebrowserUploadUrl : '{$sURL}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',

filebrowserImageUploadUrl : '{$sURL}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

filebrowserFlashUploadUrl : '{$sURL}ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',

filebrowserWindowWidth : '1000',

filebrowserWindowHeight : '500',

});

CKEDITOR.config.language = 'vi';
CKEDITOR.config.height='200';
CKEDITOR.config.extraPlugins='layout,dzcustom,oembed{$bbcode}';
//]]>
</script>";
		}

		 if ($this->frozen) {
            return $this->getFrozenHtml();
        } else 
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