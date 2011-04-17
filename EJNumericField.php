<?php
/** 
 * EJNumericField 
 * ==============
 * Yii numeric textfield with jqurey.
 * 
 * < rawtaz> tydeas: not sure but you can take the string, pass it through preg_quote() and if the result of that is !== the original
 *                string, then the string did contain something that needed quoting, yes
 * @author Dimitrios Mengidis
 * @version 0.1 
 */
class EJNumericField extends CInputWidget
{
    /** Units separator.
     * 
     * @var string
     * @since 0.1
     */
    public $seperator =  ".";
    /** Jquery selector.
     *  This string if set will be used as 1st param to 
     * the jquery <code>live()</code>.
     *  If this property is not set then the <code>$id</code>
     * will be used as selector.
     * 
     * @var string
     * @since 0.1
     */
    public $selector;
    /** 
     * @var array the core scripts to register.
     * @since 0.1
     */
    private $core = array('jquery', 'jquery.ui');
    /**
     * @var array css files to register.
     * @since 0.1 
     */
    private $css = array();
    /**
     * @var array the js files to register.
     * @since 0.1
     */ 
    private $js  = array();
    /** 
     * @var array the php files that will be registered as js/css scripts.
     * @since 0.1
     */
    private $phpScript = array('ejnumericfield.js.php', 'ejnumericfield.css.php');
    /** 
     * @var string The asset folder after published.
     * @since 0.1
     */
    private $assets;
    /** 
     * @var integer Position of the js scripts to register
     * @since 0.1 
     */
    private $jsPosition = CClientScript::POS_READY;

    private function registerScripts()
    {
        $cs = Yii::app()->clientScript;
        $assets = dirname(__FILE__).DIRECTORY_SEPARATOR."assets".DIRECTORY_SEPARATOR;
        /**
        $this->assets = Yii::app()->getAssetManager()->publish($assets);

        foreach($this->css as $file)
        {
            $cs->registerCssFile($this->assets."/".$file);
        }**/
        foreach($this->core as $file) 
        {
            if(!$cs->isScriptRegistered($file)) {
                $cs->registerCoreScript($file);
            }
        }
        /**
        foreach($this->js as $file)
        {
            $cs->registerScriptFile($this->assets."/".$file, CClientScript::POS_END);
        }**/
        foreach($this->phpScript as $file) 
        {
            $script = require_once($assets.$file);
            if(preg_match('/\.js\.php$/i', $file) === 1) {
                if(!$cs->isScriptRegistered($file, $this->jsPosition))
                    $cs->registerScript($file,$script, $this->jsPosition);
            } else if(preg_match('/\.css\.php$/i', $file)) { 
                $cs->registerCss($file, $script);
            }
        }
    }
    public function init()
    {
        $nameid = $this->resolveNameID();
        
        if(!isset($this->htmlOptions['id'])) 
            $this->htmlOptions['id'] = $nameid[1];

        $this->name = $nameid[0];

        if(!isset($this->value)) { 
            $this->value = '';
        }

        if(!isset($this->selector)) 
            $this->selector = "#".$this->htmlOptions['id'];
        
        $this->registerScripts();
        parent::init();
    }
    public function run()
    {
        if(isset($this->model) && isset($this->attribute)) {
            echo CHtml::actvieTextField($this->model, $this->attribute, $this->htmlOptions );
        } else {
            echo CHtml::textField($this->name, $this->value, $this->htmlOptions);
        }
    }
}
