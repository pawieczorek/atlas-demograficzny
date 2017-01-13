initAjaxForm();

	
function buttonPressed(value, country, mapLat, mapLng, mapZoom, countryEntity) 
			
		{
				
				
		var position = {lat: parseFloat(mapLat), lng: parseFloat(mapLng)};
						map.setCenter(position);        
						map.setZoom(parseInt(mapZoom));

		$("#loader1").show();
		
		$.post( Routing.generate("zakresAction") , {zakres: value, country: country, entity: countryEntity}, 
		
				function(response)
				
					{
					$("#loader1").hide();	
					addMarkers(response);
					}	
							
				, "json"
						
		);
		
		}//buttonPressed
		

		
function initAjaxForm()

		{   
			
			$("#wyniki").hide();
		    $("#loader1").hide();
			$("#loader2").hide();
			$("#loader3").hide();
			$("#notka").hide();
			
			$('body').on('submit', '.ajaxForm', function (e) 
					{
					var countryLat = document.getElementsByName("countryLat")[0].value;
					var countryLng = document.getElementsByName("countryLng")[0].value;
					var countryZoom = document.getElementsByName("countryZoom")[0].value;
					
					var position = {lat: parseFloat(countryLat), lng: parseFloat(countryLng)};
						map.setCenter(position);        
						map.setZoom(parseInt(countryZoom));
				
					e.preventDefault();
					
					$("#loader2").show();
					
							$.post({
								url: $(this).attr('action'),
								data: $(this).serialize()
							})
								.done(function (data) 
										{
											if (typeof data.message !== 'undefined') 
											
											{
												
												addMarkers(data);
												$("#loader2").hide();
												$("#notka").hide();
												
											}
										})
										
								.fail(function (jqXHR, textStatus, errorThrown) 
										{
											if (typeof jqXHR.responseJSON !== 'undefined') 
													{
														
													if (jqXHR.responseJSON.hasOwnProperty('form')) 
															{
															$('#form_body').html(jqXHR.responseJSON.form);
															}
													
													console.log('fail');
													
													$('.form_error').html(jqXHR.responseJSON.message);

													} 
											
											else 											
													{
														alert(errorThrown);	
													}
										
										})
							
						
					});//function(e)
					
		}//initAjaxForm		
		
				
				
function addMarkers (response)

	{
			
	if (response.code == 100 && response.success)
		
		{
		
		cityData=response.data;
		
		clearMarkers();
		document.getElementById("opis").innerHTML="";
		
		for (i = 0; i < response.data.length; i++)
			{                       
		
			postawMarker(parseFloat(cityData[i]["lat"]),parseFloat(cityData[i]["long"]), cityData[i]["zakres"] );
		   
			}//for
			
			createTable();
			
		}//if
		
	else
		
		{
		 console.log("error");
		}
		
	
	}//addMarkers		

		
function createTable()  

		{ 
	
		$( "#wyniki" ).show();	
		$( "#tbody1" ).empty();	
									
		var table = $('#table').DataTable();
		
		table
			.clear()
			.draw();
				
		for (var i = 0; i < cityData.length; i++)
			
				{
				
				var tr = document.createElement("tr");  
				tr.className="tr";
			
				var td1 = document.createElement("td");
				td1.className="td";
				var td2 = document.createElement("td");
				td2.className="td";
				var td3 = document.createElement("td");
				td3.className="td";
			
				var text1 = document.createTextNode(cityData[i]["miasto"]);
				var text2 = document.createTextNode(cityData[i]["ile"]+ " ");
				var btn = document.createElement("a");
				
				var textBtn = document.createTextNode("mapa"); 
				btn.appendChild(textBtn);
				btn.float="right";
				btn.value = i;
				btn.class = "btn";
				
				
				btn.addEventListener("click", function(){setMapCenter(this.value); addDescription(this.value); });
				
				td1.appendChild(text1);
				td2.appendChild(text2);
				td3.appendChild(btn);
				tr.appendChild(td1);
				tr.appendChild(td2);
				tr.appendChild(td3);
				
				table.row.add(tr).draw();	
				
				}
			  
						
		}//cityData        
					
		
function postawMarker(x,y, zakres)
		 
		{
			
		var image1 ={
					  url: 'images/g'+zakres+'.png',
					  size: new google.maps.Size(100, 100)
					};
						
		var geocode = {lat: x, lng: y};
		var marker = new google.maps.Marker({position: geocode, icon: 'images/g'+zakres+'.png'} );   
		
		markers.push(marker);
		setMarkers(map);
			
		}//postawMarker   
		
	 
function setMarkers(map) 

		{

		for (var i = 0; i < markers.length; i++) {
		//for (var i = markers.length; i > 1; i--) {	
			markers[i].setMap(map);
			}
			
		}// setMarkers   
		

function clearMarkers() 
			
		{

		setMarkers(null);
		markers = [];
	  
		}//clearMarkers    
   
	 
function setMapCenter(value)

		{
			
		var position = {lat: parseFloat(cityData[parseInt(value)]["lat"]), lng: parseFloat(cityData[parseInt(value)]["long"])};
		map.setCenter(position);        
		map.setZoom(10);
		
		}//setMapCenter
	
	
function addDescription(value)

		{
			
		 $("#loader3").show();
		 document.getElementById("opis").innerHTML="";
		
		 $.post( Routing.generate("ajax_Action2") , {city: cityData[value]["miasto"]},
		 
		 function(response) 
					{
					if (response.code == 100 && response.success)
							{
							$("#loader3").hide();
							$("#notka").show();
							var text = document.createTextNode(response.data);
							var element = document.getElementById("opis");
							element.appendChild(text);
							
							}//if
					else
							{
							 console.log("error");
							}
					},
					
		"json");//post
		
		
		
		}//addDescription
			
