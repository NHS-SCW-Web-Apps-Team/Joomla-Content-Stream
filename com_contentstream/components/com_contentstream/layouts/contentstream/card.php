<?php
/**
 * @package    COM_CONTENTSTREAM
 *
 * @author     NHS South, Central and West <webteam.scwcsu@nhs.net>
 * @copyright  Copyright (C) 2020 NHS South Central and West. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://www.scwcsu.nhs.uk
 */

defined('_JEXEC') or die;

extract($displayData, EXTR_OVERWRITE);

switch($type){
  case "url":
  case "remote":
    $targeturl = $link ; 
    $target = "_blank";
    $icon = "<i class='fa fa-link'></i>";
    $linktxt ="Visit Resource";
  break;
  case "file":
    $targeturl = $link ; 
    $target = "_blank";
    $icon = "<i class='fa fa-download'></i>";
    $linktxt ="Download file";
  break;
  case "component":
    $targeturl = $route ; 
    $target = "_self";
    $icon = "<i class='fa fa-cogs'></i>";
    $linktxt ="Use Calculator";
  break;
  default:
  $targeturl = "#";
  $target = "_self";
  $icon = "" ;
}

//var_dump($note);
//$notetest='{"description":"test note", "tags":["dataset"]}';
$notedata=json_decode($note,true);

if($description==NULL){
  if($notedata==NULL){$cardtxt="";}else{$cardtxt=$notedata["description"];}
}else{$cardtxt=$description ;}

?>
<div class="card" id="card-<?php echo $itemid ;?>" >
  <div class="card-body">
    <h5 class="card-title" data-toggle="collapse" data-target="#cardTxt-<?php echo $itemid ;?>"  ><?php echo $title ;?></h5>
    <div class="card-text collapse show" id="cardTxt-<?php echo $itemid ;?>" ><?php echo nl2br($cardtxt) ;?></div>
    <a href="<?php echo $targeturl ; ?> " target="<?php echo $target ;?>" class="btn btn-primary"><?php echo $icon." ".$linktxt ; ?></a>
    <div class="card-tags tags">
    <?php 
        //var_dump($type);
       //var_dump($note);
       //var_dump($notedata);
      if( isset($notedata["tags"]) && is_array($notedata["tags"]) && count($notedata["tags"])>0 ){
        foreach($notedata["tags"] as $tag){
          echo '<span class="tag badge badge-secondary float-right p-2 m-1" tag-value="'.$tag.'">'.$tag.'</span>';
        }; 
      }
    ?>
    </div>
  </div>
</div>