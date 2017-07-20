<?php
header ( "Content-type:text/html;charset=utf-8" );
require_once('./connect.php');  
?>

<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="UTF-8">
	<title>YWHS-INST数据库查询系统</title>
	<link rel="stylesheet" type="text/css" href="css/style.css?ver=1.0.1" />
	<link rel="shortcut icon" href="../image/favicon.ico" />
  <script src="//cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
  <link href="//cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet">
  <script src="//cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>
  
  <script type="text/javascript">//函数
  function accurate(){
    var type = $("#accurate>input[name=ftype][type=radio]:checked").val();
    var content = $("#accurate>input[type=text][name=content]").val();
    $("#data-table>tbody>tr").hide();
    $("#data-table>tbody>tr>th").parent().show();
    $("#data-table>tbody>tr>td:nth-child("+type+"):contains('"+content+"')").parent().show();
  }
  function blurry(){
    var type = $("#blurry>select[name=type]").val();
    var content = $("#blurry>input[name=content]").val();
    if (type=="" || content=="") {
      $("#data-table>tbody>tr").show();
      return;
    }
    $("#data-table>tbody>tr").hide();
    $("#data-table>tbody>tr>th").parent().show();
    $("#data-table>tbody>tr>td:nth-child("+type+"):contains('"+content+"')").parent().show();
  }
  </script>
	<script type="text/javascript">
  $(document).ready(function(){
    $(function(){
      $( "#filter" ).tabs();
    });
    $("#accurate>input[name=content]").on("keyup",function(){
      accurate();
    });
    $("#blurry>input[name=content]").on("keyup",function(){
      blurry();
    });
  });
	</script>

</head>
<body>
  <h1>YWHS-INST数据库查询系统</h1>
  <hr />
  <div id="filter">
    <div id="tabs">
      <ul>
        <li><a href="#accurate">精确筛选</a></li>
        <li><a href="#blurry">模糊筛选</a></li>
      </ul>
      <div id="accurate">
        <input type="radio" name="ftype" value="1" checked="checked" /> uID
        <input type="radio" name="ftype" value="2" /> 姓名<br />
        <input type="text" name="content">
      </div>
      <div id="blurry">
        <label >字段：</label>
        <select name="type">
          <option value="1">uID</option>
          <option value="2">姓名</option>
          <option value="3">分部</option>
          <option value="4">职务</option>
          <option value="5">性别</option>
          <option value="6">入学年份</option>
          <option value="7">班级</option>
          <option value="8">记载时间</option>
          <option value="9">QQ</option>
          <option value="10">荣誉头衔</option>
        </select>
        <label >值：</label><input type="text" name="content">
      </div>
    </div>
  </div>
	<hr />
	<table id="data-table">
		<?php 
		$result=$isql->prepare("select COLUMN_NAME from information_schema.COLUMNS where table_name = 'member_information' and table_schema = 'nshmohsq_idb'");
		$result->execute();
		$result->bind_result($record[0]);
		while ($result->fetch()){
			if ($record[0]=='备注') {
				break;
			}
			echo "<th>".$record[0]."</th>";
		}
		$result->close();
		$result=$isql->prepare("SELECT * FROM member_information");
		$result->execute();
		$result->bind_result($record[0],$record[1],$record[2],$record[3],$record[4],$record[5],$record[6],$record[7],$record[8],$record[9],$record[10]);
		while ($result->fetch()){
			echo "<tr>";
			foreach ($record as $key => $value) {
				if (!$value)$value='无';
				switch ($key) {
					case 4:
				        echo "<td>".($value==1?'男':'女')."</td>";
				        break;
				    case 7:
				        echo "<td>".substr($value,0,10)."</td>";
				        break;
				    case 10:
				        break;
				    default:
				        echo "<td>".($value=='NULL'||empty($value)?'无':$value)."</td>";
				}
			}
			echo "</tr>";
		}
		?>
	</table>
</body>
</html>
<?php
$isql->close();
?>