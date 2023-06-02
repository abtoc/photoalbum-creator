<?php echo '<?xml version="1.0" encoding="utf-8"?>'.PHP_EOL; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
  "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Page-{{ $page->page }}</title>
</head>

<body>
  <div>
    <img alt="{{ sprintf("%05d", $page->page) }}" src="../images/{{ sprintf('%05d', $page->page) }}.jpg" style="width:1600px;height:2560px;margin-left:0px;margin-top:0px;margin-right:0px;margin-bottom:0px;"/>
  </div>
</body>
</html>