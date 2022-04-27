<!DOCTYPE html>
<html>
	<body>
		
		<h2>HTML Forms</h2>
		<head>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
			
		</head>
		
		<form id="add_form" class="form_edit2">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="name">Name</label>
					<input type="text" class="form-control" id="name" name="name">
				</div>
				<input type="text" name="id" id="id" hidden="">
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="email">email</label>
					<input type="text" class="form-control" id="email" name="email">
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
			<button  type="submit" class="btn btn-primary">update</button>
			
		</form>
		
		<div class="table-responsive">
			<h2>Basic Table</h2>
			<table class="table">
				<thead>
					<tr>
						<th>sr no</th>
						<th>Firstname</th>
						<th>Email</th>
						<th>action</th>
					</tr>
				</thead>
				<tbody id="load_table">
					<tr>
						<td>0</td>
						<td>John</td>
						<td>john@example.com</td>
						<td> <a class="edit" title="Edit" >Edit</a>
						<a class="delete" title="Delete" >Delete</a></td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				//-----------------------display data--------------------------
				function loadTable(){
					$("#load_table").html("");
					
					$.ajax({
						url:'http://localhost/php_api/fetchallrecord.php',
						type: "GET",
						contentType: "application/json; charset=utf-8",
						dataType: "json",
						success : function(data){
							console.log(data);
							if(data.status == false){
								$("#load_table").append("<tr><td colspan='6'><h2>"+data.message+"</h2></td></tr>");
								}else{
								$.each(data, function(key, val){
									$("#load_table").append("<tr>"
									+"<td>"+val.id+"</td>"
									+"<td>"+val.name+"</td>"
									+"<td>"+val.email+"</td>"
									+"<td><button id='edit_user' class='btn btn-sm btn-info ml-1' data-eid='"+val.id+"'>Edit</button></td>"
									+"<td><button id='delete_user' class='btn btn-sm btn-danger ml-1' data-id='"+val.id+"'>Delete</button></td>"+
									"</tr>");
								});
							}
						}
					})
				}
				loadTable();
				
				//jsn data
				function jsondata(targetform){
					var array = $(targetform).serializeArray();
					//console.log(array);
					var objec ={};
					for(var i=0; i<array.length; i++){
						if(array[i].value == ""){
							return false;
						}
						objec[array[i].name] = array[i].value;
					}
					//console.log(objec);
					var jsn = JSON.stringify(objec);					
					//console.log(jsn);
					return jsn;
				}
				//----------------------edit data-------------------------
				$(document).on('click','#edit_user',function(){
                    //$("#modal_user").modal('show');	
					var uid = $(this).data("eid");
					var object ={id : uid};
					var myjsn = JSON.stringify(object);
					
					$.ajax({
						url:'http://localhost/php_api/fetch1record.php',
						type: "POST",
						dataType:'json',
						contentType: "application/json; charset=utf-8",
						data: myjsn,
						success : function(data){
							console.log(data);
							//alert(data);
							$("#id").val(data[0].id);
							$("#name").val(data[0].name);
							$("#email").val(data[0].email);
						}
					});
				});
				//----------------------insert data-------------------------
				
				$("#add_form").on('submit',function(e){
					e.preventDefault();
					var jsonobj =jsondata("#add_form");
					console.log(jsonobj);
					
					if(jsonobj == false){
						alert("all field needed");
					}
					else{
						$.ajax({
							url:'http://localhost/php_api/insertrocordapi.php',
							type: "POST",
							contentType: "application/json; charset=utf-8",
							data: jsonobj,
							dataType: 'json',
							success : function(data){
								
								loadTable();
								$("#add_form").trigger("reset");
								//$('#buttonx').hide();	
							}
						});
					}
				});
				//----------------------update data-------------------------
				
				$(".form_edit2").on('submit',function(e){
					e.preventDefault();
					var jsonobj =jsondata(".form_edit2");
					console.log(jsonobj);	
					if(jsonobj == false){
						alert("all field needed");
					}
					else{
						$.ajax({
							url:'http://localhost/php_api/updaterocordapi.php',
							type: "POST",
							contentType: "application/json; charset=utf-8",
							data: jsonobj,
							dataType: 'json',
							success : function(data){
								$("#modal_user").modal('hide');
								//loadTable();
								//$("#add_form").trigger("reset");	
							}
						});
					}
				});
				
				//----------------------------------Delete data------------------------------------- 
				$(document).on('click','#delete_user',function(){
					var uid = $(this).data("id");
				    confirm('Are you sure want to delete !');
					var object ={id : uid};
					var myjsn = JSON.stringify(object);
					
					$.ajax({
						url:'http://localhost/php_api/deleteapi.php',
						type: "DELETE",
						dataType:'json',
						contentType: "application/json; charset=utf-8",
						data: myjsn,
						success : function(data){
							loadTable();
						}
					});
				});
			
				$("#buttonx").click(function() {
					$(this).attr('disabled','disabled');
					$('#buttony').removeAttr('disabled');
				});	
				
				$("#buttony").click(function() {
					$(this).attr('disabled','disabled');
					$('#buttonx').removeAttr('disabled');
				});
			});
		</script>
		<button id="buttonx">
			update
		</button>
		
		<button id="buttony">
			edit
		</button>
	</body>
</html>	

