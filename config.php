<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action = 'root';
if (!$zbp->CheckRights($action)) {
  $zbp->ShowError(6);
  die();
}
if (!$zbp->CheckPlugin('zblogverify')) {
  $zbp->ShowError(48);
  die();
}
$act = GetVars('act', 'GET');
$suc = GetVars('suc', 'GET');
if (GetVars('act', 'GET') == 'save') {
  CheckIsRefererValid();
  foreach ($_POST as $key => $val) {
    $zbp->Config('zblogverify')->$key = trim($val);
  }
  if (!$zbp->Config('zblogverify')->igName) {
    $zbp->Config('zblogverify')->igUsrOn = 0;
  }
  $zbp->SaveConfig('zblogverify');
  // $zbp->BuildTemplate();
  $zbp->SetHint('good');
  Redirect('./config.php' . ($suc == null ? '' : '?act=$suc'));
}

$blogtitle = 'Z-Blog应用中心验证回调 - 设置';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
?>
<div id="divMain">
  <div class="divHeader"><?php echo $blogtitle; ?></div>
  <div class="SubMenu">
  </div>
  <div id="divMain2">
    <form class="search" id="search" method="post" action="main.php">
      <p style="padding: 0.2em 0 0.2em 0;">搜索(网址/应用ID/用户名): <input name="search" style="width:300px;" type="text" value="" /> &nbsp;&nbsp;
        <input type="submit" class="button" value="搜索" />
        <a href="config.php" class="button">设置</a></p>
    </form>
    <form action="<?php echo BuildSafeURL("config.php?act=save"); ?>" method="post">
      <table width="100%" class="tableBorder">
        <tr>
          <th width="10%">项目</th>
          <th>内容</th>
          <th width="45%">说明</th>
        </tr>
        <tr>
          <td>隐藏用户</td>
          <td>
            <?php echo zbpform::text("igName", $zbp->Config("zblogverify")->igName, "50%"); ?>
            <!-- <input type="text" class="checkbox" id="igUsrOn" name="igUsrOn"> -->
            <?php echo zbpform::zbradio("igUsrOn", $zbp->Config("zblogverify")->igUsrOn, "50%"); ?>
          </td>
          <td>可以隐藏开发者自己的验证信息</td>
        </tr>
        <tr>
          <td><input type="submit" value="提交" /></td>
          <td colspan="2"></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script type="text/javascript">
  AddHeaderIcon("<?php echo $bloghost . 'zb_users/plugin/zblogverify/logo.png'; ?>");
</script>
<script type="text/javascript">
  ActiveTopMenu("topmenu_zblogverify");
</script>
<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>
