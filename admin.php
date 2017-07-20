<?php
require_once('./connect.php');
if (mysqli_connect_errno()) {
    die(json_encode(array('stat'=>false,'name'=>$_POST['name'],'error'=>'数据库连接失败')));
}
session_start();
if (isset($_POST['user'])) {
    $_SESSION['user']=$_POST['user'];
    $_SESSION['password']=$_POST['password'];
}
$islogin=isset($_POST['user']);
$iscorrect=False;
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
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>YWHS-INST数据库管理系统</title>
<!--统一加载部分-->
    <link rel="shortcut icon" href="../image/favicon.ico" />
    <script src="//cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<?php if(!$iscorrect): ?>
<!--登录加载部分-->
    <link href='//fonts.proxy.ustclug.org/css?family=Kelly+Slab' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="css/login_style.css" />
    <script src="js/md5.min.js"></script>
    <script type="text/javascript">
        <?php if ($islogin) echo "alert('用户名或密码错误');";?>
        function resolveForm(){
            $("#subuser")[0].value=$('#user')[0].value;
            $("#subpassword")[0].value=md5($('#password')[0].value);
            return true;
        }
    </script>
<?php else: ?>
<!--后台管理加载部分-->
    <link href="//cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.css" rel="stylesheet">
    <script src="//cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/admin_style.css" />
    <script src="js/iajax.js?ver=1.0.0.1" charset="utf-8">></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#help-1").on('click',function(form){
                form.preventDefault();
                alert("A值为图片的URL或者年表的左值\nB值为文本或年表的右值\nA link为点击图片的跳转链接\nB link为点击文本的跳转链接");
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#form-div').css("height",$(window).height());
            $('#msg-div').css('width',$(window).width()-$('#form-div').width()-1);
            $('#msg-content').css('height',$(window).height()-$('#msg-div-title').height()-9)
            $(function(){
                $('#tabs').tabs();
            });
        })
    </script>
<?php endif; ?>
</head>
<?php if(!$iscorrect): ?>
<!--登录页面-->
<body>
    <form id="login-form" method="post" action="admin.php" onsubmit="return resolveForm()" >
    <h1>Login in</h1>
      <div class="inset">
          <p>
            <label for="user">USER NAME</label>
            <input type="text" id="user">
        </p>
        <p>
            <label for="password">PASSWORD</label>
            <input type="password"  id="password">
        </p>
        <input type="hidden" id="subuser" name="user">
        <input type="hidden" id="subpassword" name="password">
    </div>
    <p class="p-container">
        <input type="submit" name="go" id="go" value="Confirm">
    </p>
    </form>
</body>
<?php else: ?>
<!--后台管理页面-->
<body>
    <div id="form-div">
        <div id="tabs" >
            <ul>
                <li><a href="#tabs-1">新增成员</a></li>
                <li><a href="#tabs-2">新增历史事件</a></li>
                <li><a href="#tabs-3">修改成员信息</a></li>
            </ul>
            <div id="tabs-1" class="tab">
                <form class="form-body">
                    <table class="form-table">
                        <tr>
                            <td><label for="">姓名</label></td>
                            <td><input id="name" name="name" autocomplete='off' type="text" autofocus='autofocus'></td>
                        </tr>
                        <tr>
                            <td><label for="">分部</label></td>
                            <td><input name="part" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">职务</label></td>
                            <td><input name="job" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">入学年份</label></td>
                            <td><input name="year" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">班级</label></td>
                            <td><input name="class" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">QQ</label></td>
                            <td><input name="qq" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">性别</label></td>
                            <td>
                                <input type="radio" name="sex" value="1" checked="true" /> 男
                                <input type="radio" name="sex" value="0" /> 女
                            </td>
                        </tr>
                        <tr><td colspan="2"><input type="submit" value="提交" id="submit-1"></td></tr>
                    </table>
                </form>
            </div>
            <div id="tabs-2" class="tab">
                <form class="form-body">
                    <table class="form-table">
                        <tr>
                            <td><label for="">类型</label></td>
                            <td>
                                <select name="type">
                                    <option value="year">年表</option>
                                    <option value="large">大图片</option>
                                    <option value="medium">中等图片</option>
                                    <option value="small">小图片</option>
                                </select>
                                <input type="button" id="help-1" value="帮助">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="">A值</label></td>
                            <td><input type="text" name="A"></td>
                        </tr>
                        <tr>
                            <td><label for="">B值</label></td
                            ><td><input type="text" name="B"></td>
                        </tr>
                        <tr>
                            <td><label for="">A link</label></td>
                            <td><input type="text" name="Alink"></td>
                        </tr>
                        <tr>
                            <td><label for="">B link</label></td>
                            <td><input type="text" name="Blink"></td>
                        </tr>
                        <tr>
                            <td><label for="">时间</label></td>
                            <td><input type="date" name="date" value="<?php echo date("Y-m-d");?>"></td>
                        </tr>
                        <tr><td colspan="2"><input type="submit" value="提交" id="submit-2"></td></tr>
                    </table>
                </form>
                <span style="color: orange">历史事件修改不便,请谨慎填写,如需修改请联系当届互联网社社长 <a href="http://blog.ywhsinst.org/%E7%AE%A1%E7%90%86%E5%91%98%E5%90%8D%E5%8D%95and%E8%81%94%E7%B3%BB%E6%96%B9%E5%BC%8F" target="_blank" style="color: blue;">点击获取联系方式 </a></span>
            </div>
            <div id="tabs-3" class="tab">
                <form class="form-body">
                    <table class="form-table">
                        <tr>
                            <td><label for="">uID</label></td>
                            <td><input id="uID" name="uID" autocomplete='off' type="text" autofocus='autofocus'></td>
                        </tr>
                        <tr>
                            <td><label for="">姓名</label></td>
                            <td><input id="name" name="name" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">分部</label></td>
                            <td><input name="part" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">职务</label></td>
                            <td><input name="job" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">入学年份</label></td>
                            <td><input name="year" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">班级</label></td>
                            <td><input name="class" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">QQ</label></td>
                            <td><input name="qq" autocomplete='off' type="text"></td>
                        </tr>
                        <tr>
                            <td><label for="">性别</label></td>
                            <td>
                                <input type="radio" name="sex" value="1" checked="true" /> 男
                                <input type="radio" name="sex" value="0" /> 女
                            </td>
                        </tr>
                        <tr><td colspan="2"><input type="submit" value="提交" id="submit-3"></td></tr>
                    </table>
                </form>
                <span style="color: orange">请完整填写所有信息</span>
            </div>
        </div>
        <div id="giveTitle">
            <h2>授衔</h2>
                <form class="form-body">
                    <table class="form-table">
                    <tr>
                        <td><label for="">uID</label></td>
                        <td><input type="text" autocomplete='off' name="uID"></td>
                    </tr>
                    <tr>
                        <td><label for="">头衔</label></td>
                        <td><input type="text" autocomplete='off' name="title"></td>
                    </tr>
                    <tr><td colspan="2"><input type="submit" value="提交" id="submit-4"></td></tr>
                    </table>
                </form>
        </div>
    </div>
    <div id="msg-div">
        <div id='msg-div-title'>消息区</div>
        <div id='msg-content'></div>
    </div>
</body>
<?php endif; ?>
</html>
<?php
$isql->close();