<?php
/**
 * 极光推送
 * @author 517909399@qq.com
 * @version 20121109
 */

class jpush {
	private $_username = '';
	private $_password = '';
	private $_appkeys = '';
	
	/**
	 * 构造函数
	 * @param string $username
	 * @param string $password
	 * @param string $appkeys
	 */
	function __construct($username = '', $password = '', $appkeys = '') {
		$this->_username = $username;
		$this->_password = $password;
		$this->_appkeys = $appkeys;
	}
	/**
	 * 模拟post进行url请求
	 * @param string $url
	 * @param string $param
	 */
	function request_post($url = '', $param = '') {
		if (empty($url) || empty($param)) {
			return false;
		}
		
		$postUrl = $url;
		$curlPost = $param;
		$ch = curl_init();//初始化curl
		curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		$data = curl_exec($ch);//运行curl
		curl_close($ch);
		
		return $data;
	}
	/**
	 * 发送
	 * @param int $sendno 发送编号。由开发者自己维护，标识一次发送请求
	 * @param int $receiver_type 接收者类型。1、指定的 IMEI。此时必须指定 appKeys。2、指定的 tag。3、指定的 alias。4、 对指定 appkey 的所有用户推送消息。
	 * @param string $receiver_value 发送范围值，与 receiver_type相对应。 1、IMEI只支持一个 2、tag 支持多个，使用 "," 间隔。 3、alias 支持多个，使用 "," 间隔。 4、不需要填
	 * @param int $msg_type 发送消息的类型：1、通知 2、自定义消息
	 * @param string $msg_content 发送消息的内容。 与 msg_type 相对应的值
	 * @param string $platform 目标用户终端手机的平台类型，如： android, ios 多个请使用逗号分隔
	 */
	function send($sendno = 0, $receiver_type = 1, $receiver_value = '', $msg_type = 1, $msg_content = '', $platform = 'android') {
		$url = 'http://api.jpush.cn:8800/sendmsg/sendmsg';
		$param = '';
				
		$username = $this->_username;
		$param .= 'username='.$username;
		
		$password = strtoupper(md5($this->_password));
		
		$param .= '&sendno='.$sendno;
		
		$appkeys = $this->_appkeys;		
		$param .= '&appkeys='.$appkeys;		
		
		$param .= '&receiver_type='.$receiver_type;	
			
		$param .= '&receiver_value='.$receiver_value;
		
		$verification_code = strtoupper(md5($username.$sendno.$receiver_type.$receiver_value.$password));		
		$param .= '&verification_code='.$verification_code;	
		
		$param .= '&msg_type='.$msg_type;		
		
		$param .= '&msg_content='.$msg_content;
		
		$param .= '&platform='.$platform;
				
		$res = $this->request_post($url, $param);	
		if ($res === false) {
			return false;
		}	
		$res_arr = json_decode($res, true);
		/*
		switch (intval($res_arr['errcode'])) {
			case 0:
				echo '调用成功';
				break;
			case 10:
				echo '系统内部错误';
				break;
			case 1001:
				echo '只支持 HTTP Post 方法，不支持 Get 方法';
				break;
			case 1002:
				echo '缺少了必须的参数';
				break;
			case 1003:
				echo '参数值不合法';
				break;
			case 1004:
				echo '验证失败';
				break;
			case 1005:
				echo '用户名或者密码错误';
				break;
			case 1006:
				echo '消息体太大';
				break;
			case 1007:
				echo 'IMEI不合法';
				break;
			case 1008:
				echo 'receiver_type = 1 时，必须填写 AppKey';
				break;
			case 1009:
				echo 'AppKey不合法';
				break;
			case 1010:
				echo 'msg_content 不合法';
				break;
			case 1011:
				echo '没有满足条件的推送目标';
				break;
			default:
				echo '调用成功';
				break;
		}
		*/
		return $res_arr;
	}
	
}

?>