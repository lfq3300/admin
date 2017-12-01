<?php 
namespace Admin\Builder;
use Think\View;
class AdminConfigBuilder extends AdminBuilder{
	 private $_title;
	 private $_data = array();
	 private $_keyList = array();
	 private $_formtitle = array();
     private $_buttonList = array();
     private $_savePostUrl = "";
	 public function title($title)
    {
        $this->_title = $title;
        return $this;
    }


    public function formtitle($title)
    {
        $this->_formtitle = $title;
        return $this;
    }
     public function key($name, $title, $subtitle = null, $type, $opt = null)
    {
        $key = array('name' => $name, 'title' => $title, 'subtitle' => $subtitle, 'type' => $type, 'opt' => $opt);
        $this->_keyList[] = $key;
        return $this;
    }

    public function data($list)
    {
        $this->_data = $list;
        return $this;
    }

    public function button($title, $attr = array())
    {
        $this->_buttonList[] = array('title' => $title, 'attr' => $attr);
        return $this;
    }
    public function savePostUrl($url)
    {
        if ($url) {
            $this->_savePostUrl = $url;
        }
    }
    /*
		$name from 表单提交name
		$title from 表单模块标题
		$subtitle from 表单模块副标题
		placeholder 提示文字
		error   警告文字
		$opt array("placeholder"=>"****","error"=>"****")
    */
    public function keyText($name,$title,$subtitle,$opt){
    	  return $this->key($name, $title, $subtitle,'text',$opt);
    }
    public function keyTime($name,$title,$subtitle,$opt){
        return $this->key($name, $title, $subtitle,'time',$opt);
    }
    public  function  keyRadio($name,$title,$subtitle,$opt){
        return $this->key($name, $title, $subtitle,'radio',$opt);
    }
    public function keyNumber($name,$title,$subtitle,$opt){
        return $this->key($name, $title, $subtitle,'textnumber',$opt);
    }

    public function keyDisabled($name,$title,$subtitle,$opt){
           return $this->key($name, $title, $subtitle,'textDisabled',$opt);
    }

    public function keyHidden($name,$title,$subtitle,$opt){
         return $this->key($name, $title, $subtitle,'hidden',$opt);
    }
    public function keyTextarea($name,$title,$opt){
   		 return $this->key($name, $title,'','textarea',$opt);
    }

    public function keySelect($name, $title, $subtitle = null, $opt,$value)
    {
        return $this->key($name, $title, $subtitle, 'select', $opt,$value);
    }
    public function keyOnSelect($name, $title, $subtitle = null, $opt,$value)
    {
        return $this->key($name, $title, $subtitle, 'noselect', $opt,$value);
    }
    public  function  keyOnSelectData($name, $title, $subtitle = null, $opt,$value){
        return $this->key($name, $title, $subtitle, 'selectdata', $opt,$value);
    }
    public function keyDisabledStatus($name, $title, $subtitle = null, $opt){
         return $this->key($name, $title, $subtitle, 'DisabledStatus', $opt);
    }

    public function buttonSubmit($url = '', $title = '确定')
    {
        $this->savePostUrl($url);
        $attr = array();
        $attr['class'] = "am-btn am-btn-primary tpl-btn-bg-color-success ajax-post";
        $attr['id'] = 'submit';
        $attr['type'] = 'submit';
        return $this->button($title, $attr);
    }

    public function keyUploadImg($name,$title ='上传图片', $subtitle,$btntitle = "上传图片"){
    	 return $this->key($name, $title, $subtitle,'uploadimg',array("btntitle"=>$btntitle));
    }
    public function keyUploadFalsh($name,$title, $subtitle,$btntitle = "上传动画"){
         return $this->key($name, $title, $subtitle,'uploadfalsh',array("btntitle"=>$btntitle));
    }
    public function keyShowImg($name,$title, $subtitle,$btntitle = "上传图片"){
         return $this->key($name, $title, $subtitle,'showimg',array("btntitle"=>$btntitle));
    }

    public function keyEditor($name, $title, $subtitle = null, $opt = array('style'=>"width:1224px;height:800px"))
    {
        $key = array('name' => $name, 'title' => $title, 'subtitle' => $subtitle, 'type' => 'editor', 'opt' => $opt);
        $this->_keyList[] = $key;
        return $this;
    }
    public function keySmallEditor($name, $title, $subtitle = null, $opt = array('style'=>"width:700px;height:50px"))
    {
        $key = array('name' => $name, 'title' => $title, 'subtitle' => $subtitle, 'type' => 'editor', 'opt' => $opt);
        $this->_keyList[] = $key;
        return $this;
    }

	public function display($solist = ''){
		foreach ($this->_buttonList as &$button) {
            $button['attr'] = $this->compileHtmlAttr($button['attr']);
        }
		foreach ($this->_keyList as &$e) {
			$e['value'] = $this->_data[$e['name']];
		}
		$this->assign('title', $this->_title);
        $this->assign('formtitle', $this->_formtitle);
		$this->assign('keyList', $this->_keyList);
		$this->assign('buttonList', $this->_buttonList);
		$this->assign('savePostUrl', $this->_savePostUrl);
        $this->assign('selectData', $this->_selectData);
		if ($solist) {
				parent::display($solist);
			} else {
				parent::display('admin_congif');
		}
	}
}
?>