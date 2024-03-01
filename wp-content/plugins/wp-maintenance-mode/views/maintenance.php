<?php

$days = $this->plugin_settings['modules']['countdown_details']['days'];
$hours = $this->plugin_settings['modules']['countdown_details']['hours'];
$minutes = $this->plugin_settings['modules']['countdown_details']['minutes'];

$allowed_socials = array('facebook', 'twitter', 'instagram', 'google+');
$social_prefix = 'social_';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <meta name="author" content="<?php echo esc_attr($author); ?>" />
  <meta name="description" content="<?php echo esc_attr($description); ?>" />
  <meta name="keywords" content="<?php echo esc_attr($keywords); ?>" />
  <meta name="robots" content="<?php echo esc_attr($robots); ?>" />
  <?php
  if (!empty($styles) && is_array($styles)) {
    foreach ($styles as $src) {
  ?>
      <link rel="stylesheet" data href="<?php echo $src; ?>">
    <?php
    }
  }
  if (!empty($custom_css) && is_array($custom_css)) { ?>
    <style>
      <?php echo implode(array_map('stripslashes', $custom_css)) ?>
    </style>
    <?php
  }
  if (!empty($scripts) && is_array($scripts)) {
    foreach ($scripts as $src) {
    ?>
      <script src="<?php echo $src; ?>"></script>
  <?php
    }
  }
  ?>
  <link rel="icon" href="/favicon.ico">
  <title><?php echo $texts['title']; ?></title>
</head>

<body class="<?php echo $body_classes ? $body_classes : ''; ?>">

  <div class="container wrap">

    <header class="header">
      <h1 class="heading"><?php echo $texts['heading']; ?></h1>
      <div class="subheading"><?php echo $texts['subheading']; ?></div>
    </header>

    <!--START_TIMER_BLOCK-->
    <?php if ($this->plugin_settings['modules']['countdown_status']) : ?>
      <section class="timer">
        <div class="timer__item">
          <div class="timer__data" id="timerResultDays"></div>
          <div class="timer__type"><?php _e('Tage', 'wp'); ?></div>
        </div>:
        <div class="timer__item">
          <div class="timer__data" id="timerResultHours"></div>
          <div class="timer__type"><?php _e('Stunden', 'wp'); ?></div>
        </div>:
        <div class="timer__item">
          <div class="timer__data" id="timerResultMinutes"></div>
          <div class="timer__type"><?php _e('Minuten', 'wp'); ?></div>
        </div>:
        <div class="timer__item">
          <div class="timer__data" id="timerResultSeconds"></div>
          <div class="timer__type"><?php _e('Sekunden', 'wp'); ?></div>
        </div>
      </section>
      <script type="application/javascript">
        startTimer(<?php echo $days . ',' . $hours . ',' . $minutes . ',' . strtotime($countdown_start) . ',' . time(); ?> - Math.floor(Date.now() / 1000));
      </script>
    <?php endif; ?>
    <!--END_TIMER_BLOCK-->

    <!--START_ADMIN_LINK_BLOCK-->
    <section class="admin-link" style="margin: 0 0 auto; text-align: center;">
      <?php if ($this->plugin_settings['general']['admin_link']) : ?>
        <span class="">
          <a class="admin-link" href="<?php echo admin_url(); ?>" target="_self" title="Admin Dashboard"><?php echo __('Login', $this->plugin_slug); ?></a>
        <?php endif ?>
    </section>
    <!--END_ADMIN_LINK_BLOCK-->

    <!--START_SOCIAL_LINKS_BLOCK-->
    <section class="social-links">
      <?php foreach ($this->plugin_settings['modules'] as $network => $url) : ?>
        <?php $social = (($test = preg_replace('/' . $social_prefix . '(\w+)/', '$1', $network)) === $network) ?
          false : $test ?>
        <?php if ($social && in_array($social, $allowed_socials) && !empty($url)) { ?>
          <a class="social-links__link" href="<?php echo $url; ?>" target="_blank" title="<?php echo ucfirst($social); ?>">
            <span class="icon"><img src="" alt="<?php echo ucfirst($social); ?>"></span>
          </a>
        <?php } ?>
      <?php endforeach; ?>
    </section>
    <!--END_SOCIAL_LINKS_BLOCK-->

  </div>

  <footer class="footer">
    <div class="footer__bg_copyright"><?php echo $credits; ?></div>
    <div class="footer__content">
      <?php printf(__('%1$s powered by %2$s', $this->plugin_slug),  get_bloginfo('name'), $this->get_creator(true)); ?>
    </div>
  </footer>
  <script type='text/javascript'>
    var wpmm_vars = {
      "ajax_url": "<?php echo admin_url('admin-ajax.php'); ?>"
    };
  </script>

  <?php

  // Hook before scripts, mostly for internationalization
  do_action('wpmm_before_scripts');


  // Do some actions
  do_action('wm_footer'); // this hook will be removed in the next versions
  do_action('wpmm_footer');
  ?>
  <?php if (!empty($this->plugin_settings['bot']['status']) && $this->plugin_settings['bot']['status'] === 1) { ?>
    <script type='text/javascript'>
      jQuery(function($) {
        startConversation('homepage', 1);
      });
    </script>
  <?php } ?>
</body>

</html>