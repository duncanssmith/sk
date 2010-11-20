<body>

<form action="fileaccept.php" method="post" enctype="multipart/form-data">

<div id="main">

<fieldset>
<legend>Licence Entitlement Inputs</legend>

<div>

<div>

<fieldset>
<legend>Licence Details</legend>

<label for="text">SKU</label>
<input type="text" name="sku" />
&nbsp;

<label for="publisher">publisher</label>
<input type="text" name="publisher" />
&nbsp;

<label for="product">product</label>
<input type="text" name="product" />
&nbsp;

<label for="edition">edition</label>
<input type="text" name="edition" />
&nbsp;

<label for="version">version</label>
<input type="text" name="version" />
&nbsp;
</fieldset>

</div>
<div>
<fieldset>
<legend>Licence Details 2</legend>

<label for="identifying_number">identifying number</label>
<input type="text" name="identifying_number" />
&nbsp;

<label for="product_id">product id</label>
<input type="text" name="product_id" />
</fieldset>
</div>

<div>

<fieldset>
<legend>Licence Details 3</legend>

<label for="region_country">region_country</label>
<select name="region_country">
<option value="UK">UK</option>
<option value="France">France</option>
<option value="Italy">Italy</option>
<option value="Germany">Germany</option>
<option value="USA">USA</option>
</select>
&nbsp;

<label for="cal">cal</label>
<input type="text" name="cal" />
&nbsp;

<label for="licence_type">licence_type</label>
<input type="text" name="licence_type" />
&nbsp;

<label for="term">term</label>
<input type="text" name="term" />
&nbsp;

<label for="upgrade">upgrade</label>
<input type="text" name="upgrade" />
&nbsp;

<label for="term_expiry">term_expiry</label>
<input type="text" name="term_expiry" />
&nbsp;

<label for="ci_name">ci_name</label>
<input type="text" name="ci_name" />
&nbsp;

<label for="base_licence">base_licence</label>
<input type="text" name="base_licence" />
&nbsp;

<label for="maintenance_expiry">maintenance expiry</label>
<input type="text" name="maintenance_expiry" />
&nbsp;

<label for="entitlement_type">entitlement_type</label>
<input type="text" name="entitlement_type" />
&nbsp;

</fieldset>

</div>

<div>
<fieldset>
<legend>Admin Information</legend>

<label for="cost_center">cost_center</label>
<input type="text" name="cost_center"/> 

<label for="volume_licence_agreement_number">volume_licence_agreement_number</label>
<input type="text" name="volume_licence_agreement_number" />

<label for="agreement_location">agreement_location</label>
<input type="text" name="agreement_location" />

<label for="entitlement_location">entitlement_location</label>
<input type="text" name="entitlement_location" />
</fieldset>
</div>


<div>
<fieldset>
<legend>Supplier Details</legend>
<label for="supplier">supplier</label>
<input type="text" name="supplier"/> 

<label for="supplier_invoice_number">supplier_invoice_number</label>
<input type="text" name="supplier_invoice_number" />

<label for="invoice_date">invoice_date</label>
<input type="text" name="invoice_date" />

<label for="po_number">po_number</label>
<input type="text" name="po_number" />

<label for="country_of_usage">country_of_usage</label>
<input type="text" name="country_of_usage" />
</fieldset>
</div>


<div>
<fieldset>
<legend>Terms and Conditions</legend>
<label for="product_substitution_rights">product_substitution_rights</label>
<input type="text" name="product_substitution_rights"/> 

<label for="secondary_rights">secondary_rights</label>
<input type="text" name="secondary_rights" />

<label for="transfer_ability">transfer_ability</label>
<input type="text" name="transfer_ability" />

<label for="external_licence_transfer_requirements">external_licence_transfer_requirements</label>
<input type="text" name="external_licence_transfer_requirements" />

<label for="linkages">linkages</label>
<input type="text" name="linkages" />
</fieldset>
</div>


<div>
<fieldset>
<legend>Financials</legend>
<label for="total_cost_of_line_items">total_cost_of_line_items</label>
<input type="text" name="total_cost_of_line_items"/> 

<label for="quantity">quantity</label>
<input type="text" name="quantity" />

<label for="unit">unit</label>
<input type="text" name="unit" />

<label for="cost_unit">cost_unit</label>
<input type="text" name="cost_unit" />

<label for="maintenance_pa">maintenance_pa</label>
<input type="text" name="maintenance_pa" />
</fieldset>
</div>

<div>

<label for="reset">reset</label>
<input type="reset" name="reset" />
<br/>

<label for="submit">submit</label>
<input type="submit" name="submit" value="Submit" />
<br/>
</div>
</div>
</form>

<hr/>

<br/><br/>
<!--<form enctype="multipart/form-data" action="fileaccept.php" method="POST"> -->
    <!-- MAX_FILE_SIZE must precede the file input field -->
<!--    <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
    <!-- Name of input element determines name in $_FILES array -->
<!--    Send this file: <input name="userfile" type="file" /> -->
<!--    <input type="submit" value="Send File" /> -->
<!--</form> -->
</div>
</body>
</html>
