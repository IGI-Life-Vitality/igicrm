ALTER TABLE `db_igicrm_live`.`tbl_complaints_life`   
  ADD COLUMN `policy_issuance_date` DATE NULL AFTER `close_date`,
  ADD COLUMN `status_policy` VARCHAR(100) NULL AFTER `policy_issuance_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_life`   
  ADD COLUMN `plan_nature` VARCHAR(100) NULL AFTER `status_policy`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_life`   
  ADD COLUMN `bank` VARCHAR(100) NULL AFTER `is_call_back`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_life`   
  ADD COLUMN `premium_amount` VARCHAR(100) NULL AFTER `bank`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_life`   
  ADD COLUMN `refund_amount` VARCHAR(100) NULL AFTER `premium_amount`,
  ADD COLUMN `claim_amount` VARCHAR(100) NULL AFTER `refund_amount`,
  ADD COLUMN `region` VARCHAR(255) NULL AFTER `claim_amount`,
  ADD COLUMN `city` VARCHAR(255) NULL AFTER `region`,
  ADD COLUMN `reported_date` DATE NULL AFTER `city`,
  ADD COLUMN `received_date` DATE NULL AFTER `reported_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_life`   
  CHANGE `reported_date` `reported_date` DATETIME NULL;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_life`   
  CHANGE `reported_date` `reported_dt` DATETIME NULL;
  
\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

ALTER TABLE `db_igicrm_live`.`tbl_complaints_cooperate`  
  ADD COLUMN `policy_issuance_date` DATE NULL AFTER `close_date`,
  ADD COLUMN `status_policy` VARCHAR(100) NULL AFTER `policy_issuance_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_cooperate`    
  ADD COLUMN `plan_nature` VARCHAR(100) NULL AFTER `status_policy`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_cooperate`  
  ADD COLUMN `bank` VARCHAR(100) NULL AFTER `is_call_back`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_cooperate`     
  ADD COLUMN `premium_amount` VARCHAR(100) NULL AFTER `bank`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_cooperate`    
  ADD COLUMN `refund_amount` VARCHAR(100) NULL AFTER `premium_amount`,
  ADD COLUMN `claim_amount` VARCHAR(100) NULL AFTER `refund_amount`,
  ADD COLUMN `region` VARCHAR(255) NULL AFTER `claim_amount`,
  ADD COLUMN `city` VARCHAR(255) NULL AFTER `region`,
  ADD COLUMN `reported_date` DATE NULL AFTER `city`,
  ADD COLUMN `received_date` DATE NULL AFTER `reported_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_cooperate`     
  CHANGE `reported_date` `reported_date` DATETIME NULL;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_cooperate`     
  CHANGE `reported_date` `reported_dt` DATETIME NULL;
  
///////////////////////////////////////////////////////////////////////////////////////////////


ALTER TABLE `db_igicrm_live`.`tbl_complaints_legal`  
  ADD COLUMN `policy_issuance_date` DATE NULL AFTER `close_date`,
  ADD COLUMN `status_policy` VARCHAR(100) NULL AFTER `policy_issuance_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_legal`    
  ADD COLUMN `plan_nature` VARCHAR(100) NULL AFTER `status_policy`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_legal`  
  ADD COLUMN `bank` VARCHAR(100) NULL AFTER `is_call_back`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_legal`     
  ADD COLUMN `premium_amount` VARCHAR(100) NULL AFTER `bank`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_legal`    
  ADD COLUMN `refund_amount` VARCHAR(100) NULL AFTER `premium_amount`,
  ADD COLUMN `claim_amount` VARCHAR(100) NULL AFTER `refund_amount`,
  ADD COLUMN `region` VARCHAR(255) NULL AFTER `claim_amount`,
  ADD COLUMN `city` VARCHAR(255) NULL AFTER `region`,
  ADD COLUMN `reported_date` DATE NULL AFTER `city`,
  ADD COLUMN `received_date` DATE NULL AFTER `reported_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_legal`     
  CHANGE `reported_date` `reported_date` DATETIME NULL;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_legal`     
  CHANGE `reported_date` `reported_dt` DATETIME NULL;
  
/////////////////////////////////////////////////////////////////////////////////



ALTER TABLE `db_igicrm_live`.`tbl_complaints_legal`  
  ADD COLUMN `policy_issuance_date` DATE NULL AFTER `close_date`,
  ADD COLUMN `status_policy` VARCHAR(100) NULL AFTER `policy_issuance_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_legal`    
  ADD COLUMN `plan_nature` VARCHAR(100) NULL AFTER `status_policy`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_legal`  
  ADD COLUMN `bank` VARCHAR(100) NULL AFTER `is_call_back`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_legal`     
  ADD COLUMN `premium_amount` VARCHAR(100) NULL AFTER `bank`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_legal`    
  ADD COLUMN `refund_amount` VARCHAR(100) NULL AFTER `premium_amount`,
  ADD COLUMN `reported_date` DATE NULL AFTER `city`,
  ADD COLUMN `received_date` DATE NULL AFTER `reported_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_legal`     
  CHANGE `reported_date` `reported_date` DATETIME NULL;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_legal`     
  CHANGE `reported_date` `reported_dt` DATETIME NULL;
  
