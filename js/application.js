$(document).ready(function() {
	
	var fancyIt = (function($els) {
		$els.fancybox({
			'transitionIn'		: 'fade',
			'transitionOut'		: 'fade',
			'titlePosition' 	: 'over',
			'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
				var testo = '<div id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length;
				testo += '<a href="' + basepath + 'fbshare/id_photo/' + title +'" class="link" target="_blank"><img src="' + basepath + 'widgets/fbshare.png" alt="Facebook Share" /></a>';
				testo += '<a href="' + basepath + 'fonte/id_photo/' + title +'" class="fonte" target="_blank"><img src="' + basepath + 'widgets/link.png" alt="Fonte" /></a>';
				testo += '</div>';
				return testo; 
			}
		}).removeClass('.toBeFancied');				
	});
	
	fancyIt($("a[rel*=fancybox]"));

    var yScrollMax = 0;
	$(window).scroll(function () {
		var arrayCoords = getPageScroll();
		var arrayDims = getPageSize();

		if (arrayCoords[1] + arrayDims[3] >= arrayDims[1] - 320){
			$.ajax({
				url  : basepath + '/welcome/retrieve_offset',
				type: 'GET',
				async: false,
				complete: function(jqXHR, textStatus) {					
					if (textStatus == "success" && jqXHR.readyState == 4) {
						var data = jqXHR.responseText;						
						if (!($('#' + data).length > 0)) {	
							$.ajax({
								url  : basepath + '/welcome/caricamento',
								type: 'GET',
								async: false,
								success: function(){},							
								complete: function(jqXHR, textStatus) {									
									if (textStatus == "success" && jqXHR.readyState == 4) {
										var data = jqXHR.responseText;
										if (data != '') {
											 $('.container').append(data);											 
											 fancyIt($("a[rel*=fancybox]"));
											 setSizes();
										}					
									}
								}
							});							
						}
					}				
				}
			});
			
		}
		
	}).trigger('scroll');
	
});

function setSizes() {
	var arrPageSizes = getPageSize();
	var realHeight = arrPageSizes[1];
	$('#leftArea').css('height', realHeight + 'px');
	$('#rightArea').css('height', realHeight + 'px');	
}

//questa funzione restituisce un array con la posizione x,y dello scroll
function getPageScroll() {

	var xScroll, yScroll;

	if (self.pageYOffset) {
		yScroll = self.pageYOffset;
		xScroll = self.pageXOffset;
	}else if (document.documentElement && document.documentElement.scrollTop) {
        yScroll = document.documentElement.scrollTop;
        xScroll = document.documentElement.scrollLeft;
    }else if (document.body) {
        yScroll = document.body.scrollTop;
        xScroll = document.body.scrollLeft;
    }

	arrayPageScroll = new Array(xScroll,yScroll);
	return arrayPageScroll;
}

//la funzione restituisce in un array
//la larghezza e l'altezza della pagina reale(scroll compreso) e 
// la larghezza e l'altezza della finestra visibile

function getPageSize() {

	var xScroll, yScroll;

	if (window.innerHeight && window.scrollMaxY) {
		xScroll = window.innerWidth + window.scrollMaxX;
		yScroll = window.innerHeight + window.scrollMaxY;
	}else if (document.body.scrollHeight > document.body.offsetHeight){
		xScroll = document.body.scrollWidth;
		yScroll = document.body.scrollHeight;
	}else{
		xScroll = document.body.offsetWidth;
		yScroll = document.body.offsetHeight;
	}

	var windowWidth, windowHeight;

	if (self.innerHeight) {
		if(document.documentElement.clientWidth){
			windowWidth = document.documentElement.clientWidth;
		}else{
			windowWidth = self.innerWidth;
		}
		windowHeight = self.innerHeight;
	}else if (document.documentElement && document.documentElement.clientHeight) {
		windowWidth = document.documentElement.clientWidth;
		windowHeight = document.documentElement.clientHeight;
	}else if (document.body) {
		windowWidth = document.body.clientWidth;
		windowHeight = document.body.clientHeight;
	}

	//per le pagine con l'altezza totale minore dell'altezza della finestra del browser
	if(yScroll < windowHeight){
		pageHeight = windowHeight;
	} else {
		pageHeight = yScroll;
	}

	//per le pagine con larghezza totale minore della larghezza della finestra del browser
	if(xScroll < windowWidth){
		pageWidth = xScroll;
	}else{
		pageWidth = windowWidth;
	}

	//creo l'array e lo ritorno
	arrayPageSize = new Array(pageWidth,pageHeight,windowWidth,windowHeight);
	return arrayPageSize;
}

