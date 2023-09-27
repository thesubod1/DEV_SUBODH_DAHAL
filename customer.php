<?php
//try single connect
    $id = array();
    $name = array();
    $contact = array();
    $address = array();

    $connect = mysqli_connect("localhost","root","","dev_subodh");
    $query = "SELECT * FROM `customer`";
    $count = "SELECT COUNT(*) FROM `customer`";
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
                elseif($key == "Name")
                {
                    array_push($name,$val);
                }
                elseif($key == "Contact")
                {
                    array_push($contact,$val);
                }
                else 
                {
                    array_push($address,$val);
                }
        }
    }
    $head = array('ID','Name','Contact','Address');
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
            echo"<td>$name[$i]</td>";
            echo"<td>$contact[$i]</td>";
            echo"<td>$address[$i]</td>";

        }
        echo"</tr>";
    }
    echo"</table>";
    
    



    if(isset($_POST['insert']))
    {
        $contact = $_POST['Contact'];
        $address = $_POST['Address'];
        $name = $_POST['Name'];

        $insert = "insert into customer(ID,Name,Contact,Address) values('','$name','$contact','$address')";
        mysqli_query($connect,$insert);

    }


    if(isset($_POST['update']))
    {
        $ocontact = $_POST['oldcontact'];
        $ncontact = $_POST['newcontact'];
        $oaddress = $_POST['oldAddress'];
        $naddress = $_POST['newAddress'];
        $name = $_POST['Name'];
        $update = "update customer set Contact = '$ncontact' and Address = '$naddress' where Name = '$name' and  Contact = '$ocontact' and Address = '$oaddress'";
        mysqli_query($connect,$update);

    }


    if(isset($_POST['delete']))
    {
        $contact = $_POST['contact'];
        $address = $_POST['Address'];
        $name = $_POST['Name'];

        $delete = "DELETE FROM customer where Name='$name' and Contact = '$contact' and Address = '$address'";
        mysqli_query($connect,$delete);

    }

?>


<!DOCTYTPE html>
<html>
    <head>
        <title>Customer</title>
        <link rel="stylesheet" type="text/css" href="css/product.css">
    </head>
    <body>
        <div class="heading">
            <div class="heading-container">
                <div class="heading-text"><p>Customer</p></div>
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
                    <label>Name:</label>
                    <input type="text" name ="Name"/>
                    <label>Contact:</label>
                    <input type="text" name="Contact">
                    <label>Address:</label>
                    <input type="text" name="Address">
                    <input type="submit" name="insert" value="submit">
                </div>
            </form>
        </div>

        <div class="update-form" id="update">
            <form action="" method="post">
                    <div class="insert-container">
                    <label>Name:</label>
                    <input type="text" name ="Name"/>
                    <label>Old_Contact:</label>
                    <input type="text" name="oldcontact">
                    <label>Old_Address:</label>
                    <input type="text" name="oldAddress">
                    <label>New_Contact:</label>
                    <input type="text" name="newcontact">
                    <label>Old_Address:</label>
                    <input type="text" name="newAddress">
                        <input type="submit" name="update" value="update">
                    </div>
            </form>
        </div>

        <div class="delete-form" id = "delete">
            <form action="" method="post">
                <div class="insert-container">
                <label>Name:</label>
                    <input type="text" name ="Name"/>
                    <label>Contact:</label>
                    <input type="text" name="contact">
                    <label>Address:</label>
                    <input type="text" name="Address">
                    <input type="submit" name="delete" value="Delete">
                </div>
            </form>
        </div>
        <script src="css/script/script.js"></script>
    </body>
</html>