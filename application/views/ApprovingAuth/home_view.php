<style>
    .dataTables_wrapper {
            margin-bottom: 3em;
        }
</style>


<script>
    $(document).ready(function() {
      $('#mytable1').DataTable({"pageLength":50});
      $('#mytable2').DataTable({"pageLength":50});
      $('#mytable3').DataTable({"pageLength":50});
    } );
</script>

<div style="width: 75%; margin: 0 auto; padding: 120px 0 40px;">

    <ul class="tabs" data-persist="true">
      <li><a href="#view1" id="tabHeader">Verified</a></li>
      
      <li><a href="#view3" id="tabHeader" style="color:#009900;">Approved</a></li>
    </ul>
    <div class="tabcontents">
        <div id="view1">
          <div class="dataTables_wrapper">
          <table id="mytable1" class="display" cellspacing="0" width="100%">
              <thead>
                  <tr>
                      <th>PR Date</th>
                      <th>PR ID</th>
                      <th>Payee</th>
                      <th>Amount</th>
                      <th>Requestor</th>
                      <th>Posted by</th>
                      <th>Verifier</th>
                  </tr>
              </thead>
              <tbody>
                <?php
                  $prList = $this->Crud_model->getPrListForAa('30', '>0');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
					  
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight	
					  $readStyle = "";
					  if(!$list['approver3_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view_approver/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip")).'</td>';
					  
					 
                      echo '<td>'.$list['payee'].'</td>';
                      echo '<td>'.$list['amount'].'</td>';
                      echo '<td>'.$list['emp_firstname'].' '.$list['emp_lastname'].'</td>';
                      echo '<td>'.$list['asc_firstname'].' '.$list['asc_lastname'].'</td>';
                      echo '<td>'.$list['ver_firstname'].' '.$list['ver_lastname'].'</td>';
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
                      <th>Requestor</th>
                      <th>Posted by</th>
                      <th>Verifier</th>
                      <th>Approver</th>
                  </tr>
              </thead>
              <tbody>
                <?php
				
                  $prList = $this->Crud_model->getPrListForAa('40', '> 0');
                  if($prList != null){
                    foreach($prList as $list){
                      echo '<tr>';
                      echo '<td>'.$list['pr_date'].'</td>';
                      
					  //When displaying PR_ID, we BOLD them if unread, otherwise normal font weight	
					  $readStyle = "";
					  if(!$list['approver3_read_flag'])
						$readStyle = "<b/>";
                      echo '<td>'.$readStyle.anchor('home/view_approver/'.$list['pr_id'], $list['pr_id'], array("class"=>"anchorStrip")).'</td>';
					  
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
