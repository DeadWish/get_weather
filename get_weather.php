<?php

function get_weather($cityNumber){
	$weather = array(
	"00"=>"晴",
	"01"=>"多云",
	"02"=>"阴",
	"03"=>"阵雨",
	"04"=>"雷阵雨",
	"05"=>"雷阵雨伴有冰雹",
	"06"=>"雨夹雪",
	"07"=>"小雨",
	"08"=>"中雨",
	"09"=>"大雨",
	"10"=>"暴雨",
	"11"=>"大暴雨",
	"12"=>"特大暴雨",
	"13"=>"阵雪",
	"14"=>"小雪",
	"15"=>"中雪",
	"16"=>"大雪",
	"17"=>"暴雪",
	"18"=>"雾",
	"19"=>"冻雨",
	"20"=>"沙尘暴",
	"21"=>"小雨到中雨",
	"22"=>"中雨到大雨",
	"23"=>"大雨到暴雨",
	"24"=>"暴雨到大暴雨",
	"25"=>"大暴雨到特大暴雨",
	"26"=>"小雪到中雪",
	"27"=>"中雪到大雪",
	"28"=>"大雪到暴雪",
	"29"=>"浮尘",
	"30"=>"扬沙",
	"31"=>"强沙尘暴",
	"53"=>"霾");
	$ch = curl_init();
	$url = "http://m.weather.com.cn/mpub/hours/".$cityNumber.".html";
	curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
	$jsonData = curl_exec($ch);
	if ($jsonData) {
		$myfile = fopen($cityNumber.".txt","w") or die("Unable to open file!");
		$jh = json_decode($jsonData,true);
		if ($jh) {
			$jsonData = $jh["jh"];
			if ($jsonData) {
				$txt = substr($jsonData[0]["jf"], 0,8)." weather:'\n'";
				foreach ($jsonData as $hoursData) {
					$time = $hoursData["jf"];
					$year = substr($time, 0, 4);
					$mon = substr($time, 4, 2);
					$day = substr($time, 6, 2);
					$hours = substr($time, 8, 2);
					$min = substr($time, 10, 2);
					$timeString = $year.'.'.$mon.'.'.$day."->".$hours.':'.$min;
					$weatherString =$weather[$hoursData["ja"]];
					$temString = $hoursData["jb"];
					$txt = $txt.$timeString.' '.$weatherString.' '.$temString."'\n'";
				}
				fwrite($myfile, $txt);
			}
		}
	}
}
get_weather("101010100");
?>
