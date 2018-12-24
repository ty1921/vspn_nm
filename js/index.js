// JavaScript Document
 

var area0;
var area1;
var area2;
var area3;
var area4;


window.onload=function(){
     loadElements();
	 setObjAttrbute();
	 // time_range("15:25", "16:52");
     // text();
	   
	
    }


    function loadElements() {
        area0 = FocusLogic.loadElements(1, 3, "area0_", "item_focus_0", "item_0", [-1, -1, 1, -1]);
	
        area1 = FocusLogic.loadElements(1, 5, "area1_", "item_focus_1", "item_1", [0, -1, 2, -1]);
		area2 = FocusLogic.loadElements(5, 1, "area2_", "item_focus_2", "item_2", [1, -1, -1, 4]);
	    area3 = FocusLogic.loadElements(1, 2, "area3_", "item_focus_3", "item_3", [1, 2, 4, -1]);
		area4 = FocusLogic.loadElements(1, 4, "area4_", "item_focus_4", "item_4", [3, 2, -1, -1]);
			

	  initPageFocus();
	  setTimeout("window.focus()", 1);

    }
	
	
	function initPageFocus() {
	var focusObj = TurnPage.getPageFocus([1, 0, 1]);
	area1.curDomIndex = focusObj['areaInfo'][1]['curDomIndex'];
	FocusLogic.page.setCurrentFocus(focusObj['curAreaIndex'], focusObj['areaInfo'][focusObj['curAreaIndex']]['curDomIndex']);
}
	
	 function setObjAttrbute()
	 
	 {
	
	
	
	
	  area1.focusEvent = function () {
		  
		  
		    switch (area1.curDomIndex)
			 
             {
           
				  
			  case 1:
			 
			 // 	window.location.href='special/index.html'
			 TurnPage.goTo("special/index.html");
			   break;
				

				
            }
			
	
			 
			 
			 };
	
	
	

		 
		 
		 
		 
		 }

 

