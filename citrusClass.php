<?php 

define("POST_URL",  "https://sandbox.citruspay.com/xxxxxx"); //  add sand box url with vanityUrl given in your citrusPay account
define("SECRET_KEY",     "xxxxxxxxxxxxxxxxxxxxxxxxx"); // Add secretkey given in your citrus Pay Account.
define("VANITY_URL",     "xxxxxxxxxx"); // Add vanity Url given in your Citrus Pay Account.
define("RETURN_URL",     'http://'.$_SERVER['SERVER_ADDR']."/citrus/response.php"); // Return Url (Callback after payment)
define("NOTIFY_URL",     'http://'.$_SERVER['SERVER_ADDR']."/citrus/notifyResponsePage"); // IPN callback 
define("SIGNATURE_HASHING",     "sha1"); // sha is being used here for Signature Creation
/**
 * author@nswapt@gmail.com
 * Citrus Pay Class
 */
class payCitrus{
	public function __construct(){
		$this->merchant_id = uniqid();
		$this->formPostUrl = POST_URL;	
		$this->secret_key = SECRET_KEY;	
		$this->vanityUrl = VANITY_URL;
    	$this->orderAmount = 0.00;
	    $this->currency = "INR"; 
	    $this->returnURL = RETURN_URL;
    	//Need to change with your Notify URL
        $this->notifyUrl = NOTIFY_URL;
	}
	
	//Need to replace the last part of URL("your-vanityUrlPart") with your Testing/Live URL
    
    //Need to change with your Secret Key
    
             
    //Need to change with your Vanity URL Key from the citrus panel
    
	
    //Need to change with your Order Amount
    /**
    * author@nswapt@gmail.com
    * description@generates data for Signature Creation 
     */
    public function getData(){
    	return $this->vanityUrl.$this->orderAmount.$this->merchant_id.$this->currency;
    }
    public function assignData($string = null){
    	if($string != null){
    		$string = explode('|', $string);
    		$this->merchant_id = $string[1];
    		$this->orderAmount = $string[3];
    		return true;
    	}
    	return false;
    }
    //Need to change with your Return URL

    /**
   * author@nswapt@gmail.com
   * Citrus Signature Creation
   */
    public function getSignature(){
    	return  hash_hmac(SIGNATURE_HASHING, $this->getData(), $this->secret_key);
    }
    public function generateSignature($data = null ){
    	return  hash_hmac(SIGNATURE_HASHING, $data, $this->secret_key);
    }

}
/**
 * author@nswapt@gmail.com
 * Citrus Response Receiving Class which would be used in Notify and Return URl Both.
 */
class responseCitrus{
	public function __construct(){
		$this->response = array();
		$this->response = $_POST;
		$this->TxStatus = '';
		$this->Txnid = '';
	}
	public function getSignature(){
		if(isset($this->response['signature'])) {
			return $this->response['signature'];
		}
		return false;
	}
	public function getData(){
		$data = "";
		$flag = "true";	
		if(isset($this->response['TxId'])) {
			$this->Txnid = $this->response['TxId'];
			$data .= $this->Txnid;
		}
		 if(isset($this->response['TxStatus'])) {
			$this->TxStatus = $this->response['TxStatus'];
			$data .= $this->TxStatus;
		 }
		 if(isset($this->response['amount'])) {
			$amount = $this->response['amount'];
			$data .= $amount;
		 }
		 if(isset($this->response['pgTxnNo'])) {
			$pgtxnno = $this->response['pgTxnNo'];
			$data .= $pgtxnno;
		 }
		 if(isset($this->response['issuerRefNo'])) {
			$issuerrefno = $this->response['issuerRefNo'];
			$data .= $issuerrefno;
		 }
		 if(isset($this->response['authIdCode'])) {
			$authidcode = $this->response['authIdCode'];
			$data .= $authidcode;
		 }
		 if(isset($this->response['firstName'])) {
			$firstName = $this->response['firstName'];
			$data .= $firstName;
		 }
		 if(isset($this->response['lastName'])) {
			$lastName = $this->response['lastName'];
			$data .= $lastName;
		 }
		 if(isset($this->response['pgRespCode'])) {
			$pgrespcode = $this->response['pgRespCode'];
			$data .= $pgrespcode;
		 }
		 if(isset($this->response['addressZip'])) {
			$pincode = $this->response['addressZip'];
			return $data .= $pincode;
		 }
		 return false;
	}
	public function checkStatus(){
		switch ($this->TxStatus) {
			case 'SUCCESS':
				return 'Transaction is successful';
				break;
			
			case 'FAIL':
				return 'Transaction is failed.';
				break;

			case 'User Dropped':
				return 'Transaction not initiated by customer.';
				break;

			case 'CANCELED':
				return 'Transaction cancelled by customer.';
				break;

			case 'FORWARDED':
				return 'Transaction redirected to bank’s login page or 3d secure page but Citrus did not get response back.';
				break;

			case 'PG_FORWARD_FAIL':
				return 'Transaction could not be forwarded to issuer/pg due to connectivity issue.';
				break;

			case 'INQUIRY_STATUS_FAILED':
				return 'Transaction not completed by consumer';
				break;

			case 'SESSION_EXPIRED':
				return 'Transaction not completed by customer with 30 min.';
				break;

			case 'REFUND_INITIATED':
				return 'Refund initiated';
				break;

			case 'REFUND_FORWARDED':
				return 'Refund in process';
				break;

			case 'REFUND_PROCESS':
				return 'Refund in process';
				break;

			case 'REFUND_SUCCESS':
				return 'Refund success';
				break;

			case 'REFUND_FAILED':
				return 'Could not mark refund of transaction.';
				break;

			case 'DEBIT_REQ_SENT':
				return 'Pending verification.';
				break;

			case 'SUCCESS_ON_VERIFICATION':
				return 'Transaction got successful in server to server (S2S) verification with bank/issuer.';
				break;

			case 'PG_REJECTED':
				return 'These are the transactions which Citrus rejects';
				break;

			case 'REVERSED':
				return 'This is the transaction whose amount got debited at runtime but Citrus has either not received response from bank/pg or has received unexpected response from bank/pg';
				break;

			case 'ON_HOLD':
				return 'This is transaction rejected by risk engine.It can be due to transaction observer with the same IP within short span of time.Card BIN is nnot domestic etc.';
				break;

			
			default:
				return 'Error Occurred';
				break;
		}
	}
}
	$citrus = new payCitrus(); 
	$citrusResponse = new responseCitrus();
?>
