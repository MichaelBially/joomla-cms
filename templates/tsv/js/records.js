/* Beispiel für jQuery Zeilen einfügen:

 https://www.w3schools.com/jquery/html_insertafter.asp


 <!DOCTYPE html>
 <html>
 <head>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script>
 $(document).ready(function(){
 $("button").click(function(){
 $("<tr><td>test</td><td>test</td></tr>").insertAfter("#zeile1");
 });
 });
 </script>
 </head>
 <body>

 <h1>This is a heading</h1>

 <p>This is a paragraph.</p>
 <p>This is another paragraph.</p>
 <table>
 <tr id="zeile1"><td>zeile1</td><td>abc</td></tr>
 <tr id="zeile2"><td>zeile1</td><td>abc</td></tr>
 <tr id="zeile3"><td>zeile1</td><td>abc</td></tr>
 <tr id="zeile4"><td>zeile1</td><td>abc</td></tr>
 <tr id="zeile5"><td>zeile1</td><td>abc</td></tr>
 </table>

 <button>Move and insert the h1 element after each p element</button>

 </body>
 </html>
 */


jQuery(document).ready(function(){
	jQuery(".chosen-select").chosen();

	jQuery('#resetBtn').click(function() {
		jQuery('.chosen-select option').each(function(){
			jQuery(this).attr("selected",false); /* evtl .prop für .attr */
		});
		jQuery(".chosen-select").trigger("chosen:updated");

		jQuery(':input', "#RecordsFilterForm").each(function()
		{
			var type = this.type;

			var tag = this.tagName.toLowerCase(); // normalize case

			var name = this.name.toLowerCase();
			
			if (type == 'text' || type == 'password' || tag == 'textarea')
				this.value = "";
			else if (type == 'checkbox') // || type == 'radio')
				this.checked = false;
			else if (tag == 'select')
				this.selectedIndex = -1;

			if(name == 'filter_halle')
				this.checked = true;
			if(name == 'filter_freiluft')
				this.checked = true;
			if(name == 'filter_mit')
				this.checked = true;
			if(name == 'filter_ohne')
				this.checked = true;
			if(name == 'filter_alte_recorde')
				this.checked = true;

		});

	});

	if(Cookies.get('com_records.navigationLink') != 1)
	{
		jQuery("#navigationLink").html("Navigation einblenden");
		jQuery("#records_navigation").hide();
	}
	else
	{
		jQuery("#navigationLink").html("Navigation ausblenden");
		jQuery("#records_navigation").show();
	}

	if(Cookies.get('com_records.sortLink') != 1)
	{
		jQuery("#sortLink").html("Sortierung einblenden");
		jQuery("#sort").hide();
	}
	else
	{
		jQuery("#sortLink").html("Sortierung ausblenden");
		jQuery("#sort").show();
	}


	if(Cookies.get('com_records.advancedSearchLink') != 1)
	{
		jQuery("#advancedSearchLink").html("Suche einblenden");
		jQuery("#advancedSearch").hide();
	}
	else
	{
		jQuery("#advancedSearchLink").html("Suche ausblenden");
		jQuery("#advancedSearch").show();
	}

	jQuery("#navigationLink").click(function(){
		jQuery("#records_navigation").toggle("slow");
		if(Cookies.get('com_records.navigationLink') == 1)
		{
			//jQuery("#records_navigation").show("slow");
			jQuery(this).html("Navigation einblenden");
			Cookies.set('com_records.navigationLink', '0');
		}
		else
		{
			//jQuery("#records_navigation").hide("slow");
			jQuery(this).html("Navigation ausblenden");
			Cookies.set('com_records.navigationLink', '1');
		}
	});

	jQuery("#sortLink").click(function(){
		jQuery("#sort").toggle("slow");
		if(Cookies.get('com_records.sortLink') == 1)
		{
			//jQuery("#sort").show("slow");
			jQuery(this).html("Sortierung einblenden");
			Cookies.set('com_records.sortLink', '0');
		}
		else
		{
			//jQuery("#sort").hide("slow");
			jQuery(this).html("Sortierung ausblenden");
			Cookies.set('com_records.sortLink', '1');
		}
	});

	jQuery("#advancedSearchLink").click(function(){
		jQuery("#advancedSearch").toggle("slow");
		if(Cookies.get('com_records.advancedSearchLink')=='1')
		{
			Cookies.set('com_records.advancedSearchLink', '0');
			jQuery(this).html("Suchen einblenden");
		}
		else
		{
			Cookies.set('com_records.advancedSearchLink', '1');
			jQuery(this).html("Suchen ausblenden");
		}
	});

	jQuery(".record_history").click(function(){
		id = 'toogle'+jQuery(this).data('record_id');
		obj = jQuery(this);

		if(obj.data('loaded') == "no")
		{
  		  obj.data('loaded', "open");

		  jQuery.ajax({
			url: 'index.php?option=com_records&task=ajax.history&id='+jQuery(this).data('record_id'),
			datatype: "json",
			type: "GET",
			beforeSend: function()
			{
				//obj.html('<img src="/cms/media/com_records/images/loader.gif" />');
				obj.html('<div class="spinner-border spinner-border-sm" role="status"></div>');
			},
			complete: function()
			{
				obj.html('<a class="hidden-print" title="hier klicken, um frühere Vereinsrekorde in dieser Disziplin auszublenden" style="cursor:pointer;"><i class="bi bi-arrow-up-square-fill"></i></a>');
			},
			success: function(data)
			{
		        var json = jQuery.parseJSON(data);
				for (var i=0;i<json.length;++i)
				{
					txt = '<tr style="display:none" id="'+id+'a'+i+'"><td></td><td class="record_result">'+json[i].result+' '+json[i].measurement+'</td>';
					txt += '<td class="record_person">'+json[i].person+'</td>';
					txt += '<td class="record_date">'+json[i].date+'</td>';
					txt += '<td class="record_location">'+json[i].location+'</td>';
					
					if(json[i].allowedit == 1)
					{
						txt += '<td></td><td></td>';
						txt += '<td><button class="btn btn-light"><a href="index.php?option=com_records&task=record.edit&record_id='+json[i].record_id+'"><i class="bi bi-pencil"></a></button></td>';
					}
					txt += '<td></td></tr>';
					jQuery(txt).insertAfter('#'+id);
					jQuery('#'+id+'a'+i).toggle("slow");
				}
			}
		  });					
		}	
		else
		{
			m = jQuery(this).data('max_nr');

			if(obj.data('loaded') == 'open')
			{
				obj.html('<a class="hidden-print" title="hier klicken, um frühere Vereinsrekorde in dieser Disziplin anzuzeigen" style="cursor:pointer;"><i class="bi bi-arrow-down-square-fill"></i></a>');
				obj.data('loaded', 'close');
			}
			else
			{
				obj.html('<a class="hidden-print" title="hier klicken, um frühere Vereinsrekorde in dieser Disziplin auszublenden" style="cursor:pointer;"><i class="bi bi-arrow-up-square-fill"></i></a>');
				obj.data('loaded', 'open');
			}

			for(var i=0; i<m; i++)
			{				
				jQuery('#'+id+'a'+i).toggle("slow");
			}
		}
		
	});

	var options = {
		url: function (phrase){
			//return "/php/ajax/com_records/getname.php?phrase=" + phrase;
			return "index.php?option=com_records&task=ajax.getAthleteName&phrase=" + phrase;
		},

		getValue: "name",

		requestDelay: 500,



		list: {
			maxNumberOfElements: 20
//            match: {
			//              enabled: true
			//        }
		},

		theme: "bootstrap"
	};

	jQuery("#athlete").easyAutocomplete(options);
});




