<?php
/**
 * Created by PhpStorm.
 * User: fems-quan
 * Date: 2018/07/22
 * Time: 21:31
 */
include_once("PHPMailer.php");
include_once("SMTP.php");
function spamCheck($field)
{
    // filter_var() 过滤 e-mail
    // 使用 FILTER_SANITIZE_EMAIL
    $field=filter_var($field,FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL))
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

if (isset($_REQUEST['email']))
{
    // 如果接收到邮箱参数则发送邮件

    // 判断邮箱是否合法
    $mailCheck = spamCheck($_REQUEST['email']);
    if ($mailCheck==FALSE)
    {
        echo "非法输入";
    }
    else
    {
         //发送邮件
        $from="13844238586@163.com";//发件邮箱地址
        $to="240351123@qq.com";//接收者邮件地址
        $fromEmail = $_REQUEST['email'] ;//发送者邮件地址
        $eName = $_REQUEST['eName'] ;//发送者姓名
        $message = $_REQUEST['message'] ;//邮件内容


        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host="smtp.163.com";//发件人使用的smtp服务地址
        $mail->SMTPAuth=true;
        $mail->Username=$from;//发件人邮箱地址
        $mail->Password="127001smtp";//发件人密码
        $mail->CharSet = 'UTF-8';

        $mail->setFrom($from,$eName);//发件人地址和姓名
        $mail->addAddress($to,"郑传权");//收件人地址和姓名
        $mail->addReplyTo($from,"郑传权");//回复发件人

        $mail->Subject="来自我的博客";//标题
        $mail->Body=$message."我的Email地址是：".$fromEmail;//邮件内容

        if(!$mail->send()){
            echo "发送失败！";
            echo "error:".$mail->ErrorInfo;
        }else{
            echo "发送成功！";
        }
        echo'<meta http-equiv="refresh" content="3;url=\'index.html\'">';
        echo "正在加载，请稍等...<br>三秒后自动跳转";
    }
}