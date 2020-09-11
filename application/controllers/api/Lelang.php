<?php

defined('BASEPATH') or exit('No direct script access allowed');

// ini berguna untuk import class dari library RestServer
use chriskacerguis\RestServer\RestController;

// class Lelang di extend denngan RestController supaya dapat digunakan sebagai controller untuk web service kita
class Lelang extends RestController
{

	// method ini untuk mengambil data menggunakan metode GET berparameter id barang
	public function index_get($id = 0)
	{
		// selanjutnya dibuat percbangan ketika kondisi paramater id tidak kosong, maka akan ditampilkan data barang berdasarkan id barang
		if (!empty($id)) {
			$data = $this->db->get_where("tb_barang", ['id_barang' => $id])->row_array();
		} 
		// namun ketika paramater id kosong, maka akan ditampilkan seluruh data barang
		else {
			$data = $this->db->get("tb_barang")->result();
		}

		// selanjutnya, data dan kode 200 success akan dimasukkan kedalam response
		$this->response($data, RestController::HTTP_OK);
	}

	// method ini untuk memasukkan data barang menggunakan metode POST
	public function index_post()
	{
		// masukkan input dari pengambilan data melalui metode POST ke dalam variable input
		$input = $this->input->post();

		// masukkan data barang ke dalam table yang telah ditentukan
		$this->db->set('tanggal_upload', 'NOW()', FALSE);
		$this->db->insert('tb_barang', $input);

		// masukkan pesan sukses dan status kode 200 success ke dalam response
		$this->response(['Item created is successfully.'], RestController::HTTP_OK);
	}

	// method ini untuk mengedit data barang menggunakan metode PUT yang berparameter id barang
	public function index_put($id)
	{
		// masukkan input dari pengambilan data melalui metode PUT ke dalam variable input
		$input = $this->put();
		// mengedit data barang di dalam table yang telah ditentukan sesuai dengan id barang
		$this->db->set('tanggal_upload', 'NOW()', FALSE);
		$this->db->update('tb_barang', $input, array('id_barang' => $id));

		// masukkan pesan sukses dan status kode 200 success ke dalam response
		$this->response(['Item updated is successfully.'], RestController::HTTP_OK);
	}

	// method ini untuk mengahpus data barang menggunakan metode DELETE yang berparameter id barang
	public function index_delete($id)
	{
		// menghapus data barang di dalam table yang telah ditentukan sesuai dengan id barang
		$this->db->delete('tb_barang', array('id_barang' => $id));

		// masukkan pesan sukses dan status kode 200 success ke dalam response
		$this->response(['Item deleted is successfully.'], RestController::HTTP_OK);
	}
}
