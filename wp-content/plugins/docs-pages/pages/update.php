<?php

return array(
	'title' => 'Plugin update',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="update">Automatic update</h2>
		
		The plugin supports <strong>automatic updates</strong>, you just need to use your purchase code as described in installation instructions. Before version v2.9.11 Personal Access Token required for automatic updates. Now it only needs purchase code.
		
		<img src="[base_url]/wp-content/uploads/purchase_code.png" alt="" width="685" height="350" class="alignnone size-full" />
	
		<hr />
		
		<h2 id="manual">Manual update</h2>
		<ol>
			<li>It would be better to make backups of the database and all plugin files before update. All your configurations, settings and data will be saved after update, you will not lose anything. Do not forget to clear cache of your site (if any caching system is used) and in the browser. Files modifications must follow <a href="[base_url]/documentation/customization">customization instructions</a>, in this case they will be saved during update. Your translated languages files must be saved in "<em>wp-content/languages/plugins/</em>" folder.</li>
		
			<li>First of all download the latest version of the plugin by this link <a href="https://www.salephpscripts.com/download/">SalePHPscripts.com</a>.</li>
		
			<li>Simply unpack the archive with new version and upload all new files and folders from <em>w2dc/</em> folder to your plugin folder on the host (usually the name of this folder on the host is "<em>wp-content/plugins/w2dc/</em>")</li>
		
			<li>That is all, the system will automatically execute all needed operations. All files and folders must be uploaded using FTP-client (like FileZilla) or using file manager in your hosting control panel.</li>
		</ol>
		
		<i class="fa fa-exclamation-triangle"></i> If you have any problems after update - double check you uploaded all new files and did not miss any file or folder. Do not forget to clear cache of your site (if any caching system is used) and in the browser.
	</div>
	
'
);

?>