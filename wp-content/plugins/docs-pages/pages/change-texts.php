<?php

return array(
	'title' => 'How to modify texts',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="change_texts">How to modify texts</h2>
		
		If you use WordPress in English and simply want to modify one or some words of the plugin, then follow these steps:
		<ol>
			<li>Download and install <a href="https://poedit.net/" target="_blank" rel="noopener noreferrer">Poedit</a>.</li>
		
			<li>Open with Poedit <em>languages/W2DC-en_US.po</em> file.</li>
		
			<li>Now you can find and modify any needed words and texts.
			<img src="[base_url]/wp-content/uploads/2018/04/poEdit.png" alt="" width="844" height="593" class="alignnone size-full wp-image-16954" /></li>
		
			<li>Every time you save <em>W2DC-en_US.po</em> file, Poedit automatically generates <em>W2DC-en_US.mo</em> file, which is the one WordPress uses and basically the only one you need to <strong>upload to your site</strong>.</li>
		
			<li>Upload generated <em>W2DC-en_US.mo</em> file and saved <em>W2DC-en_US.po</em> file to your site into <em>wp-content/languages/plugins/</em> folder. You can use FTP client or FTP manager of your hosting.</li>
		</ol>
	</div>
	
'
);

?>