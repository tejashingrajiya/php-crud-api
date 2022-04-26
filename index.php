<!DOCTYPE html>
<html>
	<body>
		
		<h2>HTML Forms</h2>
		<head>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
			
		</head>
		<form id="add_form">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="name">Name</label>
					<input type="text" class="form-control" id="name" name="name">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="email">email</label>
					<input type="text" class="form-control" id="email" name="email">
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
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
		<div id="error_message" class="message"></div>
		<div id="Success_message" class="message"></div>
		
		<div class="modal" id="modal_user">
            <div class="modal-dialog">
				<div id="modal-form">
					<div class="modal-content">
						<form id="form_edit">
							<div class="modal-header">
								<h4 class="modal-title" id="modal_title"></h4>
							</div>
							<!-- Modal body -->
							<div class="modal-body">
								<div class="col-md-12">
									<label for="recipient-name" class="col-form-label">name:</label>
									<input type="text" name="name" id="edit_name" class="form-control" placeholder="Enter name...">
								</div>
								<input type="text" name="id" id="edit_id" hidden="">
								
								<div class="col-md-12">
									<label for="recipient-name" class="col-form-label">email:</label>
									<input type="text" name="email" id="edit_email" class="form-control" placeholder="Enter email...">
								</div>
							</div>
							<div id="error" >
							</div>
							<!-- Modal footer -->
							<div class="modal-footer">
								<button type="submit" class="btn btn-info">Update</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						</form>
						
					</div>
				</div>
			</div>
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
                    $("#modal_user").modal('show');	
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
							$("#edit_id").val(data[0].id);
							$("#edit_name").val(data[0].name);
							$("#edit_email").val(data[0].email);
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
								
								
							}
							
						});
						
					}
				});
				//----------------------update data-------------------------
				
				$("#form_edit").on('submit',function(e){
					e.preventDefault();
					var jsonobj =jsondata("#form_edit");
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
								loadTable();
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
			});
			
		</script>
	</body>
</html>	

