<div  style="" class="filter">

    <label style="float:left;">Filter By: </label>
    <select name="category" id="category">
        <option  option="selected">Category</option> 
        <?php foreach ($categoryDetails as $category): ?>
            <option value="<?php echo $category->categoryID; ?>" > <?php echo $category->categoryName; ?> </option>
        <?php endforeach; ?>
    </select>

    <button class="btn btn-small btn-info" id="edit_category" title="edit category"><i class=" cus-layout_edit"></i> Edit Categories</button>
    <button class="btn btn-small btn-info" id="add_category" title="add category"><i class="cus-layout_add" ></i> Add Category</button>


</div>
<div id="load_edit_itemTable">
    <?php $this->load->view('sysviews/admin/edit_items_table') ?>
</div>

<!------------------------------- add/update user details Modal Window----------------------------------------------->

<div id="edit_form" class="modal hide property edit_form items">

    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3>Add New User</h3>  
    </div>
    
    <div class="modal-body" >
        
        <label>Item Name:</label>
        <input type="text" name="itemName"/>

        <label>Item Description:</label>
        <input type="text" name="itemDescription">

        <label>Unit Price:</label>
        <input type="text" name="pricePerUnit">

        <label>Quantity</label>
        <input type="text" name="quantity"/>
        
        <label>Quantity Limit:</label>
        <input type="text" name="quantity_limit"/>
        
        <label>Item Category:</label>
        <select name="category">
            <option value="selected" selected="selected">Select a Category</option> 
            <?php foreach ($categoryDetails as $category): ?>
                <option value="<?php echo $category->categoryID; ?>" > <?php echo $category->categoryName; ?> </option>
            <?php endforeach; ?>
        </select>
  
    </div>
    <div class="modal-footer">
        
        <div id="confirm" class="alert alert-info  alert_modal hide">  

              <i class="icon-spinner icon-large icon-spin"></i> Submitting Data..
         </div>
        
        <a href="#" class="btn btn-small" data-dismiss="modal" >Cancel</a>
        <a href="#" id="update_item" class="btn btn-inverse btn-small"><i class="cus-database_edit"></i> Update Item</a>
        <a href="#" id="add_item" class="btn btn-inverse btn-small"><i class="cus-database_save"></i> Add Item</a>
    </div>
</div>

<!-------------------------------end of add/update user details Modal Window------------------------------------------>