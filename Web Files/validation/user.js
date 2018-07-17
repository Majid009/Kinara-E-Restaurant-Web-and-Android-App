//function to handle login-form validation
function loginValidate(loginForm){

var validationVerified=true;
var errorMessage="";

if (loginForm.login.value=="")
{
errorMessage+="Email not filled!\n";
validationVerified=false;
}
if(loginForm.password.value=="")
{
errorMessage+="Password not filled!\n";
validationVerified=false;
}
if (!isValidEmail(loginForm.login.value)) {
errorMessage+="Invalid email address provided!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle register-form validation
function registerValidate(registerForm){

var validationVerified=true;
var errorMessage="";

if (registerForm.fname.value=="")
{
errorMessage+="Firstname not filled!\n";
validationVerified=false;
}
if(registerForm.lname.value=="")
{
errorMessage+="Lastname not filled!\n";
validationVerified=false;
}
if (registerForm.login.value=="")
{
errorMessage+="Email not filled!\n";
validationVerified=false;
}
if(registerForm.password.value=="")
{
errorMessage+="Password not provided!\n";
validationVerified=false;
}
if(registerForm.cpassword.value=="")
{
errorMessage+="Confirm password not filled!\n";
validationVerified=false;
}
if(registerForm.cpassword.value!=registerForm.password.value)
{
errorMessage+="Password and Confirm Password do not match!\n";
validationVerified=false;
}
if (!isValidEmail(registerForm.login.value)) {
errorMessage+="Invalid email address provided!\n";
validationVerified=false;
}
if(registerForm.question.selectedIndex==0)
{
errorMessage+="Question not selected!\n";
validationVerified=false;
}
if(registerForm.answer.value=="")
{
errorMessage+="Answer not filled!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//validate email function
function isValidEmail(val) {
	var re = /^[\w\+\'\.-]+@[\w\'\.-]+\.[a-zA-Z]{2,}$/;
	if (!re.test(val)) {
		return false;
	}
    return true;
}

//validate special PIN
function isValidSpecialPIN(val) {
	var re = /^[0-9][0-9][A-Z][A-Z][A-Z][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/;
	if (!re.test(val)) {
		return false;
	}
	return true;
}

//validate special PIN length
function isValidLength(val){
	var length = 12;
	if (!re.test(val)) {
		return false;
	}
	return true;
}

//function to handle passwordResetForm validation
function passwordResetValidate(resetForm){

var validationVerified=true;
var errorMessage="";

if (resetForm.email.value=="")
{
errorMessage+="Please enter your account email! We need your email in order to reset your password.\n";
validationVerified=false;
}
if (!isValidEmail(resetForm.email.value)) {
errorMessage+="Invalid email address provided!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle passwordResetForm validation(2)
function passwordResetValidate_2(resetForm){

var validationVerified=true;
var errorMessage="";

if (resetForm.answer.value==""){
errorMessage+="Please enter your security answer to your provided security question.\n";
validationVerified=false;
}
if (resetForm.new_password.value==""){
errorMessage+="New Password not set!\n";
validationVerified=false;
}
if (resetForm.confirm_new_password.value==""){
errorMessage+="Confirm New Password not set!\n";
validationVerified=false;
}
if (resetForm.new_password.value!=resetForm.confirm_new_password.value){
errorMessage+="New Password and Confirm New Password do not match!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

// onchange of qty field entry totals the price
function getProductTotal(field) {
    clearErrorInfo();
    var form = field.form;
	if (field.value == "") field.value = 0;
	if ( !isPosInt(field.value) ) {
        var msg = 'Please enter a positive integer for quantity.';
        addValidationMessage(msg);
        addValidationField(field)
        displayErrorInfo( form );
        return;
	} else {
		var product = field.name.slice(0, field.name.lastIndexOf("_") ); 
        var price = form.elements[product + "_price"].value;
		var amt = field.value * price;
		form.elements[product + "_tot"].value = formatDecimal(amt);
		doTotals(form);
	}
}

function doTotals(form) {
    var total = 0;
    for (var i=0; PRODUCT_ABBRS[i]; i++) {
        var cur_field = form.elements[ PRODUCT_ABBRS[i] + "_qty" ]; 
        if ( !isPosInt(cur_field.value) ) {
            var msg = 'Please enter a positive integer for quantity.';
            addValidationMessage(msg);
            addValidationField(cur_field)
            displayErrorInfo( form );
            return;
        }
        total += parseFloat(cur_field.value) * parseFloat( form.elements[ PRODUCT_ABBRS[i] + "_price" ].value );
    }
    form.elements['total'].value = formatDecimal(total);
}

//validate orderform
function finalCheck(orderForm) {
    var validationVerified=true;
var errorMessage="";

if (orderForm.quantity.value=="")
{
errorMessage+="Please provide a quantity.\n";
validationVerified=false;
}
if (orderForm.quantity.value==0)
{
errorMessage+="Please provide a quantity rather than 0.\n";
validationVerified=false;
}
if(orderForm.total.value=="")
{
errorMessage+="Total has not been calculated! Please provide first the quantity.\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//validate updateForm
function updateValidate(updateForm) {
    var validationVerified=true;
var errorMessage="";

if (updateForm.opassword.value=="")
{
errorMessage+="Please provide your old password.\n";
validationVerified=false;
}
if (updateForm.npassword.value=="")
{
errorMessage+="Please provide a new password.\n";
validationVerified=false;
}
if(updateForm.cpassword.value=="")
{
errorMessage+="Please confirm your new password.\n";
validationVerified=false;
}
if(updateForm.cpassword.value!=updateForm.npassword.value)
{
errorMessage+="Confirm Password and New Password do not match!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//validate billingForm
function billingValidate(billingForm) {
    var validationVerified=true;
var errorMessage="";

if (billingForm.sAddress.value=="")
{
errorMessage+="Please provide a street address.\n";
validationVerified=false;
}
if (billingForm.box.value=="")
{
errorMessage+="Please provide your postal box number.\n";
validationVerified=false;
}
if (billingForm.city.value=="")
{
errorMessage+="Please provide your city.\n";
validationVerified=false;
}
if(billingForm.mNumber.value=="")
{
errorMessage+="Please provide your mobile number.\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//validate table form
function tableValidate(tableForm){

var validationVerified=true;
var errorMessage="";

if (tableForm.table.selectedIndex==0)
{
errorMessage+="Please select a table by its name or number.\n";
validationVerified=false;
}
if (tableForm.date.value=="")
{
errorMessage+="Please provide a reservation date.\n";
validationVerified=false;
}
if (tableForm.time.value=="")
{
errorMessage+="Please provide a reservation time.\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//validate partyhall form
function partyhallValidate(partyhallForm){

var validationVerified=true;
var errorMessage="";

if (partyhallForm.partyhall.selectedIndex==0)
{
errorMessage+="Please select a partyhall by its name or number.\n";
validationVerified=false;
}
if (partyhallForm.date.value=="")
{
errorMessage+="Please provide a reservation date.\n";
validationVerified=false;
}
if (partyhallForm.time.value=="")
{
errorMessage+="Please provide a reservation time.\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//validate categories form
function categoriesValidate(categoriesForm){

var validationVerified=true;
var errorMessage="";

if (categoriesForm.category.selectedIndex==0)
{
errorMessage+="Please select a category first!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//validate quantity form
function updateQuantity(quantityForm){

var validationVerified=true;
var errorMessage="";

if (quantityForm.item.selectedIndex==0)
{
errorMessage+="Please select an item id first!\n";
validationVerified=false;
}
if (quantityForm.quantity.selectedIndex==0)
{
errorMessage+="Please select a quantity first!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//validate rating form
function ratingValidate(ratingForm){

var validationVerified=true;
var errorMessage="";

if (ratingForm.food.selectedIndex==0)
{
errorMessage+="Please select the food. This information is necessary in order to serve you better.\n";
validationVerified=false;
}
if (ratingForm.scale.selectedIndex==0)
{
errorMessage+="Please select the scale. This information is necessary in order to serve you better.\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//reset password popup
 function resetPassword()
 {
window.open('password-reset.php','resetPassword','toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=no,copyhistory=no,scrollbars=yes,width=480,height=400');
 }
 
 //validates quantity and redirects quantity to update-quantity.php
function getQuantity(int)
{
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }

    xmlhttp.open("GET","update-quantity.php?quantity_id="+int,true);
    xmlhttp.send();
}

//live clock function
function updateClock ( )
{
  var currentTime = new Date ( );

  var currentHours = currentTime.getHours ( );
  var currentMinutes = currentTime.getMinutes ( );
  var currentSeconds = currentTime.getSeconds ( );

  // Pad the minutes and seconds with leading zeros, if required
  currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
  currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

  // Choose either "AM" or "PM" as appropriate
  var timeOfDay = ( currentHours < 12 ) ? "AM" : "PM";

  // Convert the hours component to 12-hour format if needed
  currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

  // Convert an hours component of "0" to "12"
  currentHours = ( currentHours == 0 ) ? 12 : currentHours;

  // Compose the string for display
  var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

  // Update the time display
  document.getElementById("clock").innerHTML = currentTimeString;
}