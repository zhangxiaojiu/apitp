<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 小九 < wtfree@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\wtfree\model\AnswerModel;
use app\wtfree\model\PaperModel;
use app\wtfree\model\QuestionModel;
use cmf\controller\AdminBaseController;

class ExamController extends AdminBaseController
{
    /*
     * 试卷列表
     */
    public function index()
    {
        $type = isset($_POST['type'])?$_POST['type']:'';
        $where = '1=1';
        if(!empty($type)) {
            $where = [
                'type' => $type,
            ];
        }
        $list = PaperModel::tb()->where($where)->paginate(20);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
    /*
     * 试卷信息
     */
    public function paperInfo(){
        $id = isset($_GET['id'])?$_GET['id']:0;
        $info = PaperModel::tb()->find($id);
        $list = AnswerModel::tb()->where(['paper_id'=>$id])->select();
        $this->assign('info',$info);
        $this->assign('list',$list);
        return $this->fetch();
    }

    /*
     *问题列表
     */
    public function questionList(){
        $type = isset($_POST['type'])?$_POST['type']:1;
        $list = QuestionModel::tb()->where('type',$type)->paginate(20);
        $this->assign('list',$list);
        $page = $list->render();
        $this->assign('list', $list);
        $this->assign('page', $page);
        return $this->fetch();
    }
    /*
     * 问题信息
     */
    public function questionInfo(){
        echo "qinfo";
    }
    /*
     * 处理问题信息
     */
    public function doQuestionInfo(){
        echo "doinfo";
    }


}