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

if($response->Items->TotalResults > 0)
{
	foreach($response->Items->Item as $eachItem){
		// we have at least one response
		$imagesrc=$eachItem->LargeImage->URL;
		$Author=$eachItem->ItemAttributes->Author;
		$title=$eachItem->ItemAttributes->Title;
		$publisher=$eachItem->ItemAttributes->Publisher;
		$ISBN13=$eachItem->ItemAttributes->EAN;
		$ISBN10=$eachItem->ItemAttributes->ISBN;
		$numberOfPages=$eachItem->ItemAttributes->NumberOfPages;
		$languages=$eachItem->ItemAttributes->Languages->Language->Name;
		$binding=$eachItem->ItemAttributes->Binding;
		$pDate=$eachItem->ItemAttributes->PublicationDate;
		$alt=$title ."  by ". $Author;
		$objEditorialReviews=$eachItem->EditorialReviews;
?>
	Title : <?php echo $title; ?>	<br/>
	Author(s) : <?php echo $Author; ?><br/>
	Publisher : <?php echo $publisher; ?><br/>
	ISBN13 : <?php echo $ISBN13; ?><br/>
	ISBN10 : <?php echo $ISBN10; ?><br/>
	Edition Information: <?php echo $binding . ", " . $pDate ; ?><br/>
	Language: <?php echo $languages; ?><br/>
	Number of Page: <?php echo $numberOfPages; ?><br/>
	<?php if($imagesrc!=""){ ?>
		<img src="<?php echo $imagesrc;?>"  title="<?php echo $alt; ?>" />
	<?php }else{ ?>
		<img src="images/no_book_cover1.jpg"  title="<?php echo $alt; ?>" />
	<?php } ?>
	<br>
<?php
		foreach($objEditorialReviews as $EditorialReview)
		{
			echo "<h3>Description:</h3>";
			echo($EditorialReview->EditorialReview->Content);
		}
	}
}else{
?>
  <h3>Book not available</h3>
  <p>Please try with different books</p>
<?php
	}
?>
