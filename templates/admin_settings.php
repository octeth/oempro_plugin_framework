<div id="page-shadow">
	<div id="page">
		<div class="page-bar">
			<ul class="livetabs" tabcollection="plugin_framework-settings">
				<li id="tab-settings"><a href="#"><?php print($PluginLanguage['Screen']['0008']); ?></a></li>
				<li id="tab-license"><a href="#"><?php print($PluginLanguage['Screen']['0009']); ?></a></li>
				<li id="tab-support"><a href="#"><?php print($PluginLanguage['Screen']['0010']); ?></a></li>
			</ul>

		</div>
		<div class="white" style="min-height:430px;">
			<div tabcollection="plugin_framework-settings" id="tab-content-settings">
				<form id="plugin_framework-form-settings" method="post" action="<?php InterfaceAppURL(); ?>/plugin_framework/admin_settings/">
					<?php if (isset($PageErrorMessage) == true && $PageErrorMessage != ''): ?>
						<h3 class="form-legend error"><?php print($PageErrorMessage); ?></h3>
					<?php elseif (isset($PageSuccessMessage) == true && $PageSuccessMessage != ''): ?>
						<h3 class="form-legend success"><?php print($PageSuccessMessage); ?></h3>
					<?php elseif (validation_errors()): ?>
						<h3 class="form-legend error"><?php InterfaceLanguage('Screen', '0018', false); ?></h3>
					<?php endif; ?>

					<h3 class="form-legend"><?php print($PluginLanguage['Screen']['0019']); ?></h3>
					<div class="form-row no-bg">
						<p><?php print($PluginLanguage['Screen']['0020']); ?></p>
					</div>



					<div class="form-row <?php print((form_error('exmaple1') != '' ? 'error' : '')); ?>" id="form-row-example1">
						<label for="example1"><?php print($PluginLanguage['Screen']['0021']); ?>: *</label>
						<input type="text" name="example1" value="<?php echo set_value('example1', ''); ?>" id="example1" class="text" placeholder="example1" />
						<div class="form-row-note"><p><?php print($PluginLanguage['Screen']['0022']); ?></p></div>
						<?php print(form_error('example1', '<div class="form-row-note error"><p>', '</p></div>')); ?>
					</div>

					<?php if (is_bool($ExampleRecords) == true && $ExampleRecords == false): ?>
						<p>Empty...</p>
					<?php else: ?>
						<p><strong>Example record results:</strong></p>
						<ul>
						<?php foreach ($ExampleRecords as $Index=>$EachRecord): ?>
							<li><?php print($EachRecord->EmailAddress); ?></li>
						<?php endforeach; ?>
						</ul>
					<?php endif; ?>


					<input type="hidden" name="Command" value="UpdateSettings" id="Command" />
				</form>
			</div>
			<div tabcollection="plugin_framework-settings" id="tab-content-license">
				<h3 class="form-legend"><?php print($PluginLanguage['Screen']['0012']); ?></h3>
				<div class="form-row no-background-color">
					<p><?php print($PluginLanguage['Screen']['0011']); ?></p>
				</div>
			</div>
			<div tabcollection="plugin_framework-settings" id="tab-content-support">
				<h3 class="form-legend"><?php print($PluginLanguage['Screen']['0013']); ?></h3>
				<div class="form-row no-background-color">
					<p><?php print($PluginLanguage['Screen']['0014']); ?></p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="span-18 last">
	<div class="form-action-container">
		<a class="button" targetform="plugin_framework-form-settings"><span class="left">&nbsp;</span><span class="right">&nbsp;</span><strong><?php print(strtoupper($PluginLanguage['Screen']['0023'])); ?></strong></a>
	</div>
</div>
