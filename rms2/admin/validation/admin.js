//function to handle login-form validation
function loginValidate(loginForm){

var validationVerified=true;
var errorMessage="";

if (loginForm.login.value=="")
{
errorMessage+="Username not filled!\n";
validationVerified=false;
}
if(loginForm.password.value=="")
{
errorMessage+="Password not filled!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

function updateValidate(updateForm) {
    var validationVerified=true;
var errorMessage="";

if (updateForm.opassword.value=="")
{
errorMessage+="Please provide your current password.\n";
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
errorMessage+="Confirm password and new password do not match!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//validate staffForm
function staffValidate(staffForm) {
    var validationVerified=true;
var errorMessage="";

if (staffForm.fName.value=="")
{
errorMessage+="Please provide the staff first name.\n";
validationVerified=false;
}
if (staffForm.lName.value=="")
{
errorMessage+="Please provide the staff last name.\n";
validationVerified=false;
}
if (staffForm.sAddress.value=="")
{
errorMessage+="Please provide the staff street address.\n";
validationVerified=false;
}
if(staffForm.mobile.value=="")
{
errorMessage+="Please provide the staff mobile/telephone number.\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle specialsForm validation
function specialsValidate(specialsForm){

var validationVerified=true;
var errorMessage="";

if (specialsForm.name.value=="")
{
errorMessage+="name not filled!\n";
validationVerified=false;
}
if (specialsForm.description.value=="")
{
errorMessage+="description not filled!\n";
validationVerified=false;
}
if (specialsForm.price.value=="")
{
errorMessage+="price not filled!\n";
validationVerified=false;
}
if(specialsForm.start_date.value=="")
{
errorMessage+="start date not filled!\n";
validationVerified=false;
}
if(specialsForm.end_date.value=="")
{
errorMessage+="end date not filled!\n";
validationVerified=false;
}
if (specialsForm.photo.value=="")
{
errorMessage+="photo not selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle foodsForm validation
function foodsValidate(foodsForm){

var validationVerified=true;
var errorMessage="";

if(foodsForm.name.value=="")
{
errorMessage+="food name not filled!\n";
validationVerified=false;
}
if(foodsForm.price.value=="")
{
errorMessage+="food price not filled!\n";
validationVerified=false;
}
if(foodsForm.category.selectedIndex==0)
{
errorMessage+="please select a food category!\n";
validationVerified=false;
}
if(foodsForm.photo.value=="")
{
errorMessage+="food photo not selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle categoriesForm validation
function categoriesValidate(categoriesForm){

var validationVerified=true;
var errorMessage="";

if (categoriesForm.name.value=="")
{
errorMessage+="category name not filled!\n";
validationVerified=false;
}
if (categoriesForm.category.selectedIndex==0)
{
errorMessage+="please select a category to remove.\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle quantitiesForm validation
function quantitiesValidate(quantitiesForm){

var validationVerified=true;
var errorMessage="";

if (quantitiesForm.name.value=="")
{
errorMessage+="quantity value not filled!\n";
validationVerified=false;
}
if (quantitiesForm.quantity.selectedIndex==0)
{
errorMessage+="please select a quantity value to remove.\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle currenciesForm validation
function currenciesValidate(currenciesForm){

var validationVerified=true;
var errorMessage="";

if (currenciesForm.name.value=="")
{
errorMessage+="currency/symbol not filled!\n";
validationVerified=false;
}
if (currenciesForm.currency.selectedIndex==0)
{
errorMessage+="there is no currency selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle ratingForm validation
function ratingsValidate(ratingsForm){

var validationVerified=true;
var errorMessage="";

if (ratingsForm.name.value=="")
{
errorMessage+="rate level not filled!\n";
validationVerified=false;
}
if (ratingsForm.rating.selectedIndex==0)
{
errorMessage+="rate level not selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle timezonesForm validation
function timezonesValidate(timezonesForm){

var validationVerified=true;
var errorMessage="";

if (timezonesForm.name.value=="")
{
errorMessage+="timezone not filled!\n";
validationVerified=false;
}
if (timezonesForm.timezone.selectedIndex==0)
{
errorMessage+="timezone not selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle tablesForm validation
function tablesValidate(tablesForm){

var validationVerified=true;
var errorMessage="";

if (tablesForm.name.value=="")
{
errorMessage+="table name/number not filled!\n";
validationVerified=false;
}
if (tablesForm.table.selectedIndex==0)
{
errorMessage+="table not selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle partyhallsForm validation
function partyhallsValidate(partyhallsForm){

var validationVerified=true;
var errorMessage="";

if (partyhallsForm.name.value=="")
{
errorMessage+="partyhall name/number not filled!\n";
validationVerified=false;
}
if (partyhallsForm.partyhall.selectedIndex==0)
{
errorMessage+="partyhall not selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle questionsForm validation
function questionsValidate(questionsForm){

var validationVerified=true;
var errorMessage="";

if (questionsForm.name.value=="")
{
errorMessage+="question not filled!\n";
validationVerified=false;
}
if (questionsForm.question.selectedIndex==0)
{
errorMessage+="question not selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle foodStatusForm validation
function statusValidate(foodStatusForm){

var validationVerified=true;
var errorMessage="";

if (foodStatusForm.food.selectedIndex==0)
{
errorMessage+="food not selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle ordersAllocation form validation
function ordersAllocationValidate(allocationForm){

var validationVerified=true;
var errorMessage="";

if (allocationForm.orderid.selectedIndex==0)
{
errorMessage+="Order ID not selected!\n";
validationVerified=false;
}
if(allocationForm.staffid.selectedIndex==0)
{
errorMessage+="Staff ID not selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle reservationsAllocation form validation
function reservationsAllocationValidate(allocationForm){

var validationVerified=true;
var errorMessage="";

if (allocationForm.reservationid.selectedIndex==0)
{
errorMessage+="Reservation ID not selected!\n";
validationVerified=false;
}
if(allocationForm.staffid.selectedIndex==0)
{
errorMessage+="Staff ID not selected!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}

//function to handle message validation
function messageValidate(messageForm){

var validationVerified=true;
var errorMessage="";

if (messageForm.subject.value=="")
{
errorMessage+="subject not filled!\n";
validationVerified=false;
}
if (messageForm.txtmessage.value=="")
{
errorMessage+="message box not filled!\n";
validationVerified=false;
}
if(!validationVerified)
{
alert(errorMessage);
}
return validationVerified;
}