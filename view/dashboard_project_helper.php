<?php
class Project_Dashboard_Template {
	public function __construct() {}
	
	public function dashboard_template_body($title, $num, $pid, $pname, $piname) {
		echo '
			<tr>
				<td>'.$title.'</td>
				<td>'.$num.'</td>
				<td>
				<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#'.$title.'">
					<span class="glyphicon glyphicon-list"></span> View
				</button>
				<div id="'.$title.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="myModalLabel">List of projects on '.$title.'</h4>
							</div>
							<div class="modal-body filterable">
								<table class="table table-striped table-hover">
									<thead>
										<tr class="filters">
											<th><input id="'.$pid.'" type="text" class="form-control" placeholder="PID" /></th>
											<th><input id="'.$pname.'" type="text" class="form-control" placeholder="Project Name" /></th>
											<th><input id="'.$piname.'" type="text" class="form-control" placeholder="PI Name" /></th>
											<th><b>PI Email</b></th>
											<th><b>Creation Date</b></th>
											<th><b>Records </b></th>
											<th><b>Forms</b></th>
											<th><b>Fields</b></th>
											<th><b>production Date</b></th>
										</tr>
									</thead>
		';
	}
	
	public function dashboard_template_footer($php_name) {
		echo '
								</table>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
				</td>
				<td><a href="csv_download/'.$php_name.'.php"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
			</tr>
		';
	}
}
?>