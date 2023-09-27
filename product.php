<?php
//try single connect
    $id = array();
    $category = array();
    $name = array();
    $price = array();

    $connect = mysqli_connect("localhost","root","","dev_subodh");
    $query = "SELECT * FROM `product`";
    $count = "SELECT COUNT(*) FROM `product`";
    $result = mysqli_query($connect,$query);
    $size = mysqli_query($connect,$count);
    $row = mysqli_fetch_array($size);
    $count = $row[0];
    
    while($ret = mysqli_fetch_assoc($result))
    {
        foreach($ret as $key => $val)
        {
                if($key == "ID")
                {
                    array_push($id,$val);
                }
                elseif($key == "category")
                {
                    array_push($category,$val);
                }
                elseif($key == "Name")
                {
                    array_push($name,$val);
                }
                else 
                {
                    array_push($price,$val);
                }
        }
    }
    $head = array('ID','Category','Name','Price');
    echo"<table border='1' id = 'view'><tr>";
    for($i = 0; $i < count($head); $i++)
        echo"<th>$head[$i]</th>";
    echo"</tr><tr>";
    for($i = 0; $i < $count; $i++)
    {
        echo"<tr>";
        for($j = 0; $j < 1; $j++)
        {
            echo"<td>$id[$i]</td>";
            echo"<td>$category[$i]</td>";
            echo"<td>$name[$i]</td>";
            echo"<td>$price[$i]</td>";

        }
        echo"</tr>";
    }
    echo"</table>";
    
    



    if(isset($_POST['insert']))
    {
        $category = $_POST['category'];
        $name = $_POST['Name'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];

        $insert = "insert into product(ID,category,Name,Price,Remaining) values('','$category','$name','$price','$qty')";
        mysqli_query($connect,$insert);

    }


    if(isset($_POST['update']))
    {
        $category = $_POST['category'];
        $name = $_POST['Name'];
        $oprice = $_POST['oldprice'];
        $nprice = $_POST['newprice'];
        $qty = $_POST['qty'];

        $update = "update product set Price = $nprice  , Remaining = $qty where Name = '$name' and category = '$category' and Price = $oprice";
        mysqli_query($connect,$update);

    }


    if(isset($_POST['delete']))
    {
        $category = $_POST['category'];
        $id = $_POST['id'];
        $price = $_POST['price'];

        $delete = "DELETE FROM product where category='$category' and ID = $id and Price = $price";
        mysqli_query($connect,$delete);

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
                <div class="heading-text"><p>Product</p></div>
            </div>
        </div>

        <div class="crud-area" id = "crud">
            <form action="" method="post">
            <div class="crud-area-container">
                <div class="crud">
                    <input type="button" name="button" value="View" onclick="toggleview()">
                </div> 

                <div class="crud">
                    <input type="button" name="button" value="Insert" onclick="toggle()">
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
                    <label>Category:</label>
                    <input type="text" name="category"/>
                    <label>Name:</label>
                    <input type="text" name ="Name"/>
                    <label>Price:</label>
                    <input type="text" name="price">
                    <label>Quantity:</label>
                    <input type="text" name="qty">
                    <input type="submit" name="insert" value="submit">
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
                        <label>Quantity:</label>
                        <input type="text" name="qty">
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