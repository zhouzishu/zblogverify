<?php
require '../../../zb_system/function/c_system_base.php';
require '../../../zb_system/function/c_system_admin.php';
$zbp->Load();
$action='root';
if (!$zbp->CheckRights($action)) {$zbp->ShowError(6);die();}
if (!$zbp->CheckPlugin('zblogverify')) {$zbp->ShowError(48);die();}

$blogtitle='ZBLOG应用中心验证回调';
require $blogpath . 'zb_system/admin/admin_header.php';
require $blogpath . 'zb_system/admin/admin_top.php';
$p = new Pagebar('{%host%}zb_users/plugin/zblogverify/main.php?{page=%page%}{&search=%search%}', false);
$p->PageCount = 50;
$p->PageNow = (int) GetVars('page', 'GET') == 0 ? 1 : (int) GetVars('page', 'GET');
$p->PageBarCount = $zbp->pagebarcount;
$p->UrlRule->Rules['{%search%}'] = urlencode(GetVars('search'));
$w = array();
if (GetVars('search')) {
    $w[] = array('search', 'Verify_appId', 'Verify_host', 'Verify_user_name', GetVars('search'));
}
$igOn = (bool)$zbp->Config("zblogverify")->igUsrOn;
$igName = $zbp->Config("zblogverify")->igName;
if ($igOn){
  $w[] = array("<>","Verify_user_name",$igName);
}
$order = array('verify_Time' => 'DESC');
$sql = $zbp->db->sql->Select($zbp->table['zblogverify_Data'], '*', $w, $order, array(($p->PageNow - 1) * $p->PageCount, $p->PageCount), array('pagebar' => $p));
$array = $zbp->GetListType('zblogverify_Data', $sql);
?>
<style type="text/css">
    table {table-layout:fixed;}
    td {white-space:nowrap;overflow:hidden;}
</style>
<div id="divMain">
  <div class="divHeader"><?php echo $blogtitle;?></div>
  <div class="SubMenu">
  </div>
  <div id="divMain2">
    <form class="search" id="search" method="post" action="#">
    <p style="padding: 0.2em 0 0.2em 0;">搜索(网址/应用ID/用户名): <input name="search" style="width:300px;" type="text" value="" /> &nbsp;&nbsp;
      <input type="submit" class="button" value="搜索"/>
      <a href="config.php" class="button">设置</a></p>
	</form>
    <table width="100%" style="padding:0;margin:0;" cellspacing="0" cellpadding="0" class="tableBorder tableBorder-thcenter table_striped table_hover">
        <tr>
            <th class="td15">校验ID</th>
            <th class="td20">网址</th>
            <th>应用ID</th>
            <th>用户账号</th>
            <th>验证状态</th>
            <th>疑似破解</th>
            <th>提交时间</th>
            <th class="td5">查看</th>
            <th class="td5">删除</th>
        </tr>
        <?php
        foreach ($array as $key=>$value){
        ?>
        <tr>
            <td><?php echo $value->UniqidID ?></td>
            <td><a href="<?php echo $value->host ?>" target="_blank" rel="nofollow"><?php echo $value->host ?></a></td>
            <td><?php echo $value->appId ?></td>
            <td><?php echo($value->user_name ? $value->user_name : '无') ?></td>
            <td style="text-align:center"><img src="<?php $value->VerifyStatus($value->error_verified) ?>"/></td>
            <td style="text-align:center"><?php echo($value->error_cracking ? '是' : '否') ?></td>
            <td><?php echo zblogverify_TimeAgo(date("Y-m-d H:i:s",$value->Time)) ?></td>
            <td style="text-align:center">
                <a href="view.php?id=<?php echo $value->ID ?>"><img src="<?php echo $bloghost.'zb_system/image/admin/page_copy.png' ?>"/></a>
            </td>
            <td style="text-align:center">
                <a onclick="return window.confirm('单击“确定”继续。单击“取消”停止。');" href="<?php echo BuildSafeURL('del.php?id='.$value->ID); ?>"><img src="<?php echo $bloghost.'zb_system/image/admin/delete.png' ?>"/></a>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    echo  '<p class="pagebar">';
    foreach ($p->buttons as $key => $value) {
    	echo '<a href="'. $value .'">' . $key . '</a>&nbsp;&nbsp;' ;
    }
    echo  '</p>';
    ?>
  </div>
</div>
<script type="text/javascript">AddHeaderIcon("<?php echo $bloghost . 'zb_users/plugin/zblogverify/logo.png';?>");</script>
<script type="text/javascript">ActiveTopMenu("topmenu_zblogverify");</script>
<?php
require $blogpath . 'zb_system/admin/admin_footer.php';
RunTime();
?>
