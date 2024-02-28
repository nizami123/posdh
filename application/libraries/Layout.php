<?php
#[\AllowDynamicProperties]
class Layout {
    public $template_data = [];
    function set($name, $value) {
        $this->template_data[$name] = $value;
    }
    function load($template = '', $view = '', $view_data = [], $return = false) {
        $this->CI =& get_instance();
        $this->set('contents', $this->CI->load->view($view, $view_data, true)); 
        return $this->CI->load->view($template, $this->template_data, $return);
    } 
}