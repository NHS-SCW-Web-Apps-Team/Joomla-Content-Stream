jQuery(document).ready(function(){

    var options = {
        valueNames: [ 'card-title','card-text','tags',{name:'tag',attr:'tag-value'}]
    };
    
    var cardlist = new List('cards-list', options) ;

    //cardlist.sort('card-title', { order: "asc" });

    jQuery('#filter-none').click(function() {
        clearfilters();
        return false;
      });


    jQuery('#clearsearch').click(function(){clearsearch(); })
    jQuery('#reset-all').click(function(){clearsearch(); clearfilters();})

    jQuery('.filter > .tag').click(function() {

        jQuery(this).toggleClass("active");

        var selected = jQuery(".tag.active").map(function(){return jQuery(this).html() ;}).toArray();        
        
        //console.log(selected);
        
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
            jQuery('.no-result').hide()
            jQuery('#itemcounter').html(list.matchingItems.length);
		} else {
            jQuery('.no-result').show()
            jQuery('#itemcounter').html(0);
		}
	});
    
})