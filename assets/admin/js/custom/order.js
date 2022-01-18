$(document).ready(function(){

/**************** Datatable Script Start *************/

if($('table').hasClass('my-datatable')){
	jQuery('.my-datatable').dataTable({
		dom: 'Bfrtip',
	    buttons: [
	        'colvis'
	    ],
	    bStateSave : true,
	    aoColumnDefs: [{
	       bSortable: false,
	       aTargets: [0,8]
	    },
	 	],
        language : {
            search : "חיפוש",
            paginate: {
                first:      "ראשון",
                previous:   "הקודם",
                next:       "הבא",
                last:       "אחרון"
            },
            info : 'מראה _PAGE_ שֶׁל _PAGES_',
            infoFiltered:   "(מסונן מ _MAX_ סך השיאים)",
            zeroRecords : 'אין נתונים זמינים בטבלה'
        }
	  });
}

/**************** Datatable Script End *************/

});