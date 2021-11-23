<?php
class Model_login extends CI_Model{
	//cek nip dan password dosen
	function cek_login($table,$where){		
		return $this->db->get_where($table,$where);
	}	

	// cek username login
	public function cek_user_login($username)
	{
		$this->db->select('p.username, l.level, p.sha, l.id_level, p.id_pengguna');
		$this->db->from('pengguna as p');
		$this->db->join('level as l', 'l.id_level = p.level', 'inner');
		$this->db->where('username', $username);
		$this->db->where('l.project', 3);

		return $this->db->get();
	}

}