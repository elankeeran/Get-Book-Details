$(document).ready(function(){
var isbn;
  $("#getBook").click(function(){ // when you click the button
    // fade out bookinfo div
	$("#bookInfo").fadeOut("slow");
	// assign isbn value to var isbn
    isbn=$("#isbn").val();
	// send isbn value as POST variable "isbn" and load result in bookinfo div
    $("#bookInfo").load("../php/getBookGet.php",{isbn:isbn},function(){
	    // fade in bookinfo div
	 	$("#bookInfo").fadeIn("slow");
	});
  });
});