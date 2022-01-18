<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Categories_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

     /*
      Description:  Use to add category.
     */
    function add_category($Input = array()) {
        $insert_array = array_filter(array(
            "category_guid" => get_guid(),
            "category_name" => @ucfirst(strtolower($Input['category_name'])),
            "created_date" => date('Y-m-d H:i:s')
        ));
        $this->db->insert('tbl_categories', $insert_array);
        if($this->db->insert_id()){
            return TRUE;
        }
        return FALSE;
    }

    /*
      Description: 	Use to get categories
     */

    function get_categories($Field = '', $Where = array(), $multiRecords = FALSE, $PageNo = 1, $PageSize = 150) {
        
        /* Additional fields to select */
        $Params = array();
        if (!empty($Field)) {
            $Params = array_map('trim', explode(',', $Field));
            $Field = '';
            $FieldArray = array(
                'created_date'  => 'DATE_FORMAT(C.created_date, "' . DATE_FORMAT . '") created_date',
                'category_id'   => 'C.category_id',
                'category_name' => 'C.category_name'
            );
            
            foreach ($Params as $Param) {
                $Field .= (!empty($FieldArray[$Param]) ? ',' . $FieldArray[$Param] : '');
            }
        }
        $this->db->select('C.category_guid');
        if (!empty($Field)) $this->db->select($Field, FALSE);
        $this->db->from('tbl_categories C');
        if (!empty($Where['keyword'])) {
            $Where['keyword'] = trim($Where['keyword']);
            $this->db->group_start();
            $this->db->like("C.category_name", $Where['keyword']);
            $this->db->group_end();
        }
        if (!empty($Where['category_id'])) {
            $this->db->where("C.category_id", $Where['category_id']);
        }
        if (!empty($Where['order_by']) && !empty($Where['sequence']) && in_array($Where['sequence'], array('ASC', 'DESC'))) {
            $this->db->order_by($Where['order_by'], $Where['sequence']);
        } else {
            $this->db->order_by('C.category_name', 'ASC');
        }

        /* Total records count only if want to get multiple records */
        if ($multiRecords) {
            $TempOBJ = clone $this->db;
            $TempQ = $TempOBJ->get();
            $Return['data']['total_records'] = $TempQ->num_rows();
            $this->db->limit($PageSize, paginationOffset($PageNo, $PageSize)); /* for pagination */
        } else {
            $this->db->limit(1);
        }

        $Query = $this->db->get();
        if ($Query->num_rows() > 0) {
            if ($multiRecords) {
                $Records = array();
                foreach ($Query->result_array() as $key => $Record) {
                    $Records[] = $Record;
                }
                $Return['data']['records'] = $Records;
                return $Return;
            } else {
                $Record = $Query->row_array();
                return $Record;
            }
        }
        return FALSE;
    }

    /*
      Description:  Use to update category
     */
    function update_category($category_id, $Input = array()) { 
        $this->db->where('category_id', $category_id);
        $this->db->limit(1);
        $this->db->update('tbl_categories', array('category_name' => @ucfirst(strtolower($Input['category_name']))));
        return TRUE;
    }

    /*
      Description:  Use to delete category.
    */
    function delete_category($category_guid) {
        $this->db->where('category_guid',$category_guid);
        $this->db->limit(1);
        $this->db->delete('tbl_categories');
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        return FALSE;
    }


}
