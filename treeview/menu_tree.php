<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Menu Vertikal</title>
<script type="text/javascript"
 src="jquery-1.5.1.min.js"></script>
<script type="text/javascript"
 src="jquery.treeview.js"></script>
<link rel="stylesheet" type="text/css"
 href="jquery.treeview.css" />
<script type="text/javascript">
 $(document).ready(function() {
 $("#menu-tree").treeview();
 });
</script>
<style type="text/css">
 body {
 font-family: Verdana, helvetica, arial, sans-serif;
 font-size: 68.75%;
 background: #fff;
 color: #333;
 }
</style>
</head>
<body>
 
 <?php include"menu.php";?>
 
</body>
</html>