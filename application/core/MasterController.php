<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require 'assets/vendor/autoload.php';

class MasterController extends CI_Controller
{

	protected $data;
	protected $load_models = [];
	protected $controller;

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('UTC');
		$this->load_models = array_merge(
			$this->load_models, []
		);
		$this->loadModels();
		$this->controller = mb_strtolower(get_class($this));
	}

	protected function isPost()
	{
		return $_SERVER['REQUEST_METHOD'] === 'POST' ? true : false;
	}

	protected function isAjax()
	{
		return $this->input->is_ajax_request();
	}

	protected function build($view)
	{
		if ($view) {
			$this->data['view'] = $view;
			$this->data['controller'] = $this->controller;
			$this->load->view('layouts/Default', $this->data);
		}
		return false;
	}


	public function _remap($method, $params = array())
	{
		if (method_exists($this, $method)) {
			return call_user_func_array(array($this, $method), $params);
		} else {
			return call_user_func_array(array($this, 'index'), array_merge((array)$method, $params));
		}
	}

	protected function loadModels()
	{
		foreach ($this->load_models as $model) {
			$this->load->model($model . "ModelMap");
			$this->load->model($model . "Model");
		}
	}
}
