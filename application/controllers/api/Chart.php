<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mSuhu','suhu');
	}

	public function get_today()
	{
		$arr = array();
		$data = $this->suhu->get_today();
		foreach ($data as $value) {
			array_push($arr, $value->suhu);
		}
		echo json_encode($arr);
	}

	public function get_by_date()
	{
		$date_search = $this->input->post('date_search');
		// $date_search = "2020-02-06";
		$get_data = $this->suhu->get_by_date($date_search);

		$data = array();
		$i = 1;
		foreach ($get_data as $value) {
			$date = date_format(date_create($value->timestamp), 'd-m-Y');
			$time = date_format(date_create($value->timestamp), 'H:i:s');
			$temp_arr = array(
				'no' => $i,
				'date' => $date,
				'time' => $time,
				'suhu' => $value->suhu
			);

			array_push($data, $temp_arr);

			$i++;
		}

		$output = array(
			"draw"    => intval($this->input->post('draw')),
			"recordsTotal"  =>  $this->dataTotal(),
			"recordsFiltered" => $i-1,
			"data"    => $data
		);

		echo json_encode($output);	
	}

	public function dataTotal()
	{
		$get = $this->suhu->get();
		$i = 0;
		foreach ($get as $value) {
			$i++;
		}
		return $i;
	}
}

/* End of file Chart.php */
/* Location: ./application/controllers/api/Chart.php */