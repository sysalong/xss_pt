<?php
/**
 * user.php 用户管理
 * ----------------------------------------------------------------
 * OldCMS,site:http://www.oldcms.com
 */
if(!defined('IN_OLDCMS')) die('Access Denied');

$act=Val('act','GET');

$where='';
switch($act){
	case 'audit':
		$isAudit=Val('isAudit','GET',1);
		$id=Val('id','GET',1);
		$db=DBConnect();
		$tbModule=$db->tbPrefix.'module';
		$db->Execute("UPDATE {$tbModule} SET isAudit='{$isAudit}',managerId='".$user->userId."',managerName='".$user->userName."' WHERE id='{$id}'");
		ShowSuccess('操作成功',URL_ROOT.'/admin/index.php?do=admin_module');
		break;
	case 'email':
		$db=DBConnect();
		$emaillist=$db->Dataset("SELECT * FROM ".Tb('email')." ORDER BY id dESC");
		if(!empty($emaillist)){
			foreach($emaillist as $k=>$v)
                {       
					$emaillist[$k]['epass'] = substr_replace($emaillist[$k]['epass'], '*****', 2,4);
                }
		}
		include('common.php');
		$smarty=InitSmarty(1);
		$smarty->assign('do',$do);
		$smarty->assign('show',$show);
		$smarty->assign('url',$url);
		$smarty->assign('emaillist',$emaillist);
		$smarty->assign('modules',$modules);
		$smarty->display('admin_emaillist.html');
		exit;
		break;
	case 'emailadd':
		$db=DBConnect();
		$ehost=trim(Val('ehost','POST'));
		$euser=trim(Val('euser','POST'));
		$epass=trim(Val('epass','POST'));
		if(empty($ehost) || empty($euser) || empty($epass)) ShowError('大哥添加email有一项为空都不行啊',URL_ROOT.'/admin/index.php?do=admin_module&act=email','重新填写');//项目验证
		if(!preg_match('/^(\w+\.)*?\w+@(\w+\.)+\w+$/',$euser)) ShowError('您的邮箱格式不正确,示例：xxxx@xxx.com',URL_ROOT.'/admin/index.php?do=admin_module&act=email','重新填写');
		$tbInviteReg=$db->tbPrefix.'email';
		$sqlValue=array(
			'ehost'=>$ehost,
			'euser'=>$euser,
			'epass'=>$epass
		);
		if($db->AutoExecute($tbInviteReg,$sqlValue)){
			ShowSuccess('操作成功',URL_ROOT.'/admin/index.php?do=admin_module&act=email');
		}else{
			ShowError('操作失败',URL_ROOT.'/admin/index.php?do=admin_module&act=email');
		}
		exit;
		break;
	case 'delmail':
		if(! $user->CheckToken(Val('token','GET'))) ShowError('操作失败');
		$id=Val('id','GET',1);
		$db=DBConnect();
		$project=$db->FirstRow("SELECT * FROM ".Tb('email')." WHERE id='{$id}' ");
		if(empty($project)) ShowError('不存在此Email设置');
		$db->Execute("DELETE FROM ".Tb('email')." WHERE id='{$id}'");
		ShowSuccess('操作成功',URL_ROOT.'/admin/index.php?do=admin_module&act=email');
		exit;
		break;
	case 'testemail':
		if(! $user->CheckToken(Val('token','POST'))) ShowError('操作失败');
		$id=Val('id','POST',1);
		if(empty($id)) ShowError('ID值禁止为空！！操作失败！！！');
		$db=DBConnect();
		$content=$db->FirstRow("SELECT * FROM ".Tb('email')." WHERE id='{$id}'");
		if(empty($content)){
			ShowError('操作失败');
		}else{
			SendtestMail($user->email,URL_ROOT."饼干商城","尊敬的".$user->email."，您在".URL_ROOT." 预订的测试数据<br>恭喜您测试成功！！！<br>已经到货！<br>详情请登陆：".URL_ROOT." 查看。",$content);
		}
		exit;
		break;
	case 'allfilter':
		$db=DBConnect();
		$allfilter=$db->Dataset("SELECT * FROM ".Tb('allfilter')." ORDER BY id dESC");
		include('common.php');
		$smarty=InitSmarty(1);
		$smarty->assign('do',$do);
		$smarty->assign('show',$show);
		$smarty->assign('url',$url);
		$smarty->assign('allfilter',$allfilter);
		$smarty->assign('modules',$modules);
		$smarty->display('admin_allfilter.html');
		exit;
		break;
	case 'addfilter':
		$db=DBConnect();
		$filterurl=trim(Val('filterurl','POST'));
		if(empty($filterurl)) ShowError('word哥，过滤参数禁止为空！！！',URL_ROOT.'/admin/index.php?do=admin_module&act=allfilter','重新填写');//项目验证
		$tbInviteReg=$db->tbPrefix.'allfilter';
		$sqlValue=array(
			'filterurl'=>$filterurl
		);
		if($db->AutoExecute($tbInviteReg,$sqlValue)){
			ShowSuccess('操作成功',URL_ROOT.'/admin/index.php?do=admin_module&act=allfilter');
		}else{
			ShowError('操作失败',URL_ROOT.'/admin/index.php?do=admin_module&act=allfilter');
		}
		exit;
		break;
	case 'delfilter':
		if(! $user->CheckToken(Val('token','GET'))) ShowError('操作失败');
		$id=Val('id','GET',1);
		$db=DBConnect();
		$project=$db->FirstRow("SELECT * FROM ".Tb('allfilter')." WHERE id='{$id}' ");
		if(empty($project)) ShowError('不存在此过滤设置');
		$db->Execute("DELETE FROM ".Tb('allfilter')." WHERE id='{$id}'");
		ShowSuccess('操作成功',URL_ROOT.'/admin/index.php?do=admin_module&act=allfilter');
		exit;
		break;
	default:
		$db=DBConnect();
		$tbModule=$db->tbPrefix.'module';
		$tbUser=$db->tbPrefix.'user';
		$where=" AND isOpen=1";
		include(ROOT_PATH.'/source/class/Pager.class.php');
		$countSql="SELECT COUNT(*) FROM {$tbModule} WHERE 1=1 {$where} ORDER BY id DESC";
		$sql="SELECT m.*,u.userName AS userName FROM {$tbModule} m INNER JOIN {$tbUser} u ON u.id=m.userId WHERE 1=1 {$where} ORDER BY id DESC";
		$href='./index.php?do=admin_module';
		if(!empty($act)) $href.='&act='.$act;
		$pager=new Pager($countSql,$sql,$href,20,5,Val('pNO','GET',1));
		$modules=$pager->data;
		$smarty=InitSmarty(1);
		$smarty->assign('modules',$modules);
		$smarty->assign('nav',$pager->nav);
		$smarty->assign('do',$do);
		$smarty->assign('show',$show);
		$smarty->assign('url',$url);
		$smarty->display('admin_module.html');
		break;
}
?>