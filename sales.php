<?php

    $connect = mysqli_connect("localhost","root","","dev_subodh");


    $t_id = array();
    $t_date = array();
    $t_time = array();
    $c_id = array();
    $amt = array();
    $pr_id = array();
    $pr_qty = array();
    $in_id = array();

    $query = "SELECT * FROM `sales`";
    $count = "SELECT COUNT(*) FROM `sales`";
    $result = mysqli_query($connect,$query);
    $size = mysqli_query($connect,$count);
    $row = mysqli_fetch_array($size);
    $count = $row[0];
    
    while($ret = mysqli_fetch_assoc($result))
    {
        foreach($ret as $key => $val)
        {
                if($key == "TRANSACTION_ID")
                {
                    array_push($t_id,$val);
                }
                elseif($key == "Transaction_Date")
                {
                    array_push($t_date,$val);
                }
                elseif($key == "TRANSACTION_Time")
                {
                    array_push($t_time,$val);
                }
                elseif($key == "Customer_Id")
                {
                    array_push($c_id,$val);
                }
                elseif($key == "Amount")
                {
                    array_push($amt,$val);
                }
                elseif($key == "Product_Id")
                {
                    array_push($pr_id,$val);
                }
                elseif($key == "Product_Qty")
                {
                    array_push($pr_qty,$val);
                }
                else 
                {
                    array_push($in_id,$val);
                }
        }
    }
    $head = array('Transaction_Id','Transaction_Date','Transaction_Time','Customer_Id','Amount','Product_Id','Product_Qty','Invoice_Id');
    echo"<table border='1' id = 'view'><tr>";
    for($i = 0; $i < count($head); $i++)
        echo"<th>$head[$i]</th>";
    echo"</tr><tr>";
    for($i = 0; $i < $count; $i++)
    {
        echo"<tr>";
        for($j = 0; $j < 1; $j++)
        {
            echo"<td>$t_id[$i]</td>";
            echo"<td>$t_date[$i]</td>";
            echo"<td>$t_time[$i]</td>";
            echo"<td>$c_id[$i]</td>";
            echo"<td>$amt[$i]</td>";
            echo"<td>$pr_id[$i]</td>";
            echo"<td>$pr_qty[$i]</td>";
            echo"<td>$in_id[$i]</td>";



        }
        echo"</tr>";
    }
    echo"</table>";// sales table



    
    if(isset($_POST['Enter']))
    {
        $c_id = $_POST['cid'];
        $p_id = $_POST['pid'];
        $qty = $_POST['qty'];

        $amt = "SELECT Price FROM Product Where ID = $p_id";
        $a = mysqli_query($connect,$amt);
        $row = mysqli_fetch_array($a);
        $amount = ($row[0]*$qty);// amount of the product

        $r_qry = "SELECT Remaining FROM product WHERE ID = $p_id";
        $r_qry_run = mysqli_query($connect,$r_qry);
        $r_array = mysqli_fetch_array($r_qry_run2);
        $remaining = ($r_array[0] - $qty);


       $sales_query = "INSERT INTO Sales (Customer_Id, Amount, Product_Id, Product_Qty) VALUES ('$c_id', '$amount', '$p_id', '$qty')";
       
        mysqli_query($connect,$sales_query);

        $up_rem = "UPDATE Product SET Remaining = $remaining WHERE ID=$p_id";
        mysqli_query($connect,$up_rem);//update remaining


    }


    if(isset($_POST['update']))
    {
        $newproductid = $_POST['newpid'];
        $newproductqty = $_POST['newqty'];
        $transaction_id = $_POST['tid'];
        $update = " UPDATE `sales` SET `Product_Id` = '$newproductid', `Product_Qty` = '$newproductqty' WHERE `sales`.`TRANSACTION_ID` = $transaction_id;";
        

        echo $update;
        mysqli_query($connect,$update);

        $r_qry = "SELECT Remaining FROM product WHERE ID = $newproductid";
        $r_qry_run = mysqli_query($connect,$r_qry);
        $r_array = mysqli_fetch_array($r_qry_run);
        $remaining = ($r_array[0] - $newproductqty);

        $up_rem = "UPDATE Product SET Remaining = $remaining WHERE ID=$newproductid";
        mysqli_query($connect,$up_rem);//update remaining

    }


    if(isset($_POST['delete']))
    {
        $trid = $_POST['trid'];

        $delete = "DELETE FROM sales where Transaction_ID = $trid ";
        mysqli_query($connect,$delete);

    }

?>


<!DOCTYTPE html>
<html>
    <head>
        <title>Sales</title>
        <link rel="stylesheet" type="text/css" href="css/product.css">
    </head>
    <body>
        <div class="heading">
            <div class="heading-container">
                <div class="heading-text"><p>Sales</p></div>
            </div>
        </div>

        <div class="crud-area" id = "crud">
            <form action="" method="post">
            <div class="crud-area-container">
                <div class="crud">
                    <input type="button" name="button" value="View" onclick="toggleview()">
                </div> 

                <div class="crud">
                    <input type="button" name="button" value="Transaction" onclick="toggle()">
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
                    <input type="text" name ="cid"/>
                    <label>Product_ID:</label>
                    <input type="text" name="pid">
                    <label>product_Qty:</label>
                    <input type="text" name="qty">
                    <input type="submit" name="Enter" value="submit">
                </div>
            </form>
        </div>

        <div class="update-form" id="update">
            <form action="" method="post">
                    <div class="insert-container">
                    <label>New_Product_Id:</label>
                    <input type="text" name="newpid">
                    <label>New_Product_Qty:</label>
                    <input type="text" name="newqty">
                    <label>Transaction_Id:</label>
                    <input type="text" name="tid">
                    <input type="submit" name="update" value="update">
                    </div>
            </form>
        </div>

        <div class="delete-form" id = "delete">
            <form action="" method="post">
                <div class="insert-container">
                <label>Transaction_Id:</label>
                <input type="text" name ="trid"/>
                <input type="submit" name="delete" value="Delete">
                </div>
            </form>
        </div>
        <script src="css/script/script.js"></script>
    </body>
</html>