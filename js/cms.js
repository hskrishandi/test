// JavaScript Document
function page(demoTable) {
	$(document).ready(function() {

		$(demoTable).jTPS({
			perPages: [5, 12, 15, 50, 'ALL'],
			scrollStep: 1,
			scrollDelay: 30,
			clickCallback: function() {
				// target table selector
				var table = demoTable;
				// store pagination + sort in cookie 
				document.cookie = 'jTPS=sortasc:' + $(table + ' .sortableHeader').index($(table + ' .sortAsc')) + ',' +
					'sortdesc:' + $(table + ' .sortableHeader').index($(table + ' .sortDesc')) + ',' +
					'page:' + $(table + ' .pageSelector').index($(table + ' .hilightPageSelector')) + ';';
			}
		});

		// reinstate sort and pagination if cookie exists
		var cookies = document.cookie.split(';');
		for (var ci = 0, cie = cookies.length; ci < cie; ci++) {
			var cookie = cookies[ci].split('=');
			if (cookie[0] == 'jTPS') {
				var commands = cookie[1].split(',');
				for (var cm = 0, cme = commands.length; cm < cme; cm++) {
					var command = commands[cm].split(':');
					if (command[0] == 'sortasc' && parseInt(command[1]) >= 0) {
						$('#demoTable .sortableHeader:eq(' + parseInt(command[1]) + ')').click();
					} else if (command[0] == 'sortdesc' && parseInt(command[1]) >= 0) {
						$('#demoTable .sortableHeader:eq(' + parseInt(command[1]) + ')').click().click();
					} else if (command[0] == 'page' && parseInt(command[1]) >= 0) {
						$('#demoTable .pageSelector:eq(' + parseInt(command[1]) + ')').click();
					}
				}
			}
		}

		// bind mouseover for each tbody row and change cell (td) hover style
		$('#demoTable tbody tr:not(.stubCell)').bind('mouseover mouseout',
			function(e) {
				// hilight the row
				e.type == 'mouseover' ? $(this).children('td').addClass('hilightRow') : $(this).children('td').removeClass('hilightRow');
			}
		);

	});


}


function saveTab(index) {
	delCookie('tab');
	setCookie('tab', index);


}

function CheckAll(items, form) {

	var ck;
	var ckAll;
	if (form == 'form') {
		ck = document.form.elements[items];
		ckAll = document.form.allbox;
	} else if (form == 'form1') {
		ck = document.form1.elements[items];
		ckAll = document.form1.allbox;
	} else if (form == 'form2') {
		ck = document.form2.elements[items];
		ckAll = document.form2.allbox;
	} else if (form == 'form3') {
		ck = document.form3.elements[items];
		ckAll = document.form3.allbox;
	} else if (form == 'form4') {
		ck = document.form4.elements[items];
		ckAll = document.form4.allbox;
	} else if (form == 'form5') {
		ck = document.form5.elements[items];
		ckAll = document.form5.allbox;
	} else if (form == 'form6') {
		ck = document.form6.elements[items];
		ckAll = document.form6.allbox;
	}


	if (!ck) {
		ckAll.checked = false;
	} else if (!ck.length) {
		ck.checked = ckAll.checked;
	} else {
		for (var i = 0; i < ck.length; i++)
			ck[i].checked = ckAll.checked;
	}
}

function setCheckboxes(cbObj) {
	cbObj = document.getElementById(cbObj);
	alert(cbObj);
	// getElementsByName() works in IE/FF
	// objsCollection = document.getElementsByName('custID[]');  // objsCollection.length returns 9

	// getElementsByTagName() works in IE/FF
	objsCollection = document.forms[0].getElementsByTagName('INPUT'); // objsCollection.length returns 12
	show_indexes(objsCollection);
	// for (idx in objsCollection) {   // it works in FF only
	for (idx = 0; idx < objsCollection.length; idx++) { // it works in IE/FF
		obj = objsCollection[idx];
		if (obj.type == "checkbox" && obj != cbObj)
			obj.checked = cbObj.checked;
	}
}

function show_indexes(arrObj) {
	s = '';
	for (idx in arrObj) {
		s += idx + ' ';
	}
	window.status = s;
	return true;
}

