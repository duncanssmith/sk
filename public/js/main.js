// JavaScript functions
// 2005 06 14 DS
// global vars
// var i = 0
// images = new Array;
//
//

function pop_form(a1, a2, a3, a4){

	var height=860;
	var width=420;
	var left=80;
	var top=30;

	var i=zoom_count;
	//var image=zoom[i];
	var rnd=Math.round(1000*Math.random());
	var namex='zoom'+rnd;
	var topline=a2+"\n";
	var left=rnd/10;
	//var top=rnd/10;
	var top=0;
  	var generator=window.open('',namex,'height='+height+',width='+width+',left='+left+',top='+top+',resizable=yes,scrollbars=yes,toolbar=no,status=yes');
	if (window.focus) {generator.focus();}
	generator.document.write('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">\n');
  	generator.document.write('<html>\n<head>\n<title>'+topline+'</title>\n');
	generator.document.write('<link rel="stylesheet" href="css/main.css">\n');
	generator.document.write('</head>\n<body class="formwindow">\n');
//****************
	generator.document.write('<div class="formdiv">');
	generator.document.write('<h1></h1>');
	generator.document.write('<h3></h3>');
	generator.document.write('<h2></h2>');

	generator.document.write('<p></p>');

	generator.document.write('<form method="post" action="mr_026.php">');
	generator.document.write('<label for="title">Title</label>');
  generator.document.write('<select name="title">');
  generator.document.write('<option value="" selected>Please select</option>\n');
  generator.document.write('<option value="Mr">Mr</option>\n');
  generator.document.write('<option value="Ms">Ms</option>\n');
  generator.document.write('<option value="Mrs">Mrs</option>\n');
  generator.document.write('<option value="Miss">Miss</option>\n');
  generator.document.write('<option value="Dr">Dr</option>\n');
  generator.document.write('</select>\n');
	generator.document.write('<label for="fname">First Name</label>');
	generator.document.write('<br/>');
	generator.document.write('<input name="fname" type="text" size="24">');
	generator.document.write('<br/>');
	generator.document.write('<label for="lname">Last Name</label>');
	generator.document.write('<br/>');
	generator.document.write('<input name="lname" type="text" size="24">');
	generator.document.write('<br/>');
	generator.document.write('<label for="email"></label>');
	generator.document.write('<br/>');
	generator.document.write('<input name="email" type="text" size="64">');
	generator.document.write('<br/>');
	generator.document.write('<label for="addr1">Address 1</label>');
	generator.document.write('<br/>');
	generator.document.write('<input name="addr1" type="text">');
	generator.document.write('<br/>');
	generator.document.write('<label for="addr2">Address 2</label>');
	generator.document.write('<br/>');
	generator.document.write('<input name="addr2" type="text">');
	generator.document.write('<br/>');
	generator.document.write('<label for="addr3">City 3</label>');
	generator.document.write('<br/>');
	generator.document.write('<input name="city" type="text">');
	generator.document.write('<br/>');
	generator.document.write('<label for="pcode">Postcode</label>');
	generator.document.write('<br/>');
	generator.document.write('<input name="pcode" type="text">');
	generator.document.write('<br/>');
	generator.document.write('<input type="submit" name="submit" value="submit"/>');
	generator.document.write('<input type="reset" name="reset" value="reset"/>');
	generator.document.write('</form>');
//****************
	generator.document.write('<p><a href="javascript:self.close()">close window</a></p>\n');
	//generator.document.write('<p><a href="mr_003.php">&nbsp;<img src="images/g/nav/arrow-right.gif" border="0"></a></p>\n');
	generator.document.write('</div>');
	generator.document.write('</body>\n</html>\n');
	generator.document.close();

	return true;
}

var zoom_count=0;

function sameimg(n){
	//n--;
       	var one="'javascript:pop_zoom(";
	var two=n;
	var three="); return false;'";
	var string=one+two+three;

	zoom_count=n;
	//document.image2.onClick = one+two+three;
	
	//alert (string);	
	document.swapImage.src = swap[n];

	//alert (" "+swap[n]+" "zoom[n]+" ");
}

