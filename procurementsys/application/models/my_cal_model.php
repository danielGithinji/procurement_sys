<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of my_cal_model
 *
 * @author G-MAN
 */
class My_cal_model extends CI_Model{
    
    var $conf;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_calendar_data($year, $month,$user_id){
        $query = $this->db->select('date, data')->from('calendar')->where('user_id',$user_id)
                ->like('date',"$year-$month",'after')->get();
        
        $cal_data = array();
        
        if($query->num_rows()>0)
        {
            foreach($query->result() as $row)
            {
                $cal_data[substr($row->date,8,2)] = $row->data;
            }
            return $cal_data;
        }
        
    }
    
    public function add_calendar_data($date,$data,$user_id){
        //create an array that will be used in the where clause of queries below
         $array = array('date' => $date, 'user_id' => $user_id);
         
       // count_all_results checks whether the data actually exists in that table
       if($this->db->select('date')->from('calendar')->where($array)->count_all_results())
       {
            $this->db->where($array)->update('calendar',array(
                'data' => $data,
            ));
       }
       else
       {
           $this->db->insert('calendar',array(
                'date' => $date,
                'data' => $data,
                'user_id' => $user_id
           ));
       }        
    }
    
    public function generate($year, $month, $user_id){
      
       $this->load->library('calendar', $this->conf);
       
       //$this->add_calender_data("2013-03-28","mambo mapya",1002);
       
       $cal_data = $this->get_calendar_data($year, $month,$user_id);
      
      // $cal_data=array(05=>'i went to the zoo',08=>'there were many people');
      // return $cal_data;
       return $this->calendar->generate($year, $month, $cal_data);
    }
    
