/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     js
 * @copyright   Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

// Avoid PrototypeJS conflicts, assign jQuery to $j instead of $
var $j = jQuery.noConflict();

// A $( document ).ready() block.
$j( document ).ready(function() {
    //alert( "ready!" );
    popup('signup');
});

function popup(myarg) {
	

	//var htmlString = $j( this ).html();
	//var popupString = $j.post('http://localhost/babyplanet.pk/index.php/popup')
  	//$j( this ).html( popupString );
  	
  	if(!checkCookie( myarg ) ) {
  		var link = "http://localhost/babyplanet.pk/index.php/popbox/index/index/which/" + myarg;
		var msg = $j.ajax({type: "POST", url: link, async: false}).responseText;
		$j("#popup-container").html( msg );
		//window.location.hash = '#custom-popup-window';
		//document.getElementById('custom-popup-window').scrollIntoView();
	}

}

//Closing Popup on outside click
$j(document).mouseup(function (e)
		{
		    var container = $j("#popup-container");

		    if (!container.is(e.target) // if the target of the click isn't the container...
		        && container.has(e.target).length === 0) // ... nor a descendant of the container
		    {
		        //container.hide();
		        popupClear();
		    }
		});

function popupClear() {
	
    $j("#popup-container").html(" ");
}

//----------- Cookies Functions ------------
function setCookie( cname, cvalue, exdays) {
    var d = new Date();
    d.setTime( d.getTime() + ( exdays*24*60*60*1000 ) );
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname+"="+cvalue+"; "+expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0 ; i < ca.length ; i++ ) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function checkCookie( which ) {
    var popup = getCookie("BabyPlanet_Cookie");
    if (popup != "") {
        //alert("Welcome again " + popup);
        return true;
    } else {
       popup = which;
       if (popup != "" && popup != null) {
           setCookie("BabyPlanet_Cookie", popup, 30);
           return false;
       }
    }
}

//	$("#popup-cancel").click(function(){
//    $("#popup-div").html(" ");
//	}); 