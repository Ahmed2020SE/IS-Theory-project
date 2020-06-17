<?php
if (session_id() == "")
{
   session_start();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['form_name']) && $_POST['form_name'] == 'logoutform')
{
   if (session_id() == "")
   {
      session_start();
   }
   unset($_SESSION['username']);
   unset($_SESSION['fullname']);
   header('Location: ./index.php');
   exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>products-store</title>
<meta name="generator" content="WYSIWYG Web Builder 14 - http://www.wysiwygwebbuilder.com">
<link href="project.css" rel="stylesheet">
<link href="products-store.css" rel="stylesheet">
<script src="jquery-1.12.4.min.js"></script>
<script>
$(document).ready(function()
{
   $.fn.alternateRowColors = function()
   {
      $('tbody tr:odd', this).removeClass('even').addClass('odd');
      $('tbody tr:even', this).removeClass('odd').addClass('even');
      return this;
   };
   $('table.sortable').each(function()
   {
      var $dataviewer = $(this);
      $dataviewer.alternateRowColors();
      $('th', $dataviewer).each(function(column)
      {
         var $header = $(this);
         var findSortKey;
         findSortKey = function($cell)
         {
            return $cell.find('.sort-key').text().toUpperCase() + ' ' + $cell.text().toUpperCase();
         };
         if (findSortKey)
         {
            $header.addClass('clickable').hover(function()
            {
               $header.addClass('hover');
            }, function()
            {
               $header.removeClass('hover');
            }).click(function()
            {
               var sortDirection = 1;
               if ($header.is('.sorted-asc'))
               {
                  sortDirection = -1;
               }
               var rows = $dataviewer.find('tbody > tr').get();
               $.each(rows, function(index, row)
               {
                  var $cell = $(row).children('td').eq(column);
                  row.sortKey = findSortKey($cell);
               });
               rows.sort(function(a, b)
               {
                  if (a.sortKey < b.sortKey) return -sortDirection;
                  if (a.sortKey > b.sortKey) return sortDirection;
                  return 0;
               });
               $.each(rows, function(index, row)
               {
                  $dataviewer.children('tbody').append(row);
                  row.sortKey = null;
               });
               $dataviewer.find('th').removeClass('sorted-asc').removeClass('sorted-desc');
               if (sortDirection == 1)
               {
                  $header.addClass('sorted-asc');
               }
               else
               {
                  $header.addClass('sorted-desc');
               }
               $dataviewer.find('td').removeClass('sorted').filter(':nth-child(' + (column + 1) + ')').addClass('sorted');
               $dataviewer.alternateRowColors();
            });
         }
      });
   });
   $('table.paginated').each(function()
   {
      var currentPage = 0;
      var numPerPage = 10;
      var $dataviewer = $(this);
      var paginate = function()
      {
         $dataviewer.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
      };
      var numRows = $dataviewer.find('tbody tr').length;
      var numPages = Math.ceil(numRows / numPerPage);
      var $pager = $('<div class="pager"></div>');
      for (var page = 0; page < numPages; page++)
      {
         $('<span class="page-number"></span>').text(page + 1)
         .bind('click', {newPage: page}, function(event)
         {
            currentPage = event.data['newPage'];
            paginate();
            $(this).addClass('active').siblings().removeClass('active');
         }).appendTo($pager).addClass('clickable');
      }
      $pager.insertBefore($dataviewer).find('span.page-number:first').addClass('active');
      paginate();
   });
});
</script>
</head>
<body>
<div id="space"><br></div>
<div id="container">
<div id="wb_LoginName1" style="position:absolute;left:703px;top:92px;width:177px;height:27px;z-index:0;">
<span id="LoginName1">Welcome <?php
if (isset($_SESSION['username']))
{
   echo $_SESSION['username'];
}
else
{
   echo 'Not logged in';
}
?>!</span></div>
<div id="wb_Logout1" style="position:absolute;left:894px;top:93px;width:96px;height:23px;z-index:1;">
<form name="logoutform" method="post" action="<?php echo basename(__FILE__); ?>" id="logoutform">
<input type="hidden" name="form_name" value="logoutform">
<input type="submit" name="logout" value="Logout" id="Logout1">
</form>
</div>
<input type="button" id="Button3" onclick="window.location.href='./Reports.php';return false;" name="" value="Back" style="position:absolute;left:149px;top:93px;width:96px;height:25px;z-index:2;">
<div id="wb_IconFont1" style="position:absolute;left:435px;top:52px;width:100px;height:85px;text-align:center;z-index:3;">
<a href="./main-page.php" title="Home"><div id="IconFont1"><i class="material-icons">&#xe88a;</i></div></a></div>
<div id="wb_Extension1" style="position:absolute;left:94px;top:211px;width:876px;height:582px;z-index:4;">
<?php
$mysql_host = 'localhost';
$mysql_user = 'root';
$mysql_password = '';
$mysql_database = 'project';
$mysql_table = '';
$db = mysqli_connect($mysql_host, $mysql_user, $mysql_password);
mysqli_select_db($db, $mysql_database);
$sql = "select
  max(p.buyprice) AS maxBuyPrice,
  p.name AS productName,
  t.name AS storeName,
  t.genre AS storeGenre
from
  product p
  inner join store_has_product s on p.id = s.product_id
  inner join store t on s.store_id = t.id;";
$result = mysqli_query($db, $sql);
?>
<table cellpadding="0" cellspacing="0" width="100%" class="sortable paginated">
<thead>
   <tr>
<?php
$fields_num = mysqli_num_fields($result);
for ($i=0; $i<$fields_num; $i++)
{
   $field = mysqli_fetch_field($result);
   echo "      <th>" . $field->name . "</th>\n";
}
?>
   </tr>
</thead>
<tbody>
<?php
while ($row = mysqli_fetch_row($result))
{
   echo "   <tr>\n";
   foreach ($row as $cell)
   {
      echo "      <td>" . $cell . "</td>\n";
   }
   echo "   </tr>\n";
}
?>
</tbody>
</table>
</div>
<div id="wb_Text1" style="position:absolute;left:282px;top:148px;width:407px;height:46px;text-align:center;z-index:5;">
<span style="color:#000000;font-family:Arial;font-size:20px;">Produce the products with maximum buy price in each store’s genre</span></div>
</div>
</body>
</html>