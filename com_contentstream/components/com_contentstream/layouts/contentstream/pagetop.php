<?php
/**
 * @package    COM_CONTENTSTREAM
 *
 * @author     NHS South, Central and West <webteam.scwcsu@nhs.net>
 * @copyright  Copyright (C) 2021 NHS South Central and West. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://www.scwcsu.nhs.uk
 */

use Joomla\CMS\Table\Table;

defined('_JEXEC') or die;

extract($displayData, EXTR_OVERWRITE);


if(isset($articleid)){
    $article = Table::getInstance("content");
    $article->load($articleid);

    $title= $article->get("title");
    echo "<h3>$title</h3>" ;
    echo $introtxt = $article->get("introtext"); ;
    
    $fulltxt=$article->get("fulltext");

    if($fulltxt==""){}else{
        ?>
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#readmoreModal" >Read more</a>
      <?php 
      $infotext=$introtxt.$fulltxt ;
    }


?>
    <div class="modal fade" id="readmoreModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo $title ; ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php echo $infotext ; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          
        </div>
      </div>
    </div>
  </div>

<?php }else{} ; 