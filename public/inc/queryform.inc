<?php
?>
<div id="queryform">
<form id="queryform" action="index.php?pageid=4.1" method="POST" >
 
<fieldset>
<legend>Your details
</legend>
<label for="title">Title</label>
<select>
<option value="">  </option>
<option value="Mr">Mr</option>
<option value="Ms">Ms</option>
<option value="Miss">Miss</option>
<option value="Mrs">Mrs</option>
<option value="Mrs">Dr</option>
</select>
<br/>
<label for="fname">First Name </label>
<input type="text" name="fname"></input>
<br/>
<label for="lname">Last Name</label>
<input type="text" name="lname"></input>
<br/>
<label for="email">Email</label>
<input type="text" name="email"></input>
<br/>
<p>I am interested in: </p>
<label for="both">1</label>
<input type="radio" name="querytype" value="1" checked="true"/>

<label for="voice">2</label>
<input type="radio" name="querytype" value="2"/>

<label for="presentation">3</label>
<input type="radio" name="querytype" value="3"/>

<label for="both">4</label>
<input type="radio" name="querytype" value="4"/>

<br/>
<label for="comments">Comments</label>
<textarea name="comments"/>
</textarea>
<br/>
<br/>
<label for="submit"></label>
<input type="submit" name="submit" value="submit">
<input type="reset" name="reset" value="reset">
</fieldset>

</form>
</div>
