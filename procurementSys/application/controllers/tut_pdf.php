<?php

class Tut_pdf extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('cezpdf');
    }

    public function single_lpo_row() {
        $id = $this->input->post('purchLpo_id');
        $address = $this->input->post('address');

        //echo $id;
        $this->cezpdf->selectFont('./fonts/Times-Roman.afm');
        $this->cezpdf->addText(85, 800, 22, '<b>TAITA TAVETA UNIVERSITY COLLEGE</b>');
        $this->cezpdf->addText(90, 790, 12, '<i>(A constituent College of Jomo Kenyatta University of Agriculture and Technology)</i>');
        $this->cezpdf->addText(200, 777, 12, 'P.O BOX 635-80300 VOI, KENYA');
        $this->cezpdf->addText(210, 767, 12, 'Telephone (020) 2437266-VOI');
        $this->cezpdf->ezSetDy(-80);

        // shows thickness of the line as 2 and its corners as rounded
        $this->cezpdf->setLineStyle(1, 'round');
        $this->cezpdf->line(20, 750, 578, 750);

        // returns the color of the text of the document back to default color
        $this->cezpdf->setColor(1, 0, 0);
        $this->cezpdf->ezText('<b>LOCAL PURCHASE ORDER<b>', 16, array('justification' => 'center'));
        $this->cezpdf->ezSetDy(-30);  
        
        // $id = $this->input->post('purch_id');
        $row = $this->site_model->get_purch_for_lpo($id);

        
        $db_data[] = array('name' => $row->itemName, 'description' => $row->itemDescription, 'quantity' => $row->quantity_ordered,
                'pricePerUnit' => $row->pricePerUnit, 'total' => $row->quantity_ordered * $row->pricePerUnit);
        
        $col_names = array(
            'name' => '<b>Name</b>',
            'description' => '<b>Description</b>',
            'quantity' => '<b>Quantity</b>',
            'pricePerUnit' => '<b>Price Per Unit(Ksh.)</b>',
            'total' => '<b>Total(Ksh.)</b>'
        );

        $this->cezpdf->ezTable($db_data, $col_names, 'Details', array('width' => 500, 'shaded' => 2, 'titleFontSize' => 14));


       $this->cezpdf->ezStream();

        $pdfcode = $this->cezpdf->ezOutput();
        $fp = fopen('./attachments/'.$row->purchaseReqID.'.pdf', 'wb');
        fwrite($fp, $pdfcode);
        fclose($fp);


        $this->load->library('email');

        $this->email->set_newline("\r\n");



        $this->email->from('danskigee@gmail.com');

        $this->email->to($address);       

        $this->email->subject('LOCAL PURCHASE ORDER');      
        $this->email->message('Attached please find an LPO file');



        $this->email->attach('./attachments/'.$row->lpoNo.'.pdf');


        if($this->email->send())
        {
            //echo 'Your email was sent successfully.';
            echo "1";
            delete_files('./attachments/');
        }

        else
        {

            //show_error($this->email->print_debugger());
            echo "2";
        }
    }

    public function bulk_lpo() {
        $id = $this->input->post('supp_id');
        $address = $this->input->post('address');
        //echo $address;
        //
        // set the font of the document up until where another font has been set
        $this->cezpdf->selectFont('./fonts/Times-Roman.afm');
        $this->cezpdf->addText(85, 800, 22, '<b>TAITA TAVETA UNIVERSITY COLLEGE</b>');
        $this->cezpdf->addText(90, 790, 12, '<i>(A constituent College of Jomo Kenyatta University of Agriculture and Technology)</i>');
        $this->cezpdf->addText(200, 777, 12, 'P.O BOX 635-80300 VOI, KENYA');
        $this->cezpdf->addText(210, 767, 12, 'Telephone (020) 2437266-VOI');
        $this->cezpdf->ezSetDy(-80);

        // shows thickness of the line as 2 and its corners as rounded
        $this->cezpdf->setLineStyle(1, 'round');
        $this->cezpdf->line(20, 750, 578, 750);

        // returns the color of the text of the document back to default color
        $this->cezpdf->setColor(1, 0, 0);
        $this->cezpdf->ezText('<b>LOCAL PURCHASE ORDER<b>', 16, array('justification' => 'center'));
        $this->cezpdf->ezSetDy(-20);
               
        // $id = $this->input->post('purch_id');
        $row_data = $this->site_model->getLpo_from_supp($id);

        // loops all the available table rows that is available from the query
         foreach($row_data as $row) {
             $db_data[] = array('name' => $row->itemName, 'description' => $row->itemDescription, 'quantity' => $row->quantity_ordered,
                'pricePerUnit' => $row->pricePerUnit, 'total' => $row->quantity_ordered * $row->pricePerUnit);
         }
            
        

        $col_names = array(
            'name' => '<b>Name</b>',
            'description' => '<b>Description</b>',
            'quantity' => '<b>Quantity</b>',
            'pricePerUnit' => '<b>Price Per Unit(Ksh.)</b>',
            'total' => '<b>Total(Ksh.)</b>'
        );

        $this->cezpdf->ezTable($db_data, $col_names, 'Details', array('width' => 500, 'shaded' => 1, 'titleFontSize' => 14, 'rowGap' => 3, 
                      'textCol' =>array(0.2,0.5,1), 
                         ));


       $this->cezpdf->ezStream();
        
        $pdfcode = $this->cezpdf->ezOutput();
        
        $fp = fopen('./attachments/attach.pdf', 'wb');
        fwrite($fp, $pdfcode);
        fclose($fp);

        $this->load->library('email');

        $this->email->set_newline("\r\n");



        $this->email->from('danskigee@gmail.com');

        $this->email->to($address);       

        $this->email->subject('LOCAL PURCHASE ORDER');      
        $this->email->message('Attached please find an LPO file');



        $this->email->attach('./attachments/attach.pdf');


        if($this->email->send())
        {
            //echo 'Your email was sent successfully.';
            echo "1";
            delete_files('./attachments/');
        }

        else
        {

            //show_error($this->email->print_debugger());
            echo "2";
        }

    }
    
    public function return_note($id){

         $this->cezpdf->cezpdf($paper='a5',$orientation='landscape');
       
        // set the font of the document up until where another font has been set
        $this->cezpdf->selectFont('./fonts/Times-Roman.afm');
        $this->cezpdf->addText(85, 390, 22, '<b>TAITA TAVETA UNIVERSITY COLLEGE</b>');
        $this->cezpdf->addText(90, 380, 12, '<i>(A constituent College of Jomo Kenyatta University of Agriculture and Technology)</i>');
        $this->cezpdf->addText(200, 367, 12, 'P.O BOX 635-80300 VOI, KENYA');
        $this->cezpdf->addText(210, 357, 12, 'Telephone (020) 2437266-VOI');
        $this->cezpdf->ezSetDy(-80);

        // shows thickness of the line as 2 and its corners as rounded
        $this->cezpdf->setLineStyle(1, 'round');
        $this->cezpdf->line(20, 350, 578, 350);
        
         $this->cezpdf->setColor(0, 0, 0);
         $this->cezpdf->addText(150, 330, 17, 'TTUC PROCUREMENT DEPARTMENT');
         $this->cezpdf->ezSetDy(-10);
        

        // returns the color of the text of the document back to default color
        $this->cezpdf->setColor(1, 0, 0);
        $this->cezpdf->ezText('<b>RETURN NOTE<b>', 15, array('justification' => 'center'));
        $this->cezpdf->ezSetDy(-60);
          
        // get the specific return note details 
        $row = $this->site_model->get_specific_returnNote($id);
       
         $this->cezpdf->setColor(0.3, 0, 0.5);
         $this->cezpdf->addText(40, 235, 10, 'RETURNED TO (SUPPLIER): '.$row->supplierName);
         
         $date = date('d/m/Y');
         $this->cezpdf->addText(470, 235, 10, 'Date: '.$date);
               

          
//
//        // loops all the available table rows that is available from the query

            $db_data[] = array('itemNo'=>$row->itemID, 'name' => $row->itemName, 'description' => $row->itemDescription, 'quantity' => $row->quantity_ordered,
                'pricePerUnit' => $row->pricePerUnit, 'total' => $row->quantity_ordered * $row->pricePerUnit);

            $col_names = array(
               'itemNo' => 'ITEM NO.',
               'name' => '<b>NAME</b>',
               'description' => '<b>DESCRIPTION</b>',
               'quantity' => '<b>QUANTITY</b>',
               'pricePerUnit' => '<b>UNIT PRICE(Ksh.)</b>',
               'total' => '<b>TOTAL(Ksh.)</b>'
           );

           $this->cezpdf->ezTable($db_data, $col_names, '', array('width' => 500, 'shaded' => 1, 'titleFontSize' => 14, 'rowGap' => 3, 
                         'textCol' =>array(0.2,0.5,1), 
                            ));


          $this->cezpdf->ezStream();
        
//        $pdfcode = $this->cezpdf->ezOutput();
//        
//        $fp = fopen('./attachments/attach.pdf', 'wb');
//        fwrite($fp, $pdfcode);
//        fclose($fp);

     
    }
        
       // create a return note pdf that lists the return note dependent on the supplier
        public function return_noteSupp($id){
        //changes the size of the page
        $this->cezpdf->cezpdf($paper='a5',$orientation='landscape');
       
        // set the font of the document up until where another font has been set
        $this->cezpdf->selectFont('./fonts/Times-Roman.afm');
        $this->cezpdf->addText(85, 390, 22, '<b>TAITA TAVETA UNIVERSITY COLLEGE</b>');
        $this->cezpdf->addText(90, 380, 12, '<i>(A constituent College of Jomo Kenyatta University of Agriculture and Technology)</i>');
        $this->cezpdf->addText(200, 367, 12, 'P.O BOX 635-80300 VOI, KENYA');
        $this->cezpdf->addText(210, 357, 12, 'Telephone (020) 2437266-VOI');
        $this->cezpdf->ezSetDy(-80);

        // shows thickness of the line as 2 and its corners as rounded
        $this->cezpdf->setLineStyle(1, 'round');
        $this->cezpdf->line(20, 350, 578, 350);
        
         $this->cezpdf->setColor(0, 0, 0);
         $this->cezpdf->addText(150, 330, 17, 'TTUC PROCUREMENT DEPARTMENT');
         $this->cezpdf->ezSetDy(-10);
        

        // returns the color of the text of the document back to default color
        $this->cezpdf->setColor(1, 0, 0);
        $this->cezpdf->ezText('<b>RETURN NOTE<b>', 15, array('justification' => 'center'));
        $this->cezpdf->ezSetDy(-60);
                    
        // get a specific supplier's details 
         $supplierDet = $this->site_model->get_supplier_data($id);
        
         $this->cezpdf->setColor(0.3, 0, 0.5);
         $this->cezpdf->addText(40, 235, 10, 'RETURNED TO (SUPPLIER): '.$supplierDet->supplierName);
         
         $date = date('d/m/Y');
         $this->cezpdf->addText(470, 235, 10, 'Date: '.$date);
        
         
         // gets the return note details depending on a certain supplier
         $row_data = $this->site_model->get_returnSupplier($id);
         
        // loops all the available table rows that is available from the query
         foreach($row_data as $row) {

             $db_data[] = array('itemNo'=>$row->itemID, 'name' => $row->itemName, 'description' => $row->itemDescription, 'quantity' => $row->quantity_ordered,
                'pricePerUnit' => $row->pricePerUnit, 'total' => $row->quantity_ordered * $row->pricePerUnit);
         }
            
        $col_names = array(
            'itemNo' => 'ITEM NO.',
            'name' => '<b>NAME</b>',
            'description' => '<b>DESCRIPTION</b>',
            'quantity' => '<b>QUANTITY</b>',
            'pricePerUnit' => '<b>UNIT PRICE(Ksh.)</b>',
            'total' => '<b>TOTAL(Ksh.)</b>'
        );

        $this->cezpdf->ezTable($db_data, $col_names, '', array('width' => 500, 'shaded' => 1, 'titleFontSize' => 14, 'rowGap' => 3, 
                      'textCol' =>array(0.2,0.5,1), 
                         ));


        $this->cezpdf->ezStream();
     
    }
    
    // creates as single LPO report
    public function single_lpo_report($id) {
        
         
        //echo $id;
        $this->cezpdf->selectFont('./fonts/Times-Roman.afm');
        $this->cezpdf->addText(85, 800, 22, '<b>TAITA TAVETA UNIVERSITY COLLEGE</b>');
        $this->cezpdf->addText(90, 790, 12, '<i>(A constituent College of Jomo Kenyatta University of Agriculture and Technology)</i>');
        $this->cezpdf->addText(200, 777, 12, 'P.O BOX 635-80300 VOI, KENYA');
        $this->cezpdf->addText(210, 767, 12, 'Telephone (020) 2437266-VOI');
        $this->cezpdf->ezSetDy(-80);

        // shows thickness of the line as 2 and its corners as rounded
        $this->cezpdf->setLineStyle(1, 'round');
        $this->cezpdf->line(20, 750, 578, 750);

         $this->cezpdf->setColor(0, 0, 0);
         $this->cezpdf->addText(150,735, 17, 'TTUC PROCUREMENT DEPARTMENT');
         $this->cezpdf->ezSetDy(-30); 
         
        // returns the color of the text of the document back to default color
        $this->cezpdf->setColor(1, 0, 0);
        $this->cezpdf->ezText('<b>LOCAL PURCHASE ORDER<b>', 15, array('justification' => 'center'));
        $this->cezpdf->ezSetDy(-10);  
        
        // $id = $this->input->post('purch_id');
        $row = $this->site_model->get_purch_for_lpo($id);

        
        $db_data[] = array('name' => $row->itemName, 'description' => $row->itemDescription, 'quantity' => $row->quantity_ordered,
                'pricePerUnit' => $row->pricePerUnit, 'total' => $row->quantity_ordered * $row->pricePerUnit);
        
        $col_names = array(
            'name' => '<b>Name</b>',
            'description' => '<b>Description</b>',
            'quantity' => '<b>Quantity</b>',
            'pricePerUnit' => '<b>Price Per Unit(Ksh.)</b>',
            'total' => '<b>Total(Ksh.)</b>'
        );

        $this->cezpdf->ezTable($db_data, $col_names, 'Details', array('width' => 500, 'shaded' => 2, 'titleFontSize' => 14));


       $this->cezpdf->ezStream();
    }
    
    // creates an LPO report with many LPO's created for one supplier
     public function bulk_lpo_report($id) {

        // set the font of the document up until where another font has been set
        $this->cezpdf->selectFont('./fonts/Times-Roman.afm');
        $this->cezpdf->addText(85, 800, 22, '<b>TAITA TAVETA UNIVERSITY COLLEGE</b>');
        $this->cezpdf->addText(90, 790, 12, '<i>(A constituent College of Jomo Kenyatta University of Agriculture and Technology)</i>');
        $this->cezpdf->addText(200, 777, 12, 'P.O BOX 635-80300 VOI, KENYA');
        $this->cezpdf->addText(210, 767, 12, 'Telephone (020) 2437266-VOI');
        $this->cezpdf->ezSetDy(-80);

        // shows thickness of the line as 2 and its corners as rounded
        $this->cezpdf->setLineStyle(1, 'round');
        $this->cezpdf->line(20, 750, 578, 750);

        $this->cezpdf->setColor(0, 0, 0);
         $this->cezpdf->addText(150,735, 17, 'TTUC PROCUREMENT DEPARTMENT');
         $this->cezpdf->ezSetDy(-30); 
         
        // returns the color of the text of the document back to default color
        $this->cezpdf->setColor(1, 0, 0);
        $this->cezpdf->ezText('<b>LOCAL PURCHASE ORDER<b>', 15, array('justification' => 'center'));
        $this->cezpdf->ezSetDy(-10);
               
        // $id = $this->input->post('purch_id');
        $row_data = $this->site_model->getLpo_from_supp($id);

        // loops all the available table rows that is available from the query
         foreach($row_data as $row) {
             $db_data[] = array('name' => $row->itemName, 'description' => $row->itemDescription, 'quantity' => $row->quantity_ordered,
                'pricePerUnit' => $row->pricePerUnit, 'total' => $row->quantity_ordered * $row->pricePerUnit);
         }
            
        

        $col_names = array(
            'name' => '<b>Name</b>',
            'description' => '<b>Description</b>',
            'quantity' => '<b>Quantity</b>',
            'pricePerUnit' => '<b>Price Per Unit(Ksh.)</b>',
            'total' => '<b>Total(Ksh.)</b>'
        );

        $this->cezpdf->ezTable($db_data, $col_names, 'Details', array('width' => 500, 'shaded' => 3, 'titleFontSize' => 14, 'rowGap' => 3, 
                      'textCol' =>array(0,0,0), 
                         ));

       $this->cezpdf->ezStream();
        
    }

}

