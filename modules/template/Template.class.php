<?php
/**
 * Created by PhpStorm.
 * User: canto87
 * Date: 2014/06/12
 * Time: 16:55
 */

class Template {

	function convert($content)
	{
		$startpic = "<?php
		\$i=0;
		\$picdata = \$tpl->pic(\$_GET['cid'],\$start,\$board->op->pic_page,\$db->conn(),\$search,\$keyword,\$skin->op->pic_thumbnail_width);
		while(\$i<count(\$picdata))
		{
			\$pic = \$picdata[\$i]['pic'];
			\$picture = \$picdata[\$i]['picture'];
			\$i++;
		?>
		";
		$endpic ="<?php } ?>";
		$startcomment ="<?php
		\$j=0;
		\$commentdata = \$tpl->comment(\$_GET['cid'],\$pic->no,\$db->conn());
		while(\$j<count(\$commentdata))
		{
			\$comment = \$commentdata[\$j];
			\$j++;
		?>
		";
		$endcomment = "<?php } ?>";
		$patterns = array();
		$patterns[0] = '/<!--@START::PIC-->/';
		$patterns[1] = '/<!--@END::PIC-->/';
		$patterns[2] = '/{\$([a-zA-Z0-9\->]*)}/ui';
		$patterns[3] = '/<!--@START::COMMENT-->/';
		$patterns[4] = '/<!--@END::COMMENT-->/';
		$patterns[5] = '/<!--@PHP::START-->/';
		$patterns[6] = '/<!--@PHP::END-->/';
		$patterns[7] = '/<!--@if::\(([a-zA-Z0-9\->\(\)\$\&\|].*)\)-->/';
		$patterns[8] = '/<!--@else if::\(([a-zA-Z0-9\->\(\)\$\&\|].*)\)-->/';
		$patterns[9] = '/<!--@else-->/';
		$patterns[10] = '/<!--@if::end-->/';
		$replacements = array();
		$replacements[0] = $startpic;
		$replacements[1] = $endpic;
		$replacements[2] = "<?php echo \\$\\1;?>";
		$replacements[3] = $startcomment;
		$replacements[4] = $endcomment;
		$replacements[5] = "<?php ";
		$replacements[6] = "?>";
		$replacements[7] = "<?php if(\\$\\1){?>";
		$replacements[8] = "<?php }else if(\\$\\1){ ?>";
		$replacements[9] = "<?php }else{ ?>";
		$replacements[10] = "<?php } ?>";

		$content = preg_replace($patterns,$replacements,$content);
		return $content;
		
	}
	function pic($cid,$start,$end,$conn,$search,$keyword,$resize)
	{
		if($search == "name")$string = "SELECT `chibi_pic`.* FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`name`LIKE'".mysql_real_escape_string($keyword)."' AND  `chibi_comment`.`cid`='".mysql_real_escape_string($cid)."'  AND  `chibi_pic`.`cid` =  '".mysql_real_escape_string($cid)."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC LIMIT ".$start.",".$end;
		else if($search == "comment")$string = "SELECT `chibi_pic`.* FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`comment` LIKE '%".mysql_real_escape_string($keyword)."%' AND  `chibi_comment`.`cid` =  '".mysql_real_escape_string($cid)."'  AND  `chibi_pic`.`cid` =  '".mysql_real_escape_string($cid)."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC LIMIT ".$start.",".$end;
		else if($search == "memo")$string = "SELECT `chibi_pic`.* FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`memo` LIKE '%".mysql_real_escape_string($keyword)."%' AND  `chibi_comment`.`cid` =  '".mysql_real_escape_string($cid)."'  AND  `chibi_pic`.`cid` =  '".mysql_real_escape_string($cid)."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC LIMIT ".$start.",".$end;
		else if($search == "no")$string = "SELECT * FROM `chibi_pic` WHERE cid='".mysql_real_escape_string($cid)."' AND no='".mysql_real_escape_string($keyword)."'";
		else $string = "SELECT * FROM `chibi_pic` where `cid`='".mysql_real_escape_string($cid)."' ORDER BY `no` DESC LIMIT ".$start.",".$end;
		$query = mysql_query($string,$conn);
		$picdata = array();
		$i = 0;
		while($array = mysql_fetch_assoc($query))
		{
			//print_r($array);
			$pic = (object) $array;
			if(empty($pic->op)==false)
			{
				$pic->op = unserialize($pic->op);
				$pic->op = (object) $pic->op;
			}
			if($pic->type=="video")
			{// 유투브 동영상
				if(get_magic_quotes_gpc()) $pic->src = stripslashes($pic->src); /* magic_quotes_gpc가 off일경우 slashes설정 */
				preg_match('@src=\"([^\"]+)\"@',$pic->src,$src);
				preg_match('@width=\"([^\"]+)\"@',$pic->src,$width);
				preg_match('@height=\"([^\"]+)\"@',$pic->src,$height);
				$size[0] = $width[1];
				$size[1] = $height[1];
				$picture = "<iframe width=\"100%\" height=\"100%\" src=\"".$src[1]."\" style=\"max-width:".$size[0]."px;max-height:".$size[1]."px;\"frameborder=\"0\" allowfullscreen></iframe>";
			}
			else if($pic->type=="picture")
			{//그림 일 경우
				$size = GetImageSize($pic->src); // 그림 크기 취득
				if($resize>=$size[0]) $pic_size = $size[0];
				else $pic_size = $resize;
				$picture = "<img src=\"".$pic->src."\" id=\"".$pic->idx."\"style=\"width:100%;max-width:".$pic_size."px;\">"; //리사이즈

			}
			$picdata[$i]['pic'] = $pic;
			$picdata[$i]['picture'] = $picture;
			$i++;
		}
		return $picdata;

	}
	function comment($cid,$pic_no,$conn)
	{
		$sql = "SELECT * FROM `chibi_comment` WHERE `cid`='".mysql_real_escape_string($cid)."' AND `pic_no`='".mysql_real_escape_string($pic_no)."' ORDER BY `no` ASC , `children` ASC, `depth` ASC";
		$query = mysql_query($sql,$conn);
		$comment = array();
		$i = 0;
		while($array = mysql_fetch_assoc($query))
		{
			$comment[$i] = (object) $array;
			$i++;
		}
		return $comment;
	}
} 