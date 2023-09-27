<?php
   
    $id = array('1','2','3','4');
    $s_date = '2022-5-15';
    $e_date = '2024-5-15';

    function bill($id,$s_date,$e_date)
    {
        $connect  = mysqli_connect("localhost","root","","dev_subodh");
        $amt = "SELECT SUM(Amount) FROM sales where Customer_id = $id and Transaction_Date >= '$s_date' and Transaction_Date <= '$e_date' ";
        $amt_qry = mysqli_query($connect,$amt);
        $amt_ary = mysqli_fetch_array($amt_qry);
        return($amt_ary[0]);
    }

    for($i = 0; $i < COUNT($id); $i++)
    {
        $amt =  bill($id[$i],$s_date,$e_date);

        if($amt <= 1000)
        {
            $amt = ($amt - ($amt*0.05));
        }
        elseif($amt > 1000)
        {
            $amt = ($amt - ($amt*0.1));
        }
        echo $amt,"</br>";

    }
?>



<?php

function getCustomerInformation($jsonParams) {
    $params = json_decode($jsonParams, true);
    $startDate = $params['startDate'];
    $endDate = $params['endDate'];
    $customerId = isset($params['customerId']) ? $params['customerId'] : null;
    
    
    $conn = mysqli_connect("localhost","root","","dev_subodh");
    
    $sql = "SELECT * FROM Customer ";
    if ($customerId) {
        $sql .= "WHERE ID = $customerId ";
    }
    $sql .= "AND ID IN (SELECT Customer_Id FROM Sales WHERE Transaction_Date BETWEEN '$startDate' AND '$endDate')";
    
    $result = $conn->query($sql);
    

    $customers = array();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customerId = $row['ID'];
            $customerName = $row['Name'];
            $customerContact = $row['Contact'];
            $customerAddress = $row['Address'];
            
            $invoices = array();
            $totalInvoice = 0;
            
            
            $invoiceQuery = "SELECT SUM(Amount) AS totalInvoice FROM Invoice WHERE Customer_Id = $customerId";
            $invoiceResult = $conn->query($invoiceQuery);
            
            if ($invoiceResult->num_rows > 0) {
                $invoiceRow = $invoiceResult->fetch_assoc();
                $totalInvoice = $invoiceRow['totalInvoice'];
            }
            
            
            $customerData = array(
                'customerID' => $customerId,
                'customerName' => $customerName,
                'customerContact' => $customerContact,
                'customerAddress' => $customerAddress,
                'totalInvoice' => $totalInvoice
            );
            
            $customers[] = $customerData;
        }
    }
    
    
    $conn->close();
    
    
    return json_encode($customers);
}


$jsonParams = '{
    "startDate": "2023-01-01",
    "endDate": "2023-12-31",
    "customerId": 5
}';

$customerInformation = getCustomerInformation($jsonParams);
echo $customerInformation;

?>






