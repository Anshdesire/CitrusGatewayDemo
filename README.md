# CitrusGatewayDemo
Citrus Payment GateWay Demo.


# demo.php 
is the page where gateway info need to be filled and post form step will be processed .

# response.php 
is the File where callback will be landing after payment is done.


#  citrusClass.php 
is the library where code and claass is written 

Need to configure 

POST_URL
SECRET_KEY
VANITY_URL   in citrusClass.php

there are two objects instantiated in library file 	$citrus (to generate data to post on citrus), $citrusResponse (to receive responce)
