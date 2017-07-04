<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Controller\AuthController;
use Think\Auth;
use Vendor\ThinkImage\ThinkImage;

class MemberController extends AuthController {
/*
 * 用户管理
 */
	public function member_list(){

		$key=I('key');
		$map['member_list_username'] = array('like',"%".$key."%");
		$map['member_list_email'] = array('like',"%".$key."%");
		$map['_logic'] = 'OR';
		/*
		 * 分页操作
		 */
		$count= M('member_list')->where($map)->count();// 查询满足要求的总记录数
		$Page= new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数
		$show= $Page->show();// 分页显示输出

		$member_list=D('Member_list')->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('member_list_addtime desc')->relation(true)->select();
		$this->assign('member_list',$member_list);
		$this->assign('page',$show);
		$this->assign('val',$key);
		$this->display();
	}
/*
 * 添加用户界面
 */
	public function member_list_add(){
		$province = M('province')->select();
		$this->assign('province',$province);
		$member_group=M('member_group')->order('member_group_order')->select();
		$this->assign('member_group',$member_group);
		$this->display();
	}

/*
 * 添加用户操作
 */
	public function member_list_runadd(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('member_list'),0);
		}else{
			$sl_data=array(
					'member_list_groupid'=>I('member_list_groupid'),
					'member_list_username'=>I('member_list_username'),
					'member_list_pwd'=>I('member_list_pwd'),
					'member_list_petname'=>I('member_list_petname'),
					'member_list_province'=>I('member_list_province'),
					'member_list_city'=>I('member_list_city'),
					'member_list_sex'=>I('member_list_sex'),
					'member_list_tel'=>I('member_list_tel'),
					'member_list_email'=>I('member_list_email'),
					'member_list_open'=>I('member_list_open'),
					'member_list_addtime'=>time(),
			);
			M('member_list')->add($sl_data);
			$this->success('会员添加成功，返回列表页进行头像操作',U('member_list'),1);
		}
	}

/*
 * 修改用户信息界面
 */
	public function member_list_edit(){
		$province = M('province')->select();
		$member_group=M('member_group')->order('member_group_order')->select();
		$member_list_edit=M('member_list')->where(array('member_list_id'=>I('member_list_id')))->find();
		$this->assign('member_list_edit',$member_list_edit);
		$this->assign('province',$province);
		$this->assign('member_group',$member_group);
		$this->display();
	}

	public function member_list_state(){
		$id=I('x');
		$status=M('member_list')->where(array('member_list_id'=>$id))->getField('member_list_open');//判断当前状态情况
		if($status==1){
			$statedata = array('member_list_open'=>0);
			$auth_group=M('member_list')->where(array('member_list_id'=>$id))->setField($statedata);
			$this->success('状态禁止',1,1);
		}else{
			$statedata = array('member_list_open'=>1);
			$auth_group=M('member_list')->where(array('member_list_id'=>$id))->setField($statedata);
			$this->success('状态开启',1,1);
		}
	}

	/*
	 * 修改用户操作
	 */
	public function member_list_runedit(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',U('member_list'),0);
		}else{

			$sl_data['member_list_id']=I('member_list_id');
			$sl_data['member_list_groupid']=I('member_list_groupid');
			$sl_data['member_list_username']=I('member_list_username');

			$pwd=I('member_list_pwd');
			if (empty($pwd)){
				$sl_data['member_list_pwd']=I('member_list_pwd','','md5');
			}


			$sl_data['member_list_petname']=I('member_list_petname');
			$sl_data['member_list_province']=I('member_list_province');
			$sl_data['member_list_city']=I('member_list_city');
			$sl_data['member_list_sex']=I('member_list_sex');
			$sl_data['member_list_tel']=I('member_list_tel');
			$sl_data['member_list_email']=I('member_list_email');
			$sl_data['member_list_open']=I('member_list_open');

			M('member_list')->save($sl_data);
			$this->success('会员修改成功，返回列表页进行头像操作',U('member_list'),1);
		}
	}

