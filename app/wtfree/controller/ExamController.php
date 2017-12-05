<?php
/**
 * Created by PhpStorm.
 * User: jiu
 * Date: 2017/12/4
 * Time: 13:21
 */

namespace app\wtfree\controller;


use app\wtfree\model\AnswerModel;
use app\wtfree\model\PaperModel;
use app\wtfree\model\QuestionModel;
use cmf\controller\HomeBaseController;
use think\Db;

class ExamController extends HomeBaseController
{
    /*
     * 试卷页面
     */
    public function index()
    {
        $type = isset($_GET['type'])?$_GET['type']:1;
        $title = '欢迎来到调研答题系统';
        if($type == 1){
            $title = '产品调研问卷（消费者版）';
        }
        if($type == 2){
            $title = '产品调研问卷（商户版）';
        }
        $list = QuestionModel::tb()->where('paper_type',$type)->select();
        $this->assign('list',$list);
        $this->assign('type',$type);
        $this->assign('title',$title);
        return $this->fetch();
    }
    /*
     * 提交试卷
     */
    public function submitPaper(){
        if(empty($_POST['type'])){
            $this->error('参数错误');
        }
        if(empty($_POST['name']) || empty($_POST['tel'])){
            $this->error('请完善个人信息');
        }
        $data = [
            'type' => $_POST['type'],
            'title' => $_POST['title'],
            'name' => $_POST['name'],
            'tel' => $_POST['tel'],
            'weixin' => $_POST['weixin'],
            'create_time' => date('Y-m-d H:i:s'),
        ];
        Db::startTrans();
        if($id = PaperModel::tb()->insertGetId($data)){
            $answers = [];
            foreach ($_POST as $k=>$v){
                if(!empty($v)) {
                    if (strpos($k, 'q_') !== false) {
                        $questionId = explode('_', $k)[1];
                        $questionTitle = explode('_', $k)[2];
                        if(is_array($v)){
                            $answer = implode(',',$v);
                        }else{
                            $answer = $v;
                        }
                        $answers[$questionId]['paper_id'] = $id;
                        $answers[$questionId]['question_id'] = $questionId;
                        $answers[$questionId]['question_title'] = $questionTitle;
                        $answers[$questionId]['question_answer'] = $answer;
                        $answers[$questionId]['question_answer_remark'] = '';
                        $answers[$questionId]['right_answer'] = '';
                    }
                    if (strpos($k, 'qother_') !== false) {
                        $questionId = explode('_', $k)[1];
                        $answerTitle = explode('_', $k)[2];
                        if(empty($answers[$questionId]['question_answer_remark'])) {
                            $answers[$questionId]['question_answer_remark'] = $answerTitle . $v;
                        }else{
                            $answers[$questionId]['question_answer_remark'] .= ',' . $answerTitle . $v;
                        }
                    }
                }
            }
            if(!AnswerModel::tb()->insertAll($answers)){
                Db::rollback();
                $this->error('提交答案失败');
            }
        }
        Db::commit();
        $this->success('提交成功，感谢您的参与');
    }

    /*
     *问题列表
     */
    public function questionList(){
        echo "qlist";
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