	
var PortletDraggable = function () {
	var list = new Array();
	var updateval = function(sorted){
		
		if(sorted.length){
			for(var i=0;i<sorted.length;i++){
				list[i]={
					"parent":$("#"+sorted[i]).parent().attr("id"),
					"id":sorted[i],
					"index":i,
					};
			}
			console.log(list);
		}	
	};
    return {
        //main function to initiate the module
        init: function () {

            if (!jQuery().sortable) {
                return;
            }
			var sorted;
            $("#sortable_portlets").sortable({
                connectWith: ".portlet",
                items: ".portlet",
                opacity: 0.8,
                coneHelperSize: true,
                placeholder: 'sortable-box-placeholder round-all',
                forcePlaceholderSize: true,
                tolerance: "pointer",
				update:function(event,ui){
					sorted = $( "#sortable_portlets" ).sortable( "toArray" );
					updateval(sorted);
				
				}
            });
			sorted = $( "#sortable_portlets" ).sortable( "toArray" );
			updateval(sorted);
            $(".column").disableSelection();

        }

    };

}();