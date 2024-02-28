<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class P404 extends CI_Controller {
	function index() {
		$this->load->view('404');
	}
}
