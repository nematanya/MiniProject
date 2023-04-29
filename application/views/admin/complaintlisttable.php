<table id='complaintList' class="table table-striped table-bordered" border="1">
  <thead>
    <tr>
        <td>Complaint No</td>
        <td>Complaint By</td>
        <td>Complaint Status</td>
        <td>Registered Date</td>
        <td>Last Update</td>
        <td>Complaint Assigned</td>
        <td>Payment Details</td>
        <td>Action</td>
    </tr>
    </thead>
    <tbody id="complaintContent">
    <?php foreach($complaintlist as $comp) { ?>
        <?php
        if($comp['paymentTransactionId']== null && $comp['personal']==1){
        $status="Not Paid";
        $paymentDetails='Not Paid';
        }else if($comp['paymentTransactionId']==0 && $comp['personal']==0){
        $status=$comp['compstatus']; 
        $paymentDetails="Payment Not Required";   
        }else{
        $status=$comp['compstatus'];
        $paymentDetails="Transaction ID: ".$comp['paymentTransactionId']."<br>Transaction Date: ".date('H:i d/m/Y',$comp['paymentDate'])."";
        }    
            
        ?>
      <tr>
        <td> <?php echo $comp['complaintNo']; ?></td>
        <td> <?php echo $comp['name']; ?></td>
        <td><?php echo $status; ?></td>
        <td> <?php echo date('H:i d/m/Y',$comp['complaintDate']); ?></td>
        <td> <?php echo date('H:i d/m/Y',$comp['lastupdate']); ?></td>
        <td> <?php echo $comp['staffname']; ?></td>
        <td><?php echo $paymentDetails ?></td>
        <td><a title="Details" href="<?php echo base_url(); ?>admin/admin/getcomplaint/<?php echo base64_encode($comp['complaint_id']) ?>/<?php echo base64_encode($comp['complaintNo']); ?>" 
        target="_blank"><i class="fas fa-align-justify" style="font-size:24px"></i></a>
          <?php if($comp['staffname']!='Not Assigned'){ ?>
          <?php if($levelaccess==2){?>
          <a title="Start Chat" href="<?php echo base_url(); ?>admin/admin/chat/<?php echo base64_encode($comp['complaint_id']) ?>"><i class="fas fa-comment" style="font-size:24px"></i></a> 
          <?php } else {?>
            <br><a title="View Chat" href="<?php echo base_url(); ?>admin/admin/chatstaff/<?php echo base64_encode($comp['complaint_id']) ?>"><i class="fas fa-comment" style="font-size:24px"></i></a>   
          <?php }?>
          <?php } ?>
        </td>
     </tr>

   
   <?php } ?>
      </tbody>
</table>