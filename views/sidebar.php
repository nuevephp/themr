<?php if (Dispatcher::getAction() != 'view'): ?>

<p class="button"><a href="<?php echo get_url('plugin/themr/documentation'); ?>"><img src="../frog/plugins/tagger/images/documentation.png" align="middle" alt="snippet icon" /> <?php echo __('Documentation'); ?></a></p>

<div class="box">
    <h2><?php echo __('What is a Themr?'); ?></h2>
    <p><?php echo __('Themr is a plugin that helps to organise and manage themes.'); ?></p>
</div>

<div class="box">
    <h2><?php echo __('Tips'); ?></h2>
    <p><?php echo __('Use simple names for theme folder structure and make sure underscore without space.'); ?></p>
</div>

<?php endif; ?>
