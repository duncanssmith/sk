<?php
?>
<div id="queryform">
<form id="queryform" action="formhandler.php" method="POST" >
 
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
<label for="fname">First Name or Initial</label>
<input type="text" name="fname"></input>
<br/>
<label for="lname">Last Name</label>
<input type="text" name="lname"></input>
<br/>
<label for="email">Email address</label>
<input type="text" name="email"></input>
<br/>
<p>I am interested in: </p>
<label for="both">Voice and Presentation training</label>
<input type="radio" name="trainingtype" value="both" checked="true"/>

<label for="voice">Voice training</label>
<input type="radio" name="trainingtype" value="voice"/>

<label for="presentation">Presentation training</label>
<input type="radio" name="trainingtype" value="presentation"/>

<label for="both">Other (please specify below)</label>
<input type="radio" name="trainingtype" value="other"/>

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
