<?php
defined('IN_WEB') or die();
global $db;
?>
<html>
<head>
	<title><?php echo ($this->get_page_title() ? $this->get_page_title() . ' - ' : '') . SITE_TITLE; ?></title>
</head>
<body>
	<?php echo $this->get_page_content(); ?>
</body>
</html>