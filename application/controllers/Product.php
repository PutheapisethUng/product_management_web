<?php 
class Product extends CI_Controller
{
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
	}

	const API_URL = "http://localhost:5000/";
	protected function getParameter() {
		return $_POST;
	}

	protected function callAPI($method, $url, $params, $isfile) {
		$ch = curl_init();

		switch ($method){
			case "POST":
				curl_setopt($ch, CURLOPT_POST, 1);
				break;
			case "GET":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
				break;
			case "DELETE":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");	 					
				break;
			case "PUT":
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				
				break;
			default:
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		}

		if($isfile) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
		} else {
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));				
		}

		curl_setopt($ch, CURLOPT_URL, Product::API_URL.$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);
		curl_close($ch);
		return json_decode($response);
	}

	public function index()
	{
		$data = array();
		$response = $this->callAPI("GET", "products/", $data , true);
		$array = json_decode(json_encode($response), True);
		$this->load->view('product' ,$array);
	}

	function create_product(){
		$params = $this->getParameter();

		$data = array();
		$data['productName'] = $params['productName'];
		$data['price'] = $params['price'];
		$data['discount'] = $params['discount'];
		$data['description'] = $params['description'];

		$cfiles = new CURLFile($_FILES['productImage']['tmp_name'], $_FILES['productImage']['type'], $_FILES['productImage']['name']);

		$data['productImage'] = $cfiles;

		$response = $this->callAPI("POST", "products/", $data, true);

		$error = array();
			$error['heading'] = "Insert Error";
			$error['message'] = "There is an error while insert product";

		if(!$response){
			$this->load->view('errors/cli/error_404' , $error);
			return;
		} else {
			$array_response = json_decode(json_encode($response), True);
			if($array_response['error']['message'])
			{
				if(isset($array_response['error']['name'])){
					$error['heading'] = $array_response['error']['name'];
				}
				if(isset($array_response['error']['message'])){
					$error['message'] = $array_response['error']['message'];
				}
				$this->load->view('errors/cli/error_404' , $error);
				return;
			}
			redirect('/product');
		}
	}
	
	function update_product($id){
		$params = $this->getParameter();

		$data = array();
		$data['productName'] = $params['productName'];
		$data['price'] = $params['price'];
		$data['discount'] = $params['discount'];
		$data['description'] = $params['description'];

		if ($_FILES['productImage']['tmp_name'] != "") {
			$cfiles = new CURLFile($_FILES['productImage']['tmp_name'], $_FILES['productImage']['type'], $_FILES['productImage']['name']);
			$data['productImage'] = $cfiles;
			$response = $this->callAPI("PUT", "products/upload/".$id, $data , true);
		} else {
			$response = $this->callAPI("PUT", "products/".$id, $data , false);
		}

		$error = array();
		$error['heading'] = "Update Error";
		$error['message'] = "There is an error while update product";

		if(!$response){
			$this->load->view('errors/cli/error_404' , $error);
			return;
		} else {
			$array_response = json_decode(json_encode($response), True);
			if($array_response['error']['message'])
			{
				if(isset($array_response['error']['name'])){
					$error['heading'] = $array_response['error']['name'];
				}
				if(isset($array_response['error']['message'])){
					$error['message'] = $array_response['error']['message'];
				}
				$this->load->view('errors/cli/error_404' , $error);
				return;
			}
			redirect('/product');
		}
	}
}