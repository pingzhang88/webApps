//TODO: jquery post file upload

function delProduct()
{
    //1. get data from form
    //3. encode the data for transmission
    var pid = $("#id_to_delete").val();
    var data = "pid=" + encodeURIComponent(pid);
    //4. send the data
    jQuery.post("delete.php", data, function(response, status)
    {
        //if (status == "success" && response == "ok")
        if (status == "success")
        {
            window.alert("The product has been delete");
            window.location.reload(true);
        }
        else
        {
            $("#product_admin").html(response); //"Could not save the product. Try again.");
            window.alert("Delete Failed");
        }
    });

}

function showDeleteConfirm(pid)
{
    jQuery.getJSON("printProductsDetails.php", "id=" + pid, function(response, status)
    {
        if (status == "success")
        {
            //jquery automatically parses the response from the server
            $("#id_to_delete").val(response.pid);
            $("#product_to_delete").html(response.product_title);
        }
    });
    $("#deleteConfirm").show("slow");
}

//Difficulty:echo sth in printProductsDetails.php, not removed; 

function getProductDetails(pid)
{
    $("#add_bt").hide();
    $("#file_div").hide();
    jQuery.getJSON("printProductsDetails.php", "id=" + pid, function(response, status)
    {
        if (status == "success")
        {
            //jquery automatically parses the response from the server
            $("#pid").val(response.pid);
            $("#product_title").val(response.product_title);
            $("#image_name").val(response.image_name);
            $("#product_desc").val(response.product_desc);
            $("#cat_id").val(response.cat_id);
            $("#feature_1").val(response.feature_1);
            $("#feature_2").val(response.feature_2);
            $("#feature_3").val(response.feature_3);
        }
    });
    $("#product_admin").show("slow");
}

function showAddProductWindow(cat_id) {
    $("#pid_div").hide();
    $("#update_bt").hide();
    $("#cat_id").val(cat_id);
    $("#product_admin").show("slow");// must bellow hide and val
}

function addProduct()
{
    //1. get data from form
    var product_title = $("#product_title").val();
    var image_name = $("#image_name").val();
    var product_desc = $("#product_desc").val();
    var cat_id = $("#cat_id").val();
    var feature_1 = $("#feature_1").val();
    var feature_2 = $("#feature_2").val();
    var feature_3 = $("#feature_3").val();

    //2. validate...
    //3. encode the data for transmission
    var data = "product_title=" + encodeURIComponent(product_title)
            + "&image_name=" + encodeURIComponent(image_name)
            + "&product_desc=" + encodeURIComponent(product_desc)
            + "&cat_id=" + encodeURIComponent(cat_id)
            + "&feature_1=" + encodeURIComponent(feature_1)
            + "&feature_2=" + encodeURIComponent(feature_2)
            + "&feature_3=" + encodeURIComponent(feature_3);

    //4. send the data
    jQuery.post("addProduct.php", data, function(response, status)
    {
        if (status == "success")// && response == "ok")
        {
            alert("The product has been saved");
            window.location.reload(true);
        }
        else
        {
            alert("Add product Fail");
        }
    });
}


function cancel() {
    $("#product_admin").hide();
    location.reload(true);
}

function updateProduct()
{
    //1. get data from form
    $("#add_bt").hide();
    $("#file_div").hide();
    var pid = $("#pid").val();
    var product_title = $("#product_title").val();
    var image_name = $("#image_name").val();
    var product_desc = $("#product_desc").val();
    var cat_id = $("#cat_id").val();
    var feature_1 = $("#feature_1").val();
    var feature_2 = $("#feature_2").val();
    var feature_3 = $("#feature_3").val();

    //2. validate...
    //3. encode the data for transmission
    var data = "pid=" + encodeURIComponent(pid)
            + "&product_title=" + encodeURIComponent(product_title)
            + "&image_name=" + encodeURIComponent(image_name)
            + "&product_desc=" + encodeURIComponent(product_desc)
            + "&cat_id=" + encodeURIComponent(cat_id)
            + "&feature_1=" + encodeURIComponent(feature_1)
            + "&feature_2=" + encodeURIComponent(feature_2)
            + "&feature_3=" + encodeURIComponent(feature_3);

    //4. send the data
    jQuery.post("update.php", data, function(response, status)
    {
        //if (status == "success" && response == "ok")
        if (status == "success")
        {
            alert("Update Done");
            //$("#update_form").trigger("reset");
        }
        else
        {
            alert("Update Failed");
        }
    });
}

