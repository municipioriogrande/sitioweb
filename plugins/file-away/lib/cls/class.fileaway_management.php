<?php
defined('fileaway') or die('Water, water everywhere, but not a drop to drink.');
if(!class_exists('fileaway_management'))
{
	class fileaway_management
	{
		public $pathoptions;
		public $settings;
		public function __construct()
		{
			$define = new fileaway_definitions;
			$this->pathoptions = $define->pathoptions;
			$this->settings = get_option('fileaway_options');
			if(is_admin())
			{
				add_action('wp_ajax_fileaway-manager', array($this, 'manager'));
				add_action('wp_ajax_nopriv_fileaway-manager', array($this, 'manager'));
			}
		}
		public function manager()
		{
			$dm = 'Go directly to jail. Do not pass GO. Do not collect $200 dollars.';
			if(!wp_verify_nonce($_POST['nonce'], 'fileaway-nonce')) die($dm);
			$li = is_user_logged_in();
			extract($this->pathoptions);
			$action = $_POST['act'];
			// Flightbox
			if($action === 'flightbox')
			{
				if(!wp_verify_nonce($_POST['flightbox_nonce'], 'fileaway-flightbox-nonce')) die($dm);
				list($url, $query) = explode('?boxtype=', $_POST['url']);
				$src = $url;
				$query = 'boxtype='.$query;
				parse_str($query);
				if(($s2 == 'true' || $s2 == 'skip') && $g == 'false')
				{
					$s2skip = $s2 == 'skip' ? '&s2member_skip_confirmation' : '';
					$init = fileaway_utility::replacefirst($url, rtrim($this->settings['baseurl'],'/').'/', $rootpath);
					$sub = fileaway_utility::replacefirst($init, WP_PLUGIN_DIR.'/s2member-files/', '');
					$url = rtrim($this->settings['baseurl'],'/').'/?s2member_file_download='.$sub.$s2skip;
				}
				$url = $g == 'true' ? $this->settings['redirect'] : $url;
				$statstatus = $s == 'true' ? ' data-stat="true"' : ' data-stat="false"';
				$linktype = $g == 'true' || $GLOBALS['is_IE'] || $GLOBALS['is_safari'] ? 'target="_blank"' : 'download';
				$uid = (string)$_POST['uid'];
				$icons = (string)$_POST['icons'];
				$next = stripslashes($_POST['next']);
				$prev = stripslashes($_POST['prev']);
				$current = stripslashes($_POST['current']);
				$nolinks = $_POST['nolinks'] == 'true' ? true : false;
				$wh = $_POST['wh'];
				$ww = $_POST['ww'];
				if($wh > 1000)
				{ 
					$font = 20;
					$bar = 40;
					$mrg = 20;
				}
				elseif($wh > 800)
				{ 
					$font = 16;
					$bar = 32;
					$mrg = 16;
				}
				elseif($wh > 600)
				{ 
					$font = 14;
					$bar = 28;
					$mrg = 14;
				}
				elseif($wh > 400)
				{
					$font = 12;
					$bar = 24;
					$mrg = 12;
				}
				else
				{ 
					$font = 8;
					$bar = 20;
					$mrg = 8;
				}
				if($boxtype == 'image')
				{
					if($wh < ($mh+150)) $mh = ($wh-150);
					if($ww < $mw) $mw = ($ww-150);
					if($d == 'width')
					{ 
						$ratio = $w / $h;
						$width = $w < $mw ? $w : $mw;
						$height = round($width / $ratio, 0);
						if($height > $mh) $d = 'height';
					}
					if($d == 'height')
					{ 
						$ratio = $h / $w;
						$height = $h < $mh ? $h : $mh;
						$width = round($height / $ratio, 0);
					}
					if($width < 200)
					{
						$offset = ($ww-230) / 2;	
						$cwidth = 200+30;
						$cheight = ($height+$bar+30);
					}
					else
					{
						$offset = ($ww-($width+30)) / 2;	
						$cwidth = $width+30; 
						$cheight = ($height+$bar+30);
					}
					$csize = 'width:'.$cwidth.'px; height:'.$cheight.'px;';
					$isize = 'width:'.$width.'px; height:'.$height.'px;';
					$top = $wh < ($height+$bar+30) ? '0' : ($wh-($height+$bar+30)) / 2;
					$download_link = $nolinks 
						?	null 
						:	'<a href="'.$url.'" class="ssfa-flightbox-download" '.$linktype.$statstatus.'>'.
								'<span class="ssfa-icon-arrow-down-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
							'</a>';
					$response = array(
						'html' =>
							'<div id="ssfa-flightbox" class="'.$_POST['theme'].'" style="display:inline-block; '.$csize.' left:'.$offset.'px; top:'.$top.'px; padding:0px!important;">'.
								'<div id="ssfa-flightbox-inner" style="opacity:0; margin: 15px 15px 0!important;">'.
									'<a href="'.$_POST['nexturl'].'" onclick="'.$next.'"><img src="'.$src.'" style="'.$isize.'"></a>'.
								'</div>'.
								'<div class="ssfa-flightbox-controls '.$icons.'" style="margin:'.$mrg.'px 15px!important; display:block; text-align:right;">'.
									'<a href="'.$_POST['prevurl'].'" onclick="'.$prev.'">'.
										'<span class="ssfa-icon-arrow-left-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="'.$_POST['nexturl'].'" onclick="'.$next.'">'.
										'<span class="ssfa-icon-arrow-right-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									$download_link.
									'<a href="javascript:" onclick="Xflightbox();">'.
										'<span class="ssfa-icon-console-2" style="font-size:'.$font.'px; margin-right:0; display:inline-block;"></span>'.
									'</a>'.
								'</div>'.
							'</div>',
						'width' => $cwidth.'px',
						'height' => $cheight.'px',
						'top' => $top.'px',
						'offset' => $offset.'px',
						'iframe' => 'false',
					);
				}
				elseif($boxtype == 'video')
				{	
					$is_iframe = 'true';
					$ratio = 1920 / 1080;
					$height = round($w / $ratio, 0);
					if($wh < ($height+150))
					{ 
						$height = ($wh-150);
						$w = round($height * $ratio, 0);
					}
					$csize = 'width:'.($w+30).'px; height:'.($height+$bar+30).'px;';
					$top = $wh < ($height+$bar+30) ? '0' : ($wh-($height+$bar+30)) / 2;
					$offset = ($ww-($w+30)) / 2;
					if($e == 'vmeo')
					{
						$download = null;
						$vimeo = explode('vimeo.com/', $src);
						$vid_id = $vimeo[1];
						$video = 
							'<iframe src="//player.vimeo.com/video/'.$vid_id.'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;autoplay=0" '.
							'width="'.$w.'" height="'.$height.'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
					}
					elseif($e == 'tube')
					{
						$download = null;
						if(stripos($src, 'youtu.be/') !== false)
						{
							$youtube = explode('youtu.be/', $src);
							$yt = explode('?', $youtube[1]);
							$vid_id = $yt[0];				
						}
						else
						{
							$youtube = explode('?', $src);
							parse_str($youtube[1], $yt);
							$vid_id = $yt['v'];
						}
						$video = '<iframe width="'.$w.'" height="'.$height.'" src="//www.youtube.com/embed/'.$vid_id.'?rel=0" frameborder="0" allowfullscreen></iframe>';
					}
					elseif($e == 'flv')
					{
						$is_iframe = 'false';
						$download = $nolinks ? null :
							'<a href="'.$url.'" class="ssfa-flightbox-download" '.$linktype.$statstatus.'>'.
								'<span class="ssfa-icon-arrow-down-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
							'</a>';
						$video = 
							'<object type="application/x-shockwave-flash" data="'.fileaway_url.'/lib/swf/player_flv_maxi.swf" width="'.$w.'" height="'.$height.'">'.
								'<param name="movie" value="'.fileaway_url.'/lib/swf/player_flv_maxi.swf" />'.
								'<param name="allowFullScreen" value="true" />'.
								'<param name="FlashVars" '.
									'value="flv='.$src.
									'&amp;margin=0'.
									'&amp;bgcolor=000000&'.
									'amp;bgcolor1=000000'.
									'&amp;bgcolor2=000000'.
									'&amp;showstop=1'.
									'&amp;showvolume=1'.					
									'&amp;showtime=1'.
									'&amp;showfullscreen=1'.
									'&amp;buttonovercolor=ffffff'.
									'&amp;sliderovercolor=ffffff'.
									'&amp;showiconplay=1'.
									'&amp;showmouse=autohide" '.
								'/>'.
							'</object>';
					}
					else
					{
						$is_iframe = 'false';
						$download = $nolinks ? null :
							'<a href="'.$url.'" class="ssfa-flightbox-download" '.$linktype.$statstatus.'>'.
								'<span class="ssfa-icon-arrow-down-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
							'</a>';
						$video = 	
							fileaway_utility::video(array(
								'src'=>$src,
								'height' => $height, 
								'width' => $w, 
								'class' => 'ssfa-flightbox-video-player', 
								'preload' => 'none',
								'id' => uniqid('flightbox-video-')
							));
					}
					$response = array(
						'html' => 
							'<div id="ssfa-flightbox" class="'.$_POST['theme'].'" style="display:inline-block; '.$csize.' left:'.$offset.'px; top:'.$top.'px; padding:0!important;">'.
								'<div id="ssfa-flightbox-inner" style="opacity:0; margin: 15px 15px 0!important;">'.$video.'</div>'.
								'<div class="ssfa-flightbox-controls '.$icons.'" style="margin:'.$mrg.'px 15px!important; display:block; text-align:right;">'.
									'<a href="'.$_POST['prevurl'].'" onclick="'.$prev.'">'.
										'<span class="ssfa-icon-arrow-left-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="'.$_POST['nexturl'].'" onclick="'.$next.'">'.
										'<span class="ssfa-icon-arrow-right-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									$download.
									'<a href="javascript:" onclick="Xflightbox();">'.
										'<span class="ssfa-icon-console-2" style="font-size:'.$font.'px; margin-right:0; display:inline-block;"></span>'.
									'</a>'.
								'</div>'.
							'</div>',
						'width' => ($w+30).'px',
						'height' => ($height+$bar+30).'px',
						'top' => $top.'px',
						'offset' => $offset.'px',
						'iframe' => $is_iframe,
						'iwidth' => $w,
						'iheight' => $height,
					);
				}
				elseif($boxtype == 'pdf')
				{
					$of = $wh < 720 ? 100 : ($wh < 400 ? 50 : 200);
					if($r == 'tall')
					{
						$ratio = 22 / 17;
						$height = ($wh-$of);
						$width = round($height / $ratio, 0);
						$rotate = 'expand';
						$current = str_replace('&r=tall', '&r=wide', $current);
						$currenturl = str_replace('&r=tall', '&r=wide', $_POST['currenturl']);
					}
					else
					{
						$ratio = 22 / (17/1.5);
						$height = ($wh-$of);
						$width = round($height * $ratio, 0);
						while($width > ($ww-$of)) $width = $width-10;
						$rotate = 'contract';
						$current = str_replace('&r=wide', '&r=tall', $current);
						$currenturl = str_replace('&r=wide', '&r=tall', $_POST['currenturl']);
					}
					if($width < 200) $width = 200;
					$csize = 'width:'.($width+30).'px; height:'.($height+$bar+30).'px;';
					$top = $wh < ($height+$bar+30) ? '0' : ($wh-($height+$bar+30)) / 2;
					$offset = ($ww-($width+30)) / 2;
					$download_link = $nolinks ? null :
						'<a href="'.$url.'" class="ssfa-flightbox-download" '.$linktype.$statstatus.'>'.
							'<span class="ssfa-icon-arrow-down-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
						'</a>';
					$response = array(
						'html' => 
							'<div id="ssfa-flightbox" class="'.$_POST['theme'].'" style="display:inline-block; '.$csize.' left:'.$offset.'px; top:'.$top.'px; padding:0!important;">'.
								'<div id="ssfa-flightbox-inner" style="opacity:0; margin: 15px 15px 0!important;">'.
									'<iframe src="'.$src.'" frameborder=0 height="'.$height.'" width="'.$width.'" name="'.fileaway_utility::basename($src).'" scrolling="no" seamless>'.
										'Your browser does not support iframes.'.
									'</iframe>'.
								'</div>'.
								'<div class="ssfa-flightbox-controls '.$icons.'" style="margin:'.$mrg.'px 15px!important; display:block; text-align:right;">'.
									'<a href="'.$_POST['prevurl'].'" onclick="'.$prev.'">'.
										'<span class="ssfa-icon-arrow-left-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="'.$_POST['nexturl'].'" onclick="'.$next.'">'.
										'<span class="ssfa-icon-arrow-right-2" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									'<a href="'.$currenturl.'" onclick="'.$current.'">'.
										'<span class="ssfa-icon-'.$rotate.'" style="font-size:'.$font.'px; margin-right:5px; display:inline-block;"></span>'.
									'</a>'.
									$download_link.
									'<a href="javascript:" onclick="Xflightbox();">'.
										'<span class="ssfa-icon-console-2" style="font-size:'.$font.'px; margin-right:0; display:inline-block;"></span>'.
									'</a>'.
								'</div>'.
							'</div>',
						'width' => ($width+30).'px',
						'height' => ($height+$bar+30).'px',
						'top' => $top.'px',
						'offset' => $offset.'px',
						'iframe' => 'true',
						'iwidth' => $width,
						'iheight' => $height,
					);					
				}
			}
			// Create Sub-Directory
			elseif($action === 'createdir')
			{
				if(!$li) die($dm);
				if(!wp_verify_nonce($_POST['manager_nonce'], 'fileaway-manager-nonce')) die($dm);
				$parents = stripslashes(trim(str_replace('..', '', $_POST['parents']), '/'));
				$newsub = stripslashes(trim(str_replace('..', '', $_POST['newsub']), '/'));
				$uid = $_POST['uid']; 
				$count = $_POST['count']; 
				$page = $_POST['pg']; 
				$querystring = ltrim($_POST['querystring'], '?');
				$drawericon = $_POST['drawer'];
				$drawerid = $_POST['drawerid'];
				$cells = $_POST['cells']; 
				$class = $_POST['cls'];
				$base = $_POST['base']; 
				$subs = explode('/', $newsub); 
				$first = $subs[0]; 
				$last = $subs[count($subs)-1];
				$start = trim(fileaway_utility::replacefirst($parents, $base, '').'/'.$first, '/'); 
				$drawer = str_replace('/','*',$start);
				$final = $rootpath.$parents.'/'.$newsub; 
				$prettyfolder = str_replace(array('~', '--', '_', '.', '*'), ' ', "$first"); 
				$prettyfolder = preg_replace('/(?<=\D)-(?=\D)/', ' ', "$prettyfolder"); 
				$prettyfolder = preg_replace('/(?<=\D)-(?=\d)/', ' ', "$prettyfolder");
				$prettyfolder = preg_replace('/(?<=\d)-(?=\D)/', ' ', "$prettyfolder"); 
				$prettyfolder = fileaway_utility::strtotitle($prettyfolder);
				if(is_dir($final)) $response = array('status'=>'error', 'message'=>__('That directory name already exists in this location.', 'file-away'));
				else
				{ 
					$first_exists = is_dir($rootpath.$parents.'/'.$first) ? true : false;
					if(mkdir($final, 0755, true)) 
					{ 
						fileaway_utility::indexmulti($rootpath.$parents.'/'.$newsub, $rootpath.$parents.'/'); 
						if(!$first_exists)
						{ 
							$status = "insert";
							$message = 
								"<tr id='ssfa-dir-$uid-$count' class='ssfa-drawers'>".
									"<td id='folder-ssfa-dir-$uid-$count' data-value=\"# # # # # $first\" class='ssfa-sorttype $class-first-column'>".
										"<a href=\"".fileaway_utility::querystring(get_permalink($page), $querystring, array($drawerid => $drawer)).
											"\" data-name=\"".$first."\" data-path=\"".$start."\">".
											"<span style='font-size:20px; margin-left:3px;' class='ssfa-faminicon ssfa-icon-$drawericon ssfa-classic' aria-hidden='true'></span>".
											"<br>"._x('dir', 'abbrv. of *directory*', 'file-away').
										"</a>".
									"</td>".
									"<td id='name-ssfa-dir-$uid-$count' data-value='# # # # # $first' class='ssfa-sortname'>".
										"<a class='ssfa-classic' href=\"".fileaway_utility::querystring(get_permalink($page), $querystring, array($drawerid => $drawer))."\">".
											"<span class='ssfa-filename' style='text-transform:uppercase;'>$prettyfolder</span>".
										"</a>".
										"<input type='text' id='rename-ssfa-dir-$uid-$count' type='text' value=\"$first\" ".
											"style='width:90%; text-align:center; display:none'>".
									"</td>"; 	
							$icell = 1; 
							while($icell < $cells)
							{ 
								$message .= "<td class='$class' data-value=\"# # # # # $first\"> &nbsp; </td>"; 
								$icell++; 
							}
							$message .= 
								"<td id='manager-ssfa-dir-$uid-$count' class=\"$class\" data-value=\"# # # # # $first\">".
									"<a href='' id='rename-ssfa-dir-$uid-$count'>".__('Rename', 'file-away')."</a><br>".
									"<a href='' id='delete-ssfa-dir-$uid-$count'>".__('Delete', 'file-away')."</a>".
								"</td>";
							$message .= "</tr>";
						}
						else 
						{
							$status = "success"; 
							$message = __('Your sub-directories have been successfully created.', 'file-away');
						}
						$response = array('status'=>$status, 'message'=>$message, 'uid'=>$uid);
					}
					else 
					{
						$response = array('status'=>'error', 'message' => __('Sorry, there was a problem creating that directory for you.', 'file-away'));
					}
				}
			}
			// Rename Directory
			elseif($action === 'renamedir')
			{
				global $wpdb;
				if(!$li) die($dm);
				if(!wp_verify_nonce($_POST['manager_nonce'], 'fileaway-manager-nonce')) die($dm);
				$table = fileaway_stats::$db;
				$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table ? false : true;
				$meta_table = fileaway_metadata::$db;
				$meta_table_exists = $wpdb->get_var("SHOW TABLES LIKE '$meta_table'") != $meta_table ? false : true;
				$metadata = $_POST['metadata'] == 'true' ? true : false;
				$oldpath = stripslashes(trim(str_replace('..', '', $_POST['oldpath']), '/'));
				$newname = stripslashes(str_replace(array('..','/'), '', $_POST['newname']));
				$pp = explode('/', $oldpath);
				$newpath = fileaway_utility::replacelast($oldpath, end($pp), $newname);
				$olddata = $_POST['datapath'];
				$datapp = explode('/', $olddata);
				$newdata = fileaway_utility::replacelast($olddata, end($datapp), $newname);
				$parents = stripslashes($_POST['parents']);
				$old = $parents.'/'.end($pp);
				$dst = $rootpath.$newpath;
				$src = $rootpath.$old;
				$check_path = trim(str_replace('/', '', $newpath));
				if(
					$rootpath.$check_path == $rootpath || 
					$rootpath.$check_path == $rootpath.'wp-content' || 
					strpos($check_path, 'wp-admin') !== false ||
					strpos($check_path, 'wp-includes') !== false
				) die($dm); 
				$page = $_POST['pg'];
				$querystring = ltrim($_POST['querystring'], '?');
				$drawer = str_replace('/', '*', $newdata);
				$drawerid = $_POST['drawerid'];
				$newurl = fileaway_utility::querystring(get_permalink($page), $querystring, array($drawerid => $drawer));
				$response = false;
				if(is_dir($dst)) $response = array('status'=>'error', 'message' => __('That directory already exists.', 'file-away'));
				elseif(!is_dir($src)) $response = array('status'=>'error','message'=>__('The directory you\'re trying to rename could not be found.', 'file-away'));
				else
				{
					if(!is_dir("$dst")) mkdir("$dst", 0755, true);
					$dirs = fileaway_utility::recursivedirs($src);
					if(is_array($dirs))
					{
						$dirs = array_reverse($dirs);
						$fcount = 0; $fscount = 0;
						$dcount = 1; $dscount = 0;
						foreach($dirs as $dir)
						{
							$dcount++;
							$files = false;
							$filedest = str_replace("$src","$dst","$dir");
							if(!is_dir($filedest)) mkdir("$filedest", 0755, true);
							$files = array_filter(glob("$dir"."/*"), 'is_file');
							if(is_array($files))
							{ 
								foreach($files as $file)
								{ 
									$fcount++; 
									$filename = fileaway_utility::basename($file); 
									if(rename("$file", "$filedest"."/"."$filename"))
									{ 
										$fscount++; 
										if($table_exists)				
											fileaway_utility::updatestats(
												'file', 
												fileaway_utility::replacefirst($file, $rootpath, ''), 
												fileaway_utility::replacefirst($filedest.'/'.$filename, $rootpath, '')
											);
										if($metadata && $meta_table_exists)				
											fileaway_utility::updatemetadata(
											false,
											fileaway_utility::replacefirst($file, $rootpath, ''), 
											fileaway_utility::replacefirst($filedest.'/'.$filename, $rootpath, ''));
									}
								}
							}
							if(rmdir($dir)) $dscount++;
						}
					}
					$basefiles = array_filter(glob("$src"."/*"), 'is_file');
					if(is_array($basefiles))
					{ 
						foreach($basefiles as $file)
						{ 
							$fcount++; 
							$filename = fileaway_utility::basename($file); 
							if(rename("$file", "$dst"."/"."$filename"))
							{ 
								$fscount++; 
								if($table_exists)				
									fileaway_utility::updatestats(
										'file', 
										fileaway_utility::replacefirst($file, $rootpath, ''), 
										fileaway_utility::replacefirst($dst.'/'.$filename, $rootpath, '')
									);	
								if($metadata && $meta_table_exists)				
									fileaway_utility::updatemetadata(
									false,
									fileaway_utility::replacefirst($file, $rootpath, ''), 
									fileaway_utility::replacefirst($dst.'/'.$filename, $rootpath, ''));															
							}
						}
					}
					if(rmdir($src)) $dscount++;
					if($fcount > 0 && !$fscount) 
						$response = array(
							'status'=>'error', 
							'message'=>__('We tried to move the files into the newly-named directory but none of them would budge.', 'file-away')
						);
					elseif($fcount > 0 && $fcount > $fscount)
						$response = array(
							'status'=>'error',
							'message'=>
								__('We tried to move the files into the newly-named directory, but there were some stragglers, so we couldn\'t remove the old directory.', 'file-away')
						);
					elseif(!is_dir($src))
							$response = array(
								'status'=>'success', 
								'url'=>$newurl, 
								'newdata'=>$newdata, 
								'newname'=>$newname
							); 
					else
						$response = array(
							'status'=>'error', 
							'message'=>__('An unspecified error occurred.', 'file-away')
						); 
				}
			}
			// Delete Directory
			elseif($action === 'deletedir')
			{
				if(!$li) die($dm);
				if(!wp_verify_nonce($_POST['manager_nonce'], 'fileaway-manager-nonce')) die($dm);
				$status = $_POST['status'];
				$path1 = $_POST['path1'];
				$path2 = $_POST['path2'];
				$path = stripslashes($path1.'/'.$path2);
				$src = $rootpath.$path;
				if(
					$src == $rootpath || 
					$src == $rootpath.'wp-content' || 
					strpos($src, 'wp-admin') !== false ||
					strpos($src, 'wp-includes') !== false
				) die($dm); 
				$response = false;
				if(!is_dir("$src")) $response = array('status'=>'error','message'=>__('The directory marked for deletion could not be found.', 'file-away').' '.$path); 
				else
				{	
					$dirs = fileaway_utility::recursivedirs($src);
					$dirs = is_array($dirs) ? array_reverse($dirs) : $dirs;
					if($status === 'life')
					{
						$dcount = 0; 
						$fcount = 0;
						if(is_array($dirs))
						{
							foreach($dirs as $dir)
							{
								$dcount++;
								$files = false; 
								$files = array_filter(glob("$dir"."/*"), 'is_file');
								if(is_array($files)) foreach($files as $file) $fcount++;
							}
						}
						$basefiles = array_filter(glob("$src"."/*"), 'is_file');
						if(is_array($basefiles)) foreach($basefiles as $file) $fcount++;
						if($fcount == 0) $status = 'death';
						else
						{ 
							$filemsg = null;
							if($fcount >= 1)
							{
								$plufiles = $fcount > 1 ? _x('files', 'plural', 'file-away') : _x('file', 'singular', 'file-away'); 
								$filemsg = ' '.__('and', 'file-away').' '.$fcount.' '.$plufiles;
							}
							$dirmsg = null;
							if($dcount >= 1)
							{
								$pludirs = $dcount > 1 ? _x('sub-directories', 'plural', 'file-away') : _x('sub-directory', 'singular', 'file-away');
								$dirmsg = ', '.$dcount.' '.$pludirs;
							}
							$message = sprintf(_x('You are about to delete 1 directory%s from the server. '.
								'This action is permanent and cannot be undone. Are you sure you wish to proceed?', 
								'Do not put a space between *directory* and the %s variable', 'file-away'), $dirmsg.$filemsg);
							$response = array('status'=>'confirm', 'message'=>$message);
						}
					}
					if($status === 'death')
					{
						$pcount = 1; 
						$pscount = 0; 
						$dcount = 0; 
						$dscount = 0; 
						$fcount = 0; 
						$fscount = 0;
						if(is_array($dirs))
						{
							foreach($dirs as $dir)
							{
								$dcount++;
								$files = false; 
								$files = array_filter(glob("$dir"."/*"), 'is_file');
								if(is_array($files))
								{
									foreach($files as $file)
									{
										$fcount++; $file = realpath($file); 
										if(is_readable($file))
										{ 
											if(unlink($file)) $fscount++; 
										}
									}
								}
								if(rmdir($dir)) $dscount++;
							}
						}
						$basefiles = array_filter(glob("$src"."/*"), 'is_file');
						if(is_array($basefiles))
						{ 
							foreach($basefiles as $file)
							{
								$fcount++;
								$file = realpath($file); 
								if(is_readable($file))
								{ 
									if(unlink($file)) $fscount++; 
								}
							}
						}
						if(rmdir($src)) $pscount++;
						if(($pscount && $fscount) || ($pscount && !$fcount))
						{
							$success = $pscount == $pcount && $dscount == $dcount && $fscount == $fcount ? 'success' : 'partial';
							$success = $fscount == $fcount && !$fcount ? 'success-single' : $success;
							$filemsg = null;
							if($fcount >= 1)
							{
								$plufiles = $fcount > 1 ? _x('files', 'plural', 'file-away') : _x('file', 'singular', 'file-away'); 
								$filemsg = ' '.__('and', 'file-away').' '.$fscount.' '.__('of', 'file-away').' '.$fcount.' '.$plufiles;
							}
							else $filemsg = ' '.sprintf(__('and %d files', 'file-away'), $fcount);
							$dirmsg = null;
							if($dcount >= 1)
							{
								$pludirs = $dcount > 1 ? _x('sub-directories', 'plural', 'file-away') : _x('sub-directory', 'singular', 'file-away');
								$dirmsg = ', '.$dscount.' '.__('of', 'file-away').' '.$dcount.' '.$pludirs;
							}
							$message = sprintf(_x('%d of 1 directory%s have been removed from the server.', 
								'Do not put a space between *directory* and the %s variable', 'file-away'), $pscount, $dirmsg.$filemsg);
							$response = array('status'=>$success, 'message'=>$message);
						}
						else
						{
							$response = array(
								'status'=>'error',
								'message'=>__('Sorry, but there was an error attempting to remove this directory.', 'file-away')
							);
						}
					}
				}
			}			
			// rename action
			elseif($action === 'rename')
			{
				if(!$li) die($dm);
				if(!wp_verify_nonce($_POST['manager_nonce'], 'fileaway-manager-nonce')) die($dm);
				global $wpdb;
				$table = fileaway_stats::$db;
				$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table ? false : true;
				$meta_table = fileaway_metadata::$db;
				$meta_table_exists = $wpdb->get_var("SHOW TABLES LIKE '$meta_table'") != $meta_table ? false : true;
				$metadata = $_POST['metadata'] == 'true' ? true : false;
				$url = stripslashes($_POST['url']);	
				$pp = $problemchild ? fileaway_utility::replacefirst(stripslashes($_POST['pp']), $install, '') : stripslashes($_POST['pp']);
				$oldname = stripslashes($_POST['oldname']);	
				$rawname = stripslashes($_POST['rawname']);
				$ext = $_POST['ext'];
				if(strpos(strtolower($ext), 'php') !== false) die($dm);
				if(strpos($url, '.'.$ext.'?type=') !== false)
				{ 
					list($url, $querystring) = explode('?', $url);	
					$querystring = '?'.$querystring;
				}
				else $querystring = '';
				$oldfile = $chosenpath."$pp/$oldname.$ext";
				$customdata = isset($_POST['customdata']) ? $_POST['customdata'] : array();
				if(!$metadata)
				{
					$not_empty = false;
					if(is_array($customdata))
					{	
						$customd = array();	
						foreach($customdata as $datum)
						{
							$customd[] = stripslashes($datum);
							if(stripslashes($datum) != '') $not_empty = true;
						}
					}
					$customd = $not_empty ? stripslashes(implode(',', $customdata)) : '';
					if($customd !== '') $customd = " [$customd]"; 
					else $customd = '';
					$newfile = $chosenpath."$pp/$rawname$customd.$ext";
					if($newfile !== $oldfile)
					{
						$i = 1;
						while(is_file($newfile))
						{
							if($i == 1) $rawname = "$rawname" . " ($i)"; 
							else{ 
								$j = ($i - 1); 
								$rawname = rtrim("$rawname", " ($j)");
								$rawname = "$rawname" . " ($i)"; 
							}
							$i++;
							$newfile = $chosenpath."$pp/$rawname$customd.$ext";
						}
					}
					if($customd !== '') $customd = " [".trim(ltrim(rtrim("$customd", "]"), " ["), " ")."]";
					$newfile = $chosenpath."$pp/".trim("$rawname", ' ')."$customd.$ext";		
					$newurl = str_replace("$pp/$oldname.$ext", "", fileaway_utility::urlesc("$url", true));
					$newurl = fileaway_utility::urlesc("$newurl$pp/".trim("$rawname")."$customd.$ext");
					$newoldname = trim("$rawname", ' ')."$customd";
					$download = trim("$rawname", ' ')."$customd.$ext";		
					if(is_file("$oldfile")) rename("$oldfile", "$newfile");
					$errors = is_file("$newfile") ? '' : __('The file was not renamed.', 'file-away');
					if(is_file($newfile) && $table_exists)				
						fileaway_utility::updatestats(
							'file', 
							fileaway_utility::replacefirst($oldfile, $rootpath, ''), 
							fileaway_utility::replacefirst($newfile, $rootpath, ''));
				}
				else
				{
					$not_empty = false;
					if(is_array($customdata))
					{	
						$customd = array();	
						foreach($customdata as $datum)
						{
							$customd[] = stripslashes($datum);
							if(stripslashes($datum) != '') $not_empty = true;
						}
					}
					$customdata = $not_empty ? $customd : '';	
					$newfile = $chosenpath."$pp/$rawname.$ext";
					if($newfile !== $oldfile)
					{
						$i = 1;
						while(is_file($newfile))
						{
							if($i == 1) $rawname = "$rawname" . " ($i)"; 
							else{ 
								$j = ($i - 1); 
								$rawname = rtrim("$rawname", " ($j)");
								$rawname = "$rawname" . " ($i)"; 
							}
							$i++;
							$newfile = $chosenpath."$pp/$rawname.$ext";
						}
					}
					$newfile = $chosenpath."$pp/".trim("$rawname", ' ').".$ext";		
					$newurl = str_replace("$pp/$oldname.$ext", "", fileaway_utility::urlesc("$url", true));
					$newurl = fileaway_utility::urlesc("$newurl$pp/".trim("$rawname").".$ext");
					$newoldname = trim("$rawname", ' ');
					$download = trim("$rawname", ' ').".$ext";		
					if(is_file("$oldfile")) rename("$oldfile", "$newfile");
					$errors = is_file("$newfile") ? '' : __('The file was not renamed.', 'file-away');
					if(is_file($newfile) && $table_exists)				
						fileaway_utility::updatestats(
							'file', 
							fileaway_utility::replacefirst($oldfile, $rootpath, ''), 
							fileaway_utility::replacefirst($newfile, $rootpath, ''));
					if(is_file($newfile) && $meta_table_exists)				
						fileaway_utility::updatemetadata(
							$customdata,
							fileaway_utility::replacefirst($oldfile, $rootpath, ''), 
							fileaway_utility::replacefirst($newfile, $rootpath, ''));
					if($customdata === '') $customdata = array();
				}
				$response = array(
					"errors" => $errors, 
					"download" => $download, 
					"pp" => $pp, 
					"newurl" => $newurl.$querystring, 
					"extension" => $ext, 
					"oldfile" => $oldfile, 
					"newfile" => $newfile, 
					"rawname" => $rawname, 
					"customdata" => $customdata, 
					"newoldname" => $newoldname,
				);
			}
			// delete action (single)
			elseif($action === 'delete')
			{
				if(!$li) die($dm);
				if(!wp_verify_nonce($_POST['manager_nonce'], 'fileaway-manager-nonce')) die($dm);
				$pp = $_POST["pp"];
				$oldname = $_POST["oldname"];	
				$ext = $_POST["ext"];
				if(!in_array($ext, array('php','htaccess','htpasswd')) && strpos($oldname, 'wp-admin') === false && strpos($oldname, 'wp-config') === false && strpos($oldname, 'wp-includes') === false)
				{
					$oldfile = "$rootpath$pp/$oldname.$ext";
					if(!is_file("$oldfile")) $oldfile = stripslashes("$oldfile");
					if(is_file("$oldfile"))
					{ 
						if(unlink("$oldfile")) $response = "success"; 
						else $response = "error";
					}
					else $response = "error";
				}
				else $response = 'error';
			}
			// bulk download action
			elseif($action == 'bulkdownload')
			{
				if(!wp_verify_nonce($_POST['bulkdownload_nonce'], 'fileaway-bulk-download-nonce')) die($dm);
				$files = $_POST["files"];
				$stats = $_POST['stats'];
				$zipfiles = array(); 
				$values = array();
				if(is_array($files))
				{
					foreach($files as $file)
					{ 
						if(strpos($file, '..') !== false) continue;
						if(strpos($file, '/') === false) continue;
						if(strpos($file, '.php') !== false) continue;
						if(strpos($file, 'wp-config') !== false) continue;
						if(strpos($file, 'wp-admin') !== false) continue;
						if(strpos($file, 'wp-includes') !== false) continue;
						
						$file = $rootpath.stripslashes($file);
						if(file_exists($file))
						{ 
							$zipfiles[] = $file; 
							$values[] = fileaway_utility::basename($file); 
						}
					}
				}
				$numvals = array_count_values($values);
				$prefix = isset($this->settings['download_prefix']) ? $this->settings['download_prefix'] : false;
				$prefix = $prefix && $prefix !== '' ? $prefix : date('Y-m-d', current_time('timestamp'));
				$time = uniqid();
				$destination = fileaway_dir.'/temp'; 
				if(!is_dir($destination)) mkdir($destination);
				$filename = stripslashes($prefix).' '.$time.'.zip';
				$link = fileaway_url.'/temp/'.$filename;
				$filename = $destination.'/'.$filename;
				if(count($zipfiles))
				{ 
					$zip = new ZipArchive;
					$zip->open($filename, ZipArchive::CREATE);
					foreach($zipfiles as $k => $zipfile)
					{ 
						$zip->addFile($zipfile,fileaway_utility::basename($zipfile));
						if($numvals[fileaway_utility::basename($zipfile)] > 1)
						{ 
							$parts = fileaway_utility::pathinfo($zipfile);
							$zip->renameName(fileaway_utility::basename($zipfile), $parts['filename'].'_'.$k.'.'.$parts['extension']);
						}
					}
					$zip->close();
				}
				if($stats == 'true' && count($zipfiles) > 0)
				{
					$stat = new fileaway_stats;
					$ifiles = array();
					foreach($zipfiles as $zfile)
					{
						$zfile = fileaway_utility::replacefirst($zfile, $rootpath, '');
						$ifiles[] = $zfile;
						$stat->insert($zfile, false);	
					}
					$current = wp_get_current_user();
					if($this->settings['instant_stats'] == 'true')
					{
						$data = array(
							'timestamp' => date('Y-m-d H:i:s', current_time('timestamp')),
							'file' => count($ifiles).' '.strtolower(_x('files', 'plural', 'file-away')),
							'files' => "\r\n".implode("\r\n", $ifiles),
							'uid' => $current->ID,
							'email' => $current->user_email,
							'ip' => $_SERVER['REMOTE_ADDR'],
							'agent' => $_SERVER['HTTP_USER_AGENT'],
						);
						$stat->imail($data);
					}
				}
				$response = is_file($filename) ? $link : "Error";
			}
			// Bulk Copy Action
			elseif($action == 'bulkcopy')
			{
				if(!$li) die($dm);
				if(!wp_verify_nonce($_POST['manager_nonce'], 'fileaway-manager-nonce')) die($dm);
				$from = $_POST['from'];
				$to = $_POST['to'];		
				$ext = $_POST['exts'];				
				$destination = $problemchild 
					? fileaway_utility::replacefirst(stripslashes($_POST['destination']), $install, '')
					: stripslashes($_POST['destination']);
				$success = 0;
				$total = 0;		
				$renamers = 0;
				foreach($from as $k => $fro)
				{
					$fro = stripslashes($fro);
					$to[$k] = stripslashes($to[$k]);
					$fro = $problemchild ? fileaway_utility::replacefirst("$fro", $install, '') : "$fro";
					$to[$k] = $problemchild ? fileaway_utility::replacefirst("$to[$k]", $install, '') : "$to[$k]";
					$total++;
					$newfile = $chosenpath."$to[$k]";
					if(is_file($chosenpath."$fro") && is_file("$newfile"))
					{
						$i = 1;
						$noext = fileaway_utility::replacelast("$newfile", '.'.$ext[$k], '');
						while(is_file("$newfile"))
						{
							if($i == 1) $noext = "$noext" . " ($i)"; 
							else
							{ 
								$j = ($i - 1); 
								$noext = rtrim("$noext", " ($j)");
								$noext = "$noext" . " ($i)"; 
							}
							$i++;
							$newfile = "$noext".'.'.$ext[$k];
						}
						$renamers ++;
					}
					if(is_file($chosenpath."$fro") && !is_file("$newfile")) copy($chosenpath."$fro", "$newfile"); 
					if(is_file("$newfile")) $success++; 
				}
				$response = $success == 0 
					? __('There was a problem copying the files. Please consult your local pharmacist.', 'file-away') 
					: ($success == 1 
						? sprintf(__('One file was copied to %s and it no longer feels special.', 'file-away'), $destination) 
						: ($success > 1 
							? sprintf(__('%d of %d files were successfully cloned and delivered in a black caravan to %s.', 'file-away'), $success, $total, $destination) 
							: null 
						)
					);
			}
			// bulk move action
			elseif($action == 'bulkmove')
			{
				if(!$li) die($dm);
				if(!wp_verify_nonce($_POST['manager_nonce'], 'fileaway-manager-nonce')) die($dm);
				global $wpdb;
				$table = fileaway_stats::$db;
				$table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table'") != $table ? false : true;				
				$meta_table = fileaway_metadata::$db;
				$meta_table_exists = $wpdb->get_var("SHOW TABLES LIKE '$meta_table'") != $meta_table ? false : true;
				$metadata = $_POST['metadata'] == 'true' ? true : false;
				$from = $_POST["from"];
				$to = $_POST["to"];		
				$ext = $_POST['exts'];				
				$destination = $problemchild 
					? fileaway_utility::replacefirst(stripslashes($_POST["destination"]), $install, '') 
					: stripslashes($_POST["destination"]);
				$success = 0;
				$total = 0;
				$renamers = 0;		
				foreach($from as $k => $fro)
				{
					$fro = stripslashes($fro);
					$to[$k] = stripslashes($to[$k]);
					$fro = $problemchild ? fileaway_utility::replacefirst("$fro", $install, '') : "$fro";
					$to[$k] = $problemchild ? fileaway_utility::replacefirst("$to[$k]", $install, '') : "$to[$k]";
					$total++;
					$newfile = $chosenpath."$to[$k]";			
					if(is_file($chosenpath."$fro") && is_file("$newfile"))
					{
						$i = 1;
						$noext = fileaway_utility::replacelast("$newfile", '.'.$ext[$k], '');
						while(is_file("$newfile"))
						{
							if($i == 1) $noext = "$noext" . " ($i)"; 
							else
							{ 
								$j = ($i - 1); 
								$noext = rtrim("$noext", " ($j)");
								$noext = "$noext" . " ($i)"; 
							}
							$i++;
							$newfile = "$noext".'.'.$ext[$k];
						}
						$renamers ++;
					}
					if(is_file($chosenpath."$fro") && !is_file("$newfile")) rename($chosenpath."$fro", "$newfile");
					if(is_file("$newfile"))
					{ 
						$success++; 
						if($table_exists) 
							fileaway_utility::updatestats(
								'file', 
								fileaway_utility::replacefirst($chosenpath.$fro, $rootpath, ''), 
								fileaway_utility::replacefirst($newfile, $rootpath, '')
							);
						if($metadata && $meta_table_exists)				
							fileaway_utility::updatemetadata(
								false,
								fileaway_utility::replacefirst($chosenpath.$fro, $rootpath, ''), 
								fileaway_utility::replacefirst($newfile, $rootpath, ''));
					}
				}
				$response = $success == 0 
					? __('There was a problem moving the files. Please consult your local ouija specialist.', 'file-away') 
					: ($success == 1 
						? sprintf(__('One lonesome file was forced to leave all it knew and move to %s.', 'file-away'), $destination) 
						: ($success > 1 
							? sprintf(__('%d of %d files were magically transported to %s.', 'file-away'), $success, $total, $destination) 
							: null 
						)
					);
			}
			// bulk delete action
			elseif($action == 'bulkdelete')
			{
				if(!$li) die($dm);
				if(!wp_verify_nonce($_POST['manager_nonce'], 'fileaway-manager-nonce')) die($dm);
				$files = $_POST['files'];
				$success = 0;
				$total = 0;
				foreach($files as $k => $file)
				{
					$file = stripslashes($file);
					if(
						strpos($file, '.php') === false &&
						strpos($file, 'htaccess') === false &&
						strpos($file, 'htpasswd') === false &&
						strpos($file, 'wp-admin') === false && 
						strpos($file, 'wp-config') === false && 
						strpos($file, 'wp-includes') === false
					)
					{
						$total++;
						if(is_file($rootpath.$file)) unlink($rootpath.$file);
						if(!is_file($rootpath.$file)) $success++;
					}
				}
				$response = $success == 0 
					? __('There was a problem deleting the files. Please try pressing your delete button emphatically and repeatedly.', 'file-away') 
					: ($success == 1 
						? __('A million fewer files in the world is a victory. One less file, a tragedy. Farewell, file. Au revoir. Auf Wiedersehen. Adieu.', 'file-away') 
						: ($success > 1 
							? sprintf(__('%d of %d files were sent plummeting to the nether regions of cyberspace.', 'file-away'), $success, $total) 
							: null 
						)
					);
			}
			// upload action
			elseif($action == 'upload')
			{
				
				if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST")
				{
					if(!wp_verify_nonce($_POST['upload_nonce'], 'fileaway-fileup-nonce'))
					{
						echo 'system_error';
						exit;	
					}
					$file_name = strip_tags(stripslashes($_FILES['upload_file']['name']));
					$new_name = strip_tags(stripslashes($_POST['new_name']));
					$extension = $_POST['extension'];
					$check_ext = str_replace('/', '', $extension);
					$check_name = str_replace('/', '', $new_name);
					if(empty($check_ext) || empty($check_name))
					{
						echo 'system_error';
						exit;	
					}
					$uploader = stripslashes($_POST['uploader']);
					$file_id = strip_tags($_POST['upload_file_id']);
					$file_size = $_FILES['upload_file']['size'];
					$max_file_size = (int)$_POST['max_file_size'];
					$file_path = trim($_POST['upload_path'], '/');
					if($uploader)
					{
						$user = new WP_User($uploader);
						$uploadedby = $_POST['identby'] == 'id' ? $user->ID : $user->display_name;
						if(preg_match('/\[([^\]]+)\]/', $new_name)) $new_name =	fileaway_utility::replacelast($new_name, ']', ','.$uploadedby.']');
						else $new_name = fileaway_utility::replacelast($new_name, '.'.$extension, ' ['.$uploadedby.'].'.$extension);
					}
					$location = str_replace('//','/',$chosenpath.$file_path.'/'.$new_name);
					$location = stripslashes($location);
					$dir = fileaway_utility::dirname($location);
					$_POST['size_check'] = $file_size > $max_file_size ? 'true' : 'false';
					if($file_size > $max_file_size) echo 'system_error';
					elseif(strpos($location, 'wp-admin') !== false) echo 'system_error';
					elseif(strpos($location, 'wp-config') !== false) echo 'system_error';
					elseif(strpos($location, '.php') !== false) echo 'system_error'; 
					elseif(strpos($extension, 'php') !== false) echo 'system_error';
					elseif(strpos($dir, '..') !== false) echo 'system_error';
					else
					{
						if(!is_dir($dir)) mkdir($dir, 0755, true);
						$p = fileaway_utility::pathinfo($location);
						$filename = $p['filename'];
						$i = 1;
						$overwrite = $li && stripslashes($_POST['overwrite']) == 'true' ? true : false;
						if(!$overwrite)
						{
							while(is_file($location))
							{
								if($i == 1) $filename = $filename." ($i)"; 
								else
								{ 
									$j = ($i - 1); 
									$filename = rtrim($filename, " ($j)");
									$filename = $filename." ($i)"; 
								}
								$i++;
								$name = $filename.'.'.$p['extension'];
								$location = $p['dirname'].'/'.$name;		
							}
						}
						$name = $filename.'.'.$p['extension'];
						$location = $p['dirname'].'/'.$name;		
						if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $location)) echo $file_id;
						else echo 'system_error';
					}
					exit;
				}
				else
				{ 
					echo 'system_error'; 
					exit;
				}
			}
			// path generator
			elseif($action == 'actionpath')
			{
				if(!wp_verify_nonce($_POST['manager_nonce'], 'fileaway-manager-nonce')) die($dm);
				$fileup = $_POST['uploadaction'] === 'true' ? 'fileup-' : '';
				$build = null;
				if($problemchild)
				{
					$pathparts = fileaway_utility::replacefirst($_POST['pathparts'], $install, ''); 
					$start = trim(fileaway_utility::replacefirst($_POST['start'], $install, ''), '/');
				}
				else
				{
					$pathparts = $_POST['pathparts']; 
					$start = trim($_POST['start'], '/');
				}
				if($pathparts === '/') $pathparts = $start;
				$pathparts = trim($pathparts, '/');
				$basename = trim($_POST['basename'], '/');
				if(!fileaway_utility::startswith($pathparts, $start)) $pathparts = $start;
				$security = $basename === $start ? false : true;
				$nocrumbs = $security ? trim(fileaway_utility::replacelast("$start","$basename",''), '/') : null;
				if(strpos($pathparts, '..') !== false) $pathparts = $start;
				$dir = $chosenpath.$pathparts;	
				$build .= "<option></option>";
				$directories = glob($dir."/*", GLOB_ONLYDIR);
				if($directories && is_array($directories))
				{
					foreach($directories as $k=> $folder)
					{
						$direxcluded = 0;
						if($this->settings['direxclusions'])
						{
							$direxes = preg_split( '/(, |,)/', $this->settings['direxclusions'], -1, PREG_SPLIT_NO_EMPTY);
							if(is_array($direxes))
							{
								foreach($direxes as $direx)
								{
									$check = strripos($folder, $direx);
									if($check !== false)
									{
										$direxcluded = 1; 
										break;
									}
								}
							}
						}
						if(!$direxcluded)
						{			
							$folder = str_replace($chosenpath, '', $folder); $dirname = explode('/', $folder); $dirname = end($dirname);
							$build .= '<option value="'.$folder.'">'.$dirname.'</option>'; 
						}
					}	
				}
				else $build .= '';
				if($security) $pieces = explode('/', trim(trim(fileaway_utility::replacefirst("$pathparts", "$nocrumbs", ''), '/'), '/')); 
				else $pieces = explode('/', trim("$pathparts", '/'));
				$piecelink = array(); 
				$breadcrumbs = null;
				foreach($pieces as $k => $piece)
				{
					$i = 0; $piecelink[$k] = ($security ? "$nocrumbs/" : null); 
					while($i <= $k)
					{ 
						$piecelink[$k] .= "$pieces[$i]/"; 
						$i++;
					}
					$breadcrumbs .= '<a href="javascript:" data-target="'.trim($piecelink[$k],'/').'" id="ssfa-'.$fileup.'action-pathpart-'.$k.'">'
						.fileaway_utility::strtotitle($piece).'</a> / ';
				}
				$breadcrumbs = stripslashes($breadcrumbs); 
				$pathparts = stripslashes($pathparts); 
				$build = stripslashes($build);
				$response = array
				(
					"ops" => $build, 
					"crumbs" => $breadcrumbs, 
					"pathparts" => $pathparts
				);
			}
			// delete csv
			elseif($action == 'deletecsv')
			{
				if(!wp_verify_nonce($_POST['values_nonce'], 'fileaway-values-nonce')) die($dm);
				$src = base64_decode($_POST['src']);
				if(is_file($rootpath.$src))
				{ 
					if(unlink($rootpath.$src)) $response = array('status'=>'success');	
					else $response = array(
						'status'=>'error', 
						'message'=>__('There was a problem deleting the files. Please try pressing your delete button emphatically and repeatedly.', 'file-away')
					);
				}
				else $response = array('status'=>'error','message'=>__('The file specified does not exist in this location.', 'file-away'));
			}
			// create csv
			elseif($action == 'makecsv')
			{
				if(!wp_verify_nonce($_POST['values_nonce'], 'fileaway-values-nonce')) die($dm);
				$dir = base64_decode($_POST['path']);
				$filename = trim($_POST['name'], '/');
				if(!fileaway_utility::endswith(strtolower($filename), '.csv')) 
					$filename = $filename.'.csv';
				if(is_file($rootpath.$dir.'/'.$filename)) 
				{
					$response = array('status'=>'error','message'=>__('A file by that name already exists in this directory.', 'file-away'));
				}
				else
				{
					if(strpos($filename, '/') !== false && !is_dir($rootpath.$dir.'/'.fileaway_utility::dirname($filename)))
						mkdir($rootpath.$dir.'/'.fileaway_utility::dirname($filename), 0775, true);
					$csv = new fileaway_csv();
					$read = $_POST['read'];
					$write = $_POST['writ'];
					$csv->encoding($read, $write);
					$rows = array();
					$cols = array();
					$csv->titles = preg_split('/(, |,)/', $_POST['cols'], -1, PREG_SPLIT_NO_EMPTY);
					foreach($csv->titles as $header) $cols[$header] = '';
					$rows[0] = $cols;
					$csv->data = $rows;					
					$csv->save($rootpath.$dir.'/'.$filename);	
					if(is_file($rootpath.$dir.'/'.$filename))
					{
						$recursive = $_POST['recursive'] == 'true' ? true : false;
						$fullpath = $rootpath.$dir;
						$querystring = ltrim($_POST['querystring'], '?');
						$files = $recursive ? fileaway_utility::recursefiles($fullpath, array(), array(), '[cC][sS][vV]') : glob("{$fullpath}/*.[cC][sS][vV]"); 
						$file_index = array_search($rootpath.$dir.'/'.$filename, $files);
						$link = fileaway_utility::querystring(get_permalink($_POST['pg']), $querystring, array('fa_csv' => base64_encode(fileaway_utility::basename($filename)), 'fa_index' => $file_index));
						$response = array('status'=>'success','redirect'=>$link);
					}
					else $reponse = array('status'=>'error','message'=>sprintf(__('Sorry. There was a problem creating %s', 'file-away'), $filename));
				}
			}
			// csv cell text change
			elseif($action == 'values')
			{
				if(!wp_verify_nonce($_POST['values_nonce'], 'fileaway-values-nonce')) die($dm);
				$src = $rootpath.base64_decode($_POST['src']);
				$csv = new fileaway_csv();
				$csv->sort_by = 'id';
				$csv->auto($src);
				$read = $_POST['read'];
				$write = $_POST['writ'];
				$csv->encoding($read, $write);
				$csv->data[$_POST['row']][$_POST['col']] = $_POST['newvalue'];
				if($csv->save()) $response = array('status'=>'success');
				else
				{ 
					$csv->data[$_POST['row']][$_POST['col']] = $_POST['oldvalue'];
					if($csv->save()) $response = array('status'=>'error','message'=>__('Sorry about that, but your changes could not be saved.', 'file-away'));
					else $response = array('status'=>'error','message'=>__('Sorry about that, but your changes could not be saved.', 'file-away'));
				}
			}
			// new csv row
			elseif($action == 'newrow')
			{
				if(!wp_verify_nonce($_POST['values_nonce'], 'fileaway-values-nonce')) die($dm);
				$response = array();
				$src = $rootpath.base64_decode($_POST['src']);
				$data = array('test', 'test');
				$csv = new fileaway_csv();
				$csv->sort_by = 'id';
				$csv->auto($src);
				$read = $_POST['read'];
				$write = $_POST['writ'];
				$csv->encoding($read, $write);
				foreach($csv->titles as $col) $csv->data[$_POST['numrows']][$col] = '';
				if($csv->save())
				{ 
					$response['status'] = 'success';
					$k = $_POST['numrows'];
					$uid = $_POST['uid'];
					$theme = $_POST['theme'];
					$headers = $csv->titles;
					$html = "<tr id='ssfa-values-$uid-$k' class='ssfa-values-context' data-row='$k'>";
					foreach($headers as $key=> $header)
					{ 
						$col1class = $key < 1 ? "class='$theme-first-column'" : null;
						$html .= 
							'<td id="cell-ssfa-values-'.$uid.'-'.$k.'-'.$key.'" '.$col1class.' style="cursor:cell">'.
								'<span id="value-ssfa-values-'.$uid.'-'.$k.'-'.$key.'" data-row="'.$k.'" data-col="'.$header.'" data-colnum="'.$key.'"></span>&nbsp;'.
								'<input type="text" id="input-ssfa-values-'.$uid.'-'.$k.'-'.$key.'" data-row="'.$k.'" data-col="'.$header.'" data-colnum="'.$key.'" '.
									'value="" style="display:none; width:90%">'.
							'</td>';
					}
					$html .= "</tr>";
					$response['html'] = $html;
				}
				else $response = array('status'=>'error','message'=>__('Sorry about that, but your changes could not be saved.', 'file-away'));
			}
			// csv row delete
			elseif($action == 'deleterow')
			{
				if(!wp_verify_nonce($_POST['values_nonce'], 'fileaway-values-nonce')) die($dm);
				$src = $rootpath.base64_decode($_POST['src']);
				$csv = new fileaway_csv();
				$csv->sort_by = 'id';
				$csv->auto($src);
				$read = $_POST['read'];
				$write = $_POST['writ'];
				$csv->encoding($read, $write);						
				unset($csv->data[$_POST['row']]);
				if($csv->save()) $response = array('status'=>'success');
				else $response = array('status'=>'error','message'=>__('Sorry about that, but your changes could not be saved.', 'file-away'));
			}
			// csv col create
			elseif($action == 'createcol')
			{
				if(!wp_verify_nonce($_POST['values_nonce'], 'fileaway-values-nonce')) die($dm);
				$src = $rootpath.base64_decode($_POST['src']);
				$csv = new fileaway_csv();
				$csv->sort_by = 'id';
				$csv->auto($src);
				$read = $_POST['read'];
				$write = $_POST['writ'];
				$csv->encoding($read, $write);				
				$headers = $csv->titles;
				$rows = $csv->data;
				if(count($headers) < 2) $csv->delimiter = ",";
				foreach($rows as $k => $v) 
				{
					fileaway_utility::recreatecol($rows[$k], $_POST['colnum'], 0, $_POST['col']);
				}
				array_splice($headers, $_POST['colnum'], 0, $_POST['col']);
				$csv->titles = $headers;
				$csv->data = $rows;
				if($csv->save()) $response = array('status'=>'success');
				else $response = array('status'=>'error','message'=>__('Sorry about that, but your changes could not be saved.', 'file-away'));
			}
			// csv col rename
			elseif($action == 'colrename')
			{
				if(!wp_verify_nonce($_POST['values_nonce'], 'fileaway-values-nonce')) die($dm);
				$src = $rootpath.base64_decode($_POST['src']);
				$csv = new fileaway_csv();
				$csv->sort_by = 'id';
				$csv->auto($src);
				$read = $_POST['read'];
				$write = $_POST['writ'];
				$csv->encoding($read, $write);
				$headers = $csv->titles;
				$rows = $csv->data;
				foreach($rows as $k => $v) 
				{
					fileaway_utility::recreatecol($rows[$k], $_POST['colnum'], 0, $_POST['newname'], $rows[$k][$_POST['oldname']]);
					unset($rows[$k][$_POST['oldname']]);
				}			
				$headers[$_POST['colnum']] = $_POST['newname'];
				$csv->titles = $headers;
				$csv->data = $rows;
				if($csv->save()) $response = array('status'=>'success');
				else $response = array('status'=>'error','message'=>__('Sorry about that, but your changes could not be saved.', 'file-away'));
			}
			// csv col delete
			elseif($action == 'coldelete')
			{
				if(!wp_verify_nonce($_POST['values_nonce'], 'fileaway-values-nonce')) die($dm);
				$src = $rootpath.base64_decode($_POST['src']);
				$csv = new fileaway_csv();
				$csv->sort_by = 'id';
				$csv->auto($src);
				$read = $_POST['read'];
				$write = $_POST['writ'];
				$csv->encoding($read, $write);
				$del_val = $_POST['col'];
				$del_key = $_POST['colnum'];
				$headers = $csv->titles;
				$rows = $csv->data;
				unset($headers[$_POST['colnum']]);
				$headers = array_values($headers);
				foreach($rows as $k => $v)
				{
					unset($rows[$k][$_POST['col']]);
				}
				$rows = array_values($rows);
				$csv->titles = $headers;
				$csv->data = $rows;				
				if($csv->save()) $response = array('status'=>'success');
				else $response = array('status'=>'error','message'=>__('Sorry about that, but your changes could not be saved.', 'file-away'));
			}	
			// csv backup
			elseif($action == 'backupcsv')
			{
				if(!wp_verify_nonce($_POST['values_nonce'], 'fileaway-values-nonce')) die($dm);
				$src = $rootpath.base64_decode($_POST['src']);
				$csv = new fileaway_csv();
				$csv->auto($src);
				$read = $_POST['read'];
				$write = $_POST['writ'];
				$csv->encoding($read, $write);				
				$bits = fileaway_utility::pathinfo($src);
				$newfile = str_replace('.'.$bits['extension'], ' ['.date('Y-m-d H-i-s', current_time('timestamp')).'].'.$bits['extension'], $src);
				if($csv->save($newfile)) $response = array('status'=>'success');
				else $response = array('status'=>'error','message'=>__('Sorry about that, but a backup could not be successfully saved.', 'file-away'));
			}												
			$response = json_encode($response); 
			header("Content-Type: application/json");
			echo $response;	
			exit;	
		}
	}
}