<?php include('citrusClass.php');   
$citrus->orderAmount = "1.00";
$st = '********|4323532|NA|1868.00|NA|NA|NA|INR|NA|R|*****|NA|NA|F|02-268|3977610|NA|NA|NA|NA|NA|http://*****/***/Mobile/Payment/ProcessCallback2|19681C59C46ED3B462DAED2587DC9B85E5C48AB1D58810B8A5F80685031FF246';
      var_dump($citrus->assignData($st));
      ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
 <html>
     <head>
         <meta HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=iso-8859-1">
     </head>
     <body>
        <form align="center" method="post" action="<?php echo $citrus->formPostUrl; ?>">
             <input type="hidden" id="merchantTxnId" name="merchantTxnId" value="<?php echo $citrus->merchant_id; ?>" />
             <input type="hidden" id="orderAmount" name="orderAmount" value="<?php echo $citrus->orderAmount; ?>" />
             <input type="hidden" id="currency" name="currency" value="<?php echo $citrus->currency; ?>" />
             <input type="hidden" name="returnUrl" value="<?php echo $citrus->returnURL; ?>" />
             <input type="hidden" id="notifyUrl" name="notifyUrl" value="<?php echo $citrus->notifyUrl; ?>" />
             <input type="hidden" id="secSignature" name="secSignature" value="<?php echo $citrus->getSignature() ;?>" />
             <input type="Submit" value="Pay Now"/>
        </form>
        <form align="center" method="post" action="<?php echo $billdesk->PostUrl; ?>">
             <input type="hidden" id="secSignature" name="msg" value="<?php echo $billdesk->getPostData() ;?>" />
             <input type="Submit" value="Pay Now"/>
        </form>
     </body>
 </html>
