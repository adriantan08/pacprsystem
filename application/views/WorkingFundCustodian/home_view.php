<style>
    .dataTables_wrapper {
            margin-bottom: 3em;
        }
</style>



<div style="width: 75%; margin: 0 auto; padding: 20px 0 40px;">
    <ul class="tabs" data-persist="true">
		 <li><a id="tabHeader" href="#view0">Drafts</a></li>
        <li><a id="tabHeader" href="#view1">Submitted</a></li>
        <li><a id="tabHeader" href="#view2" style="color:#009900;">Approved</a></li>
        <li><a id="tabHeader" href="#view3">Returned</a></li>
		<li><a id="tabHeader" href="#view4"><i>Archived</i></a></li>
    </ul>
    <div class="tabcontents">
		 <div id="view0">
          <div class="dataTables_wrapper">
          <table id="mytable0" class="display" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>PR Date</th>
                      <th>PR ID</th>
                      <th>Payment Form</th>
                      <th>Payee</th>
                      <th>Amount</th>
                      <th>Requestor</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $prList = $this->Crud_model->getDraftedPRs('0');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
					  
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight
					  $readStyle = "";
					  if(!$list['request_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip")).'</td>';
					  
					  
                      echo '<td>'.$list['pr_paymentForm'].'</td>';
                      echo '<td>'.$list['payee'].'</td>';
                      echo '<td>'.$list['amount'].'</td>';
                      echo '<td>'.$list['emp_firstname'].' '.$list['emp_lastname'].'</td>';
                      echo '</tr>';
                    }
                  }
                ?>
              </tbody>
          </table>
        </div>
        </div>
        <div id="view1">
          <div class="dataTables_wrapper">
          <table id="mytable1" class="display" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>PR Date</th>
                      <th>PR ID</th>
                      <th>Status</th>
                      <th>Payment Form</th>
                      <th>Payee</th>
                      <th>Amount</th>
                      <th>Requestor</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $prList = $this->Crud_model->getSubPrs('(10,20,25,30,35)');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
                      
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight
					  $readStyle = "";
					  if(!$list['request_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip")).'</td>';
					  
                      echo '<td>'.$list['pr_status'].'</td>';
                      echo '<td>'.$list['pr_paymentForm'].'</td>';
                      echo '<td>'.$list['payee'].'</td>';
                      echo '<td>'.$list['amount'].'</td>';
                      echo '<td>'.$list['emp_firstname'].' '.$list['emp_lastname'].'</td>';
                      echo '</tr>';
                    }
                  }
                ?>
              </tbody>
          </table>
        </div>
        </div>
        <div id="view2">
          <div class="dataTables_wrapper">
		  
		  <span>
			<button class="flatbutton" id="printButton"><img src="<?=base_url()?>img/print.png" width=20px />
				<b>Print</b></button>
		  
			<button class="flatbutton" name="archiveOrRestoreButton" id="archive" style="position:relative; left:20px;background-color:grey;">
				<b>Archive</b></button>
		  </span>
		  
		  <br/><br/><br/>
		  
          <table id="mytable2" class="display" cellspacing="0" width="100%">
              <thead >
                  
					  <th><input type="checkbox" style="position:relative; left:-15px;" id="selectToggle"  value=""></th>
                      <th>PR Date</th>
                      <th>PR ID</th>
                      <th>Payment Form</th>
                      <th>Payee</th>
                      <th>Amount</th>
                      <th>Requestor</th>
                      <th>Submitted</th>
                      <th>Verifier</th>
                      <th>Approver</th>
                  
              </thead>
              <tbody>
                <?php
                  $prList = $this->Crud_model->getApprovedPRs('40', '>0');
				  
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
					  echo '<td><input type="checkbox" name="printselect" value="'.$list['pr_id'].'"></td>';
                      echo '<td>'.$list['pr_date'].'</td>';
                      
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight
					  $readStyle = "";
					  if(!$list['request_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip")).'</td>';
					  
                      echo '<td>'.$list['pr_paymentForm'].'</td>';
                      echo '<td>'.$list['payee'].'</td>';
                      echo '<td>'.$list['amount'].'</td>';
                      echo '<td>'.$list['emp_firstname'].' '.$list['emp_lastname'].'</td>';
                      echo '<td>'.$list['asc_firstname'].' '.$list['asc_lastname'].'</td>';
                      echo '<td>'.$list['ver_firstname'].' '.$list['ver_lastname'].'</td>';
                      echo '<td>'.$list['app_firstname'].' '.$list['app_lastname'].'</td>';
                      echo '</tr>';
                    }
                  }
                ?>
              </tbody>
          </table>
        </div>
        </div>
        <div id="view3">
          <div class="dataTables_wrapper">
          <table id="mytable3" class="display" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>PR Date</th>
                      <th>PR ID</th>
                      <th>Payee</th>
                      <th>Amount</th>
                      <th>Admin Sec Head</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $prList = $this->Crud_model->getPrListForWfc('15');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
                      
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight
					  $readStyle = "";
					  if(!$list['request_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip")).'</td>';
					  
                      echo '<td>'.$list['payee'].'</td>';
                      echo '<td>'.$list['amount'].'</td>';
                      echo '<td>'.$list['approver2_id'].'</td>';
                      echo '</tr>';
                    }
                  }
                ?>
              </tbody>
          </table>
        </div>
        </div>
		<div id="view4">
          <div class="dataTables_wrapper">
		  
		  <span>
			<button class="flatbutton" name="archiveOrRestoreButton" id="restore" style="position:relative; left:20px;background-color:green;">
				<b>Restore</b></button>
		  </span>
		  
		  <br/><br/><br/>
		  
          <table id="mytable4" class="display" cellspacing="0" width="100%">
              <thead >
                  
					  <th><input type="checkbox" style="position:relative; left:-15px;" id="selectToggleArchived"  value=""></th>
                      <th>PR Date</th>
                      <th>PR ID</th>
                      <th>Payment Form</th>
                      <th>Payee</th>
                      <th>Amount</th>
                      <th>Requestor</th>
                      <th>Submitted</th>
                      <th>Verifier</th>
                      <th>Approver</th>
                  
              </thead>
              <tbody>
                <?php
                  $prList = $this->Crud_model->getApprovedPRs('99', '>0');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
					  echo '<td><input type="checkbox" name="archivedselect" value="'.$list['pr_id'].'"></td>';
                      echo '<td>'.$list['pr_date'].'</td>';
                      
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight
					  $readStyle = "";
					  if(!$list['request_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip")).'</td>';
					  
                      echo '<td>'.$list['pr_paymentForm'].'</td>';
                      echo '<td>'.$list['payee'].'</td>';
                      echo '<td>'.$list['amount'].'</td>';
                      echo '<td>'.$list['emp_firstname'].' '.$list['emp_lastname'].'</td>';
                      echo '<td>'.$list['asc_firstname'].' '.$list['asc_lastname'].'</td>';
                      echo '<td>'.$list['ver_firstname'].' '.$list['ver_lastname'].'</td>';
                      echo '<td>'.$list['app_firstname'].' '.$list['app_lastname'].'</td>';
                      echo '</tr>';
                    }
                  }
                ?>
              </tbody>
          </table>
        </div>
        </div>
    </div>
