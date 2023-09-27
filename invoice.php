<?php
    $connect = mysqli_connect("localhost","root","","dev_subodh");
    $in_id = array();
    $cu_id = array();
    $amtt  = array();
    $dispr = array();

    $query = "SELECT * FROM `invoice`";
    $count = "SELECT COUNT(*) FROM `invoice`";
    $result = mysqli_query($connect,$query);
    $size = mysqli_query($connect,$count);
    $row = mysqli_fetch_array($size);
    $count = $row[0];
    
    while($ret = mysqli_fetch_assoc($result))
    {
        foreach($ret as $key => $val)
        {
                if($key == "Invoice_Id")
                {
                    array_push($in_id,$val);
                }
                elseif($key == "Customer_Id")
                {
                    array_push($cu_id,$val);
                }
                elseif($key == "Amount")
                {
                    array_push($amtt,$val);
                }
                else 
                {
                    array_push($dispr,$val);
                }
        }
    }
    $head = array('Invoice_Id','Customer_Id','Amount','Discounted_Price');
    echo"<table border='1' id = 'view'><tr>";
    for($i = 0; $i < count($head); $i++)
        echo"<th>$head[$i]</th>";
    echo"</tr><tr>";
    for($i = 0; $i < $count; $i++)
    {
        echo"<tr>";
        for($j = 0; $j < 1; $j++)
        {
            echo"<td>$in_id[$i]</td>";
            echo"<td>$cu_id[$i]</td>";
            echo"<td>$amtt[$i]</td>";
            echo"<td>$dispr[$i]</td>";


        }
        echo"</tr>";
    }
    echo"</table>";// invoice table

    if(isset($_POST['insert']))
    {
        $cid = $_POST['cid'];

       

        $sum_amt_qry = "SELECT SUM(Amount) FROM sales WHERE Customer_Id = $cid";
        $sum_qry_res = mysqli_query($connect,$sum_amt_qry);
        $sum_qey_array = mysqli_fetch_array($sum_qry_res);
        $sum_amt = $sum_qey_array[0];
         //sum amount


        $invoice_query = "INSERT INTO invoice (Invoice_Id,Customer_Id,Amount) VALUES('','$cid','$sum_amt')";  
        mysqli_query($connect,$invoice_query);


        $iid = "SELECT Invoice_Id FROM invoice where Customer_id = $cid";
        $b = mysqli_query($connect,$iid);
        $t = mysqli_fetch_array($b);
        $invoice_id = $t[0]; //invoice id 

        

        $update_sales = "UPDATE sales set invoice_id = $invoice_id Where Customer_id = $cid";
        mysqli_query($connect,$update_sales);

        $dp = "SELECT MAX(Amount) FROM invoice where Customer_id = $cid";
        $disp = mysqli_query($connect,$dp);
        $dp_arr = mysqli_fetch_array($disp);
        $inv_amt = $dp_arr[0];// amt form invoice

        if($inv_amt <= 1000)
        {
            $dis_amt = ($inv_amt - ($inv_amt*0.05));
        }
        elseif($inv_amt > 1000)
        {
            $dis_amt = ($inv_amt - ($inv_amt*0.1));
        }


        $update_invoice = "UPDATE invoice SET Discounted_Price = $dis_amt WHERE Customer_id = $cid";
        mysqli_query($connect,$update_invoice);
        
    }



?>

<!DOCTYTPE html>
<html>
    <head>
        <title>Product</title>
        <link rel="stylesheet" type="text/css" href="css/product.css">
    </head>
    <body>
        <div class="heading">
            <div class="heading-container">
                <div class="heading-text"><p>Invoice</p></div>
            </div>
        </div>

        <div class="crud-area" id = "crud">
            <form action="" method="post">
            <div class="crud-area-container">
                <div class="crud">
                    <input type="button" name="button" value="View" onclick="toggleview()">
                </div> 

                <div class="crud">
                    <input type="button" name="button" value="Create Invoice" onclick="toggle()">
                </div>
                   
                <div class="crud">
                    <input type="button" name="button" value="Update" onclick="toggleup()">
                </div>

                <div class="crud">
                    <input type="button" name="button" value="Delete" onclick="toggledel()">
                </div>
            </div>
            </form>
        </div>


        <div class="insert-form" id = "insert">
            <form action="" method="post">
                <div class="insert-container">
                    <label>Customer_ID:</label>
                    <input type="text" name="cid"/>
                    <input type="submit" name="insert" value="create">
                </div>
            </form>
        </div>

        <div class="update-form" id="update">
            <form action="" method="post">
                    <div class="insert-container">
                        <label>Category:</label>
                        <input type="text" name="category"/>
                        <label>Name:</label>
                        <input type="text" name ="Name"/>
                        <label>Old_Price:</label>
                        <input type="text" name="oldprice">
                        <label>New_Price:</label>
                        <input type="text" name="newprice">
                        <input type="submit" name="update" value="update">
                    </div>
            </form>
        </div>

        <div class="delete-form" id = "delete">
            <form action="" method="post">
                <div class="insert-container">
                    <label>Category:</label>
                    <input type="text" name="category"/>
                    <label>Name:</label>
                    <input type="text" name ="Name"/>
                    <label>Price:</label>
                    <input type="text" name="price">
                    <label>ID:</label>
                    <input type="text" name="id">
                    <input type="submit" name="delete" value="Delete">
                </div>
            </form>
        </div>
        <script src="css/script/script.js"></script>
    </body>
</html>