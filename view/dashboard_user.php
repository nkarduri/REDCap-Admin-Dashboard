<?php
error_reporting(0);
if (ISSET($_GET['username'])) {
    $userid = $_GET['username'];
} else {
    header("Location: dashboard.php");
}
require_once '../../../redcap_connect.php';
include_once "../sql_list.php";
include_once "dashboard_project_helper.php";

$mysql = new MySQL();

// Total users
$conso_total_user_sql = db_query($mysql->conso_total_user());
$conso_total_user = mysqli_num_rows($conso_total_user_sql);

$conso_last6month_user_sql = db_query($mysql->conso_last6month_user());
$conso_last6month_user = mysqli_num_rows($conso_last6month_user_sql);

$last_user_10days_sql = db_query($mysql->conso_user_last_10days());
$last_user_10days_num = mysqli_num_rows($last_user_10days_sql);
if ($last_user_10days_num == "") { 
    $last_user_10days_num = "0";
}
                                        
$last_user_30days_sql = db_query($mysql->conso_user_last_30days());
$last_user_30days_num = mysqli_num_rows($last_user_30days_sql);
if ($last_user_30days_num == "") { 
    $last_user_30days_num = "0";
}

$last_user_90days_sql = db_query($mysql->conso_user_last_90days());
$last_user_90days_num = mysqli_num_rows($last_user_90days_sql);
if ($last_user_90days_num == "") { 
    $last_user_90days_num = "0";
}

$suspended_user_sql = db_query($mysql->suspended_users());
$suspended_user_num = mysqli_num_rows($suspended_user_sql);

//API user accounts

$api_user_sql = db_query($mysql->api_users());
$api_user_sql_num = mysqli_num_rows($api_user_sql);



//APP(OFFLINE) user accounts

$app_user_sql     = db_query($mysql->app_users());
$app_user_sql_num  = mysqli_num_rows($app_user_sql);  



if($suspended_user_num == "")
 {
   $suspended_user_num = "0";
 } 

 
?>

