<?php

class Gridsquares_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_worked_sat_squares() {
        $CI =& get_instance();
        $CI->load->model('Stations');
        $station_id = $CI->Stations->find_active();

        $this->db->where("station_id", $station_id);

        return $this->db->query('SELECT distinct substring(COL_GRIDSQUARE,1,4) as SAT_SQUARE, COL_SAT_NAME FROM '.$this->config->item('table_name').' WHERE station_id = "'.$station_id.'" AND COL_GRIDSQUARE != "" AND COL_SAT_NAME != ""');
	}


    function get_confirmed_sat_squares() {
        $CI =& get_instance();
        $CI->load->model('Stations');
        $station_id = $CI->Stations->find_active();

        return $this->db->query('SELECT distinct substring(COL_GRIDSQUARE,1,4) as SAT_SQUARE, COL_SAT_NAME FROM '.$this->config->item('table_name').' WHERE station_id = "'.$station_id.'" AND COL_GRIDSQUARE != "" AND COL_SAT_NAME != "" AND (COL_LOTW_QSL_RCVD = "Y" OR COL_QSL_RCVD = "Y")');
    }

    function get_confirmed_sat_vucc_squares() {
        $CI =& get_instance();
        $CI->load->model('Stations');
        $station_id = $CI->Stations->find_active();
        
        return $this->db->query('SELECT COL_VUCC_GRIDS, COL_SAT_NAME FROM '.$this->config->item('table_name').' WHERE station_id = "'.$station_id.'" AND COL_VUCC_GRIDS != "" AND COL_SAT_NAME != "" AND (COL_LOTW_QSL_RCVD = "Y" OR COL_QSL_RCVD = "Y") AND (COL_LOTW_QSL_RCVD = "Y" OR COL_QSL_RCVD = "Y")');
    }

    function get_worked_sat_vucc_squares() {
        $CI =& get_instance();
        $CI->load->model('Stations');
        $station_id = $CI->Stations->find_active();

	    $this->db->select('COL_PRIMARY_KEY, COL_VUCC_GRIDS, COL_SAT_NAME');
        $this->db->where("station_id", $station_id);
    	$this->db->where('COL_VUCC_GRIDS !=', "");
    	$this->db->where('COL_SAT_NAME !=', "");
		return $this->db->get($this->config->item('table_name'));
	}

    function get_band($band) {
        $CI =& get_instance();
        $CI->load->model('Stations');
        $station_id = $CI->Stations->find_active();
        return $this->db->query('SELECT distinct substring(COL_GRIDSQUARE,1,4) as GRID_SQUARES, COL_BAND FROM '.$this->config->item('table_name').'
            WHERE station_id = "'.$station_id.'" AND COL_GRIDSQUARE != "" 
            AND COL_BAND = "'.$band.'"
            AND COL_PROP_MODE != "SAT"
            AND COL_PROP_MODE != "INTERNET"
            AND COL_PROP_MODE != "ECH"
            AND COL_PROP_MODE != "RPT"
            AND COL_SAT_NAME = "" 
            ');
    }

    function get_band_confirmed($band) {
        $CI =& get_instance();
        $CI->load->model('Stations');
        $station_id = $CI->Stations->find_active();

        return $this->db->query('SELECT distinct substring(COL_GRIDSQUARE,1,4) as GRID_SQUARES, COL_BAND FROM '.$this->config->item('table_name').' WHERE station_id = "'.$station_id.'" AND COL_GRIDSQUARE != "" AND COL_BAND = "'.$band.'" 
            AND COL_PROP_MODE != "SAT"
            AND COL_PROP_MODE != "INTERNET"
            AND COL_PROP_MODE != "ECH"
            AND COL_PROP_MODE != "RPT"
            AND COL_SAT_NAME = ""
            AND (COL_LOTW_QSL_RCVD = "Y" OR COL_QSL_RCVD = "Y")
            ');
    }
}