    public function initialize($department){
         
        if($department == "procurement")
        {
                $this->conf = array(
               'start_day' => 'monday',
               'show_next_prev'=> true,
                'day_type' => 'long',
               'next_prev_url' => base_url().'site_nav/procure_dash',
                    'local_time'
           );
           
             $this->conf['template'] = '
             {table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}

                    {heading_row_start}<tr class="url_links" style="height:10px;">{/heading_row_start}

                    {heading_previous_cell}<th><a href="{previous_url}" rel="previous" class="cal_link"><i class=" icon-double-angle-left"></i></a></th>{/heading_previous_cell}
                    {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
                    {heading_next_cell}<th><a href="{next_url}" class="cal_link"><i class=" icon-double-angle-right"></i></a></th>{/heading_next_cell}

                    {heading_row_end}</tr>{/heading_row_end}

                    {week_row_start}<tr class="weekdays">{/week_row_start}
                    {week_day_cell}<td>{week_day}</td>{/week_day_cell}
                    {week_row_end}</tr>{/week_row_end}

                    {cal_row_start}<tr class="days">{/cal_row_start}
                        {cal_cell_start}<td class="day">{/cal_cell_start}

                        {cal_cell_content}
                            <div class="day_num">{day}</div>
                            <div class="content">{content}</div>
                        {/cal_cell_content}

                        {cal_cell_content_today}
                            <div class="day_num highlight">{day}</div>
                            <div class="content">{content}</div>
                         {/cal_cell_content_today}

                        {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
                        {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}
                        
                        {cal_cell_blank}&nbsp;{/cal_cell_blank}

                        {cal_cell_end}</td>{/cal_cell_end}
                    {cal_row_end}</tr>{/cal_row_end}

               {table_close}</table>{/table_close}
           ';
              
        }
        elseif($department == "administrator")
        {
            $this->conf = array(
               'start_day' => 'monday',
               'show_next_prev'=> true,
                'day_type' => 'long',
               'next_prev_url' => base_url().'site_nav/admin_panel'
           );
            
               $this->conf['template'] = '
             {table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}

                    {heading_row_start}<tr class="url_links" style="height:10px;">{/heading_row_start}

                    {heading_previous_cell}<th><a href="{previous_url}" rel="previous" class="cal_link"><i class=" icon-double-angle-left"></i></a></th>{/heading_previous_cell}
                    {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
                    {heading_next_cell}<th><a href="{next_url}" class="cal_link"><i class=" icon-double-angle-right"></i></a></th>{/heading_next_cell}

                    {heading_row_end}</tr>{/heading_row_end}

                    {week_row_start}<tr class="weekdays">{/week_row_start}
                    {week_day_cell}<td>{week_day}</td>{/week_day_cell}
                    {week_row_end}</tr>{/week_row_end}

                    {cal_row_start}<tr class="days">{/cal_row_start}
                        {cal_cell_start}<td class="day">{/cal_cell_start}

                        {cal_cell_content}
                            <div class="day_num">{day}</div>
                            <div class="content">{content}</div>
                        {/cal_cell_content}

                        {cal_cell_content_today}
                            <div class="day_num highlight">{day}</div>
                            <div class="content">{content}</div>
                         {/cal_cell_content_today}

                        {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
                        {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}
                        
                        {cal_cell_blank}&nbsp;{/cal_cell_blank}

                        {cal_cell_end}</td>{/cal_cell_end}
                    {cal_row_end}</tr>{/cal_row_end}

               {table_close}</table>{/table_close}
         ';
        }
         elseif($department == "finance")
         {
              $this->conf = array(
               'start_day' => 'monday',
               'show_next_prev'=> true,
                'day_type' => 'long',
               'next_prev_url' => base_url().'site_nav/finance_dash'
           );
            
               $this->conf['template'] = '
             {table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}

                    {heading_row_start}<tr class="url_links" style="height:10px;">{/heading_row_start}

                    {heading_previous_cell}<th><a href="{previous_url}" rel="previous" class="cal_link"><i class=" icon-double-angle-left"></i></a></th>{/heading_previous_cell}
                    {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
                    {heading_next_cell}<th><a href="{next_url}" class="cal_link"><i class=" icon-double-angle-right"></i></a></th>{/heading_next_cell}

                    {heading_row_end}</tr>{/heading_row_end}

                    {week_row_start}<tr class="weekdays">{/week_row_start}
                    {week_day_cell}<td>{week_day}</td>{/week_day_cell}
                    {week_row_end}</tr>{/week_row_end}

                    {cal_row_start}<tr class="days">{/cal_row_start}
                        {cal_cell_start}<td class="day">{/cal_cell_start}

                        {cal_cell_content}
                            <div class="day_num">{day}</div>
                            <div class="content">{content}</div>
                        {/cal_cell_content}

                        {cal_cell_content_today}
                            <div class="day_num highlight">{day}</div>
                            <div class="content">{content}</div>
                         {/cal_cell_content_today}

                        {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
                        {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}
                        
                        {cal_cell_blank}&nbsp;{/cal_cell_blank}

                        {cal_cell_end}</td>{/cal_cell_end}
                    {cal_row_end}</tr>{/cal_row_end}

               {table_close}</table>{/table_close}
         ';
         }
         else
         {
             $this->conf = array(
               'start_day' => 'monday',
               'show_next_prev'=> true,
                'day_type' => 'long',
               'next_prev_url' => base_url().'site_nav/user_dash'
           );
           
               $this->conf['template'] = '
             {table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}

                    {heading_row_start}<tr class="url_links" style="height:10px;">{/heading_row_start}

                    {heading_previous_cell}<th><a href="{previous_url}" rel="previous" class="cal_link"><i class=" icon-double-angle-left"></i></a></th>{/heading_previous_cell}
                    {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
                    {heading_next_cell}<th><a href="{next_url}" class="cal_link"><i class=" icon-double-angle-right"></i></a></th>{/heading_next_cell}

                    {heading_row_end}</tr>{/heading_row_end}

                    {week_row_start}<tr class="weekdays">{/week_row_start}
                    {week_day_cell}<td>{week_day}</td>{/week_day_cell}
                    {week_row_end}</tr>{/week_row_end}

                    {cal_row_start}<tr class="days">{/cal_row_start}
                        {cal_cell_start}<td class="day">{/cal_cell_start}

                        {cal_cell_content}
                            <div class="day_num">{day}</div>
                            <div class="content">{content}</div>
                        {/cal_cell_content}

                        {cal_cell_content_today}
                            <div class="day_num highlight">{day}</div>
                            <div class="content">{content}</div>
                         {/cal_cell_content_today}

                        {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
                        {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>{/cal_cell_no_content_today}
                        
                        {cal_cell_blank}&nbsp;{/cal_cell_blank}

                        {cal_cell_end}</td>{/cal_cell_end}
                    {cal_row_end}</tr>{/cal_row_end}

               {table_close}</table>{/table_close}
           ';
               
         }
   }
        
      
}


