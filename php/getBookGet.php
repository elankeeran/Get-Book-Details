<?php

// include the class
require_once 'amazon.php';
$isbn=$_POST['isbn'];
$Amazon=new Amazon();

$parameters=array(
"region"=>"com",
"AssociateTag"=>'affiliateTag',
"Condition"=>"All",
"Operation"=>"ItemSearch",
'ResponseGroup'=>'Large',
"SearchIndex"=>"Books",
"Keywords"=>$isbn //"145161036X"
);

$queryUrl=$Amazon->getSignedUrl($parameters);

$response=simplexml_load_file($queryUrl);
//print_r($response);

if($response->Items->TotalResults > 0)
{

   // we have at least one response
  $imagesrc=$response->Items->Item->LargeImage->URL;
  $Author=$response->Items->Item->ItemAttributes->Author;
  $title=$response->Items->Item->ItemAttributes->Title;
  $publisher=$response->Items->Item->ItemAttributes->Publisher;
  $ISBN13=$response->Items->Item->ItemAttributes->EAN;
  $ISBN10=$response->Items->Item->ItemAttributes->ISBN;
  $numberOfPages=$response->Items->Item->ItemAttributes->NumberOfPages;
  $languages=$response->Items->Item->ItemAttributes->Languages->Language->Name;
    $binding=$response->Items->Item->ItemAttributes->Binding;
	$pDate=$response->Items->Item->ItemAttributes->PublicationDate;
  $alt=$title ."  by ". $Author;
$objEditorialReviews=$response->Items->Item->EditorialReviews;
}
else
{
   // no response, show some other image
  $imgesrc='no-image.png';
  $alt='no book image';
}
?>
<!-- show the image -->


Title : <?php echo $title; ?>
<br/>
Author(s) : <?php echo $Author; ?>
<br/>
Publisher : <?php echo $publisher; ?>
<br/>
ISBN13 : <?php echo $ISBN13; ?>
<br/>
ISBN10 : <?php echo $ISBN10; ?>
<br/>
Edition Information: <?php echo $binding . ", " . $pDate ; ?>
<br/>
Language: <?php echo $languages; ?>
<br/>
Number of Page: <?php echo $numberOfPages; ?>
<br/>
<img src="<?php echo $imagesrc;?>"  title="<?php echo $alt; ?>" />
<br>

<?php
//print_r($objEditorialReviews);

foreach($objEditorialReviews as $EditorialReview)
{
 
 echo "<h3>Description:</h3>";
 echo($EditorialReview->EditorialReview->Content);
}


?>