////////////////////////////////////////////////////////////////////////////////////////////////



ALTER TABLE `db_igicrm_live`.`tbl_complaints_internal`  
  ADD COLUMN `policy_issuance_date` DATE NULL AFTER `close_date`,
  ADD COLUMN `status_policy` VARCHAR(100) NULL AFTER `policy_issuance_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_internal`    
  ADD COLUMN `plan_nature` VARCHAR(100) NULL AFTER `status_policy`;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_internal`  
  ADD COLUMN `bank` VARCHAR(100) NULL ;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_internal`     
  ADD COLUMN `premium_amount` VARCHAR(100) NULL AFTER `bank`;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_internal`    
  ADD COLUMN `refund_amount` VARCHAR(100) NULL AFTER `premium_amount`,
  ADD COLUMN `claim_amount` VARCHAR(100) NULL AFTER `refund_amount`,
  ADD COLUMN `region` VARCHAR(255) NULL AFTER `claim_amount`,
  ADD COLUMN `city` VARCHAR(255) NULL AFTER `region`,
  ADD COLUMN `reported_date` DATE NULL AFTER `city`,
  ADD COLUMN `received_date` DATE NULL AFTER `reported_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_internal`     
  CHANGE `reported_date` `reported_date` DATETIME NULL;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_internal`     
  CHANGE `reported_date` `reported_dt` DATETIME NULL;

////////////////////////////////////////////////////////////////////////////////////



ALTER TABLE `db_igicrm_live`.`tbl_complaints_banca_bank`  
  ADD COLUMN `policy_issuance_date` DATE NULL AFTER `close_date`,
  ADD COLUMN `status_policy` VARCHAR(100) NULL AFTER `policy_issuance_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_banca_bank`    
  ADD COLUMN `plan_nature` VARCHAR(100) NULL AFTER `status_policy`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_banca_bank`  
  ADD COLUMN `bank` VARCHAR(100) NULL AFTER `is_call_back`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_banca_bank`     
  ADD COLUMN `premium_amount` VARCHAR(100) NULL AFTER `bank`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_banca_bank`    
  ADD COLUMN `refund_amount` VARCHAR(100) NULL AFTER `premium_amount`,
  ADD COLUMN `claim_amount` VARCHAR(100) NULL AFTER `refund_amount`,
  ADD COLUMN `region` VARCHAR(255) NULL AFTER `claim_amount`,
  ADD COLUMN `city` VARCHAR(255) NULL AFTER `region`,
  ADD COLUMN `reported_date` DATE NULL AFTER `city`,
  ADD COLUMN `received_date` DATE NULL AFTER `reported_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_banca_bank`     
  CHANGE `reported_date` `reported_date` DATETIME NULL;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_banca_bank`     
  CHANGE `reported_date` `reported_dt` DATETIME NULL;
  
//////////////////////////////////////////////////////////////////////////////


ALTER TABLE `db_igicrm_live`.`tbl_complaints_vatality`  
  ADD COLUMN `policy_issuance_date` DATE NULL AFTER `close_date`,
  ADD COLUMN `status_policy` VARCHAR(100) NULL AFTER `policy_issuance_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaints_vatality`    
  ADD COLUMN `plan_nature` VARCHAR(100) NULL AFTER `status_policy`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_vatality`  
  ADD COLUMN `bank` VARCHAR(100) NULL AFTER `is_call_back`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_vatality`     
  ADD COLUMN `premium_amount` VARCHAR(100) NULL AFTER `bank`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_vatality`    
  ADD COLUMN `refund_amount` VARCHAR(100) NULL AFTER `premium_amount`,
  ADD COLUMN `claim_amount` VARCHAR(100) NULL AFTER `refund_amount`,
  ADD COLUMN `region` VARCHAR(255) NULL AFTER `claim_amount`,
  ADD COLUMN `city` VARCHAR(255) NULL AFTER `region`,
  ADD COLUMN `reported_date` DATE NULL AFTER `city`,
  ADD COLUMN `received_date` DATE NULL AFTER `reported_date`;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_vatality`     
  CHANGE `reported_date` `reported_date` DATETIME NULL;


ALTER TABLE `db_igicrm_live`.`tbl_complaint_details_vatality`     
  CHANGE `reported_date` `reported_dt` DATETIME NULL;

//////////////////////////////////////////////////////////////////////////////////////////

ALTER TABLE `db_igicrm_live`.`tbl_complaints`   
  ADD COLUMN `over_all_satisfaction` VARCHAR(255) NULL AFTER `close_date`,
  ADD COLUMN `resolution_time_satisfaction` VARCHAR(255) NULL AFTER `over_all_satisfaction`,
  ADD COLUMN `staff_behavior` VARCHAR(255) NULL AFTER `resolution_time_satisfaction`,
  ADD COLUMN `feedback_comments` VARCHAR(255) NULL AFTER `staff_behavior`,
  ADD COLUMN `feedback_date` DATE NULL AFTER `feedback_comments`;

