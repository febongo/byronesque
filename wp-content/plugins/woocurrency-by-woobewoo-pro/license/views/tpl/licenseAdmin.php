<section class="supsystic-bar">
	<h4>
		<?php if($this->isActive) {
			printf(__('Congratulations! PRO version of %s plugin has been activated and is working fine!', WCU_LANG_CODE), WCU_WP_PLUGIN_NAME);
		} elseif($this->isExpired) {
			printf(__('Your license for PRO version of %s plugin has expired. You can <a href="%s" target="_blank">click here</a> to extend your license, then - click on "Re-activate" button to re-activate your PRO version.', WCU_LANG_CODE), WCU_WP_PLUGIN_NAME, $this->extendUrl);
		} else {
			printf(__('Congratulations! You have successfully installed PRO version of %s plugin. Final step to finish Your PRO version setup - is to enter your Email and License Key on this page. This will activate Your copy of software on this site.', WCU_LANG_CODE), WCU_WP_PLUGIN_NAME);
		}?>
	</h4>
	<div style="clear: both;"></div>
	<hr />
</section>
<section>
	<form id="wcuLicenseForm" class="">
		<div class="supsystic-item supsystic-panel">
			<table class="form-table" style="">
				<tr>
					<th scope="row" style="padding-left:40px">
						<?php _e('Email', WCU_LANG_CODE)?>
					</th>
					<td style="width: 1px;">
						<i class="fa fa-question woobewoo-tooltip tooltipstered" title="<?php echo esc_html(sprintf(__('Your email address, used on checkout procedure on <a href="%s" target="_blank">%s</a>', WCU_LANG_CODE), 'https://woobewoo.com/product/woo-currency/', 'https://woobewoo.com/product/woo-currency/'))?>"></i>
					</td>
					<td>
						<?php echo htmlWcu::text('email', array('value' => $this->credentials['email'], 'attrs' => 'style="width: 300px;"'))?>
					</td>
				</tr>
				<tr>
					<th scope="row" style="padding-left:40px">
						<?php _e('License Key', WCU_LANG_CODE)?>
					</th>
					<td>
						<i class="fa fa-question woobewoo-tooltip tooltipstered" title="<?php echo esc_html(sprintf(__('Your License Key from your account on <a href="%s" target="_blank">%s</a>', WCU_LANG_CODE), 'https://woobewoo.com/product/woo-currency/', 'https://woobewoo.com/product/woo-currency/'))?>"></i>
					</td>
					<td>
						<?php echo htmlWcu::text('key', array('value' => $this->credentials['key'], 'attrs' => 'style="width: 300px;"'))?>
					</td>
				</tr>
				<tr>
					<th scope="row" colspan="3" style="padding-left:40px">
						<?php echo htmlWcu::hidden('mod', array('value' => 'license'))?>
						<?php echo htmlWcu::hidden('action', array('value' => 'activate'))?>
						<button class="button button-primary">
							<i class="fa fa-fw fa-save"></i>
							<?php if($this->isExpired) {
								_e('Re-activate', WCU_LANG_CODE);
							} else {
								_e('Activate', WCU_LANG_CODE);
							}?>
						</button>
					</th>
				</tr>
			</table>
			<div style="clear: both;"></div>

		</div>
	</form>
</section>