</div>
<script>
	$("#printButton").click(function(){
		var checkedArr = [];
		$("input:checkbox[name=printselect]:checked").each(function () {
           checkedArr.push($(this).val());
        });
		if(checkedArr.length>0)
		window.open("<?=base_url()?>home/print_preview/"+encodeURI(checkedArr.join(" ")));
	});
	
	$("button[name='archiveOrRestoreButton']").click(function(){
		var buttonAction = this.id;
		var checkedArr = [];
		if(buttonAction == 'archive'){
			$("input:checkbox[name=printselect]:checked").each(function () {
			   checkedArr.push($(this).val());
			});
		}
		else{ //means intent is to restore
			$("input:checkbox[name=archivedselect]:checked").each(function () {
			   checkedArr.push($(this).val());
			});
		}
		if(checkedArr.length>0){ 
			if(buttonAction == 'archive')
				var textMsg = "Selected PRs will be archived and viewable in the ARCHIVE TAB.";
			else
				var textMsg = "Selected PRs will be restored and will be APPROVED by status.";
			
			swal({
			  title: "Confirm Action",
			  text: textMsg,
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#DD6B55",
			  confirmButtonText: "Continue",
			  cancelButtonText: "Cancel",
			  closeOnConfirm: true,
			  closeOnCancel: true
			},
			function(isConfirm){
			  if (isConfirm) {
				  $.ajax({
					  url: "<?=base_url()?>home/archive",
					  method:"POST",
					  async:true,
					  data:{ids:checkedArr, action:buttonAction}
					}).done(function(data) {
					  location.reload();
					});
				  
			  }
			});

			
		}
	});
	
	$("#selectToggle").click(function(){
		
		if($('#selectToggle:checkbox:checked').is(":checked"))
			$("input:checkbox[name=printselect]").prop('checked', true);
		else
			$("input:checkbox[name=printselect]").prop('checked', false);
		
	});

	
	$("#selectToggleArchived").click(function(){
		
		if($('#selectToggleArchived:checkbox:checked').is(":checked"))
			$("input:checkbox[name=archivedselect]").prop('checked', true);
		else
			$("input:checkbox[name=archivedselect]").prop('checked', false);
		
	});
</script>

<script>
    $(document).ready(function() {
		$('#mytable0').DataTable({"pageLength":50});
        $('#mytable1').DataTable({"pageLength":50});
        $('#mytable2').DataTable({"pageLength":50});
        $('#mytable3').DataTable({"pageLength":50});
		$('#mytable4').DataTable({"pageLength":50});
    } );
</script>
