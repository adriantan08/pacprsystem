<h2> Comments</h2><br/>
	<div>
		<table><tr><td>
		<textarea id="commentsTextarea" rows=3 cols=30></textarea>
		</td><td valign=top>&nbsp&nbsp
		<button id="addCommentButton" class="flatbutton">
			Add Comment
		</button></td>
		</tr>
		</table>
	</div>
	<br/><br/><br/>
	<script>
	$("#addCommentButton").click(function(){
		var comment = $("#commentsTextarea").val();
		if(comment !== ""){
			comment = comment.replace(/\r\n|\r|\n/g,"<br/>");
			$.ajax({
				url:"<?=base_url()?>api/addcomment",
				method:"POST",
				async: true,
				data:{
					prId : <?=$prDetails['pr_id']?>,
					comment: comment
					
				},
				success: function(data){}
			})
			.done(function(data){
				location.reload();
			});
		}
		else{
			swal("","Blank comments are not accepted.","error");
		}
	});
</script>

	<div>
		<?php
			$commentsArr = $this->crud_model->getComments($prDetails['pr_id']);
			
			if($commentsArr!=null){
				echo '<hr class="carved"/>';
				echo '<table class="commentsTable" >';
					foreach($commentsArr as $comment){
						echo '<tr><td>';
						echo '<p>'.$comment['comment_text'].'</p><br/><br/>';
						echo '<strong>'.$comment['emp_firstname'].' '.$comment['emp_lastname'].'</strong><br/>';
						
						echo '<font style="font-size:13px;">'.$comment['date_added'].'</font>';
						echo '<br/><br/></td></tr>';
					}
				echo "</table>";
			}
			else
				echo 'No comments yet.';
			
		?>
	</div>


