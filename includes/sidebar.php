<?php
    $user_type_name = array(
        '1' => 'Super Admin',
        '2' => 'Admin (CCU)',
        '3' => 'Agent (CSO)',
        '4' => 'User'
    );

    if (isset($_SESSION['user_type'])) 
    {
       $user_type = $_SESSION['user_type'];
    }
?>

<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">

        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;"><img src="assets/img/IGI-Pro.png" alt="" /></a>
                </div>
                <div class="info">
                    IGI Life
                    <small> <? echo $user_type_name[$user_type]; ?> </small>
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->

        <!-- begin sidebar nav -->
        <ul class="nav">
            <li class="nav-header">Navigation</li>
            <li class="has-sub <? echo ($menu_id == 'dashboard' ? 'active' : ''); ?>">
                <a href="dashboard.php">
                    <i class="ion-ios-pulse-strong"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <? if($user_type == 3) { ?>
                <li class="has-sub <? echo ($module_id == '0' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-compose-outline bg-gradient-blue"></i>
                        <span>Agent Desktop</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? echo ($menu_id == 'search' ? 'active' : ''); ?>"><a href="search.php">Search</a></li>
                        <li class="<? echo ($menu_id == 'customer_info' ? 'active' : ''); ?>"><a href="customer_info.php">Customer Info</a></li>
                    </ul>
                </li>

                <li class="has-sub <? echo ($parent_id == '35' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-color-filter-outline bg-purple"></i>
                        <span>Leads Management</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? echo ($menu_id == 'leads_add' ? 'active' : ''); ?>"><a href="leads_add.php">Add Leads</a></li>
                        <li class="<? echo ($menu_id == 'leads_views' ? 'active' : ''); ?>"><a href="leads_view.php">View Leads</a></li>
                    </ul>
                </li>

                <li class="has-sub <? echo ($parent_id == '19' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-compose-outline bg-gradient-blue"></i>
                        <span>Complaint</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? echo ($menu_id == 'complaint_add' ? 'active' : ''); ?>"><a href="complaint_add.php">Add Complaints</a></li>
                        <li class="<? echo ($menu_id == 'complaint_views' ? 'active' : ''); ?>"><a href="complaint_views.php">View Complaints</a></li>
                    </ul>
                </li>
            <? } else { ?>
                <li class="has-sub <? echo ($parent_id == '1' ? 'active' : ''); ?>">
                    <!--<a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-briefcase-outline bg-gradient-purple"></i>
                        <span>E-Form</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? //echo ($menu_id == 'eform_add' ? 'active' : ''); ?>"><a href="eform_add.php">Add E-Form</a></li>
                        <li class="<?// echo ($menu_id == 'eform_view' ? 'active' : ''); ?>"><a href="eform_view.php">View E-Form</a></li>
                        <li class="<? //echo ($menu_id == 'eform_type_add' ? 'active' : ''); ?>"><a href="eform_type_add.php">Add E-Form Type</a></li>
                        <li class="<? //echo ($menu_id == 'eform_type_view' ? 'active' : ''); ?>"><a href="eform_type_view.php">View E-Form Types</a></li>
                    </ul>-->
                </li>

                <li class="has-sub <? echo ($parent_id == '26' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-briefcase-outline bg-gradient-red"></i>
                        <span>Task Management</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? echo ($menu_id == 'task_add' ? 'active' : ''); ?>"><a href="task_add.php">Add Task</a></li>
                        <li class="<? echo ($menu_id == 'task_view' ? 'active' : ''); ?>"><a href="task_view.php">View Task</a></li>
                        <li class="<? echo ($menu_id == 'task_category_add' ? 'active' : ''); ?>"><a href="task_category_add.php">Add Task Categories</a></li>
                        <li class="<? echo ($menu_id == 'task_category_list' ? 'active' : ''); ?>"><a href="task_category_list.php">View Task Categories</a></li>
                        <li class="<? echo ($menu_id == 'task_subcategory_add' ? 'active' : ''); ?>"><a href="task_subcategory_add.php">Add Task Sub Categories</a></li>
                        <li class="<? echo ($menu_id == 'task_subcategory_list' ? 'active' : ''); ?>"><a href="task_subcategory_list.php">View Task Sub Categories</a></li>
                        <li class="<? echo ($menu_id == 'task_ism_add' ? 'active' : ''); ?>"><a href="task_ism_add.php">Add Task ISM</a></li>
                        <li class="<? echo ($menu_id == 'task_ism_types' ? 'active' : ''); ?>"><a href="task_ism_types.php">View Task ISM</a></li>
                    </ul>
                </li>

                <li class="has-sub <? echo ($parent_id == '19' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-compose-outline bg-gradient-blue"></i>
                        <span>Complaint</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? echo ($menu_id == 'complaint_add' ? 'active' : ''); ?>"><a href="complaint_add.php">Add Complaints</a></li>
                        <li class="<? echo ($menu_id == 'complaint_views' ? 'active' : ''); ?>"><a href="complaint_views.php">View Complaints</a></li>
                        <li class="<? echo ($menu_id == 'complaint_types_add' ? 'active' : ''); ?>"><a href="complaint_types_add.php">Add Complaint Types</a></li>
                        <li class="<? echo ($menu_id == 'complaint_types' ? 'active' : ''); ?>"><a href="complaint_types.php">View Complaint Types</a></li>
                    </ul>
                </li>

                <li class="has-sub <? echo ($parent_id == '35' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-color-filter-outline bg-purple"></i>
                        <span>Leads Management</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? echo ($menu_id == 'leads_add' ? 'active' : ''); ?>"><a href="leads_add.php">Add Leads</a></li>
                        <li class="<? echo ($menu_id == 'leads_view' ? 'active' : ''); ?>"><a href="leads_view.php">View Leads</a></li>
   
                      <li class="<? echo ($menu_id == 'add_user_mapping' ? 'active' : ''); ?>"><a href="lead_users.php">Add Leads Users</a></li>
                        <li class="<? echo ($menu_id == 'view_user_mapping' ? 'active' : ''); ?>"><a href="lead_users_view.php">View Leads Users</a></li>
                        <li class="<? echo ($menu_id == 'leads_mapping_add' ? 'active' : ''); ?>"><a href="leads_mapping_add.php">Add Leads Mapping</a></li>
                        <li class="<? echo ($menu_id == 'leads_mapping_view' ? 'active' : ''); ?>"><a href="leads_mapping_view.php">View Leads Mapping</a></li>
                    </ul>
                </li>

                <li class="has-sub <? echo ($parent_id == '20' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-toggle-outline bg-gradient-green"></i>
                        <span>Administration</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? echo ($menu_id == 'user_add' ? 'active' : ''); ?>"><a href="user_add.php">Add User</a></li>
                        <li class="<? echo ($menu_id == 'user_view' ? 'active' : ''); ?>"><a href="user_list.php">View User</a></li>

                        <li class="<? echo ($menu_id == 'group_add' ? 'active' : ''); ?>"><a href="group_add.php">Add Groups</a></li>
                        <li class="<? echo ($menu_id == 'group_view' ? 'active' : ''); ?>"><a href="group_view.php">View Groups</a></li>

                        <!--<li class="<?// echo ($menu_id == 'role_add' ? 'active' : ''); ?>"><a href="organization_role_add.php">Add Organization Role</a></li>
                        <li class="<? //echo ($menu_id == 'role_view' ? 'active' : ''); ?>"><a href="organization_role_view.php">View Organization Role</a></li>
                        <li class="<? //echo ($menu_id == 'unit_add' ? 'active' : ''); ?>"><a href="organization_unit_add.php">Add Organization Unit</a></li>
                        <li class="<? //echo ($menu_id == 'unit_view' ? 'active' : ''); ?>"><a href="organization_unit_view.php">View Organization Unit</a></li>-->
                        <li class="<? echo ($menu_id == 'city_add' ? 'active' : ''); ?>"><a href="city_add.php">Add City</a></li>
                        <li class="<? echo ($menu_id == 'city_view' ? 'active' : ''); ?>"><a href="city_view.php">View City</a></li>

                        <li class="<? echo ($menu_id == 'area_add' ? 'active' : ''); ?>"><a href="area_add.php">Add City Areas</a></li>
                        <li class="<? echo ($menu_id == 'area_view' ? 'active' : ''); ?>"><a href="area_view.php">View City Areas</a></li>

                        <li class="<? echo ($menu_id == 'hospital_add' ? 'active' : ''); ?>"><a href="hospital_add.php">Add Hospital</a></li>
                        <li class="<? echo ($menu_id == 'hospital_view' ? 'active' : ''); ?>"><a href="hospital_view.php">View Hospital</a></li>

                        <li class="<? echo ($menu_id == 'agency_add' ? 'active' : ''); ?>"><a href="agency_add.php">Add Agency</a></li>
                        <li class="<? echo ($menu_id == 'agency_view' ? 'active' : ''); ?>"><a href="agency_view.php">View Agency</a></li>

                        <li class="<? echo ($menu_id == 'business_line_add' ? 'active' : ''); ?>"><a href="business_line_add.php">Add Line Of Business</a></li>
                        <li class="<? echo ($menu_id == 'Business_line_view' ? 'active' : ''); ?>"><a href="business_line_view.php">View Line Of Business</a></li>

                        <!-- <li class="<? //echo ($menu_id == 'task_ownership_add' ? 'active' : ''); ?>"><a href="task_ownership_add.php">Add Ownership</a></li>
                        <li class="<? //echo ($menu_id == 'task_ownership_list' ? 'active' : ''); ?>"><a href="task_ownership_list.php">View Ownership</a></li> -->

                        <!-- <li class="<? //echo ($menu_id == 'template_add' ? 'active' : ''); ?>"><a href="template_add.php">Add Template</a></li> -->
                        <!-- <li class="<? //echo ($menu_id == 'template_view' ? 'active' : ''); ?>"><a href="template_view.php">View Template</a></li> -->

                        <li class="<? echo ($menu_id == 'calendar_info' ? 'active' : ''); ?>"><a href="calendar_info.php">Calendar Manager</a></li>

                        <!--<li class="<? //echo ($menu_id == 'question_add' ? 'active' : ''); ?>"><a href="question_add.php">Add KYC</a></li>
                        <li class="<? //echo ($menu_id == 'question_list' ? 'active' : ''); ?>"><a href="question_list.php">View KYC</a></li>-->
                    </ul>
                </li>

                <li class="has-sub <? echo ($parent_id == '21' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-list-outline bg-gradient-aqua"></i>
                        <span>Product Manager</span>
                    </a>
                    <ul class="sub-menu">
                        <!-- <li class="<?// echo ($menu_id == 'product_category_add' ? 'active' : ''); ?>"><a href="product_category_add.php">Add Category</a></li>
                        <li class="<? //echo ($menu_id == 'product_category_list' ? 'active' : ''); ?>"><a href="product_category_list.php">View Category</a></li> -->
                        <li class="<? echo ($menu_id == 'product_add' ? 'active' : ''); ?>"><a href="complaint_product_add.php">Add Product</a></li>
                        <li class="<? echo ($menu_id == 'product_list' ? 'active' : ''); ?>"><a href="complaint_product_list.php">View Product</a></li>
                    </ul>
                </li>

                <li class="has-sub <? echo ($parent_id == '22' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-chatboxes-outline bg-gradient-orange"></i>
                        <span>Messages</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? echo ($menu_id == 'message_create' ? 'active' : ''); ?>"><a href="message_create.php">Create Message</a></li>
                        <li class="<? echo ($menu_id == 'message_view' ? 'active' : ''); ?>"><a href="message_view.php">View Messages</a></li>
                    </ul>
                </li>

                <li class="has-sub <? echo ($parent_id == '23' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-email-outline bg-gradient-purple"></i>
                        <span>News & Announcement</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? echo ($menu_id == 'news_add' ? 'active' : ''); ?>"><a href="news_add.php">Add News Announcement</a></li>
                        <li class="<? echo ($menu_id == 'news_view' ? 'active' : ''); ?>"><a href="news_view.php">View News Announcement</a></li>
                    </ul>
                </li>

                <!-- <li class="has-sub <? //echo ($parent_id == '24' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="ion-ios-monitor-outline bg-gradient-aqua"></i>
                        <span>Document Uploader</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="<? //echo ($menu_id == 'document_add' ? 'active' : ''); ?>"><a href="document_add.php">Add Documents</a></li>
                        <li class="<? //echo ($menu_id == 'documents_view' ? 'active' : ''); ?>"><a href="document_view.php">View Documents</a></li>
                    </ul>
                </li> -->

                <li class="has-sub <? echo ($parent_id == '25' ? 'active' : ''); ?>">
                    <a href="javascript:;">
                        <b class="caret pull-right"></b>
                        <i class="fa fa-align-left"></i> 
                        <span>Reports Management</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="has-sub <? echo ($parent_id2 == '25' ? 'active' : ''); ?>">
                            <a href="javascript:;">
                                <b class="caret pull-right"></b>
                                Lead Reports
                            </a>
                            <ul class="sub-menu">
                                <li class="<? echo ($menu_id == 'rpt_lead_status' ? 'active' : ''); ?>"><a href="rpt_lead_status.php">Lead Status</a></li>
                                <li class="<? echo ($menu_id == 'rpt_lead_citywise' ? 'active' : ''); ?>"><a href="rpt_lead_citywise.php">City wise Lead Analysis</a></li>
                                <li class="<? echo ($menu_id == 'rpt_lead_source_info' ? 'active' : ''); ?>"><a href="rpt_lead_source_info.php">Source of Info</a></li>
                                <li class="<? echo ($menu_id == 'rpt_lead_regional_manager' ? 'active' : ''); ?>"><a href="rpt_lead_regional_manager.php">Regional Manager</a></li>
                            </ul>
                        </li>
                        <li class="has-sub <? echo ($parent_id2 == '54' ? 'active' : ''); ?>">
                            <a href="javascript:;">
                                <b class="caret pull-right"></b>
                                Complaint QA
                            </a>
                            <ul class="sub-menu">
                                <li class="<? echo ($menu_id == 'rpt_cmp_ageing' ? 'active' : ''); ?>"><a href="rpt_cmp_ageing.php">Ageing Report</a></li>
                                <li class="<? echo ($menu_id == 'rpt_cmp_annual' ? 'active' : ''); ?>"><a href="rpt_cmp_annual.php">Annual Report</a></li>
                                <li class="<? echo ($menu_id == 'rpt_cmp_comparison' ? 'active' : ''); ?>"><a href="rpt_cmp_comparison.php">Comparison Report</a></li>
                                <li class="<? echo ($menu_id == 'rpt_cmp_typewise' ? 'active' : ''); ?>"><a href="rpt_cmp_typewise.php">Type wise Report</a></li>
                                <li class="<? echo ($menu_id == 'rpt_cmp_departmentwise' ? 'active' : ''); ?>"><a href="rpt_cmp_departmentwise.php">Department wise Report</a></li>
                                <li class="<? echo ($menu_id == 'rpt_cmp_channelwise' ? 'active' : '');  ?>"><a href="rpt_cmp_channelwise.php">Channel Wise Report</a></li>
                            </ul>
                        </li>
                        <li class="has-sub <? echo ($parent_id2 == '61' ? 'active' : ''); ?>">
                            <a href="javascript:;">
                                <b class="caret pull-right"></b>
                                Complaint CS & Ops
                            </a>
                            <ul class="sub-menu">
                                <li class="<? echo ($menu_id == 'rpt_cmp_board_of_directors_quarterly' ? 'active' : ''); ?>"><a href="rpt_cmp_board_of_directors_quarterly.php">Board of Directors Quarterly Report</a></li>
                                <li class="<? echo ($menu_id == 'rpt_cmp_board_of_directors_yearly' ? 'active' : ''); ?>"><a href="rpt_cmp_board_of_directors_yearly.php">Board of Directors Yearly Report</a></li>
                                <li class="<? echo ($menu_id == 'rpt_cmp_legal_complaint_closure' ? 'active' : ''); ?>"><a href="rpt_cmp_legal_complaint_closure.php">Legal Complaint Closure Analysis</a></li>
                                <li class="<? echo ($menu_id == 'rpt_cmp_quarterly_departmental_complaint' ? 'active' : ''); ?>"><a href="rpt_cmp_quarterly_departmental_complaint.php">Quarterly Department Complaint Analysis</a></li>
                                <li class="<? echo ($menu_id == 'rpt_cmp_annual_departmental_summary' ? 'active' : ''); ?>"><a href="rpt_cmp_annual_departmental_summary.php">Annual Departmental Summary Report</a></li>
                            </ul>
                        </li>
                        <li class="has-sub <? echo ($parent_id2 == '66' ? 'active' : ''); ?>">
                            <a href="javascript:;">
                                <b class="caret pull-right"></b>
                                Task Reports
                            </a>
                            <ul class="sub-menu">
                                <li class="<? echo ($menu_id == 'rpt_task_department_wise_ism' ? 'active' : ''); ?>"><a href="rpt_task_department_wise_ism.php">Department Wise ISM Results</a></li>
                                <li class="<? echo ($menu_id == 'rpt_task_ism_wise' ? 'active' : ''); ?>"><a href="rpt_task_ism_wise.php">ISM Wise Results</a></li>
                            </ul>
                        </li>
                        <li class="<? echo ($menu_id == 'rpt_sms_interim' ? 'active' : ''); ?> "><a href="rpt_sms_interim.php">SMS Interim Report</a></li>

                    </ul>
                </li>
            <? } ?>

            <!-- begin sidebar minify button -->
            <li><a href="javascript:;" id="ancCollapse" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-left"></i> <span>Collapse</span></a></li>
            <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>

<div class="sidebar-bg"></div>
<!-- end #sidebar -->