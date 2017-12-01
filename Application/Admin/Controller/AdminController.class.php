<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Builder\AdminListBuilder;
use Admin\Builder\AdminConfigBuilder;
class AdminController extends Controller{
    public function _initialize(){ //权限检测
        $account = $_SESSION['account'];
        if(empty($account)){
            $url = U("Index/index");
            header("Location: $url");
        }
    }

    public  function  admin(){
        $builder = new AdminListBuilder();
        $builder->display("index");
    }

	public function index($r = 50){
		$model = D("Admin/AdminMenu");
		$builder = new AdminListBuilder();
		$data = $model->getFirstMenuList();
		$builder
			->title("菜单管理")
			->newButton(U("Admin/addMenu"))
			->keyLink('title','标题',"nextMenu?id=###")
			->keyText('p_title','所属目录')
			->keyText('url','连接')
			->keyText('sort','排序')
			->keyStatus('hide','是否隐藏',array("0"=>'未隐藏',"1"=>"隐藏"))
			->keyDoAction("editMenu?id=###")
			->data($data)
			->display();
	}
	
	public function addMenu(){
		$model = D("Admin/AdminMenu");
		if(IS_POST){

			$data  = 
				array(
					"title" =>I("post.title"),
					"url"	=>I("post.url"),
					"hide"	=>I("post.hide",0,"intval"),
					"p_id"	=>I("post.p_id",0,"intval"),
					"sort"	=>I("post.sort",1,"intval")
				);
			if($model->create($data,1)){
				$ret = $model->addMenu($data);
				if($ret){
					$this->success("成功",U("index"));
				}
			}
		}else{
			$builder = new AdminConfigBuilder();
			$pidList = $model->getFirstMenuConfig();
			$pidList = i_array_column($pidList,'title','id');
			$builder
				->title("新增菜单")
				->keySelect("p_id","所属目录","",$pidList)
				->keyText("title","标题")
				->keyText('url','菜单连接','',array("placeholder"=>"一级目录无需连接"))
				->keyText("sort","排序")
				->keySelect('hide','是否隐藏',"",array("0"=>"不隐藏","1"=>"隐藏"))
				->buttonSubmit(U("Admin/addMenu"))
				->display();
		}
	}


   function getSearch($word =244555){
        $map['A.anchor_id'] = $word;
        $map['_logic'] = 'OR';
        $map['B.username'] = array('like','%'.$word.'%');
        $mnap['A.family_id']=$word;
        $mnap['_logic']='AND';
        $data = M()->table('mc_anchor_info as A')
            ->join('mc_user as B on A.user_id = B.id')
            ->join('mc_anchor_level as C on A.exp >= C.exp_start and A.exp < C.exp_end')
            ->where($map)
            ->field('A.`anchor_id`,A.`port`,B.`username`,A.`anchor_img`,B.`sex`,B.`sign`,A.`follow_user`,C.`level`,A.`k_status`,A.`k_type`')
            ->limit(100)
            ->select();
        print_r(M()->getLastSql());
        return $data;
    }
	//查看下一级目录
	public function nextMenu(){
		$id = I("get.id");
		$model = D("Admin/AdminMenu");
		$builder = new AdminListBuilder();
		$data = $model->getNextMenuList($id);
		$builder
			->title("菜单管理")
			->newButton(U("Admin/addMenu"))
			->keyText('title','标题')
			->keyText('p_title','所属目录')
			->keyText('url','连接')
			->keyText("sort","排序")
			->keyStatus('hide','是否隐藏',array("0"=>'未隐藏',"1"=>"隐藏"))
			->keyDoAction("editMenu?id=###")
			->data($data)
			->display();

	}

	public function editMenu(){
		$model = D("Admin/AdminMenu");
		if(IS_POST){
			$data = array(
					"title" =>I("post.title"),
					"url"	=>I("post.url"),
					"hide"	=>I("post.hide",0,"intval"),
					"p_id"	=>I("post.p_id",0,"intval"),
					"sort"	=>I("post.sort",1,"intval")
				);
				$id = I("post.id");
				$ret = $model->saveMenu($data,$id);
				if($ret){
					$this->success("成功",U("index"));
				}else{
					$this->error($model->getError());
				}
		}else{
			$builder = new AdminConfigBuilder();
			$pidList = $model->getFirstMenuConfig();
			$id = I("get.id");
			$pidList = i_array_column($pidList,'title','id');
			list($data) = $model->getMenuInfo($id);
			$builder
				->title("新增菜单")
				->keyHidden("id")
				->keySelect("p_id","所属目录","",$pidList)
				->keyText("title","标题")
				->keyText('url','菜单连接','',array("placeholder"=>"一级目录无需连接"))
				->keyText("sort","排序")
				->keySelect('hide','是否隐藏',"",array("0"=>"不隐藏","1"=>"隐藏"))
				->buttonSubmit(U("Admin/editMenu"))
				->data($data)
				->display();
		}
	}

