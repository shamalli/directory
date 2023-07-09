<?php

return array(
	'title' => 'Translation',
	'content' => '
	
	<div class="w2dc-docs w2dc-docs-side">
		<h2 id="translations">Translation</h2>
		
		Web 2.0 Directory plugin is ready for use in any languages. The <em>languages/</em> folder contains W2DC-en_US.po file, which is used for translations. The process of translation is quite similar to <a href="[base_url]/documentation/change-texts/">modifying texts</a> with <a href="https://poedit.net/" target="_blank" rel="noopener noreferrer">PoEdit</a> application. The only difference is that before translation you need to duplicate W2DC-en_US.po file and give a name to new file according to following rules:
		<ol>
			<li>On Wordpress <em>Settings -> General</em> page select needed site language.
			<img src="[base_url]/wp-content/uploads/2018/04/language.png" /></li>
		
			<li>Make a copy of the <em>W2DC-en_US.po</em> file and rename it to <em>W2DC-WP_LOCALE.po</em> according to your <a href="https://make.wordpress.org/polyglots/teams/" target="_blank" rel="noopener noreferrer">WP Locale</a></li>
		
			<li>Example for the Portuguese Brazil language: <em>W2DC-pt_BR.po</em>
		    -- pt_BR - is the WP Locale, it means Portuguese (Brazil) language
		    -- you\'ll have to fill in with your own language, the list of WordPress locales <a href="https://make.wordpress.org/polyglots/teams/" target="_blank" rel="noopener noreferrer">here</a></li>
		
			<li>Download and install <a href="https://poedit.net/" target="_blank" rel="noopener noreferrer">Poedit</a>.</li>
		
			<li>Open with Poedit <em>W2DC-pt_BR.po</em> file.</li>
		
			<li>Now you can find and modify any needed words and texts.
			<img src="[base_url]/wp-content/uploads/2018/04/poEdit.png" /></li>
		
			<li>Every time you save translated <em>W2DC-WP_LOCALE.po</em> file, PoEdit automatically generates <em>W2DC-WP_LOCALE.mo</em> file, which is the one WordPress uses and basically the only one you need to <strong>upload to your site</strong>.</li>
		
			<li>Upload generated <em>W2DC-WP_LOCALE.mo</em> file and saved <em>W2DC-WP_LOCALE.po</em> file to your site into <em>wp-content/languages/plugins/</em> folder. You can use FTP client or FTP manager of your hosting.</li>
		</ol>
		
		<a href="[base_url]/documentation/search/">Search Forms builder</a> interface should be translated in the same way using <em>search/plugin/languages/WCSEARCH.pot</em> file.
		
		<i class="fa fa-exclamation-triangle"></i> Also the plugin can be translated using Loco Translate plugin.
	</div>
	
'
);

?>