// JavaScript Document


//document.getElementById("displayName").innerHTML="HIHI";



function swap(content1,content2){
	document.getElementById(content1).style.display="none";
	document.getElementById(content2).style.display="block";
	

}

function checkContent(postid,brCount,contentLen){



	if(contentLen<400&&brCount<=4){
		document.getElementById("readMore"+postid).style.display="none";
	}

}

function checkLogin(id){
	document.getElementById(id).style.display="none";
	document.getElementById("error").innerHTML="Please login to leave comment";	
	document.getElementById("reply_form").style.border="solid";
	document.getElementById("reply_form").style.borderWidth="1px";
	document.getElementById("reply_form").style.borderColor="#F00";
	
}


function del_comment(comment_id,base_url)
{
	$("#commentid"+comment_id).hide('slow');
	//document.getElementById("approve_res"+id).innerHTML="approved";
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function(){
  if (xmlhttp.readyState==4 && xmlhttp.status==200){
    }
  }
xmlhttp.open("GET",base_url+"discussion/maintain?action=del&commentid="+comment_id,true);
xmlhttp.send();
}