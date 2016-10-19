<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Email;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    //发送邮件
    public function write()
    {
        if ($input = Input::all()) {
            $rules = [
                'mail_title'=>'required', //验证规则
                'mail_content'=>'required', //验证规则
                'mail_toaddr'=>'required', //验证规则
            ];
            $message = [
                //验证不成功的返回提示
                'mail_title.required'=>'邮件标题不能为空！',
                'mail_content.required'=>'邮件内容不能为空！',
                'mail_toaddr.required'=>'收件人不能为空！',
            ];
            $validator = Validator::make($input,$rules,$message);
            if ($validator->passes()) {
                //查找并判断收件人地址是否正确
                $user = User::where('user_mail', $input['mail_toaddr'])->count();
                if ($user == 1) {
                    //如果没有上传附件就没有附件地址
                    if ($input['mail_filename'] != null) {
                        $input['mail_filepath'] = 'uploads/' . $input['mail_filename'];
                    }
                    //如果没写发件人，默认发件人名称
                    if ($input['mail_formname'] == "") {
                        $input['mail_formname'] = session('name');
                    }
                    $input['mail_status'] = 0; //邮件状态为发送未读
                    $input['mail_date'] = time();
                    $input['mail_formaddr'] = session('mail');
                    $rst = Email::create($input);
                    if ($rst) {
                        return redirect('Admin/email/sent');
                    } else {
                        return back()->with('errors', '发送失败，请稍后重试');
                    }
                } else {
                    return back()->with('errors', '收件人错误，请重新填写');
                }
            } else {
                return back()->withErrors($validator);
            }
        } else {
            return view('Admin.email.add');
        }


    }

    //发件箱
    public function sent()
    {
        $mail = session('mail');
        $data = Email::where('mail_formaddr',"$mail")->whereIn('mail_status',[0,1,3])->orderBy('mail_date','desc')->paginate(10);
        return view('Admin.email.sent',compact('data'));
    }

    //收件箱
    public function read()
    {
        $mail = session('mail');
        $data = Email::where('mail_toaddr',"$mail")->whereIn('mail_status',[0,1,2])->orderBy('mail_date','desc')->paginate(10);
        return view('Admin.email.read',compact('data'));
    }

    //删除邮件
    public function del($id)
    {
        $rst = Email::where('mail_id',$id)->update('mail_status',2);
        if ($rst) {
            $data = [
                'status' => 0,
                'msg' => '删除成功'
            ];
        } else {
            $data = [
                'status' => 1,
                'msg' => '删除失败'
            ];
        }
        return $data;
    }

    //查看邮件
    public function show($id)
    {
        $data = Email::find($id);
        //dd($data->mail_filename);
        if ($data->mail_toaddr == session('mail')) {
            Email::where('mail_id',$id)->update(['mail_status'=>'1']);
        }
        return view('admin.email.show',compact(['data']));
    }

    //修改邮件
    public function edit($id)
    {
        $data = Email::find($id);
        return view('admin.email.edit',compact(['data']));
    }

    //下载附件
    public function download($id){
        #查询操作
        $data = Email::find($id);
        #下载
        $file = $data->mail_filepath;
        header("Content-type: application/octet-stream");
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header("Content-Length: ". filesize($file));
        readfile($file);
    }

//    //草稿箱
//    public function draft()
//    {
//        $mail = session('mail');
//        $data = Email::where(['mail_status'=>'4','mail_formaddr'=>"$mail"])->orderBy('mail_date','desc')->paginate(10);
//        return view('Admin.email.draft',compact('data'));
//    }

    //上传附件
    public function upload()
    {
        $file = Input::file('Filedata');
        if ($file->isValid()) {
            $entension = $file->getClientOriginalExtension(); //上传文件的后缀.
            $newName = date('YmdHis') . mt_rand(100, 999) . '.' . $entension;
            $path = $file->move(base_path() . '/uploads', $newName);
            $filepath = $newName;
            return $filepath;
        }
    }
}
