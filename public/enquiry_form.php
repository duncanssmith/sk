<h1>
Enquiry form
</h1>
<?php
  if (isset($errors['main'])){
    #echo "<span class=\"mandatory_form_field_error\">".$errors['main']."</span><br /><br />\n";
    echo "<h4>".$errors['main']."</h4><br />\n";
  }else{
    echo "<p>";
    echo "Complete the form below to submit an enquiry.";
    echo "</p>";
  }
?>

<form accept-charset="UTF-8" action="index.php?pageid=5.0" class="" enctype="multipart/form-data" id="" method="post">
  <input name="utf8" type="hidden" value="&#x2713;" />
  <input name="authenticity_token" type="hidden" value="u6wpG9k6+uK3yj8ogRQua122IqzXoUHPNOjmytdF818=" />
  <label for="enquiry_title">Title</label>
  <br />
  <select id="enquiry_title" type="text" name="enquiry[title]" >
    <option value=""> - </option>
    <option value="Mr">Mr</option>
    <option value="Ms">Ms</option>
    <option value="Mrs">Mrs</option>
    <option value="Miss">Miss</option>
    <option value="Dr">Dr</option>
  </select>

  <br />
<?php
  if(isset($errors['fname'])){
    echo "<br /><span class=\"mandatory_form_field_error\">".$errors['fname']."</span><br />\n";
  }
?>
  <label for="enquiry_fname">First name</label>
  <br />
<?php
  if(isset($_POST['enquiry']['fname'])){
    printf("<input id=\"enquiry_fname\" name=\"enquiry[fname]\" size=\"30\" type=\"text\" value=\"%s\" />", $_POST['enquiry']['fname']);
  }else{
    print "<input id=\"enquiry_fname\" name=\"enquiry[fname]\" size=\"30\" type=\"text\" />";
  }
?>
  <br />
<?php
  if(isset($errors['lname'])){
    echo "<br /><span class=\"mandatory_form_field_error\">".$errors['lname']."</span><br />\n";
  }
?>
  <label for="enquiry_lname">Last name</label>
  <br />
<?php
  if(isset($_POST['enquiry']['lname'])){
    printf("<input id=\"enquiry_lname\" name=\"enquiry[lname]\" size=\"30\" type=\"text\" value=\"%s\" />", $_POST['enquiry']['lname']);
  }else{
    print "<input id=\"enquiry_lname\" name=\"enquiry[lname]\" size=\"30\" type=\"text\" />";
  }
?>
  <br />
<?php
  if(isset($errors['email'])){
    echo "<br /><span class=\"mandatory_form_field_error\">".$errors['email']."</span><br />\n";
  }
  if(isset($errors['email_format'])){
    echo "<br /><span class=\"mandatory_form_field_error\">".$errors['email_format']."</span><br />\n";
  }
?>
  <label for="enquiry_email">Email address</label>
  <br />
<?php
  if(isset($_POST['enquiry']['email'])){
    printf("<input id=\"enquiry_email\" name=\"enquiry[email]\" size=\"30\" type=\"text\" value=\"%s\" />", $_POST['enquiry']['email']);
  }else{
    print "<input id=\"enquiry_email\" name=\"enquiry[email]\" size=\"30\" type=\"text\" />";
  }
?>

  <br />
<?php
  if(isset($errors['enquiry_text'])){
    echo "<br /><span class=\"mandatory_form_field_error\">".$errors['enquiry_text']."</span><br />\n";
  }
?>
  <label for="enquiry_text">Enquiry (up to 400 words)</label>
  <br />
<?php
  if(isset($_POST['enquiry']['enquiry_text'])){
    printf("<textarea id=\"enquiry_enquiry_text\" name=\"enquiry[enquiry_text]\" cols=\"64\" rows=\"12\" size=\"4096\" type=\"text\">%s</textarea>", $_POST['enquiry']['enquiry_text']);
  }else{
    print "<textarea id=\"enquiry_enquiry_text\" name=\"enquiry[enquiry_text]\" cols=\"64\" rows=\"12\" size=\"2048\" type=\"text\"></textarea>";
  }
?>
<!--  <br />
  <label for="image_file">Photo upload (files up to 2MB)</label>
  <br>
-->
<?php
#  if(isset($_FILES['image_file'])){
#    printf("<input id=\"image_file\" name=\"image_file\" type=\"file\" value=\"%s\">%s</input>", $_FILES['image_file']['name'], $_FILES['image_file']['name']);
#  }else{
#    print "<input id=\"image_file\" name=\"image_file\" type=\"file\" />";
#  }
?>

  <br />
  <br />


  <input type="submit" name="submit" value="submit" />
</form>


<div style="margin:0;padding:0;display:inline">
</div>


