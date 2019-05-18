<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('zblogverify')) {$zbp->ShowError(48);die();}

$blogtitle='Z-Blog应用中心验证回调 - 数据查看';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
$value = new zblogverify_Data;
$value->LoadInfoByID((int) GetVars('id','GET'));
?>
<style type="text/css">
    table {table-layout:fixed;}
    td {white-space:nowrap;overflow:hidden;}
</style>
<div id="divMain">
  <div class="divHeader"><?php echo $blogtitle;?></div>
  <div class="SubMenu">
      <a href="main.php"><span>返回列表</span></a>
  </div>
  <div id="divMain2">
    <table width="100%" style="padding:0;margin:0;" cellspacing="0" cellpadding="0" class="tableBorder tableBorder-thcenter table_striped table_hover">
        <?php if($value->UniqidID){ ?>
        <tr>
            <td width="25%">
                校验ID
            </td>
            <td width="75%">
                <?php echo $value->UniqidID ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td width="25%">
                校验来源
            </td>
            <td width="75%">
                <?php echo $value->from ?>
            </td>
        </tr>
        <?php if($value->error_number){ ?>
        <tr>
            <td width="25%">
                错误编号
            </td>
            <td width="75%">
                <?php echo $value->error_number ?>
            </td>
        </tr>
        <?php } ?>
        <?php if($value->error_message){ ?>
        <tr>
            <td width="25%">
                错误信息
            </td>
            <td width="75%">
                <?php echo $value->error_message ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td width="25%">
                是否验证成功
            </td>
            <td width="75%">
                <?php echo($value->error_verified ? '是' : '否') ?>
            </td>
        </tr>
        <tr>
            <td width="25%">
                是否疑似破解
            </td>
            <td width="75%">
                <?php echo($value->error_cracking ? '是' : '否') ?>
            </td>
        </tr>
        <?php if($value->error_user_message){ ?>
        <tr>
            <td width="25%">
                面向用户的错误信息
            </td>
            <td width="75%">
                <?php echo $value->error_user_message ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td width="25%">
                应用ID
            </td>
            <td width="75%">
                <?php echo $value->appId ?>
            </td>
        </tr>
        <tr>
            <td width="25%">
                网站
            </td>
            <td width="75%">
                <a href="<?php echo $value->host  ?>" target="_blank" rel="nofollow"><?php echo $value->host ?></a>
            </td>
        </tr>
        <tr>
            <td width="25%">
                用户-应用中心ID
            </td>
            <td width="75%">
                <?php echo ($value->user_id ? $value->data->user_id : '无' )  ?>
            </td>
        </tr>
        <tr>
            <td width="25%">
                用户-用户账号
            </td>
            <td width="75%">
                <?php echo ($value->data->user_name ? $value->data->user_name : '无' )  ?>
            </td>
        </tr>
        <tr>
            <td width="25%">
                应用最后修改日期
            </td>
            <td width="75%">
                <?php echo date("Y-m-d H:i:s",$value->modified) ?>
            </td>
        </tr>
        <?php if($value->license_appId){ ?>
        <tr>
            <td width="25%">
                授权文件-应用ID
            </td>
            <td width="75%">
                <?php echo $value->license_appId ?>
            </td>
        </tr>
        <tr>
            <td width="25%">
                授权文件-用户ID
            </td>
            <td width="75%">
                <?php echo $value->license_userId ?>
            </td>
        </tr>
        <tr>
            <td width="25%">
                授权文件-生成日期
            </td>
            <td width="75%">
                <?php echo date("Y-m-d H:i:s",$value->license_timestamp) ?>
            </td>
        </tr>
        <?php } ?>
    </table>
  </div>
</div>
<script type="text/javascript">AddHeaderIcon("<?php echo $bloghost . 'zb_users/plugin/zblogverify/logo.png';?>");</script>
<script type="text/javascript">ActiveTopMenu("topmenu_zblogverify");</script>
<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>