/*
 * 会员删除
 */
	public function member_list_del(){
		$p=I('p');
		M('active_register')->where(array('ar_userid'=>I('member_list_id')))->delete();
		M('class_register')->where(array('cr_userid'=>I('member_list_id')))->delete();
		M('save')->where(array('rs_userid'=>I('member_list_id')))->delete();
		M('member_list')->where(array('member_list_id'=>I('member_list_id')))->delete();//转入回收站
		$this->redirect('member_list', array('p' => $p));
	}

/*
 * 头像上传，目前不能用
 */
	public function member_list_userpic(){
		$member_list_id=I('member_list_id');
		$cm1=I('cm1');
		$member_list=M('member_list');
		$sl_date=array(
				'member_list_id'=>$member_list_id,
				'member_list_headpic'=>$cm1,
		);
		$member_list->save($sl_date);
	}

/************************************************会员组列表管理**************************************************/
/*
 *会员组显示列表
 */
	public function member_group(){
		$member_group=M('member_group');
		$member_group_list=$member_group->order('member_group_order')->select();
		$this->assign('member_group_list',$member_group_list);
		$this->display();
	}

/*
 * 会员组添加方法
 */
	public function member_group_runadd(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',0,0);
		}else{
			M('member_group')->add($_POST);
			$this->success('会员组添加成功',U('member_group'),1);
		}
	}

/*
 * 会员组删除
 */
	public function member_group_del(){
		$member_group_id=I('member_group_id');
		if (empty($member_group_id)){
			$this->error('会员组ID不存在',U('member_group'),0);
		}
		M('member_group')->where(array('member_group_id'=>I('member_group_id')))->delete();
		$this->redirect('member_group');
	}

/*
 * 改变会员组状态
 */
	public function member_group_state(){
		$member_group_id=I('x');
		if (!$member_group_id){
			$this->error($member_group_id,U('member_group'),0);
		}
		$status=M('member_group')->where(array('member_group_id'=>$member_group_id))->getField('member_group_open');//判断当前状态情况
		if($status==1){
			$statedata = array('member_group_open'=>0);
			M('member_group')->where(array('member_group_id'=>$member_group_id))->setField($statedata);
			$this->success('状态禁止',1,1);
		}else{
			$statedata = array('member_group_open'=>1);
			M('member_group')->where(array('member_group_id'=>$member_group_id))->setField($statedata);
			$this->success('状态开启',1,1);
		}
	}

/*
 * 排序更新
 */
	public function member_group_order(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',0,0);
		}else{
			$member_group=M('member_group');
			foreach ($_POST as $id => $sort){
				$member_group->where(array('member_group_id' => $id ))->setField('member_group_order' , $sort);
			}
			$this->success('排序更新成功',U('member_group'),1);
		}
	}

/*
 * 修改会员组返回值
 */
	public function member_group_edit(){
		$member_group_id=I('member_group_id');
		$member_group=M('member_group')->where(array('member_group_id'=>$member_group_id))->find();

		$sl_data['member_group_id']=$member_group['member_group_id'];
		$sl_data['member_group_name']=$member_group['member_group_name'];
		$sl_data['member_group_open']=$member_group['member_group_open'];
		$sl_data['member_group_toplimit']=$member_group['member_group_toplimit'];
		$sl_data['member_group_bomlimit']=$member_group['member_group_bomlimit'];
		$sl_data['member_group_order']=$member_group['member_group_order'];

		$sl_data['status']=1;
		$this->ajaxReturn($sl_data,'json');
	}

/*
 * 修改用户组方法
 */
	public function member_group_runedit(){
		if (!IS_AJAX){
			$this->error('提交方式不正确',0,0);
		}else{
			$sl_data=array(
					'member_group_id'=>I('member_group_id'),
					'member_group_name'=>I('member_group_name'),
					'member_group_toplimit'=>I('member_group_toplimit'),
					'member_group_bomlimit'=>I('member_group_bomlimit'),
					'member_group_order'=>I('member_group_order'),

			);
			M('member_group')->save($sl_data);
			$this->success('用户组修改成功',U('member_group'),1);
		}
	}








}