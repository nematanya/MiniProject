
    <section class="content-header">
        <h3>
            <i class="fa fa-user"></i>Users List
        </h3>
        <label id="list">Filter User: </label>
        <select name="selected" id="select" class="select22">
        <option value="">All</option>
        <option value="1">Active</option>
        <option value="2">In-Active</option>
        <option value="3">Deleted</option>
        </select>
    </section>
    <div class="userfilteredcontent" id="userfilteredcontent">
 <table id='userList' class="table table-striped table-bordered" border="1">
  <thead>
    <tr>
        <td>Name</td>
        <td>Username</td>
        <td>Mobile</td>
        <td>Email</td>
        <td>Address</td>
        <td>Status</td>
        <td>Action</td>
        
    </tr>
    </thead>
    <tbody id="complaintContent">
    <?php foreach($userlist as $user) { ?>
        <?php   
            if($user['status']==1){
              $stat1='Active';
              $stat2='&nbsp;&nbsp;<button class="btn btn-warning btn-sm" onclick="makeactive('.$user['userid'].',2)" title="Make In-Active">In-Active</button>';
              $status=$stat1.''.$stat2;
            } else if($user['status']==2){
              $stat1='In-Active';
              $stat2='&nbsp;&nbsp;<button class="btn btn-success btn-sm" onclick="makeactive('.$user['userid'].',1)" title="Make Active">Active</button>';
              $status=$stat1.''.$stat2;
            }else  if($user['status']==3){
            $status='Deleted';
            }
        ?>
      <tr>
        <td> <?php echo $user['name']; ?></td>
        <td> <?php echo $user['username']; ?></td>
        <td> <?php echo $user['mobile']; ?></td>
        <td> <?php echo $user['email']; ?></td>
        <td> <?php echo $user['buildingname'].', Room No-'.$user['roomno']; ?></td>
        <td><?php echo $stat1; ?></td>
        <td><a class="btn btn-info btn-sm" href="<?php echo base_url(); ?>admin/admin/getuser/<?php echo base64_encode($user['userid']) ?>/<?php echo base64_encode($user['mobile']); ?>" 
        target="_blank">Details </a>
        <?php if($this->rbac->hasPrivilege('users', 'can_edit')){?>
        <?php echo $stat2 ?>
        <a class="btn btn-primary btn-sm" href="<?php echo base_url();?>admin/admin/userprofile/<?php echo base64_encode($user['userid']) ?>">Edit</a>
        <?php } ?>

     </tr>

   
   <?php } ?>
      </tbody>
</table>
</div>


<script>
var baseurl = "<?php echo base_url(); ?>";
var redirect= "<?php echo base_url('admin/admin/userList'); ?>";


  $(document).ready(function () {
    $('#userList').DataTable({      
      pageLength:10,
      "bLengthChange" : false,
    
    });
});
$('.select22').change(function() {
    	ajaxgetTable(this.value);
});

function ajaxgetTable(status){
  $.ajax({
		type: "POST",
		url: baseurl + "admin/admin/filterbaseuserslist",
		data: {'status':status},
		dataType: "JSON",
    success: function(data) {
      document.getElementById("userfilteredcontent").innerHTML='';
      
    if(parseInt(data.status) === 1) {
      document.getElementById("userfilteredcontent").innerHTML+=data.html;
				swal({
					title: "Data Loaded Successfully",
					type: "success",
					showConfirmButton: true,
					confirmButtonText: "Ok",
					closeOnConfirm: true
				}, function() {
					//window.location = redirect;
				});

			} else {
				swal({
					title:data.errorP,
					type: "warning",
					showConfirmButton: true,
					confirmButtonText: "Ok",
					closeOnConfirm: true
				 }, function() {
					//window.location = redirect;
				});
			}
    },
    complete: function() {
      $('#userList').DataTable({      
       pageLength:10,
      "bLengthChange" : false,
    
    });
    }

  });
}

function makeactive3(userid,active){
  $.ajax({
		type: "POST",
		url: baseurl + "admin/admin/useractivestatus",
		data: {'userid':userid,'status':active},
		dataType: "JSON",
    success: function(data) {
    window.location.reload();
    },


  });

}


function makeactive(userid,active){
  $.ajax({
		type: "POST",
		url: baseurl + "admin/admin/useractivestatus",
		data: {'userid':userid,'status':active},
		dataType: "JSON",
    success: function(data) {
      if (parseInt(data.status) === 1) {
				swal({
					title: "Status Changed",
					type: "success",
					showConfirmButton: true,
					confirmButtonText: "Ok",
					closeOnConfirm: true
				}, function() {
					window.location = redirect;
				});

			} else {
				swal({
					title:data.error,
					type: "warning",
					showConfirmButton: true,
					confirmButtonText: "Ok",
					closeOnConfirm: true
				 }, function() {
				});
			}
    },


  });

}
</script>



