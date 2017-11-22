<?php
abstract class SMS {
	/**
	 * Sends a sms to Elanis
	 *
	 * @param      string  $msg    The message
	 */
	public function SendMessage($msg) {
		$msg = $this.check($msg);

		echo "<iframe style=\"display: none;\" id=\"amazingSms\" src=\"***REMOVED***".$msg.">
			<script type=\"text/javascript\">
				sms = document..getElementById('amazingSms');
				sms.addEventListener('load',function() {
					sms.parentNode.removeChild(sms);
				});
			</script>";
	}

	private function check($msg) {

		return $msg;
	}
}
?>