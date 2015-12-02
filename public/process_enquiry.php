<?php

if(isset($_POST['enquiry'])){
  $errors=validate_form();
  if(sizeof($errors)!=0){
    include "enquiry_form.php";
  }else{ // Form successfully submitted
?>
  <h1> Thank you for your enquiry </h1>
  <p> We will contact you as soon as possible.  </p>
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <br />

<?php

    if(isset($_FILES['image_file'])){
      save_uploaded_image_file();
    }
    build_email_response();
  }
}else{
  include "enquiry_form.php";
}
  
?>