function showrollover(i){
	//document.write(roll_images[i]);
	//document.write(imagename[i]);
	document[imagenames[i]].src=roll_images[i];
	document[imagenames[i]].border=1;
	//document[imagenames[i]].border.borderColor="#ffee11";
}

function hiderollover(i){
	//document.write(roll_images[i]);
	//document.write(imagename[i]);
	document[imagenames[i]].src=origimages[i];
}


function write_text(n){
	document.write(text[n]);
}


function createZoomLayer(i){
	var current = document.getElementById("zoomLayerContent");
	var parent = current.parentNode;
	var c = document.createElement("div");
	var before="<table><tr><td><img src=";
	var after="></td></tr></table>\n";
	
	var string=before+roll_images[i]+after;
	parent.replaceChild(c, current);
	c.setAttribute("id","zoomLayerContent");
	c.innerHTML=string;	

	return true;
}

function createlayer(i){
	var current = document.getElementById("layerContent");
	var parent = current.parentNode;
	var notify_url = "<input type=\"hidden\" name=\"notify_url\" value=\"http://www.rebeccaandpenelope.com/pp_php_ipn.php\">";
	notify_url = "";
	var c = document.createElement("div");
	
	var string=itemtext[i];

	parent.replaceChild(c, current);
	c.setAttribute("id","layerContent");
	c.innerHTML=string;	

	return true;
}

function flip_border_color(i){
	//td.border-top.color="#fdde08";	

	return true;
}

function isblank(s){
	for(var i=0;i<s.length;i++){
		var c = s.charAt(i);
		if((c!= ' ')&&(c != '\n')&&(c != '')){
			return false;
		}
	}
	return true;
}

function verify(f){
	var msg;
	var empty_fields="";
	var errors = "";

	for(var i=0;i<f.length;i++){
		var e=f.elements[i];
		if((    (e.type == "text") || 
			(e.type == "textarea") || 
			(e.type == "select-one") || 
			(e.type == "radio") || 
			(e.type == "checkbox")) && 
			(!e.optional)){
			if((e.value == null) || (e.value == "") || isblank(e.value)){
				empty_fields += "\n            " + e.name;
				continue;
			}
			if(e.numeric || (e.min != null) || (e.max != null)){
				var v = parseFloat(e.value);
				if(isNaN(v) ||
					((e.length < 5)))
			//		((e.min != null) && (v < e.min)) ||
		//			((e.max != null) && (v < e.max))) 
				{
					errors += " length of ZIP is less than 5 digits\n";
						errors += "- The field " + e.name + " must be a number\n";
					if(e.min != null){
						errors += " greater than " + e.min;
						errors += ".\n";
					}
					if(e.max != null){
						errors += " that is less than " + e.max;
						errors += ".\n";
					}else if (e.max != null){
						errors += ".\n";
					}
				}
			}
		}
	}
	var x = document.getElementById("useremail");
	if(x.value != ""){
		var r = new RegExp("[a-zA-Z0-9]+@[a-zA-Z0-9]+\.{1}[a-zA-Z0-9]+","gi");
		if (!r.exec(x.value)){
			errors += "- email address \" " + x.value + " \" is invalid \n";
		}
	}	

	if(!empty_fields && !errors){ 
		return true;
	}

	msg =  "________________________________________________________    \n\n";
	msg += "Some required fields were empty.\n";
	msg += "Thank you for taking the time to complete them.\n";
	msg += "________________________________________________________    \n\n";

	if (empty_fields){
		msg += "We need the following details:" + empty_fields + "\n";
		if(errors){
			msg += "\n";
		}
	msg += errors;
	alert(msg);
	return false;
	}
}

