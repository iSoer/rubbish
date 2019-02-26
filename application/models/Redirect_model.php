<?php

class Redirect_model extends CI_Model {

    public function __construct()
    {
            $this->load->database();
    }

    public function get_url($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->where('small != ""')->get('urls');
            return $query->result_array();
        }

        $query = $this->db->get_where('urls', array('small' => $id));
        return $query->row_array();
    }

    public function set_url()
    {
        $ret = FALSE;

        $url = strip_tags($this->input->post('url'));
        
        if( filter_var($url, FILTER_VALIDATE_URL) ){
            $data = array(
                'url' => $url
            );

            $this->db->insert('urls', $data);
            $this->db->select_max('id', 'cnt');
            $ret = $this->db->get('urls')->row_array();
        }
        return $ret;
    }

    public function set_small_url($id, $small_url){
        $this->db->set('small', $small_url)->where('id', $id)->update('urls');        
    }
}

?>