	//删除
	public function deleteMenu($ids){

	}

	public  function account(){
        $builder = new AdminListBuilder();
        $model  = D("account");
        $data = $model->getAccountInfo($_SESSION["level"]);
        $builder
                ->title("后台账号管理")
                ->newButton(U("addAccount"))
                ->keyText("account","账号")
                ->keyText("level","权限等级")
                ->keyText("status","账户状态")
                ->keyDoAction("setPower?id=###","权限设置")
                ->keyDoAction("setLoginOff?id=###","禁止登录")
                ->keyDoAction("setLoginOn?id=###","允许登录")
                ->data($data)
                ->display();
    }

    public  function  setLoginOff(){
        $id = I("get.id");
        M("account")->where(array("id"=>$id))->save(array("status"=>"0"));
        $this->success("修改成功",U("account"));
    }
    public  function  setLoginOn(){
        $id = I("get.id");
        M("account")->where(array("id"=>$id))->save(array("status"=>"1"));
        $this->success("修改成功",U("account"));
    }

    public  function  setPower(){
        if($_POST){
           $id = I("post.account_id");
            S("menus".$id,NULL); //清空账户的权限缓存
            S("menuChildrens".$id,NULL);
            S("menuPower".$id,NULL);
            M("power")->where(array("account_id"=>$id))->delete();
           $one = I("post.one");
           $oneData = array();
           foreach ($one as $key =>$item){
               $oneData[] = array("account_id"=>$id,"menu_id"=>$item,"add"=>1,"remove"=>1,"edit"=>1,"query"=>"1","export"=>1,"verify"=>1,"level"=>1);
           }
           $ret = M("power")->addAll($oneData);
           $three = I("post.three");
           $threeData = array();
           foreach ($three as $key =>$item){
               $add = $item['add'][0]==1?$item['add'][0]:0;
               $remove = $item['remove'][0]==1?$item['remove'][0]:0;
               $edit = $item['edit'][0]==1?$item['edit'][0]:0;
               $query = $item['query'][0]==1?$item['query'][0]:0;
               $excel = $item['excel'][0]==1?$item['excel'][0]:0;
               $verify = $item['verify'][0]==1?$item['verify'][0]:0;
               $threeData[] = array("account_id"=>$id,"menu_id"=>$key,"add"=>$add,"remove"=>$remove,"edit"=>$edit,"query"=>$query,"export"=>$excel,"verify"=>$verify,"level"=>2);
           }
            $ret2 = M("power")->addAll($threeData);
            if($ret && $ret2){
                $this->success("设置成功",U("account"));
            }else{
                $this->error("设置失败,请重新设置",U("setPower",array("id"=>$id)));
            }
        }else{
            $builider = new AdminListBuilder();
            $model  = D("account");
            $data = $model->setPower($_SESSION["level"]);
            $builider
                ->otherData($data)
                ->display("power")  ;
        }
    }

    public  function  addAccount(){
        if(IS_POST){
            $data = array(
                "account"=>I("post.account"),
                "password"=>I("post.password"),
                "level"   =>I("post.level")
            );
            if ($data["level"] =="-100000000"){
                $this->error("权限不正确 ,请刷新页面后重试");
            }
            $model = D("account");
            if($model->create()){
                $ret =  D("account")->add($data);
                if($ret){
                    $this->success("添加成功",U("account"));
                }else{
                    $this->error($model->getError());
                }
            }else{
                $this->error($model->getError());
            }
        }else{
            $builder = new AdminConfigBuilder();
            $builder->title("添加后台账号")
                ->keyText("account","账号")
                ->keyText("password","密码")
               ->keyRadio("level","权限","",array("checked"=>array("1"=>"管理员")))
                ->buttonSubmit()
                ->display();
        }
    }
}	
?>