function update_cookie(curr){

	var anticurr = "   ";

	if(curr == "USD"){anticurr = "GBP";
				currname="US Dollars";
				anticurrname="British Pounds Sterling";}
	else if(curr == "GBP"){anticurr = "USD";
				anticurrname="US Dollars";
				currname="British Pounds Sterling";}

	var warning="Please note:\n\nYou have requested to change your shopping currency from "+anticurrname+" ("+anticurr+") to "+currname+" ("+curr+".)\n\nIf you have already made a purchase in "+anticurrname+" you will not be able to add further purchases to your shopping basket in "+currname+". This is because we can only accept payments in either Dollars or Pounds in one transaction.\n\nPlease click 'OK' to change currency to "+currname+" or 'Cancel' to stay in "+anticurrname+"\n\nThank You!\nRebecca and Penelope\n";

	var allcookies=document.cookie;

	//alert(allcookies);

	var pos = allcookies.indexOf(curr);

	//alert(pos);
	if(pos == -1){
		if(confirm (warning)){
			var posx = allcookies.indexOf(anticurr);
			var start = posx;	
			var end = allcookies.indexOf(";", start);
			if(end == -1){end = allcookies.length;}
	
			valueNew = curr;
			var expdate = new Date ();
	
			expdate.setTime (expdate.getTime() + (60 * 60 * 24 * 10 * 1000)); 
	
			//alert (expdate);
			setCookieValue("RebeccaAndPenelope", valueNew, expdate);
	
			//alert("currency changed to "+valueNew+" ");

			window.location.reload(true);
		}
	}else if(pos != -1){
		var start = pos;
		var end = allcookies.indexOf(";", start);
		if(end == -1){end = allcookies.length;}

		var value = allcookies.substring(start, end);

		value = unescape(value);
		
		//alert (value);
		if(value == curr){//alert("unchanged")
			;
		}
	}
	return true;
}

function setCookieValue(name, value, expires, path, domain, secure) {
	// Some characters - including spaces - are not allowed in cookies
	// so we escape to change the value we have entered into
	// a form acceptable to the cookie.

	var thisCookie = name + "=" + escape(value) + 
	((expires) ? "; expires=" + expires.toGMTString() : "") +
	((path) ? "; path=" + path : "") +
	((domain) ? "; domain=" + domain : "") +
	((secure) ? "; secure" : "");

	document.cookie = thisCookie;
}
// cookie object constructor:
function Cookie(document, name, hours, path, domain, secure){

	this.$document = document;
	this.$name = name;
	if(hours){
		this.$expiration = new Date((new Date()).getTime()+hours*3600000);
	}	
	else{
		this.$expiration = null;
	}
	if(path){ this.$path = path; }else{ this.$path = null; }
	if(domain){ this.$domain = domain; }else{ this.$domain = null; }
	if(secure){ this.$secure = secure; }else{ this.$secure = null; }
}

// build the cookie string
Cookie.prototype.store = function(){

	var cookieval = "";
	for(var prop in this){
		if((prop.charAt(0) == '$')||((typeof this[prop]) == 'function')){
			continue;
		}
		if(cookieval != ""){
			cookieval += '&';
		}
		cookieval += prop + ':' + escape(this[prop]);
	}
	
	var cookie = this.$name + '=' + cookieval;
	if(this.$expiration){ cookie += '; expires=' + this.$expiration.toGMTString(); }
	if(this.$path){ cookie += '; path=' + this.$path; }
	if(this.$domain){ cookie += '; domain=' + this.$domain; }
	if(this.$secure){ cookie += '; secure=' + this.$secure; }

	this.$document.cookie = cookie;	
}

Cookie.prototype.load = function(){
	var allcookies = this.$document.cookie;
	if(allcookies == "") return false;

	var start = allcookies.indexOf(this.$name + '=');

	if(start == -1) return false;

	start += this.$name.length +1;
	
	var end = allcookies.indexOf(';', start);

	if(end == -1) end = allcookies.length;

	var cookieval = allcookies.substring(start, end);


	var a = cookieval.split('&');
	for(var i=0;i<a.length;i++){
		a[i] = a[i].split(':');
	}

	for(var i=0; i , a.length;i++){
		this[a[i][0]] = unescape(a[i][1]);

	}

	return true;
}

