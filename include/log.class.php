 <?php 
   header("Content-Type: text/html; charset=utf-8");
   /*
	file log.class.php
	作用:记录信息到日志
   */

	/*
	给定内容写入文件
	如果文件大于1M,另写一份

	传给我一个内容
		判断当前日志大小,如果>1M,备份
		否则写入
	*/

	class Log{

		const LOGFILE = 'curr.log';   //类里面定义常量用const

		//写日志
		public static function write($str){
			$str .= "\r\n";
			//判断是否备份
			$log = self::isBack();  //计算出日志文件的地址
			$fh = fopen($log, 'ab');
			fwrite($fh, $str);
			fclose($fh);
		} 

		//备份日志
		public static function back(){
			//把原来的日志文件改名后存储
			//改成 年-月-日.bak 的形式
			$log = ROOT . 'data/log/' . self::LOGFILE;
			$newname = ROOT . 'data/log/' . date('ymdhi'). mt_rand(1000,9999) .'.bak';
			return rename($log, $newname);
		}

		//读取并判断日志大小
		public static function isBack(){
			$log = ROOT . 'data/log/' . self::LOGFILE;
			if (!file_exists($log)) {  //如果文件不存在,则创建该文件
				touch($log);  //快速建立一个文件
				return $log;
			}
			//清除缓存
			clearstatcache(true,$log);
			//要是存在,则判断大小
			$size = filesize($log);
			if ($size <= 1024*1024) {  //小于1M
				return $log;
			}
			//文件大于1M,备份
			if(!self::back()){
				return $log;
			}else{
				touch($log);
				return $log;
			}
		}
	}

?>