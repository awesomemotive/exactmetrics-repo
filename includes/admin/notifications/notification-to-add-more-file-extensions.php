<?php

/**
 * Add notification when there is no extension added or only the default extensions exist
 * Recurrence: 20 Days
 *
 * @since 7.12.3
 */
final class ExactMetrics_Notification_To_Add_More_File_Extensions extends ExactMetrics_Notification_Event {

	public $notification_id = 'exactmetrics_notification_to_add_more_file_extensions';
	public $notification_interval = 20; // in days
	public $notification_type = array( 'basic', 'lite', 'master', 'plus', 'pro' );

	/**
	 * Build Notification
	 *
	 * @return array $notification notification is ready to add
	 *
	 * @since 7.12.3
	 */
	public function prepare_notification_data( $notification ) {
		$download_extensions = exactmetrics_get_option( 'extensions_of_files', '' );

		if ( empty( $download_extensions ) || "doc,pdf,ppt,zip,xls,docx,pptx,xlsx" === $download_extensions ) {

			$settings_url          = is_network_admin() ? $this->get_view_url( 'exactmetrics-settings-block-file-downloads', 'exactmetrics_network', 'engagement' ) : $this->get_view_url( 'exactmetrics-settings-block-file-downloads', 'exactmetrics_settings', 'engagement' );
			$publishers_report_url = $this->get_view_url( 'exactmetrics-report-download-links', 'exactmetrics_reports', 'publishers' );
			$notification['title'] = __( 'Add More File Extensions to Track as Downloads', 'google-analytics-dashboard-for-wp' );
			// Translators: File extensions notification content
			$notification['content'] = sprintf( __( 'By default, ExactMetrics automatically tracks downloads of the following file extensions: doc, pdf, ppt, zip, xls, docx, pptx, and xlsx. You can easily add or remove extensions from that list in the %sEngagement settings%s of ExactMetrics.<br><br> You can view your Top Downloads report directly in the ExactMetrics %sPublishers report%s.', 'google-analytics-dashboard-for-wp' ), '<a href="' . $settings_url . '">', '</a>', '<a href="' . $publishers_report_url . '">', '</a>' );
			$notification['btns']    = array(
				"add_more_file_extensions" => array(
					'url'  => $settings_url,
					'text' => __( 'Add File Extensions', 'google-analytics-dashboard-for-wp' )
				),
			);

			return $notification;
		}

		return false;
	}

}

// initialize the class
new ExactMetrics_Notification_To_Add_More_File_Extensions();
