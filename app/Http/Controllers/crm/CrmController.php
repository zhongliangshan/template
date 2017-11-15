<?php
namespace App\Http\Controllers\crm;

use App\Http\Controllers\ControllerBase;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\CrmLogic;
use Illuminate\Http\Request;

class CrmController extends ControllerBase
{
    private $users    = [];
    private $userInfo = null;
    private $crmLogic = null;
    public function __construct()
    {

        parent::__construct();
        $this->crmLogic = CrmLogic::getInstance();
        $this->users    = $this->crmLogic->getAllUserInfo();

        $this->userInfo = BaseLogic::getInstance()->getUser();
    }

    // home 首页
    public function index()
    {
        return view('index', [
            'title' => '网心工单系统',
        ]);
    }

    // 我创建的
    public function myCreate()
    {
        $filter = array_map('trim', [
            'start_time'    => \Input::get('start_time', date('Y-m-d 00:00')),
            'end_time'      => \Input::get('end_time'),
            'status'        => \Input::get('status'),
            'level'         => \Input::get('level'),
            'type'          => \Input::get('type'),
            'create_name'   => $this->userInfo['username'],
            'now_deal_name' => \Input::get('now_deal_name'),
            'search'        => \Input::get('search'),
            '',
        ]);

        $page = $this->crmLogic->getMyCreate($filter);
        return view('crm/my_create', [
            'title'      => '我创建的工单',
            'requireJs'  => 'crm/index',
            'breadcrumb' => ['我创建的工单'],
            'types'      => $this->crmLogic->get('types'),
            'users'      => $this->users,
            'levels'     => $this->crmLogic->get('levels'),
            'status'     => $this->crmLogic->get('status'),
            'page'       => $page,
        ]);
    }

    public function createCrm(Request $req)
    {
        if ($req->isMethod('post')) {
            return response()->json($this->crmLogic->addCrm($req->input(), $this->userInfo['username']));
        }

        return view('crm/create_crm', [
            'types'   => $this->crmLogic->get('types'),
            'users'   => $this->users,
            'levels'  => $this->crmLogic->get('levels'),
            'modules' => $this->crmLogic->getModelInfo(),
        ]);
    }

    // 需要我处理的
    public function myWaitHandle()
    {

    }

    // 已经处理的
    public function myHandled()
    {

    }

    // 需要我关注的
    public function myCare()
    {

    }

    public function upload(Request $req)
    {
        if ($req->isMethod('post')) {
            $file = $req->file('upload');
            //判断文件是否上传成功
            if ($file->isValid()) {
                //获取原文件名
                $originalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //文件类型
                $type = $file->getClientMimeType();
                //临时绝对路径
                $realPath = $file->getRealPath();

                $filename = date('Y-m-d-H-i-S') . '-' . uniqid() . '.' . $ext;
                $bool     = \Storage::disk('uploads')->put($filename, file_get_contents($realPath));

                if (true == $bool) {
                    $msg = "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(" . $req->input('CKEditorFuncNum') . ", '" . env('APP_URL') . "/uploads/" . $filename . "', '');</script>";
                } else {
                    $msg = "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(" . $req->input('CKEditorFuncNum') . ", '" . env('APP_URL') . "/uploads/" . $filename . "', '文件上传失败');</script>";
                }

                echo $msg;
            }

        }
    }
}
