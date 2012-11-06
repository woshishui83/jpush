<?php
/**
 * 本代码推送给android系统测试通过，ios没有测试
 * @author 517909399@qq.com
 */

include('jpush.php');

$username = '';
$password = '';
$appkeys = '';

$sendno = 4;
$receiver_value = '';		
$msg_content = json_encode(array('n_builder_id'=>0, 'n_title'=>'', 'n_content'=>'hello friend2222!'));
$platform = 'android';

$obj = new jpush($username, $password, $appkeys);
$res = $obj->send($sendno, 3, $receiver_value, 1, $msg_content, $platform);
print_r($res);
exit();