function hideThread(obj) {
	$('#' + obj).hide(500);
}



function approve_res(type, id) {
	document.getElementById("approve_res" + id).innerHTML = "approved";
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {}
	}
	xmlhttp.open("GET", "../cms/resources/approve_res?type=" + type + "&id=" + id, true);
	xmlhttp.send();
}

function approveMultiRes(frm, type) {
	// JavaScript & jQuery Course - http://coursesweb.net/javascript/
	var selchbox = []; // array that will store the value of selected checkboxes

	// gets all the input tags in frm, and their number
	var inpfields = frm.getElementsByTagName('input');
	var nr_inpfields = inpfields.length;

	// traverse the inpfields elements, and adds the value of selected (checked) checkbox in selchbox
	for (var i = 0; i < nr_inpfields; i++) {
		if (inpfields[i].type == 'checkbox' && inpfields[i].checked == true) selchbox.push(inpfields[i].value);

	}

	for (var i = 0; i < selchbox.length; i++) {
		approve_res(type, selchbox[i])
		document.getElementById(type + 'CheckBox' + selchbox[i]).checked = false;
	}
}


function hide_res(hidden, type, id, res) {
	//alert(hidden+type+id); 
	var action = "";
	if (hidden == 1) {
		action = "hide_res";
		$('#' + type + id).css("color", "#CCC");
		$('#' + type + 'Link' + id).css("color", "#CCC");
		$('#' + type + 'Edit' + id).css("color", "#CCC");
	} else if (hidden == 0) {
		action = "unhide_res";
		$('#' + type + id).css("color", "#7575a9");
		$('#' + type + 'Link' + id).css("color", "#7575a9");
		$('#' + type + 'Edit' + id).css("color", "#7575a9");
	}

	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {



		}
	}
	xmlhttp.open("GET", "../cms/" + res + "/" + action + "?type=" + type + "&id=" + id, true);
	xmlhttp.send();
}


function del_res(type, id, res) {
	$("#" + type + id).hide('slow');
	if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

		}
	}
	xmlhttp.open("GET", "../cms/" + res + "/del_res?type=" + type + "&id=" + id, true);
	xmlhttp.send();
}


function delMultiRes(frm, type, res) {
	// JavaScript & jQuery Course - http://coursesweb.net/javascript/
	var selchbox = []; // array that will store the value of selected checkboxes

	// gets all the input tags in frm, and their number
	var inpfields = frm.getElementsByTagName('input');
	var nr_inpfields = inpfields.length;

	// traverse the inpfields elements, and adds the value of selected (checked) checkbox in selchbox
	for (var i = 0; i < nr_inpfields; i++) {
		if (inpfields[i].type == 'checkbox' && inpfields[i].checked == true) selchbox.push(inpfields[i].value);

	}

	for (var i = 0; i < selchbox.length; i++) {
		del_res(type, selchbox[i], res)
		document.getElementById(type + 'CheckBox' + selchbox[i]).checked = false;
	}
}


function hideMultiRes(frm, hidden, type, res) {
	// JavaScript & jQuery Course - http://coursesweb.net/javascript/
	var selchbox = []; // array that will store the value of selected checkboxes

	// gets all the input tags in frm, and their number
	var inpfields = frm.getElementsByTagName('input');
	var nr_inpfields = inpfields.length;

	// traverse the inpfields elements, and adds the value of selected (checked) checkbox in selchbox
	for (var i = 0; i < nr_inpfields; i++) {
		if (inpfields[i].type == 'checkbox' && inpfields[i].checked == true) selchbox.push(inpfields[i].value);

	}

	for (var i = 0; i < selchbox.length; i++) {
		hide_res(hidden, type, selchbox[i], res)
		document.getElementById(type + 'CheckBox' + selchbox[i]).checked = false;
	}
}




/*
function unhide_res(type,id)
{
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
    $('#'+type+id).css("color","##7575a9");
    $('#del'+type+id).html("delete");
   
    }
  }
xmlhttp.open("GET","../cms/resources/unhide_res?type="+type+"&&id="+id,true);
xmlhttp.send();
}
*/