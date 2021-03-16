jQuery(document).ready(function(){

    var options = {
        valueNames: [ 'card-title','card-text','tags',{name:'tag',attr:'tag-value'}]
    };
    
    var streamoptions = Joomla.getOptions("com_contentstream");
//    console.log(streamoptions);
//    console.log(streamoptions.tags.length);
    
    try {
        var cardlist = new List('cards-list', options) ;

        //cardlist.sort('card-title', { order: "asc" });
        // if list has size 
        var listSize = cardlist.size();
        jQuery('#no-filterresult').hide();
        jQuery('#no-listitems').remove();
        jQuery('#itemcounter').html(listSize);
        jQuery('#listsize').html(listSize);

        if(streamoptions.tags.length==0){
            /** if no tags remove filters area */
            jQuery("#filtergroup").hide()
        }else{
            /** if tags then generate  */
            streamoptions.tags.forEach(element => {
                jQuery("#filtergroup").append("<li class=\"btn btn-secondary tag\" >"+element+"</li>");
            });
        }
      

    jQuery('#filter-none').click(function() {
        clearfilters();
        return false;
      });


    jQuery('#clearsearch').click(function(){clearsearch(); })
    jQuery('#reset-all').click(function(){clearsearch(); clearfilters();})

    jQuery('.filter > .tag').click(function() {

        jQuery(this).toggleClass("active");

        var selected = jQuery(".tag.active").map(function(){return jQuery(this).html() ;}).toArray();        
        
       // console.log(selected.length);
        if(selected.length==0){
            cardlist.filter();
        }else{
            cardlist.filter(function(item) {

                var itemtags = jQuery(item.values().tags).map(function(){return jQuery(this).attr("tag-value") ;}).toArray() ;
                //console.log(itemtags); 
                //console.log(selected);            
                // console.log(jQuery.inArray(item.values().tag,selected));
                //console.log(jQuery.inArray(selected[0],itemtags));

            //if(jQuery.inArray(item.values().tag,selected)>-1){return true ;}else{ return false}; 
            // if(jQuery.inArray(selected[0],itemtags)>-1){return true ;}else{ return false}; 
            var match=false;  
            var x ;
            for(x of selected){
                if(jQuery.inArray(x,itemtags)>-1){match = true ; break; }
            }
            return match ;
            });
        };
        //return false;
      });

    jQuery("#expandcollapse-toggle").click(function(){
    
    if(jQuery("#expandcollapse-toggle i.d-none").attr("id")=="expandviewbtn"){
      jQuery(".card-text").collapse("hide");
    }else{
      jQuery(".card-text").collapse("show");
    }

      jQuery("#expandcollapse-toggle i").toggleClass("d-none");
    });

    jQuery("#listgrid-toggle").click(function(){
      jQuery("#itemlist").toggleClass("card-columns");
      jQuery("#listgrid-toggle i").toggleClass("d-none");
    });

    function clearsearch(){
        cardlist.search();
        cardlist.update();
        jQuery('.search').val('');
    } 

    function clearfilters(){
        cardlist.filter();
        jQuery(".tag.active").removeClass("active");
    }

    cardlist.on('updated', function (list) {
		if (list.matchingItems.length > 0) {
            jQuery('.no-filterresult').hide()
            jQuery('#itemcounter').html(list.matchingItems.length);
		} else {
            jQuery('.no-filterresult').show()
            jQuery('#itemcounter').html(0);
		}
	});

}
catch (err) {
    //alert("");
    /** IF LIST IS EMPTY OR HAS NO SIZE */
    jQuery('.no-filterresult').hide();
    jQuery('#listcontrols').hide();
   
}
    
})