<h3>User Dashboard</h3>
<br>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#user_consortium" data-toggle="tab">REDCap Database</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane in active" id="user_consortium">
        <br>    
        <div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title">Redcap Admin Dashboard</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <td><b>User Status</b></td>
                            <td><b>Number of users</b></td>
                            <td><b>View</b></td>
                            <td><b>Download</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><h4>Total</h4></td>
                            <td><?php echo $conso_total_user; ?></td>
                            <td>
                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#conso_total_user">
                                    <span class="glyphicon glyphicon-list"></span> View
                                </button>
                                <div id="conso_total_user" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">List of total users</h4>
                                            </div>
                                            <div class="modal-body filterable">
                                                <table class="filter_table table table-striped table-hover">
                                                    <thead>
                                                        <tr class="filters">
                                                            <th><input id="total_username" type="text" class="form-control" placeholder="Username" /></th>
                                                            <th><input id="total_fname" type="text" class="form-control" placeholder="First Name" /></th>
                                                            <th><input id="total_lname" type="text" class="form-control" placeholder="Last Name" /></th>
                                                            <th><b>E-mail</b></th>
                                                            <th>Sponsor</th>
                                                            <th>Sponsor Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ( $conso_total_user_result = db_fetch_array($conso_total_user_sql) ) { ?>
                                                        <tr>
                                                            <td><?php echo $conso_total_user_result['username']; ?></td>
                                                            <td><?php echo $conso_total_user_result['user_firstname']; ?></td>
                                                            <td><?php echo $conso_total_user_result['user_lastname']; ?></td>
                                                            <td><a href="mailto: <?php echo $conso_total_user_result['user_email']; ?>"><?php echo $conso_total_user_result['user_email']; ?></a></td>
                                                            <td><?php echo $conso_total_user_result['user_sponsor'];?></td>
                                                            <td>
                                                            <?php 
                                  
                                                              if(isset($conso_total_user_result['user_sponsor']))
                                                              {
                                                             
                                                              $usersponsor = $conso_total_user_result['user_sponsor'];
                                                               
                                                              $sql = db_query("select user_email from redcap_user_information where username = '$usersponsor'");    
                                                            
                                                              $result = db_fetch_array($sql);
                                                              
                                                              echo $result['user_email'];                        
                                                              }
                                                              
                                                              ?>
      
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        } ?>
                                                    </tbody>
                                                </table>
                                                
                                             </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a href="csv_download/user_total.php"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
                            <!-- td><button id="btn-conso-prod" class="btn btn-success btn-xs" type="button"><span class="glyphicon glyphicon-download-alt"></span> Download</button></td -->
                        </tr>
                        <tr>
                            <td><h4>Active (last 6 months)</h4><button id="btn_email_all" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-send"></span> email all</button></td>
                            <td><?php echo $conso_last6month_user; ?></td>
                            <td>
                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#conso_active_user">
                                    <span class="glyphicon glyphicon-list"></span> View
                                </button>
                                <div id="conso_active_user" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">List of active users</h4>
                                            </div>
                                            <div class="modal-body filterable">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr class="filters">
                                                            <th><input id="active_username" type="text" class="form-control" placeholder="Username" /></th>
                                                            <th><input id="active_fname" type="text" class="form-control" placeholder="First Name" /></th>
                                                            <th><input id="active_lname" type="text" class="form-control" placeholder="Last Name" /></th>
                                                            <th><b>E-mail</b></td>
                                                            <th>Sponsor</th>
                                                            <th>Sponsor Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $email_all = "";
                                                        while ( $conso_last6month_user_result = db_fetch_array($conso_last6month_user_sql) ) { 
                                                            $email_all .= $conso_last6month_user_result['user_email'].";";
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $conso_last6month_user_result['username']; ?></td>
                                                            <td><?php echo $conso_last6month_user_result['user_firstname']; ?></td>
                                                            <td><?php echo $conso_last6month_user_result['user_lastname']; ?></td>
                                                            <td><a href="mailto: <?php echo $conso_last6month_user_result['user_email']; ?>"><?php echo $conso_last6month_user_result['user_email']; ?></a></td>
                                                            <td><?php echo $conso_last6month_user_result['user_sponsor']; ?></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                        } ?>
                                                    </tbody>
                                                </table>
                                                
                                             </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><a href="csv_download/user_active.php"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
                            <!-- td><button id="btn-conso-dev" class="btn btn-success btn-xs" type="button"><span class="glyphicon glyphicon-download-alt"></span> Download</button></td -->
                        </tr>
                    <tr>    
                     <td><h4>Suspended User accounts</h4><button id="btn_email_all1" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-send"></span> email all</button></td></td>    
                     <td> <?php echo $suspended_user_num;  ?></td>
                     <td>
                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#conso_active_user1">
                                    <span class="glyphicon glyphicon-list"></span> View
                                </button>
                                <div id="conso_active_user1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">List of Suspended users</h4>
                                            </div>
                                            <div class="modal-body filterable">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr class="filters">
                                                            <th><input id="active_username" type="text" class="form-control" placeholder="Username" /></th>
                                                            <th><input id="active_fname" type="text" class="form-control" placeholder="First Name" /></th>
                                                            <th><input id="active_lname" type="text" class="form-control" placeholder="Last Name" /></th>
                                                            <th><b>E-mail</b></td>
                                                            <th>Sponsor</th>
                                                            <th>Sponsor Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $email_all1 = "";
                                                        while ( $conso_suspended_user_result = db_fetch_array($suspended_user_sql) ) { 
                                                            $email_all1 .= $conso_suspended_user_result['user_email'].";";
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $conso_suspended_user_result['username']; ?></td>
                                                            <td><?php echo $conso_suspended_user_result['user_firstname']; ?></td>
                                                            <td><?php echo $conso_suspended_user_result['user_lastname']; ?></td>
                                                            <td><a href="mailto: <?php echo $conso_suspended_user_result['user_email']; ?>"><?php echo $conso_suspended_user_result['user_email']; ?></a></td>
                                                            <td><?php echo $conso_suspended_user_result['user_sponsor']; ?></td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                        } ?>
                                                    </tbody>
                                                </table>
                                                
                                             </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                                
                    <td><a href="csv_download/user_suspended.php"><span class="glyphicon glyphicon-download-alt"></span> Download</a></td>
                        
                    </tr>
                    
                     <!-- API token section   -->
                    <tr>    
                     <td><h4>API User accounts</h4>&nbsp;<button id="btn_email_all_api" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-send"></span> email all</button></td></td>    
                     <td> <?php echo $api_user_sql_num;  ?></td>
                     <td>
                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#conso_api_user">
                                    <span class="glyphicon glyphicon-list"></span> View 
                                </button>
                                <div id="conso_api_user" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">List of API users</h4>
                                            </div>
                                            <div class="modal-body filterable">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr class="filters">
                                                        
                                                            <th>Project Title</th>
                                                            <th>Status</th>
                                                            <th><input id="active_username" type="text" class="form-control" placeholder=" Project ID" /></th>
                                                            <th><input id="active_username" type="text" class="form-control" placeholder="username" /></th>
                                                            <th><input id="active_fname" type="text" class="form-control" placeholder="First Name" /></th>
                                                            <th><input id="active_lname" type="text" class="form-control" placeholder="Last Name" /></th>
                                                            <th><b>E-mail</b></td>
                                                            <th>Sponsor</th>
                                                            <th>Sponsor Email</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        
                                                        $email_all2 = "";
                                                        while ( $api_user_result = db_fetch_array($api_user_sql) ) { 
                                                            $email_all2 .= $api_user_result['user_email'].";";
                                                              
                                                        ?>
                                                        <tr>
                                                          <td>
                                                            <?php
                                                            
                                                             
                                                              if(isset($api_user_result['project_id']))
                                                              {
                                                                  
                                                                  
                                                              $project_id = $api_user_result['project_id'];
                                                               
                                                              $sql = db_query("select app_title from redcap_projects where project_id = '$project_id'");    
                                                            
                                                              $result = db_fetch_array($sql);
                                                              
                                                              echo $result['app_title'];
                                                                                      
                                                              }
                                                             ?>
                                                           </td>
                                                        
                                                             <td>
                                                            <?php
                                                            
                                                              if(isset($api_user_result['project_id']))
                                                              {
                                                                  
                                                                  
                                                              $project_id = $api_user_result['project_id'];
                                                               
                                                              $sql = db_query("select status from redcap_projects where project_id = '$project_id'");    
                                                            
                                                              $result = db_fetch_array($sql);
                                                              
                                                               if ($result['status'] == '0' )
                                                               echo "<font color='red'>Development</font>";
                                                               else if ($result['status'] == '1' )
                                                               echo "<font color=blue>Production</font>"; 
                                                                                     
                                                              }
                                                             ?>
                                                           </td> 
                                                        
                                                        
                                                        
                                                            <td><?php echo $api_user_result['project_id']; ?></td>
                                                          
                                                            <td><?php echo $api_user_result['username']; ?></td>
                                                            <td><?php echo $api_user_result['user_firstname']; ?></td>
                                                            <td><?php echo $api_user_result['user_lastname']; ?></td>
                                                            <td><a href="mailto: <?php echo $api_user_result['user_email']; ?>"><?php echo $api_user_result['user_email']; ?></a></td>
                                                            <td><?php echo $api_user_result['user_sponsor']; ?></td>
                                                            <td></td>
                                                        </tr>
                                                        
                                                        <?php
                                                        } ?>
                                                    </tbody>
                                                </table>
                                                
                                             </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                                
                      
                    </tr>    
                    
                     <tr>    
                     <td><div style="font-weight:bold;color:#fff;border:1px solid #ccc;border-bottom:0;background-color:#555;padding:8px 10px;font-size:13px;">APP(OFFLINE) User accounts
                      
                     <button id="btn_email_all_app" class="btn btn-xs btn-warning"><span class="glyphicon glyphicon-send"></span> email all</button></div></td>  
                     <td> <?php echo $app_user_sql_num;  ?></td>
                     <td>
                                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#conso_app_user">
                                    <span class="glyphicon glyphicon-list"></span> View 
                                </button>
                                <div id="conso_app_user" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">List of APP(OFFLINE) users</h4>
                                            </div>
                                            <div class="modal-body filterable">
                                                <table class="table table-striped table-hover">
                                                    <thead>
                                                        <tr class="filters">
                                                           <th>Project Title</th>
                                                           <th>Status</th>
                                                            <th><input id="active_username" type="text" class="form-control" placeholder=" Project ID" /></th>
                                                            <th><input id="active_username" type="text" class="form-control" placeholder="username" /></th>
                                                            <th><input id="active_fname" type="text" class="form-control" placeholder="First Name" /></th>
                                                            <th><input id="active_lname" type="text" class="form-control" placeholder="Last Name" /></th>
                                                            <th><b>E-mail</b></td>
                                                            <th>Sponsor</th>
                                                            <th>Sponsor Email</th>
                                                            <th>Allows user to collect data offline</th>
                                                            <th>Allow user to download data for all records</th>
                                                            <th>API token</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        
                                                        $email_all3 = "";
                                                        while ( $app_user_result = db_fetch_array($app_user_sql) ) { 
                                                            $email_all3 .= $app_user_result['user_email'].";";
                                                              
                                                        ?>
                                                        <tr>
                                                        
                                                            <td>
                                                            <?php
                                                            
                                                              if(isset($app_user_result['project_id']))
                                                              {
                                                                  
                                                                  
                                                              $project_id = $app_user_result['project_id'];
                                                               
                                                              $sql = db_query("select app_title from redcap_projects where project_id = '$project_id'");    
                                                            
                                                              $result = db_fetch_array($sql);
                                                              
                                                              echo $result['app_title'];
                                                                                      
                                                              }
                                                             ?>
                                                           </td>
                                                        
                                                            <td>
                                                            <?php
                                                            
                                                              if(isset($app_user_result['project_id']))
                                                              {
                                                                  
                                                                  
                                                              $project_id = $app_user_result['project_id'];
                                                               
                                                              $sql = db_query("select status from redcap_projects where project_id = '$project_id'");    
                                                            
                                                              $result = db_fetch_array($sql);
                                                              
                                                               if ($result['status'] == '0' )
                                                               echo "<font color='red'>Development</font>";
                                                               else if ($result['status'] == '1' )
                                                               echo "<font color=blue>Production</font>"; 
                                                                                     
                                                              }
                                                             ?>
                                                           </td> 
                                                        
                                                        
                                                    
                                                            <td><?php echo $app_user_result['project_id']; ?></td>
                                                             <td><?php echo $app_user_result['username']; ?></td>
                                                            <td><?php echo $app_user_result['user_firstname']; ?></td>
                                                            <td><?php echo $app_user_result['user_lastname']; ?></td>
                                                            <td><a href="mailto: <?php echo $app_user_result['user_email']; ?>"><?php echo $app_user_result['user_email']; ?></a></td>
                                                            <td><?php echo $app_user_result['user_sponsor']; ?></td>
                                                            <td>
                                                            <?php 
                                  
                                                              if(isset($app_user_result['user_sponsor']))
                                                              {
                                                             
                                                              $usersponsor = $app_user_result['user_sponsor'];
                                                               
                                                              $sql = db_query("select user_email from redcap_user_information where username = '$usersponsor'");    
                                                            
                                                              $result = db_fetch_array($sql);
                                                              
                                                              echo $result['user_email'];                        
                                                              }
                                                    
                                                              ?>
                                                            </td>
                                                            <td><?php if($app_user_result['mobile_app'] == '1') echo "Yes"; else echo ""; ?></td>
                                                            <td><?php if($app_user_result['mobile_app_download_data'] == '1') echo "Yes"; else echo ""; ?></td>
                                                            <td><?php 
                                                            if(!empty($app_user_result['api_token'])) echo "*************"; else echo ""; ?></td>
                                                        </tr>
                                                        
                                                        <?php
                                                        } ?>
                                                    </tbody>
                                                </table>
                                                
                                             </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </td>
                                           
                    </tr>    
                    
                    </tbody>
                </table>
                
                <hr>

                <h4><b>Users Created in Database</b></h4>
                <div class="row">
                    <div class="col-sm-4">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <td>Last 10 days</td>
                                    <td><?php echo $last_user_10days_num; ?></td>
                                </tr>
                                <tr>
                                    <td>Last 30 days</td>
                                    <td><?php echo $last_user_30days_num; ?></td>
                                </tr>
                                <tr>
                                    <td>Last 90 days</td>
                                    <td><?php echo $last_user_90days_num; ?></td>
                                </tr>
                            </tbody>
                        </table>                    
                    </div>
                    <div class="col-sm-8"></div>
                </div>                
            </div>
        </div>
        
        <input id="email_all" type="hidden" value="<?php echo $email_all; ?>" />
        <input id="email_all1" type="hidden" value="<?php echo $email_all1; ?>" />
        <input id="email_all2" type="hidden" value="<?php echo $email_all2; ?>" />
        <input id="email_all3" type="hidden" value="<?php echo $email_all3; ?>" />
        
        
           
        <button id="btn_select" class="btn btn-xs btn-warning" style="display:none">Select</button>
        <button id="btn_close" class="btn btn-xs btn-default" style="display:none">Close</button>
        <div id="load_email_all" style="display:none"></div>
        
        <br>
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Graph</h3>
            </div>
            <div class="panel-body">

                <script type="text/javascript">
                $(function () {
                    $('#user-bar-chart').highcharts({
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: 'REDCap Datbase'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            categories: ['User Status']
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Number'
                            }
                        },
                        tooltip: {
                            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                            footerFormat: '</table>',
                            shared: true,
                            useHTML: true
                        },
                        plotOptions: {
                            column: {
                                pointPadding: 0.2,
                                borderWidth: 0
                            }
                        },
                        series: [{
                            name: 'Total',
                            data: [<?php echo $conso_total_user; ?>],
                            color: '#428bca'
                        }, {
                            name: 'Active',
                            data: [<?php echo $conso_last6month_user; ?>],
                            color: '#5cb85c'                
                        }]
                    });
                });
                </script>
                <div id="user-bar-chart"></div>
                
                <script type="text/javascript">
                $(function () {
                    $('#user-creation-bar-chart').highcharts({
                        chart: {
                            type: 'bar'
                        },
                        title: {
                            text: 'Users Created in Database'
                        },
                        subtitle: {
                            text: ''
                        },
                        xAxis: {
                            categories: ['Users'],
                            title: {
                                text: null
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Number',
                                align: 'high'
                            },
                            labels: {
                                overflow: 'justify'
                            }
                        },
                        tooltip: {
                            valueSuffix: ''
                        },
                        plotOptions: {
                            bar: {
                                dataLabels: {
                                    enabled: true
                                }
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'top',
                            x: -40,
                            y: 100,
                            floating: true,
                            borderWidth: 1,
                            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor || '#FFFFFF'),
                            shadow: true
                        },
                        credits: {
                            enabled: false
                        },
                        series: [{
                            name: 'Last 90 days',
                            data: [<?php echo $last_user_90days_num; ?>],
                            color: '#f0ad4e'
                        }, {
                            name: 'Last 30 days',
                            data: [<?php echo $last_user_30days_num; ?>],
                            color: '#5cb85c'
                        }, {
                            name: 'Last 10 days',
                            data: [<?php echo $last_user_10days_num; ?>],
                            color: '#428bca'
                        }]
                    });
                });
                </script>
                <div id="user-creation-bar-chart"></div>
            </div>
        </div>
        
    </div>
    
   
    <div id="download_load"></div>
