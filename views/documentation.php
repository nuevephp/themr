<h1><?php echo __('Themr: Documentation'); ?></h1>

<h2 class="subtitle"><?php echo __('How to use Themr?'); ?></h2>
<p><?php echo __('You can create themes by following the folder structure similiar to the Themr Skeleton theme. The essential parts of the structure are the directory name, xml file, layouts and snippets directories.'); ?></p>
<p class="code bottom-5">
<?php echo __('themr<br />&nbsp;&nbsp;&nbsp;css<br />&nbsp;&nbsp;&nbsp;images<br />&nbsp;&nbsp;&nbsp;layouts<br />&nbsp;&nbsp;&nbsp;snippets<br />&nbsp;&nbsp;&nbsp;screenshot.png<br />&nbsp;&nbsp;&nbsp;theme.xml'); ?>
</p>
<h2 class="subtitle"><?php echo __('Themr XML Definition file'); ?></h2>
<p><?php echo __('In this file we define our theme information, which would be the theme name to display in themr, author, website, description and version. Check the Themr theme folder for theme.xml example'); ?></p>
<p class="code bottom-5"><?php echo __('&lt;?xml version="1.0" encoding="UTF-8"?&gt;<br />
&lt;themr&gt;<br />
&nbsp;&nbsp;&lt;name&gt;Theme Name&lt;/name&gt;<br />
&nbsp;&nbsp;&lt;author&gt;Theme Author&lt;/author&gt;<br />
&nbsp;&nbsp;&lt;author_website&gt;http://www.themeauthorwebsite.com/&lt;/author_website&gt;<br />
&nbsp;&nbsp;&lt;website&gt;http://www.themewebsite.com/&lt;/website&gt;<br />
&nbsp;&nbsp;&lt;description&gt;Theme description&lt;/description&gt;<br />
&nbsp;&nbsp;&lt;version&gt;0.1.1&lt;/version&gt;<br />
&lt;/themr&gt;'); ?></p>
<h2 class="subtitle"><?php echo __('Themr Convention'); ?></h2>
<p><?php echo __('Themr uses a precise naming convention to allow the plugin to work correctly and to have less conflicts when you have more themes installed. Layouts and Snippets should always have the theme directory name before the actual filename. Snippets uses hyphen in the name and themes use underscore.'); ?></p>
<p class="code bottom-5">
<?php echo __('layouts<br />&nbsp;&nbsp;&nbsp;themr_about_us.php<br />&nbsp;&nbsp;&nbsp;themr_home.php<br />snippets<br />&nbsp;&nbsp;&nbsp;themr-copyright.php<br />'); ?>
</p>
<p><?php echo __('When referencing a snippet in a theme it should have the same name as the file in the snippets folder without the .php extension'); ?></p>