<?php
/**
 * @package    COM_CONTENTSTREAM
 *
 * @author     NHS South, Central and West <webteam.scwcsu@nhs.net>
 * @copyright  Copyright (C) 2021 NHS South Central and West. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://www.scwcsu.nhs.uk
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die;

JHtml::_('jquery.framework');

HTMLHelper::_('script', '//cdnjs.cloudflare.com/ajax/libs/list.js/2.3.1/list.min.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('script', 'com_contentstream/script.js', array('version' => 'auto', 'relative' => true));
HTMLHelper::_('stylesheet', 'com_contentstream/style.css', array('version' => 'auto', 'relative' => true));

$app = Factory::getApplication();

//get Parameters
$params = $app->getParams();

//get Tag helper
$tags = new JHelperTags;
$usedtags = array();
//get the active menu
$sitemenu = $app->getMenu();
$activemenu = $sitemenu->getActive() ;

//get any Child menu Items 

$menuitems = $sitemenu->getItems(array("parent_id"), array($activemenu->id));
$itemcount=count($menuitems);

//get the layout for the top of the page  
$pagetop=new FileLayout('contentstream.pagetop');

//get the layout for the card display
$card=new FileLayout('contentstream.card');


// page top text goes here 
echo $pagetop->render(["articleid"=>$params->get("pre_text_article_id")]) ;
?>

<div id="cards-list">

<div id="listcontrols" >
    <div class="row mt-2" >
        <div class="col">
            <div class="input-group ">
                <input type="text" class="search form-control" placeholder="Search" aria-label="Search Control" aria-describedby="button-addon4">
                <div class="input-group-append" id="button-addon4">
                    <button id="clearsearch" class="btn btn-outline-danger" type="button" >Clear Search</button>
                    <button class="sort btn btn-outline-secondary" type="button" data-sort="card-title" >Sort by Name</button>
                </div>
            </div>
        </div>
       <!-- <div class="col">
            <ul id="filtergroup" class="filter btn-group">
                <li class="btn btn-outline-danger" id="filter-none">Clear Filters</li>
            </ul>
        </div> -->
        <!--  --> 
        <div class="col-auto">
            <button id="listgrid-toggle" class="btn" data-toggle="tooltip" data-placement="top" title="Toggle between Grid or List View"><i class="fas fa-th-list"></i> <i class="fas fa-th d-none"></i></button>
            <button id="expandcollapse-toggle" class="btn" data-toggle="tooltip" data-placement="top" title="Toggle between Compact or Expanded View" ><i id="compactviewbtn" class="fas fa-compress-arrows-alt compact"></i><i id="expandviewbtn" class="fas fa-expand-arrows-alt expand d-none"></i></button>
        </div>
    </div>

    <div class="row mt-2" >
       <!-- <div class="col">-->
            <ul id="filtergroup" class="col filter btn-group">
                <li class="btn btn-outline-danger" id="filter-none">Clear Filters</li>
                <!--<li class="btn btn-secondary tag" id="filter-data">dataset</li>
                <li class="btn btn-secondary tag" id="filter-kpi">calculator</li>
                <li class="btn btn-secondary tag" id="filter-sim">simulation</li>-->
            </ul>
       <!-- </div> -->
    </div>
</div>

<div id="list-itemcounter-area"  >Showing <span id="itemcounter" ><?php echo $itemcount ;?></span> of <span id="listsize" ><?php echo $itemcount ;?></span> items</div>
<div id="no-filterresult" class="no-filterresult alert alert-danger ">No Results from Filter or Search <button id="reset-all" class="btn btn-danger"> Reset </button> </div>
<div id="no-listitems" class="no-listitems alert alert-danger ">No Items returned</div>

<?php

echo "<div id=\"itemlist\" class=\"list card-columns\">" ;

foreach($menuitems as $item ):
  //var_dump($item->note);
  $displaydata["itemid"] = $item->id ;
  $displaydata["type"] = $item->type ;
  $displaydata["link"] = $item->link ;
  $displaydata["route"] = $item->route ;
  $displaydata["title"] = $item->title ;

  
  $tagnames=$tags->getTagNames($item->getParams()["tags"]);
  array_merge($usedtags,$tagnames);  
  //var_dump($item->note);
  $notedata=json_decode($item->note,true);
  if($notedata==null){$notedata=array("description"=>"","tags"=>array());}

  if(isset($notedata["tags"])){
    $notedata["tags"]=array_merge($notedata["tags"],$tagnames);
  }else{
    $notedata["tags"]=$tagnames;
  }

  $displaydata["note"] = json_encode($notedata);//$item->note ;
  $displaydata["description"] = $item->params->get("itemdesc") ; 
//echo $card->render((array) $item);
echo $card->render( $displaydata);
endforeach;

if(null !== $params->get("weblinkcategory")){

  $weblink_category=$params->get("weblinkcategory");
  JLoader::import( 'category', JPATH_SITE . '/components/com_weblinks/models' );
  // $items_model = Model::getInstance( 'category', 'WeblinksModel' );
    $items_model = JModelLegacy::getInstance('category', 'WeblinksModel');
    $items_model->getState('category.id');
    $items_model->setState('category.id',$weblink_category);
    $items= $items_model->getItems();

   // $itemcount += count($items);
   // var_dump($items);
  foreach($items as $item):
    $data=array();
    $data["itemid"] = "weblinks-".$item->id ;
    $data["link"]=$item->url  ;
    $data["title"]=$item->title;
    $data["description"]=$item->description;
    //var_dump($item->tags->itemTags);
    $tags=array_column($item->tags->itemTags, 'title');
    // var_dump($tags);
    $usedtags=array_merge($usedtags,$tags);
    $data["note"] = json_encode(array("description"=>$item->description,"tags"=>$tags)) ;
    $data["type"]="url";
    echo $card->render($data) ;
  endforeach ;


}else{};

//var_dump($infodata["useweblink"]);

if(null !== $params->get("docmancategory")){
 
  $docman_category=$params->get("docmancategory");
  
  $doccontroller = KObjectManager::getInstance()->getObject('com://site/docman.controller.document');
  $user       = KObjectManager::getInstance()->getObject('user');
  // Fetch documents in a category
  $documents_in_a_category = $doccontroller
    ->access($user->getRoles()) // Permissions
     ->current_user($user->getId())
     ->enabled(1)
     ->status('published')
     ->category($docman_category)
     ->category_children('true')
     ->sort('publish_date')
     ->direction('desc')
     ->limit(5)   // Limiting to 50 documents
     ->offset(0)   // You can set this to 50 in the next call to paginate results
     ->browse();
 // $countitems += count($documents_in_a_category);

  $docmanmenuid = $params->get('docmanmenu');
  //var_dump($docmanmenuid);
  $doclink = Route::_("index.php?Itemid={$docmanmenuid}");
  //var_dump($doclink);
  foreach($documents_in_a_category as $document):
    $data=array();
    $data["itemid"] = "doc-".$document->id ;
    //$data["link"]= JUri::getInstance() .'/'. $document->alias ;
    $data["link"]= $doclink."/".$document->alias."/file" ;
    $data["title"]=$document->title;
    $data["description"]=$document->description;

    $tags=$document->getTags();
    
    $tag_titles = [];
      if (count($tags)) {
        //$tag_titles = [];

        foreach ($tags as $tag) {$tag_titles[] = $tag->title;}
        
      }
     //var_dump($tag_titles);
    $usedtags=array_merge($usedtags,$tag_titles);  
    $data["note"] = json_encode(array("description"=>$document->description,"tags"=>$tag_titles)) ;
    $data["type"]=$document->storage_type;
    
    //var_dump($data["type"]);
    //$data["type"]="url";
    echo $card->render($data) ;
  endforeach ;

}else{

};



echo "</div></div>";

//$uniquetags=array_values(array_unique($usedtags));
// apparently array_flip is faster than array_unique 
$uniquetags=array_keys(array_flip($usedtags));

$document = Factory::getDocument();
$document->addScriptOptions('com_contentstream', 
array('tags' => $uniquetags,'tagfreq' => array_count_values($usedtags))
);