///////////////////////////////////////////////////////////////////////////////////////////////////////
ALTER TABLE `db_igicrm_live`.`tbl_complaints_banca`   
  ADD COLUMN `over_all_satisfaction` VARCHAR(255) NULL AFTER `plan_nature`,
  ADD COLUMN `resolution_time_satisfaction` VARCHAR(255) NULL AFTER `over_all_satisfaction`,
  ADD COLUMN `staff_behavior` VARCHAR(255) NULL AFTER `resolution_time_satisfaction`,
  ADD COLUMN `feedback_comments` VARCHAR(255) NULL AFTER `staff_behavior`,
  ADD COLUMN `feedback_date` DATE NULL AFTER `feedback_comments`;
///////////////////////////////////////////////////////////////////////////////////////////////////////
ALTER TABLE `db_igicrm_live`.`tbl_complaints_banca_bank`   
  ADD COLUMN `over_all_satisfaction` VARCHAR(255) NULL AFTER `plan_nature`,
  ADD COLUMN `resolution_time_satisfaction` VARCHAR(255) NULL AFTER `over_all_satisfaction`,
  ADD COLUMN `staff_behavior` VARCHAR(255) NULL AFTER `resolution_time_satisfaction`,
  ADD COLUMN `feedback_comments` VARCHAR(255) NULL AFTER `staff_behavior`,
  ADD COLUMN `feedback_date` DATE NULL AFTER `feedback_comments`;
///////////////////////////////////////////////////////////////////////////////////////////////////////
ALTER TABLE `db_igicrm_live`.`tbl_complaints_cooperate`   
  ADD COLUMN `over_all_satisfaction` VARCHAR(255) NULL AFTER `plan_nature`,
  ADD COLUMN `resolution_time_satisfaction` VARCHAR(255) NULL AFTER `over_all_satisfaction`,
  ADD COLUMN `staff_behavior` VARCHAR(255) NULL AFTER `resolution_time_satisfaction`,
  ADD COLUMN `feedback_comments` VARCHAR(255) NULL AFTER `staff_behavior`,
  ADD COLUMN `feedback_date` DATE NULL AFTER `feedback_comments`;
///////////////////////////////////////////////////////////////////////////////////////////////////////
ALTER TABLE `db_igicrm_live`.`tbl_complaints_internal`  
  ADD COLUMN `over_all_satisfaction` VARCHAR(255) NULL AFTER `plan_nature`,
  ADD COLUMN `resolution_time_satisfaction` VARCHAR(255) NULL AFTER `over_all_satisfaction`,
  ADD COLUMN `staff_behavior` VARCHAR(255) NULL AFTER `resolution_time_satisfaction`,
  ADD COLUMN `feedback_comments` VARCHAR(255) NULL AFTER `staff_behavior`,
  ADD COLUMN `feedback_date` DATE NULL AFTER `feedback_comments`;
///////////////////////////////////////////////////////////////////////////////////////////////////////
ALTER TABLE `db_igicrm_live`.`tbl_complaints_legal`  
  ADD COLUMN `over_all_satisfaction` VARCHAR(255) NULL AFTER `plan_nature`,
  ADD COLUMN `resolution_time_satisfaction` VARCHAR(255) NULL AFTER `over_all_satisfaction`,
  ADD COLUMN `staff_behavior` VARCHAR(255) NULL AFTER `resolution_time_satisfaction`,
  ADD COLUMN `feedback_comments` VARCHAR(255) NULL AFTER `staff_behavior`,
  ADD COLUMN `feedback_date` DATE NULL AFTER `feedback_comments`;
///////////////////////////////////////////////////////////////////////////////////////////////////////
ALTER TABLE `db_igicrm_live`.`tbl_complaints_life` 
  ADD COLUMN `over_all_satisfaction` VARCHAR(255) NULL AFTER `plan_nature`,
  ADD COLUMN `resolution_time_satisfaction` VARCHAR(255) NULL AFTER `over_all_satisfaction`,
  ADD COLUMN `staff_behavior` VARCHAR(255) NULL AFTER `resolution_time_satisfaction`,
  ADD COLUMN `feedback_comments` VARCHAR(255) NULL AFTER `staff_behavior`,
  ADD COLUMN `feedback_date` DATE NULL AFTER `feedback_comments`;
///////////////////////////////////////////////////////////////////////////////////////////////////////
ALTER TABLE `db_igicrm_live`.`tbl_complaints_vatality` 
  ADD COLUMN `over_all_satisfaction` VARCHAR(255) NULL AFTER `plan_nature`,
  ADD COLUMN `resolution_time_satisfaction` VARCHAR(255) NULL AFTER `over_all_satisfaction`,
  ADD COLUMN `staff_behavior` VARCHAR(255) NULL AFTER `resolution_time_satisfaction`,
  ADD COLUMN `feedback_comments` VARCHAR(255) NULL AFTER `staff_behavior`,
  ADD COLUMN `feedback_date` DATE NULL AFTER `feedback_comments`;