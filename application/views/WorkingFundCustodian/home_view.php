<style>
    .dataTables_wrapper {
            margin-bottom: 3em;
        }
</style>



<div style="width: 75%; margin: 0 auto; padding: 20px 0 40px;">
    <ul class="tabs" data-persist="true">
		    <li><a href="#view0">Drafted PRs</a></li>
        <li><a href="#view1">Submitted PRs</a></li>
        <li><a href="#view2" style="color:#009900;">Approved PRs</a></li>
        <li><a href="#view3">Returned PRs</a></li>
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
                  $prList = $this->crud_model->getDraftedPRs('0');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
					  
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight
					  $readStyle = "";
					  if(!$list['request_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip", "target"=>"_blank")).'</td>';
					  
					  
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
                  $prList = $this->crud_model->getSubPrs('(10,20,25,30,35)');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
                      
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight
					  $readStyle = "";
					  if(!$list['request_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip", "target"=>"_blank")).'</td>';
					  
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
		  
		  <button class="flatbutton" id="printButton"><img src="<?=base_url()?>img/print.png" width=20px />
		  <b>Print</b></button><br/><br/><br/>
		  
          <table id="mytable2" class="display" cellspacing="0" width="100%">
              <thead>
                  <tr>
					  <th></th>
                      <th>PR Date</th>
                      <th>PR ID</th>
                      <th>Payment Form</th>
                      <th>Payee</th>
                      <th>Amount</th>
                      <th>Requestor</th>
                      <th>Submitted</th>
                      <th>Verifier</th>
                      <th>Approver</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $prList = $this->crud_model->getApprovedPRs('40', '>0');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
					  echo '<td><input type="checkbox" name="printselect" value="'.$list['pr_id'].'"></td>';
                      echo '<td>'.$list['pr_date'].'</td>';
                      
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight
					  $readStyle = "";
					  if(!$list['request_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip", "target"=>"_blank")).'</td>';
					  
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
                  $prList = $this->crud_model->getPrListForWfc('15');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
                      
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight
					  $readStyle = "";
					  if(!$list['request_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip", "target"=>"_blank")).'</td>';
					  
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
</script>

<script>
    $(document).ready(function() {
		 $('#mytable0').DataTable();
        $('#mytable1').DataTable();
        $('#mytable2').DataTable();
        $('#mytable3').DataTable();
    } );
</script>
