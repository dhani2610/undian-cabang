<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model extends CI_Model
{
	
    function pagination($table, $id, $base, $per_page)
    {
        $query = $this->db->query("SELECT * FROM ta_peserta order by ta_peserta_id asc");    
        $config['base_url']     = base_url().$base;
        $config['total_rows']   = $query->num_rows();  
        $config['per_page']     = $per_page;
        $config['use_page_numbers'] = FALSE;
        $config['page_query_string'] = TRUE;
        $num                    = $config['per_page'];
        $config['query_string_segment'] = 'page';
        if(isset($_GET['page'])){
            $offset                 = $_GET['page']; 
        }
        else{ $offset = 0;}
        $offset                 = ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
        if(empty($offset))  
        {  
            $offset=0;  
        }
        if($offset > ($config['total_rows'] - 1))
        {
            $offset=0;  
        }

        /* This Application Must Be Used With BootStrap 4 *  */
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);  
        $data['query']      = $this->db->query("SELECT * FROM ta_peserta order by ta_peserta_id asc limit $offset,$num");
        $data['base']       = $this->config->item('base_url');  
        $data['jumlah_row'] = $config['total_rows'];
        return $data;
    }

    function pagination_search($table, $id, $base, $per_page, $where)
    {
        $query = $this->db->query("SELECT * FROM $table $where order by $id asc");    
        $config['base_url']     = base_url().$base;
        $config['total_rows']   = $query->num_rows();  
        $config['per_page']     = $per_page;
        $config['use_page_numbers'] = FALSE;
        $config['page_query_string'] = TRUE;
        $num                    = $config['per_page'];
        $config['query_string_segment'] = 'page';
        if(isset($_GET['page'])){
            $offset                 = $_GET['page']; 
        }
        else{ $offset = 0;}
        $offset                 = ( ! is_numeric($offset) || $offset < 1) ? 0 : $offset;  
        if(empty($offset))  
        {  
            $offset=0;  
        }
        if($offset > ($config['total_rows'] - 1))
        {
            $offset=0;  
        }

        /* This Application Must Be Used With BootStrap 4 *  */
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->pagination->initialize($config);  
        $data['query']      = $this->db->query("SELECT * FROM $table $where order by $id asc limit $offset,$num");
        $data['base']       = $this->config->item('base_url');  
        $data['jumlah_row'] = $config['total_rows'];
        return $data;
    }
}