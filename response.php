 <?php
  	// set_include_path('../lib'.PATH_SEPARATOR.get_include_path());
  	include('citrusClass.php'); 
	//Replace this with your secret key from the citrus panel
	$flag = "true";
	 if($citrusResponse->getSignature() != "" && strcmp($citrusResponse->getSignature(), $citrus->generateSignature($citrusResponse->getData())) != 0) {
		$flag = "false";
	 }
    ?>
    <html>
    <head>
        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=iso-8859-1">
    </head>
    <body>
        <?php 
        if ($flag == "true") {	
        ?>
        Your Unique Transaction/Order Id : <?php echo $citrusResponse->Txnid; ?>
        Transaction Status : <?php echo $citrusResponse->TxStatus; ?>
        <?php } else { ?>
        Citrus Response Signature and Our (Merchant) Signature Mis-Mactch 
        <?php }	?>
    </body>
    </html>