<style>
    .dataTables_wrapper {
            margin-bottom: 3em;
        }
</style>


<script>
    $(document).ready(function() {
        $('#mytable1').DataTable();
        $('#mytable2').DataTable();
        $('#mytable3').DataTable();
    } );
</script>

<div style="width: 75%; margin: 0 auto; padding: 120px 0 40px;">
    <ul class="tabs" data-persist="true">
        <li><a href="#view1">Submitted PRs</a></li>
        <li><a href="#view2">Posted PRs</a></li>
        <li><a href="#view3">Returned PRs</a></li>
    </ul>
    <div class="tabcontents">
        <div id="view1">
          <div class="dataTables_wrapper">
          <table id="mytable1" class="display" cellspacing="0" width="100%">
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
                  $prList = $this->crud_model->getSubPRs('(10)');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
					
					//When displaying PR_ID, we BOLD them if unread, otherwise normal font weight	
					  $readStyle = "";
					  if(!$list['approver1_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view_adminsechead/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip", "target"=>"_blank")).'</td>';
					  
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
          <table id="mytable2" class="display" cellspacing="0" width="100%">
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
                  $prList = $this->crud_model->getSubPRs('(20)');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
                      
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight	
					  $readStyle = "";
					  if(!$list['approver1_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view_adminsechead/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip", "target"=>"_blank")).'</td>';
					  
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
        <div id="view3">
          <div class="dataTables_wrapper">
          <table id="mytable3" class="display" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>PR Date</th>
                      <th>PR ID</th>
                      <th>Payee</th>
                      <th>Amount</th>
                      <th>Verifier</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $prList = $this->crud_model->getPrListForAsh('25');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
                      
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight	
					  $readStyle = "";
					  if(!$list['approver1_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view_adminsechead/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip", "target"=>"_blank")).'</td>';
					  
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