</div>
<script type="text/javascript" src="js/filter_user.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $("#btn_email_all").on("click", function() {
        var email_list = $("#email_all").val();
        $("#load_email_all").show();
        $("#btn_select").show();
        $("#btn_close").show();
        $("#load_email_all").html(email_list);
    });
    
        $("#btn_email_all1").on("click", function() {
        var email_list = $("#email_all1").val();
        $("#load_email_all").show();
        $("#btn_select").show();
        $("#btn_close").show();
        $("#load_email_all").html(email_list);
    });
    
    
        $("#btn_email_all_api").on("click", function() {
        var email_list = $("#email_all2").val();
        $("#load_email_all").show();
        $("#btn_select").show();
        $("#btn_close").show();
        $("#load_email_all").html(email_list);
    });
    
        $("#btn_email_all_app").on("click", function() {
        var email_list = $("#email_all3").val();
        $("#load_email_all").show();
        $("#btn_select").show();
        $("#btn_close").show();
        $("#load_email_all").html(email_list);
    });
     
    
    
    
    $("#btn_select").on("click", function() {
        $("#load_email_all").focus();
    });
    
    $("#btn_close").on("click", function() {
        $("#load_email_all").hide();
        $("#btn_select").hide();
        $("#btn_close").hide();
    });
    
    
});
</script>