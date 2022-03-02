<?php



function rmdirs( $dir, $level = 0)
{
	static $baseDir = false ;
	static $unsucceed = 0 ;
	static $succeed = 0 ;
	static $round = 1 ;
	
	$baseDir = $baseDir === false ? $dir : $baseDir;
	
	$dir = str_replace ("\\","/", $dir);
	$dir.="/";
	$dir = str_replace ("//","/", $dir);
	
	//print "----------------------------------------" .PHP_EOL;
	//print "** Checking in: " . $dir.PHP_EOL;
	$files = glob("{$dir}*") ;
	foreach ($files as $file)
	{
		if (!is_dir($file)) continue;
		$pure_filename = pathinfo($file)["basename"];
		$result = @rmdir($file) ;
		$unsucceed += $result ? 0 : 1 ;
		$succeed += !$result ? 0 : 1 ;
		$mark = $result ? "[F&D]" : "[F  ]";
		rmdirs($dir . $pure_filename , $level + 1 );
		print ("[R:{$round}/SUCC:$succeed/UNSUCC:$unsucceed] :: $mark ".$file.PHP_EOL);
	}
	
	if ($level === 0 )
	{
		if ($succeed>0)
		{
			$round++;
			rmdirs( $baseDir );
			return;
		}
		print "FINISHED.";
	}
	
}

rmdirs ("./");