<?php
/*
 */
?>
<div id="product_admin">      
    <form class="form-horizontal" method="post" id="update_form" enctype="multipart/form-data">

        <fieldset>

            <!-- Form Name -->
            <legend>Update / Add Products</legend>

            <div class="product_admin_sub" id="product_admin_sub_left">

                <!-- Text input-->
                <div class="control-group" id="pid_div">
                    <label class="control-label" for="p_id">Product ID</label>
                    <div class="controls">
                        <input id="pid" name="pid" type="text" placeholder="Product ID" class="input-medium" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="control-group">
                    <label class="control-label" for="product_title">Product Title</label>
                    <div class="controls">
                        <input id="product_title" name="product_title" type="text" placeholder="Product Title" class="input-medium" required="">

                    </div>
                </div>

                <!-- Text input-->
                <div class="control-group">
                    <label class="control-label" for="image_name">Image Name</label>
                    <div class="controls">
                        <input id="image_name" name="image_name" type="text" placeholder="Image Name" class="input-medium" required="">

                    </div>
                </div>

                <!-- Textarea -->
                <div class="control-group">
                    <label class="control-label" for="product_desc">product desc</label>
                    <div class="controls">                     
                        <textarea id="product_desc" name="product_desc" class="mytextarea"></textarea>
                    </div>
                </div>


                <!-- Text input-->
                <div class="control-group" id="cat_id_div">
                    <label class="control-label" for="cat_id">Category ID</label>
                    <div class="controls">
                        <input id="cat_id" name="cat_id" type="text" placeholder="Category ID" class="input-medium" required="">

                    </div>
                </div>

            </div>
            <div class="product_admin_sub" id="product_admin_sub_right">

                <!-- Textarea -->
                <div class="control-group">
                    <label class="control-label" for="feature_1">feature 1</label>
                    <div class="controls">                     
                        <textarea id="feature_1" name="feature_1" class="mytextarea"></textarea>
                    </div>
                </div>

                <!-- Textarea -->
                <div class="control-group">
                    <label class="control-label" for="feature_2">feature 2</label>
                    <div class="controls">                     
                        <textarea id="feature_2" name="feature_2" class="mytextarea"></textarea>
                    </div>
                </div>

                <!-- Textarea -->
                <div class="control-group">
                    <label class="control-label" for="feature_3" class="mytextarea">feature 3</label>
                    <div class="controls">                     
                        <textarea id="feature_3" name="feature_3" class="mytextarea"></textarea>
                    </div>
                </div>

                <!-- File Button --> 
                <div class="control-group" id="file_upload_div">
                    <label class="control-label" for="file_bt">Upload</label>
                    <div class="controls" id="file_upload">
                        <input id="file" name="file" class="input-file" type="file">
                    </div>
                </div>

                <!-- Button (Double) -->
                <div class="control-group" id="bt_div">
                    <label class="control-label" for="update_bt">ACTION</label>
                    <div class="controls">
                        <button id="update_bt" name="update_bt" class="btn btn-success"  onclick="updateProduct()">Update</button>

                        <button id="add_bt" name="add_bt" class="btn btn-info" onclick="addProduct()">Add Product</button>

                        <button id="cancel_bt" name="cancel_bt" class="btn btn-primary" onclick="cancel()">Close</button>

                    </div>
                </div>

            </div>

        </fieldset>
    </form>

</div>

<div id="deleteConfirm">
    <h3>Are you sure you want to delete <br /><br /><span id="product_to_delete"></span>?</h3>
    <form class="form-horizontal" method="POST">
        <fieldset>
            <div class="control-group">
                <label class="control-label" for="button1id"></label>
                <div class="controls">
                    <input type="hidden" id="id_to_delete" name="id_to_delete" />
                    <button id="delete_bt" name="button1id" class="btn btn-danger" onclick="delProduct()" >DELETE</button>
                    <button id="close" name="close" class="btn btn-default">STOP</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>

