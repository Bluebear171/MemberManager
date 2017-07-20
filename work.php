<?php
error_reporting(0);
function finalException($exception)
{
	if (empty($exception->getMessage())) {
		die(json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>'未知错误')));
	}
	die(json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>$exception->getMessage())));
}
set_exception_handler('finalException');
header("Content-Type: application/json;charset=utf-8"); 
require_once('./connect.php');
session_start();
if (isset($_SESSION['user'])) {
    $stat=$isql->prepare("SELECT `uId`,`member_information`,`history` FROM `maps` WHERE Community=? AND password=?");
    $tmpUser=$_SESSION['user'];
    $tmpPassword=md5($_SESSION['password']);
    $stat->bind_param('ss',$tmpUser,$tmpPassword);
    $stat->execute();
    $toke;
    $stat->bind_result($token,$_SESSION['pre_member'],$_SESSION['pre_history']);
    $stat->fetch();
    if ($stat&&!empty($token)) {
        $iscorrect=true;
    }else{
        $iscorrect=false;
    }
    $stat->close();
}else{
	die(json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>'授权失败')));
}

if (mysqli_connect_errno()) {
	die(json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>'数据库连接失败')));
}

//以上为与表单无关的预处理以及验证
if ($iscorrect) {
	if ($_POST['type']=='AddMember') {
		if (empty($_POST['name'])||empty($_POST['sex'])||empty($_POST['year'])||empty($_POST['class'])||empty($_POST['qq'])) {
			die(json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>'表单信息不完整')));
		}//表单完整性验证
		$result=$isql->prepare("INSERT INTO ".$_SESSION['pre_member'].'member_information'." (`姓名`,`分部`,`职务`,`性别`,`入学年份`,`班级`,`QQ`) VALUES (?,?,?,?,?,?,?)");
		$result->bind_param('sssiiis',
			$_POST['name'],
			$_POST['part'],
			$_POST['job'],
			$_POST['sex'],
			$_POST['year'],
			$_POST['class'],
			$_POST['qq']
			);
		$stat=$result->execute();
		if ($stat) {
			echo json_encode(array('stat'=>true,'name'=>$_POST['name'],'uID'=>$result->insert_id));
		}else{
			echo json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>$result->error));
		}
	}elseif ($_POST['type']=='AddEvent') {
		if (empty($_POST['eventType'])||empty($_POST['A'])||empty($_POST['B'])||empty($_POST['Alink'])||empty($_POST['Blink'])||empty($_POST['date'])) {
			die(json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>'表单信息不完整')));
		}//表单完整性验证
		$result=$isql->prepare("INSERT INTO ".$_SESSION['pre_member'].'history'." (`类型`,`A值`,`B值`,`A link`,`B link`,`时间`) VALUES (?,?,?,?,?,?)");
		$result->bind_param('ssssss',
			$_POST['eventType'],
			$_POST['A'],
			$_POST['B'],
			$_POST['Alink'],
			$_POST['Blink'],
			$_POST['date']
			);
		$stat=$result->execute();
		if ($stat) {
			echo json_encode(array('stat'=>true));
		}else{
			echo json_encode(array('stat'=>false,'error'=>$result->error));
		}
	}elseif($_POST['type']=='ChangeMember'){
		if (empty($_POST['uID'])||empty($_POST['name'])||empty($_POST['sex'])||empty($_POST['year'])||empty($_POST['class'])||empty($_POST['qq'])) {
			die(json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>'表单信息不完整')));
		}//表单完整性验证
		$result=$isql->prepare("update ".$_SESSION['pre_member'].'member_information'." set `姓名`=?,`分部`=?,`职务`=?,`性别`=?,`入学年份`=?,`班级`=?,`QQ`=? WHERE uID =? ");
		$result->bind_param('sssiiisi',
			$_POST['name'],
			$_POST['part'],
			$_POST['job'],
			$_POST['sex'],
			$_POST['year'],
			$_POST['class'],
			$_POST['qq'],
			$_POST['uID']
			);
		$stat=$result->execute();
		if ($stat) {
			echo json_encode(array('stat'=>true,'name'=>$_POST['name']));
		}else{
			echo json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>$result->error));
		}
	}elseif($_POST['type']=='giveTitle'){
		if (empty($_POST['uID'])) {
			die(json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>'表单信息不完整')));
		echo("update ".$_SESSION['pre_member'].'member_information'." set `荣誉头衔`=? WHERE uID =? ");
		$result=$isql->prepare("update ".$_SESSION['pre_member'].'member_information'." set `荣誉头衔`=? WHERE uID =? ");
		$result->bind_param('si',$_POST['title'],$_POST['uID']);
		$stat=$result->execute();
		if ($stat) {
			echo json_encode(array('stat'=>true,'name'=>$_POST['uID']));
		}else{
			echo json_encode(array('stat'=>false,'name'=>$_POST['uID'],'error'=>$result->error));
		}
	}else{
		die(json_encode(array('stat'=>false,'error'=>'表单数据不正确')));
	}
}
$result->close();