Cookie.prototype.remove = function(){
	var cookie;
	cookie = this.$name + '=';

	if(this.$path){ cookie += '; path=' + this.$path; }
	if(this.$domain){ cookie += '; domain=' + this.$domain; }
	cookie += '; expires=Fri, 02-Jan-1970 00:00:00: GMT';

	this.$document.cookie = cookie;
}

function pop_zoom_2(section,size,index)
{
	//alert(zoom[index]);

	var image=zoom[index];
	var rnd=Math.round(1000*Math.random());
	var height=size+=80;
	var width=size+=80;
	var namex='zoom'+rnd;
	var topline="<h4>Sharon Hall "+section+" </h4>\n";
	var left=rnd/10;
	var top=rnd/10;
  	var generator=window.open('',namex,'height='+height+',width='+width+',left='+left+',top='+top+',resizable=yes,scrollbars=no,toolbar=no,status=yes');
	if (window.focus) {generator.focus();}
  
  	generator.document.write('<html>\n<head>\n<title> </title>\n');
	generator.document.write('<link rel="stylesheet" href="css/sh.css">\n');
	generator.document.write('</head>\n<body>\n');
	//generator.document.write( topline );
	
	generator.document.write('<p>');
	//generator.document.write(namex);
	generator.document.write('</p>');
	generator.document.write('<img src=\"');
	generator.document.write( image );
	generator.document.write('"/>\n');
	generator.document.write('<p><a href="javascript:self.close()">&nbsp;<img src="images/close_window.gif" border="0"></a></p>\n');
	generator.document.write('</body>\n</html>\n');
	generator.document.close();


}

function pop_zoom(img,title,text,width,height)
{
	var i=zoom_count;
//var image=zoom[i];
	var rnd=Math.round(1000*Math.random());
	var height=height+=40;
	var width=width+=40;
	var namex='zoom'+rnd;
	var topline="<h1>"+title+"</h1><br/>\n";
	var left=rnd/10;
	var top=rnd/10;
  var generator=window.open('',namex,'height='+height+',width='+width+',left='+left+',top='+top+',resizable=yes,scrollbars=no,toolbar=no,status=yes');
	if (window.focus) {generator.focus();}
  
  generator.document.write('<html>\n<head>\n<title>' );
  generator.document.write( title ); 
  generator.document.write('</title>');
      
	generator.document.write('<link rel="stylesheet" href="css/main.css">\n');
	generator.document.write('</head>\n');
	generator.document.write('<body id="popup">\n');
	generator.document.write( topline );
	
    //generator.document.write('<p>');
	  //generator.document.write(namex);
	  //generator.document.write('</p>');
	generator.document.write('<img src=\"');
	generator.document.write( img );
	generator.document.write('"/>\n');
	  //generator.document.write('<p><a href="javascript:self.close()">&nbsp;<img src="images/close_window.gif" border="0"></a></p>\n');
	generator.document.write('<br/><p>');

	generator.document.write( text );
	generator.document.write('</p>');
	generator.document.write('<p><br/><a href="javascript:self.close()">close window</a></p>\n');
	generator.document.write('</body>\n</html>\n');
	generator.document.close();
}

function zoom_image(i){
	
	//var target=image+".php";
	var target="";
	var width="width="+width+"";
	var height="height="+height+"";
	var title="image zoom";
	
	open(target, width, height, status="no", resizable="yes");

	var args=target+" "+width+" "+title+" "+height+" ";

	alert (args);

}

function preloadImages() {
	var d=document; 

	if(d.images){ 
		if(!d.p){ 
			d.p=new Array();
		}
    
		var i,j=d.p.length,a=preloadImages.arguments; 

		for(i=0; i<a.length; i++){
			if (a[i].indexOf("#")!=0){ 
				d.p[j]=new Image; 
				d.p[j++].src=a[i];
			}
		}
	}
}

function logout_reload_page(){

	window.location.reload(true);
}

