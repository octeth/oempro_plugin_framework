<?php include_once(TEMPLATE_PATH . 'desktop/layouts/admin_header.php'); ?>

<!-- Section bar - Start -->
<div class="container">
	<div class="span-23 last">
		<div id="section-bar">
			<div class="header">
				<h1 class="left-side-padding"><?php print(strtoupper($PluginLanguage['Screen']['0001'])); ?></h1>
			</div>
		</div>
	</div>
</div>
<!-- Section bar - End -->

<!-- Page - Start -->
<div class="container">
	<form id="form1" method="post" action="">
		<div class="span-23">
			<div id="page-shadow">
				<div id="page">
					<div class="page-bar">
						<div class="actions">
							<a href="<?php print(InterfaceAppURL(true)); ?>/plugin_framework/admin_settings/"><?php print($PluginLanguage['Screen']['0006']); ?></a>
						</div>
						<ul class="livetabs" tabcollection="octautomation-reports">
							<li id="tab-overview">
								<a href="<?php print(InterfaceAppURL(true)); ?>/plugin_framework/admin_reports/overview"><?php print($PluginLanguage['Screen']['0007']); ?></a>
							</li>
						</ul>
					</div>
					<div class="white">
						<div tabcollection="octautomation-reports" id="tab-content-overview">
							dummy content
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- Page - End -->

<?php include_once(TEMPLATE_PATH . 'desktop/layouts/admin_footer.php'); ?>
