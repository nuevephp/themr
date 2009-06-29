<h1><?php echo __('Themr'); ?></h1>

<div id="snippets-def" class="index-def">
  <div class="snippet"><?php echo __('Themes'); ?></div>
</div>

<ul id="snippets" class="index">
<?php foreach($themes as $theme): ?>
  <li id="snippet_<?php echo $theme['id']; ?>" class="snippet node <?php echo odd_even(); ?>">
  	<div class="screenshot">
	  	<img src="<?php $screenshot = $theme['path'] . '/screenshot.png'; if(file_exists($screenshot)){ echo URL_PUBLIC . 'public/themes/' . $theme['id'] . '/screenshot.png'; } else { echo URL_PUBLIC . '/frog/plugins/themr/images/screenshot.png'; } ?>" alt="<?php echo $theme['name'] ?>" width="180" height="140" />
  	</div>
  	<div class="info">
		<h4 class="header">
			<?php if ($theme['website']): ?><a href="<?php echo $theme['website']; ?>" target="_blank"><?php endif ?>
				<?php echo $theme['name']; ?>
			<?php if ($theme['website']): ?></a><?php endif ?>
			<span class="from"> by 
			<?php if ($theme['author_website']): ?><a href="<?php echo $theme['author_website']; ?>" target="_blank"><?php endif ?>
				<?php echo $theme['author']; ?>
			<?php if ($theme['author_website']): ?></a><?php endif ?>
			| version <?php echo $theme['version']; ?></h4></span>
	    <p><?php echo $theme['description']; ?></p>
    </div>
    <div class="action">
    	<?php if($theme['id'] !== 'themr') { ?>
		    <?php if(Themr::isInstalled($theme['id'])) { ?>
	    		<a href="<?php echo get_url('plugin/themr/uninstall/'.$theme['id']); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to uninstall'); ?> <?php echo $theme['name']; ?>?');"><?php echo __('Uninstall'); ?></a>
			<?php } else { ?>
				<a href="<?php echo get_url('plugin/themr/install/'.$theme['id']); ?>"><?php echo __('Install'); ?></a>
	    	<?php } ?>
    	<?php } ?>
    </div>
  </li>
<?php endforeach; ?>
</ul>