<h1><?php echo __('Themr'); ?></h1>

<div id="snippets-def" class="index-def">
  <div class="snippet"><?php echo __('Themes'); ?></div>
</div>

<ul id="snippets" class="index">
<?php foreach($themes as $theme): ?>
  <li id="snippet_<?php echo $theme['id']; ?>" class="snippet node <?php echo odd_even(); ?>">
  	<div class="screenshot">
	  	<img src="<?php $screenshot = $theme['path'] . '/screenshot.png'; if(file_exists($screenshot)){ echo '/public/themes/' . $theme['id'] . '/screenshot.png'; } else { echo '../frog/plugins/themr/images/screenshot.png'; } ?>" alt="<?php echo $theme['name'] ?>" width="180" height="140" />
  	</div>
  	<div class="info">
		<h4 class="header"><a href="<?php echo $theme['website']; ?>" target="_blank"><?php echo $theme['name']; ?></a> <span class="from"> by <?php echo $theme['author']; ?> | version <?php echo $theme['version']; ?></h4></span>
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

<!-- <div class="pagination">
<?php
  if ($currentpage == $lastpage) {
    $next = '<span class="disabled">Next Page</span>';
  } else {
    $nextpage = $currentpage + 1;
    $next = '<a href="' . get_url('plugin/themr/index/') . '' . $nextpage .
      '">Next Page</a>';

  }
  if ($currentpage == 0) {
    $prev = '<span class="disabled">Previous Page</span>';
  } else {
    $prevpage = $currentpage - 1;
    $prev = '<a href="' . get_url('plugin/themr/index/') . '' . $prevpage .
      '">Previous Page</a>';
  }
  if ($currentpage != 0) {
    echo "<a href=" . get_url('plugin/themr/index/') . "0>First Page</a>\n ";
  }
  else {
    echo "<span class=\"disabled\">First Page</span>";
  }
  echo $prev;
  for ($i = 0; $i <= $lastpage; $i++) {
    if ($i == $currentpage)
      echo '<span class="current">'.$i.'</span';
    else
      echo " <a href=" . get_url('plugin/themr/index/') . "$i>$i</a>\n";
  }
  echo $next;
  if ($currentpage != $lastpage) {
    echo "\n<a href=" . get_url('plugin/themr/index/') . "$lastpage>Last Page</a>&nbsp&nbsp;";
  }
  else {
    echo "<span class=\"disabled\">Last Page</span>";
  }
?>
</div> -->