insertRecord = function(id, cl, m) {
	var zeile = 'toogle'+id;
/*

	if(!(jQuery(zeile + 'a0').length))
	{
		alert("ja2");
		//var response = doRequest(id, cl);
	}
	else
	{
alert("nein1");
		for(var i=0; i<m; i++)
			jQuery(zeile+'a'+i).toggle();
	}
	*/
};


var doRequest = function(id, cl) {
	var zeile = 'toogle'+id;
	
	var req = new Request.JSON({
      method: 'get',
      url: 'index.php?option=com_records&view=history&tmpl=component&format=raw',
      data: { 'id' : id },
      onRequest: function() {
		  var tr = new Element('tr', {id: zeile+'b', class: 'sectiontableentry'+cl}); 
		  tr.inject(zeile,'after');
		  
		  var td1 = new Element('td', {class: 'record_name', colspan:'6'});
		  td1.set('html','<center><img src="/cms/media/com_records/images/ajax-loader.gif" /></center>');
		  tr.grab(td1);
      },

     onSuccess: function(response) {
    	  $(zeile+'b').dispose();
    	  for (var i = 0; i < response.length; i++) {
    		  var q = response[i];
    		  var tr = new Element('tr', {id: zeile+'a'+i, class: 'sectiontableentry'+cl}); 
    		  tr.inject(zeile,'after');
    		  
    		  var td1 = new Element('td', {class: 'record_name'});
    		  tr.grab(td1);
    		  
    		  var td2 = new Element('td', {class: 'record_result'});
    		  td2.set('text',q["result"] + ' ' + q["measurement"]);
    		  tr.grab(td2);
    		  
    		  var td3 = new Element('td', {class: 'record_person'});
    		  td3.set('html',q["person"]);
    		  tr.grab(td3);
    		  
    		  var td4 = new Element('td', {class: 'record_date'});
    		  td4.set('text',q["date"]);
    		  tr.grab(td4);
    		  
    		  var td5 = new Element('td', {class: 'record_location'});
    		  td5.set('text',q["location"]);
    		  tr.grab(td5);
    		  
    		  var td6 = new Element('td', {class: 'record_history'});
    		  tr.grab(td6);
    	  }
    	  
      }
      
    }).send();

};

/*
window.addEvent('domready', function() {
	$('themessage').addEvent('click', function(event) {
	    //prevent the page from changing
		alert('event');
	    event.stop();
	    //make the ajax call
	    var req = new Request({
	      method: 'get',
	      url: "http://localhost/ajax/hello.php",
	      data: { 'do' : '1' },
	      onRequest: function() { $('mymessage').set('text','loading...'); },
	      onComplete: function(response) { $('mymessage').set('text', response); }
	    }).send();
	});
});
*/