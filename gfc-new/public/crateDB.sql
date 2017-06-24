#
#
#注单详情表
#
CREATE TABLE IF NOT EXISTS "doc"."ffc_order" (
   "ffc_guid" STRING,
   "ffc_id" LONG NOT NULL,
   "ffc_u_id" LONG NOT NULL,
   "ffc_username" STRING NOT NULL,
   "ffc_top_5" STRING NOT NULL,
   "ffc_top_4" STRING NOT NULL,
   "ffc_top_3" STRING NOT NULL,
   "ffc_top_2" STRING NOT NULL,
   "ffc_top_1" STRING NOT NULL,
   "ffc_proportion_5" INTEGER NOT NULL,
   "ffc_proportion_4" INTEGER NOT NULL,
   "ffc_proportion_3" INTEGER NOT NULL,
   "ffc_proportion_2" INTEGER NOT NULL,
   "ffc_proportion_1" INTEGER NOT NULL,
   "ffc_lid" INTEGER NOT NULL,
   "ffc_m_id" INTEGER NOT NULL,
   "ffc_mg_id" INTEGER NOT NULL,
   "ffc_issue" LONG NOT NULL,
   "ffc_trace_id" LONG NOT NULL,
   "ffc_single_num" INTEGER,
   "ffc_multiple" INTEGER,
   "ffc_modes" LONG NOT NULL,
   "ffc_amount" LONG NOT NULL,
   "ffc_prize" LONG NOT NULL,
   "ffc_check_prize_status" BYTE NOT NULL,
   "ffc_send_prize_status" BYTE NOT NULL,
   "ffc_cancel_status" BYTE NOT NULL,
   "ffc_cancel_admin_id" LONG NOT NULL,
   "ffc_u_ip" STRING NOT NULL,
   "ffc_proxy_ip" STRING NOT NULL,
   "ffc_server_ip" STRING NOT NULL,
   "ffc_code" STRING NOT NULL,
   "ffc_hash_value" STRING NOT NULL,
   "ffc_deleteflag" BYTE NOT NULL,
   "ffc_add_time" TIMESTAMP NOT NULL,
   "ffc_send_prize_time" TIMESTAMP NOT NULL,
   "ffc_cancel_time" TIMESTAMP NOT NULL,
   "ffc_update_time" TIMESTAMP NOT NULL,
   "ffc_draw_time" TIMESTAMP NOT NULL,
   "ffc_sid" LONG NOT NULL,
   PRIMARY KEY ("ffc_guid")
);

CREATE TABLE IF NOT EXISTS "doc"."ffc_order_istest" (
   "ffc_guid" STRING,
   "ffc_id" LONG NOT NULL,
   "ffc_u_id" LONG NOT NULL,
   "ffc_username" STRING NOT NULL,
   "ffc_top_5" STRING NOT NULL,
   "ffc_top_4" STRING NOT NULL,
   "ffc_top_3" STRING NOT NULL,
   "ffc_top_2" STRING NOT NULL,
   "ffc_top_1" STRING NOT NULL,
   "ffc_proportion_5" INTEGER NOT NULL,
   "ffc_proportion_4" INTEGER NOT NULL,
   "ffc_proportion_3" INTEGER NOT NULL,
   "ffc_proportion_2" INTEGER NOT NULL,
   "ffc_proportion_1" INTEGER NOT NULL,
   "ffc_lid" INTEGER NOT NULL,
   "ffc_m_id" INTEGER NOT NULL,
   "ffc_mg_id" INTEGER NOT NULL,
   "ffc_issue" LONG NOT NULL,
   "ffc_trace_id" LONG NOT NULL,
   "ffc_single_num" INTEGER,
   "ffc_multiple" INTEGER,
   "ffc_modes" LONG NOT NULL,
   "ffc_amount" LONG NOT NULL,
   "ffc_prize" LONG NOT NULL,
   "ffc_check_prize_status" BYTE NOT NULL,
   "ffc_send_prize_status" BYTE NOT NULL,
   "ffc_cancel_status" BYTE NOT NULL,
   "ffc_cancel_admin_id" LONG NOT NULL,
   "ffc_u_ip" STRING NOT NULL,
   "ffc_proxy_ip" STRING NOT NULL,
   "ffc_server_ip" STRING NOT NULL,
   "ffc_code" STRING NOT NULL,
   "ffc_hash_value" STRING NOT NULL,
   "ffc_deleteflag" BYTE NOT NULL,
   "ffc_add_time" TIMESTAMP NOT NULL,
   "ffc_send_prize_time" TIMESTAMP NOT NULL,
   "ffc_cancel_time" TIMESTAMP NOT NULL,
   "ffc_update_time" TIMESTAMP NOT NULL,
   "ffc_draw_time" TIMESTAMP NOT NULL,
   "ffc_sid" LONG NOT NULL,
   PRIMARY KEY ("ffc_guid")
);



#
#
#交付报表
#
CREATE TABLE IF NOT EXISTS "doc"."ffc_order_report" (
   "ffc_guid" STRING,
   "ffc_u_id" LONG NOT NULL,
   "ffc_username" STRING NOT NULL,
   "ffc_top_5" STRING NOT NULL,
   "ffc_top_4" STRING NOT NULL,
   "ffc_top_3" STRING NOT NULL,
   "ffc_top_2" STRING NOT NULL,
   "ffc_top_1" STRING NOT NULL,
   "ffc_results_5" INTEGER NOT NULL,
   "ffc_results_4" INTEGER NOT NULL,
   "ffc_results_3" INTEGER NOT NULL,
   "ffc_results_2" INTEGER NOT NULL,
   "ffc_results_1" INTEGER NOT NULL,
   "ffc_lid" INTEGER NOT NULL,
   "ffc_issue" LONG NOT NULL,
   "ffc_amount" LONG NOT NULL,
   "ffc_prize" LONG NOT NULL,
   "ffc_wins" LONG NOT NULL,
   "ffc_counts" INTEGER NOT NULL,
   "ffc_deleteflag" BYTE NOT NULL,
   "ffc_draw_time" TIMESTAMP NOT NULL,
   PRIMARY KEY ("ffc_guid")
);


#
#
#交付报表
#
CREATE TABLE IF NOT EXISTS "doc"."ffc_order_report_istest" (
   "ffc_guid" STRING,
   "ffc_u_id" LONG NOT NULL,
   "ffc_username" STRING NOT NULL,
   "ffc_top_5" STRING NOT NULL,
   "ffc_top_4" STRING NOT NULL,
   "ffc_top_3" STRING NOT NULL,
   "ffc_top_2" STRING NOT NULL,
   "ffc_top_1" STRING NOT NULL,
   "ffc_results_5" INTEGER NOT NULL,
   "ffc_results_4" INTEGER NOT NULL,
   "ffc_results_3" INTEGER NOT NULL,
   "ffc_results_2" INTEGER NOT NULL,
   "ffc_results_1" INTEGER NOT NULL,
   "ffc_lid" INTEGER NOT NULL,
   "ffc_issue" LONG NOT NULL,
   "ffc_amount" LONG NOT NULL,
   "ffc_prize" LONG NOT NULL,
   "ffc_wins" LONG NOT NULL,
   "ffc_counts" INTEGER NOT NULL,
   "ffc_deleteflag" BYTE NOT NULL,
   "ffc_draw_time" TIMESTAMP NOT NULL,
   PRIMARY KEY ("ffc_guid")
);