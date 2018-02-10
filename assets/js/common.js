/*
	04.02.2015 00:55 -> jquery dependency %2 ( sortable )
*/

var Common_Base = {
	MAIN_URL: "http://sucuoglugranit.com/test/",
	URL_LOADER: "http://sucuoglugranit.com/test/res/img/rolling.gif"
};


// kendi ready fonksiyonum
function AHReady( cb ){
	// Chrome, ff, opera.. > ie8
	if( document.addEventListener ){
		document.addEventListener( "DOMContentLoaded", cb, false );
	// <= ie8	
	} else if( document.attachEvent ){
		document.attachEvent("onreadystatechange", function(){
			if( document.readyState === "complete" ){
				cb();
			}
		});
	// eksantrik browserlar icin her turlu calisacak ready
	} else {
		var old_onload = window.onload;
		window.onload = function(){
			old_onload && old_onload();
			cb();
		}
	}
}
// class selector
function $AHC( cs ){
	var el_array = [];
	// ie 8 ve altinda tum dom u tara ve className uyan
	// elementleri listeye ekle
	if( !document.querySelectorAll || ( window.attachEvent && !window.addEventListener ) ){
		var tmp = document.getElementsByTagName("*"),
			regex = new RegExp("(^|\\s)" + cs + "(\\s|$)"),
			l = tmp.length;
		for( var i = 0; i < l; i++ ){
			if( regex.test(tmp[i].className) ) el_array.push(tmp[i]);
		}
		// cache de kalmasin
		tmp = [];
	} else {
		el_array = document.querySelectorAll( "." + cs );
	}
	// // tek seçim icin
	if( el_array.length == 1 ) return el_array[0];
	return el_array;
}

// assoc array
Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function is_defined( vari ){
	return (typeof vari !== 'undefined');
}

function is_element( o ){
	return (
		typeof HTMLElement === "object" ? o instanceof HTMLElement :
		o && typeof o === "object" && o !== null && o.nodeType === 1 && typeof o.nodeName === "string"
	);
}

function get_object_type(obj, type){
	return Object.prototype.toString.call( obj ) === '[object '+type+']';
}
	
// id selector
function $AH(id){
	return document.getElementById(id);
}

// @parent elementinin child elementlerinde arama
function find_elem( parent, context ){
	var found = [], i,
		list = get_children( parent ), len = list.length;
	// tum elementler icin kontrol fonksiyonu calistir
	// uyanlari ekle
	for( i = 0; i < len; i++ ){
		if( match_context( list[i], context ).length > 0 ){
			found.push(list[i]);
			delete list[i];
		}
	}
	if( found.length == 1 ) return found[0];
	return found;
}

// @par altindaki tum children elementleri bul
function get_children( par ){
	var nodes = par.childNodes, len = nodes.length, elem_list = [], i;
	// birinci seviye childrenlar icin for baslat
	for( i = 0; i < len; i++ ){
		if( nodes[i].nodeName != "#text" && nodes[i].nodeName != "#comment" ){
			// ekle bulunanlara
			elem_list.push(nodes[i]);
			// simdi kontrol ettigimiz elementin alt elementlerine bak
			var children = get_children(nodes[i]);
			// varsa her birini bulunanlara ekle
			// recursive fonksiyon kullaniyorum
			// her element icin children var mi, varsa ekle yapiyoruz
			if( children ){
				foreach( children, function(node){
					elem_list.push(node);
				});		
			}
		}
	}
	// bosalt bunu
	nodes = [];
	return elem_list;
}

// @elem icin contextte verilen icerige uygunluk kontrolu yap
// .class, #id, [attr], li, input vs(node name kontrolu)
function match_context( elem, context ){
	var match = [];
		context = context.replace(/ /g,"");
	// class
	if( context.indexOf(".") > -1 ){
			if( hasClass( elem, context.substr(1) ) ) match.push( elem );
	// id
	} else if( context.indexOf("#") > -1 ){
		if( elem.id == context.substr(1) ) match.push( elem );
	// attr
	} else if( context.indexOf("[") > -1 ){
		// son ve ilk köşeli parantezleri temizle
		var attr_name = context.substr(1);
		attr_name = attr_name.substr( 0, attr_name.length - 1 );
		if( elem.getAttribute(attr_name) != null ) match.push( elem );
	// elem tip
	} else {
		if( elem.nodeName == context.toUpperCase() ) match.push( elem );
	}
	return match;
}


// elementin indexini bul
function get_node_index(node) {
	var index = 0;
	// bir elementin indexi o elementin oncesindeki element sayisindan bir fazla
	// ama baslangic sifir kabul ettigimiz icin direk eşit
	// onceki eleman null olana kadar yani ilk indexe gelene kadar degiskeni
	// arttiriyoruz ve indexi buluyoruz
	while ( (node = node.previousSibling) ) {
		// yalnizca DOM elementleri sayiyoruz
		if (node.nodeType != 3 || !/^\s*$/.test(node.data))	index++;
	}
	return index;
}


// ilk parenti bul	
function get_parent( elem ){
	if( elem && elem.parentNode ){
		return elem.parentNode;
	}
	return false;
}

// documente kadar parentlarini bul
function get_parents( elem ){
	var parents = [];
	// parent oldugu surece arraye ekle
	while( get_parent( elem ) ){
		parents.push( get_parent(elem) );
		elem = get_parent(elem);
	}
	return parents;
}


// direk elem yada ID si gelenin value yu döner
function get_val( elem ){
	if( is_element( elem ) ) {
		return elem.value;
	} else {
		return $AH(elem).value;
	}
	
}

function is_numeric( val ){
	return (val - 0) == val && trim( (''+val) ).length > 0;
}

// removeChild dan ziyade crossbrowser calisiyor
//https://developer.mozilla.org/en-US/docs/Web/API/Element/outerHTML
function remove_elem( elem ){
	if( elem ) elem.outerHTML = "";
}

function create_element( tag, class_names ){
	var elem = document.createElement( tag ),
	class_name = "";
	foreach( class_names, function( class_name ){
		addClass(elem, class_name );
	});
	return elem;
}

function create_img( src, alt ){
	var img =  document.createElement( "img" );
	img.src = src;
	img.alt = alt;
	return img;
}

function set_html( elem, cont ){
	if( elem ) elem.innerHTML = cont;
}

function get_html( elem ){
	if( elem ) return elem.innerHTML;
	return "";
}

function append_html( elem, content ){
	// console.log( content );
	if( elem ){
		var old_content = get_html( elem );
		set_html( elem, old_content + content );
	} 
}

function prepend_html( elem, content ){
	if( elem ){
		var old_content = get_html( elem );
		set_html( elem, content + old_content );
	}
}

// selectore gore elementlere event ekle
// birden fazla elementi foreachsiz burada handle edebiliyoruz
function add_event( selector, event, cb ){
	if( get_object_type(selector, "NodeList") || get_object_type(selector, "Array") ){
		foreach( selector, function(elem){
			add_event_to( elem, event, cb );
		});
	} else {
		add_event_to(selector, event, cb);
	}

}

// add event cross browser
// this keywordu kullanabiliyoruz
function add_event_to(elem, event, cb) {
	// addEventlistener destekleyenler icin
	function listen_handler(e) {
		// this icin
		var ret = cb.apply(this, arguments);
		if (ret === false) {
			e.stopPropagation();
			e.preventDefault();
		}
		return(ret);
	}
	// IE<9
	function attachHandler() {
		var ret = cb.call(elem, window.event);   
		if (ret === false) {
			window.event.returnValue = false;
			window.event.cancelBubble = true;
		}
		return(ret);
	}
	if( !elem ) return;
	// duruma gore eventleri bagla elemente
	if (elem.addEventListener) {
		elem.addEventListener(event, listen_handler, false);
	} else {
		elem.attachEvent("on" + event, attachHandler);
	}
}

// IE ve diger browserler icin preventDefault
function event_prevent_default( event ){
	( event.preventDefault ) ? event.preventDefault() : ( event.returnValue = false );
}
// IE ve diger browserler icin stopProp
function event_stop_propagation( event ){
	( event.stopPropagation ) ? event.stopPropagation() : ( window.event.cancelBubble = true );
}


function add_event_on( elem, find, event, cb ){
	var selector, off_target = false;
	// eger bulunacak elem  false ise direk document click, element aramiyoruz
	// off target falan mevzularinda kullanmak icin
	// diger turlu selectorun id veya class ismini al
	if( !find ) {
		off_target = true;
	} else {
		// attr bulma

		if( find.indexOf("[") > -1 ){
			selector = find.substr( 1, (find.length - 2)  );
		} else {
			selector = find.substr( 1 );
		}
		// console.log( selector );
	}
	add_event( elem, event, function(e){
		if( !off_target ) {
			// IE8 icin e.target srcElement onun icin kontrol
			var targ = e.target;
			if( !targ ) targ = window.event.srcElement;
			// Firefox ibnesi select option larina basildiginda, target olarak
			// opiton u aliyor o yuzden onun icin kontrol. eger optionsa parenti al (select)
			if( targ.nodeName == "OPTION" ) targ = targ.parentNode;
			// class veya id tutan eleman varsa callback calistir 
			// elem i de callback e argument olarak gec ( this )
			if( hasClass( targ, selector ) || targ.id == selector || targ.getAttribute(selector) != undefined ){
				cb( targ, e );
				return;
			}
			// console.log( get_parents(targ));
			// event bubble icin. en icteki elemente basildiginda parentlari da
			// kontrol et
			var parents = get_parents( targ ), len = parents.length;
			for( var i = 0; i < len; i++ ){
				if( hasClass( parents[i], selector ) || parents[i].id == selector ){
					cb( parents[i], e );
					break;
				}
			}
			
		} else {
			cb();
		}
	});
}

function sort_by_key(array, key, type ) {
	if( type == 'date' ){
		return array.sort(function(a, b) {
			var x = new Date(a), 
			y = new Date(b);
			if(x < y) return -1;
			if(x > y) return 1;
			return 0;
		});
	} else if( type == 'string' ){
		return array.sort(function(a, b) {
			var x = a[key], 
			y = b[key];
			return ((x < y) ? -1 : ((x > y) ? 1 : 0));
		});
	} else if( type == 'numeric' ){
		return array.sort(function(a,b) {
			var x = a[key], y = b[key];
		    return x - y;
		});
	}
}


// select e options ekle
// @elem -> select
// @clear -> true ise varolan option varsa temizler, false ise append
// @options -> option array
// @name_val_same -> eger select val ile text aynıysa optionlar array degilde direk string olarak gelir
function add_options( elem, clear, options, selected, name_val_same = false ){
	if( clear ) set_html(elem, "");
	foreach( options, function(option){
		var opt = document.createElement('OPTION');
		if( name_val_same ){
			opt.value = option;
			opt.text  = option;
			if( selected && selected == option ) opt.selected  =  true;
		} else {
			opt.value = option[0];
			opt.text  = option[1];
			if( selected && selected == option[0] ) opt.selected  =  true;
		}
		
		// console.log(option)
		
		elem.options.add( opt );
	});
}

function show(e){
	css( e, { display:"block"} );
	// e.style.display = "block";
}

function hide(e){
	css( e, { display:"none"} );
}


function toggle_class( elem, cls ){
	if(elem){
		if(hasClass(elem, cls)){
			removeClass(elem, cls);
		} else {
			addClass(elem,cls);
		}
	}
}

function hasClass(element, cls) {
	if( element ) return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
}

function addClass(element, cls){
	if( element ) if( !hasClass(element, cls ) ) element.className += ' ' + cls;
}

function removeClass(element, cls) {
	if( element ) {
		var newClass = ' ' + element.className.replace( /[\t\r\n]/g, ' ') + ' ';
		if( hasClass(element, cls ) ){
			while( newClass.indexOf(' ' + cls + ' ' ) >= 0 ){
				newClass = newClass.replace( ' ' + cls + ' ', ' ' );
			}
			element.className = newClass.replace( /^\s+|\s+$/g, '' );
		}
	}
}

// cross-browser trimjanim preg yalarim
function trim(str){
	return str.replace(/ /g,"");
}

// array in her bir elemani icin callback
function foreach( array, cb ){
	var i, l = array.length;
	for( var i = 0; i < l; i++ ){
		cb( array[i] );
	}
}

// object extend olayi
// x objesine, y deki objeleri ekle yada overwrite
function extend(x, y) {
	var i;
	if (!x) x = {};
	for (i in y) {
		x[i] = y[i];
	}
	return x;
};
// bunda örtüşmeyen elemanlar devredışı
// ayni metod ve degiskenler overwrite ediliyor
function overwrite(x, y){
	var i;
	if (!x) x = {};
	for (i in y) {
		if( x[i] != undefined ) x[i] = y[i];
	}
	return x;
}

function in_array( elem, array ){
	for( var i = 0; i < array.length; i++ ){
		if( elem == array[i] ) return true;
	}
	return false;
}
function remove_from_array( elem, array ){
	for( var i = 0; i < array.length; i++ ){
		if( elem == array[i] ) array.splice(i, 1);
	}
}

function css(elem, style) {
	// console.log(elem);
	extend(elem.style, style);
}

function get_return_url(){
	return (location.href).substr(31);
}

function debounce(func, frekans, ilkSefer) {
	// Her çağrılışta sıfırlanan bayrak ( istenen geckikmeyi algılayan )
	 var timeout;
	 return function debounced () {
		// debounce fonksiyonu ve args
		var obj = this, args = arguments;
		// Eğer ilk seferde debounce istemiyorsak direk fonksiyonu çalıştır
		// timeout'u sıfırla
		function delayed () {
			if (!ilkSefer) {
				func.apply(obj, args);
			}
			timeout = null; 
		}
		// Eğer delayden öncse basıldıysa timeout'u sıfırla
		if (timeout) {
			clearTimeout(timeout);
		}
		// Eğer delay şartı sağlanmışsa ve ilkSeferde delay istemiyorsak
		// Fonksiyonu çalıştırıyoruz.
		else if (ilkSefer) {
			func.apply(obj, args);
		}
		// Timeout' u resetledik
		timeout = setTimeout(delayed, frekans || 100); 
	};
}

var AHAJAX_V3 = {
	req: function( url, data, cb ){
		var xhr;
		// DT_functions.row_loader(true);
        // modern browserlar da XMLHttpRequest kullan
        if(typeof XMLHttpRequest !== 'undefined') {
        	xhr = new XMLHttpRequest();
        } else {
            // IE 6 dayinin ibneliklerini çözüyoruz
            var versions = ["MSXML2.XmlHttp.5.0",  "MSXML2.XmlHttp.4.0", "MSXML2.XmlHttp.3.0", "MSXML2.XmlHttp.2.0", "Microsoft.XmlHttp"]        
            // uyan versiyonu kullaniyoruz tek tek kontrol edip
            for(var i = 0, len = versions.length; i < len; i++) {
            	try {
            		xhr = new ActiveXObject(versions[i]);
            		break;
            	}
            	catch(e){}
            }
        }
        // ajax requesti yaptiginda onreadystatechange e tanimlanmis
        // fonksiyon 5 defa calisacak. her calismada durum ile ilgili bilgiye
        // gore fail, complete fonksiyonlari calistirabiliyoruz
        xhr.onreadystatechange = state_check;
        // kontrol fonksiyonu
        function state_check() {
            // uninitialized, loading, loaded, interactive state lerinde
            // birsey yapma requeste devam
            if(xhr.readyState < 4) {
            	return;
            };
            // network level de bir hata olursa calisiyor. ( cross domain vs )
            xhr.onerror = function(){ console.log( "Ajax request failed" ); };
            // readyState 4 request completed
            // status 200 HTTP OK
            if( xhr.readyState === 4 && xhr.status === 200 ) {
                // IE.7 ve altinda json.parse yok
           		// crockford dayinin kutuphanesini kullanabilirim 
           		var rsp = JSON.parse(xhr.responseText);
           		if( typeof cb == 'function' ) cb( rsp );
           		// DT_functions.row_loader(false);
                // console.log(xhr);
            }
        }
        // ucur bizi sıkati
        xhr.open("POST", url, true);
        
        // server dan response json
        // formdata ile upload yapiyorsak contentype boş olmalı
        if( typeof data.append != 'function' ){
        	// xhr.setRequestHeader("Content-Type", "application/json");
        	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        	// xhr.setRequestHeader("Content-Type", "multipart/form-data");
        }
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        // console.log( data );
        // gonder
        xhr.send(data);
    }
}


// Slider - Obarey Inc 2016
var Slider = function( element, items, options ){
	this.init = function(){
		this.slides = [];
		this.thumbs = [];
		var tli, sli, imga, img, mob_desc, div_bullet, div_tc, span_title, span_desc,
			slides_cont = document.createElement("ul"),
			thumbs_cont = document.createElement("ul");
		slides_cont.className = "slides";
		addClass( slides_cont, "clearfix" );
		thumbs_cont.className = "slider-thumbs";
		addClass( thumbs_cont, "clearfix" );
		element.appendChild( slides_cont );
		element.appendChild( thumbs_cont );
   		// html olustur
   		for( var i = 0; i < items.length; i++ ){
   			var item = items[i];
   			sli = document.createElement("li");
   			tli = document.createElement("li");
   			imga = document.createElement("a");
   			imga.href = item.href;
   			img = document.createElement("img");
   			img.src = "res/img/slider/"+item.img+".png";
   			img.alt = item.title;
   			mob_desc = document.createElement("div");
   			mob_desc.className = "mobile-slider-desc";
   			set_html( mob_desc, item.desc );
   			imga.appendChild( img );
   			imga.appendChild( mob_desc );
   			sli.appendChild( imga );
   			div_bullet = document.createElement("div");
   			div_bullet.className = "custom-bullet";
   			div_tc = document.createElement("div");
   			div_tc.className = "thumb-content";
   			span_title = document.createElement("span");
   			span_title.className = "thumb-title";
   			set_html( span_title, item.title );
   			span_desc = document.createElement("span");
   			span_desc.className = "thumb-desc";
   			set_html( span_desc, item.desc );
   			div_tc.appendChild( span_title );
   			div_tc.appendChild( span_desc );
   			tli.appendChild( div_bullet );
   			tli.appendChild( div_tc );
   			slides_cont.appendChild( sli );
   			thumbs_cont.appendChild( tli );
            // slide ve thumblari listele    al
            this.slides.push( sli );
            this.thumbs.push( tli );
        }
        foreach( this.thumbs, function(thumb){
   		// thumb sigdirma
   			css(thumb, { width : ( 100 / items.length ) + "%"  });
   		});
        addClass( this.slides[0], "active" );
        addClass( this.thumbs[0], "active" );
        this.current_index = 0;
        var slider_ref = this;
        foreach( this.thumbs, function( thumb ){
        	add_event( thumb, "click", function(){
        		slider_ref.click( this );
        	});
        });
    },
    this.click = function( clicked_thumb ){
    	var index = get_node_index( clicked_thumb );
   		// zaten aktifs slide a basılmışsa islem yapmiyoruz
   		if( index == this.current_index ) return false;
   		// bir önceki seçileni kapat
   		removeClass( this.thumbs[this.current_index], "active" );
   		removeClass( this.slides[this.current_index], "active" );
   		// seçilen slaytı aktif yap
   		addClass( clicked_thumb, "active" );
   		addClass( this.slides[get_node_index( clicked_thumb )], "active" );
   		// son state
   		this.current_index = get_node_index( clicked_thumb );
   	}
}

// SectionTab - Obarey Inc. 2016
var SectionTab = function( element, items, options ){
	this.init = function(){
		this.page_count = 1;
		this.active_page = 1;
		this.active_rows = [];
		this.section_rows = [];
		var sec_row = create_element( "div", [ "section-row", "clearfix" ] ),
			gal_item, gal_item_container, gal_item_thumb, gal_item_content, gal_item_title, sec_count = 1;
        // html olustur
        for( var i = 0; i < items.length; i++ ){   
        	gal_item = create_element( "div", ["gal-item"] );
        	gal_item_container = create_element("div", ["gal-item-container"]);
        	gal_item_thumb = create_element( "div", ["gal-item-thumb"]);
        	gal_item_content = create_element( "div", ["gal-item-content"]);
        	gal_item_thumb.appendChild( create_img( items[i].img, items[i].title ) );
        	gal_item_title = create_element( "span", [ "gal-item-title"] );
        	set_html( gal_item_title, items[i].title );
        	gal_item_content.appendChild(gal_item_title  );
        	gal_item_content.appendChild( this.create_tag_span( items[i].tags ) );
        	gal_item_container.appendChild( gal_item_thumb );
        	gal_item_container.appendChild( gal_item_content );
        	gal_item.appendChild( gal_item_container );
        	sec_row.appendChild( gal_item );
            // item click
            add_event( gal_item, "click", function(){
            	window.location = items[i].href;
            });
            // her dortte bir yeni row olustur
            if( sec_count == 4 || i == items.length - 1 ){
            	element.appendChild( sec_row );
            	this.section_rows.push( sec_row );
            	sec_row = create_element( "div", [ "section-row", "clearfix" ] );
            	sec_count = 0;
            }
            sec_count++;
        }
        this.total_row_count = this.section_rows.length;
        this.page_count = Math.ceil( this.total_row_count / options.row_count );
        for( var i = 0; i < options.row_count; i++ ) {
        	addClass( this.section_rows[i], "active" );
        	this.active_rows.push( i );
        }
        this.prev_buton = find_elem( element.parentNode, ".section-tab-prev" );
        this.next_buton = find_elem( element.parentNode, ".section-tab-next" );
        // tek sayfaysa butonlari gizle
        if( this.page_count == 1 ) {
        	hide( this.prev_buton );
        	hide( this.next_buton );
        } else {
            // butonlar varsa event attach et
            var section_ref = this;
            add_event( this.next_buton, "click", function(e){
            	section_ref.next_page();
            });
            add_event( this.prev_buton, "click", function(e){
            	section_ref.prev_page();
            });
        }
    },
    this.next_page = function(){
    	var start;
               /*  aktif rowlar = [ 3, 4 , 5 ]
                *  opt.row_count = 3
                *  for( i = 3; i < 3+3 ) 3, 4, 5 */

        for( var i = this.active_rows[0]; i < this.active_rows[0] + options.row_count ; i++ ){
        	removeClass( this.section_rows[i], "active" );
        }
        this.active_rows = [];

        if( this.active_page == this.page_count ){
        	this.active_page = 1;
        	for( var i = 0; i < options.row_count; i++ ) {
        		addClass( this.section_rows[i], "active" );
        		this.active_rows.push( i );
        	}
        } else {
                  
                  /*  active_page = 2
                   *  total_row_count = 9
                   *  aktif_rowlar = [ 5, 6, 7, 8 ]
                   *  opt.row_count = 5
                   *  start = 2 * 5 - 5 = 5
                   *  for( i = 5; i < 5 + 5 ) 5, 6, 7, 8 ( fazlaysa kesiyorum ) */
                  
            this.active_page++;
            start = this.active_page * options.row_count - options.row_count;
            for( var i = start; i < start + options.row_count; i++ ){
                // son sayfa tam dolmuyorsa fazladan 
                if( i < this.total_row_count ){
                	addClass( this.section_rows[ i ], "active" );
                	if( i < this.total_row_count ) this.active_rows.push( i );
                }
            }
        }

    },
    this.prev_page = function(){
    	var start;
    	for( var i = this.active_rows[0]; i < this.active_rows[0] + options.row_count ; i++ ){
    		removeClass( this.section_rows[i], "active" );
    	}
        // temizle aktifleri
        this.active_rows = [];
        if( this.active_page == 1 ){
            // ilk sayfadaysa prev yapildiginda son sayfaya git
            this.active_page = this.page_count;
                  /*  aktif rowlar = [ 0, 1, 2, 3, 4 ]
                   *  opt.row_count = 5
                   *  total_row = 9
                   *  start = 9 - 5 + 1 = 5
                   *  for( i = 5; i < 5 + 5 ) 6, 7, 8, 9 */
            start = this.total_row_count - options.row_count + 1;
            for( var i = start; i < start + options.row_count; i++ ) {
            	addClass( this.section_rows[i], "active" );
            	this.active_rows.push( i );
            }
        } else {

                  /*  active_page = 1
                   *  total_row_count = 9
                   *  aktif_rowlar = [ 6, 7, 8, 9 ]
                   *  opt.row_count = 5
                   *  start = 1 * 5 - 5 = 0
                   *  for( i = 0; i < 0 + 5 ) 0, 1, 2, 3, 4 */

            this.active_page--;
            start = this.active_page * options.row_count - options.row_count;
            for( var i = start; i < start + options.row_count; i++ ){
            	addClass( this.section_rows[ i ], "active" );
            	if( i < this.total_row_count ) this.active_rows.push( i );
            }
        }
    },
    this.create_tag_span = function( tags ){
    	var container = create_element("span", ["gal-item-tags"]), a, i;
    	foreach( tags, function(tag){
    		a = document.createElement( "a" );
    		a.href = "?tag="+tag;
    		a.className="tag";
    		i = document.createElement("i");
    		i.className = "tag";
    		set_html( i, tag );
    		a.appendChild(i);
    		container.appendChild( a );
    	});
    	return container;
    }
}

// right bar tab
var jwTab = function( options ){
	this.init = function(){
		this.bullets = find_elem( options.container, ".tab-button" );
		this.divs = find_elem( options.container, "[tabdiv]" );
		this.active_index = 0;
	    // ilk siradaki tabi aktif et
	    addClass( this.bullets[0], "selected" );
	    addClass( this.divs[0], "active" );
	    var this_ref = this;
	    add_event( this.bullets, "click", function(ev){
	    	this_ref.activate(this);
	    });
	},
	this.activate = function( bullet ){
	   	// tab bulletlerden aktive etme
	   	if( bullet.getAttribute("tab-toggle") == null ){
	   		var bullet_index = get_node_index( bullet.parentNode );
	   		if( bullet_index != this.active_index ){
	   			removeClass( this.divs[this.active_index], "active" );
	   			removeClass( this.bullets[this.active_index], "selected" );
	   			addClass( this.divs[bullet_index], "active" );
	   			addClass( this.bullets[bullet_index], "selected" );
	   			this.active_index = bullet_index;
	   		}
	    	// tab bullet harici attr lerden aktive etme
	    } else {
	    	for( var i = 0; i < this.divs.length; i++ ){
	    		if( this.divs[i].getAttribute("tabdiv") == bullet.getAttribute("tab-toggle") ){
	    			removeClass( this.divs[this.active_index], "active" );
	    			removeClass( this.bullets[this.active_index], "selected" );
	    			addClass( this.divs[i], "active" );
	    			addClass( this.bullets[i], "selected" );
	    			this.active_index = i;
	    			continue;
	    		}
	    	}
	    }
	}
}

var FormValidation = {
	errors: [],
	list: [],
	error_messages: {
		posnum: "Numerik ve sıfırdan büyük olmalıdır.",
		numeric: "Numerik değer giriniz.",
		req: "Boş bırakılamaz.",
		not_zero: "Sıfırdan büyük olmalıdır.",
		email: "Lütfen geçerli bir email adresi girin.",
		select_not_zero: "Lütfen seçim yapınız."
	},
	submit_btns:[],
	find_inputs: function (f){
		// Listeyi her kontrol öncesi bosalt
		this.list = [];
		var form = f, i;
		// ilk versiyonda tum inputlari listeliyordum
		//artik kontrol class i olanlari aliyoruz sadee
		for( i = 0; i <= form.elements.length; i++ ){
			if( form.elements[i] != undefined ) {
				if( 
					hasClass( form.elements[i], "posnum" ) ||
					hasClass( form.elements[i], "posnum" ) ||
					hasClass( form.elements[i], "req" )  ||
					hasClass( form.elements[i], "not_zero" )  ||
					hasClass( form.elements[i], "select_not_zero" )  ||
					hasClass( form.elements[i], "email" ) 
				) {
					if( form.elements[i].type == "text" ||
						form.elements[i].type == "textarea" ||
						form.elements[i].type == "password" ||
						form.elements[i].type == "email" ||
						form.elements[i].type == "select-one" ||
						form.elements[i].type == "select-multiple" ||
						form.elements[i].type == "checkbox"
						) this.list.push( form.elements[i] );
					// Radio secildiyse
					if( form.elements[i].type == "radio" ){
						if( form.elements[i].checked ) this.list.push( form.elements[i] );
					}
				}
				// submit btn
				if( form.elements[i].type == "submit" ) this.submit_btns.push( form.elements[i] );
			}
		}
		this.keyup( f );
	},
	check: function(f){
		this.find_inputs(f);
		this.check_input( this.list );
		if( this.is_valid() ) {
			return true;
		} else {
			this.show_errors();
		}
	},
	// form submit esnasinda tum submit butonlari disabled yap
	// birden fazla olabilir submit o yuzden array
	disable_submit_btn: function( flag ){
		var status_text, i, prevtext = "Kaydet";
		if( this.submit_btns[0].getAttribute("oldval") != undefined ) prevtext = this.submit_btns[0].getAttribute("oldval");
		for( i = 0; i < this.submit_btns.length; i++ ){

			status_text = "Lütfen bekleyin..."
			if( !flag ) status_text = prevtext;
			this.submit_btns[i].disabled = flag;
			this.submit_btns[i].value = status_text;
		}
	},
	get_input_list: function(){
		return this.list;
	},
	check_input: function(input){
		// Toplu kontrol
		var elem, i, x;
			input_count = input.length;
		// gelen inputlarin sayisini inputlar array halinde geldiginde aliyoruz
		// eger tek bir input gelirse length = undefined oluyor. buradan tek input geldigini anlayip
		// loop icin son limiti 1 yapiyoruz yani bir kere loop yapiyor.
		if( input_count == undefined ) input_count = 1;
		for( i = 0; i < input_count; i++ ){
			// burada da input tekse direk onu loop ta isleme aliyoruz
			// eger liste halinde geldiyse, listenin elemanlarini tek tek isliyoruz
			( input instanceof Array ) ? elem = input[i] : elem = input;
			for( x in this.error_messages ){
				if( hasClass( elem, x ) ){
					// ornek -> this.posnum( val )
					if( !this[x]( elem.value ) ) this.errors.push( [ elem, this.error_messages[x] ] );
				}
			}
		}
	},
	is_valid: function(){
		return ( this.errors.length == 0 );
	},
	show_serverside_errors: function( errors ){
		this.errors = errors;
		this.show_errors();
	},
	show_errors: function(){
		var co = this.errors.length;
		for( var i = 0; i < co; i++ ){
			// input'un kontrol parent'ina error notf divini ekle
			var elem = this.errors[i][0];
			// Hata zaten varsa yeni error divleri yapma
			if( !hasClass(elem, "redborder") ){
				addClass(elem, "redborder");
			}
		}
		// Hatalari gosterdikten sonra bosalt
		// Bir önce kontrol edilen formun hatalarindan kurtulmak
		this.errors = [];
	},
	hide_error: function( e ){
		var p = e.parentNode, pc = p.childNodes, i;
		removeClass(e, "redborder" );
		// input-error divini bul ve sil
		for( i = 0; i < pc.length; i++ ){
			if( pc[i] != undefined ) 
				if( hasClass(pc[i], "input-error") ) {
					p.removeChild(p.childNodes[i]);
				}
		}
	},
	close_error_dialogue: function( error_div ){
		console.log( error_div );
	},
	numeric: function( val ){
		return !isNaN(val);
	},
	posnum: function( val ){
		// console.log( val );
		// Bos birakilmissa true don, onu kontrol icin req() fonksiyonu var
		if( trim(val) == "") return true;
		return (val - 0) == val && trim( (''+val) ).length > 0 && !( val < 0 );
	},
	not_zero: function( val ){
		return !( val <= 0 );
	},
	req: function( val ){
		return !( trim( val ) == "" || val == undefined );
	},
	select_not_zero: function(val){
		return val != 0;
	},
	int_only: function( val ){
		var str = val.toString();
		return !(str.indexOf(".") != -1 );
	},
	email: function( val ){
		if( trim(val) == "" ) return true;
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(val);
	},
	// keyuta error gizleme
	keyup: function (form){
		$(form).on("keyup", ".req, .posnum, .email, .not_zero", function(){
			if(hasClass(this, "redborder")) removeClass(this, "redborder");
		});
		$(form).on("change", ".select_not_zero", function(){
			if(hasClass(this, "redborder")) removeClass(this, "redborder");
		});
	},
	error_to_pnotfiy: function( inputret ){
		var str = "";
		for( var key in inputret ){
			str += inputret[key] + "</br>";
		}
		return str;
	}
};


var Popup = {
	overlay: "popup-overlay",
	popup  : "popup",
	open   : false,
	on: function( data, header, loader ){
		show( $AH(this.overlay) );
		var	i = $AH(this.popup);
		show(i);
		if( loader == undefined ){
			removeClass( $AH(this.popup), "loader" );
		}

		// Once datalari yazdir
		set_html( i,  "<div id='popup-buton' onclick='Popup.off()'>X</div><div id='popup-header'>"+header+"</div><div id='popup-content'>" + data +"</div>");
		// Ã–lÃ§ - ortala
		css( i, {
			//left: "50%",
			//marginLeft:  "-" + ( i.offsetWidth / 2 ) + "px",
			top: ( document.body.scrollTop + 30 ) + "px"
		});
		this.open = true;
	},
	off: function(){
		hide($AH(this.overlay));
		$AH(this.popup).innerHTML = "";
		hide($AH(this.popup));
		this.open = false;
		removeClass( $AH(this.popup), "loader" );
	},
	start_loader:function(){
		addClass( $AH(this.popup), "loader" );
		this.on( '<img src="'+Common_Base.URL_LOADER+'" />', "Lütfen bekleyin...", true );
	},
	is_open: function(){
		return this.open;
	}
}

function manual_serialize( j ){
	var i, s = [], c, str = "";
	if( Object.size(j) > 0 ){
		for( i in j ){
			s.push( i + "=" + j[i] );
		}
		str = s.join("&");
	}
	return str;
}

// uzun stringleri lim_len kadar karakterden sonra ikiye bolup br cakiyoruz arasina
function br_string( string, lim_len ){
	if( string.length > lim_len ){
		return string.substr( 0, lim_len ) + '<br>' + string.substr( lim_len, string.length );
	}
	return string;
}


function serialize(form) {
	if (!form || form.nodeName !== "FORM") {
		return;
	}
	var i, j, q = [];
	for (i = form.elements.length - 1; i >= 0; i = i - 1) {
		if (form.elements[i].name === "") {
			continue;
		}
		if( form.elements[i].getAttribute("disabled") != undefined ) continue;
		switch (form.elements[i].nodeName) {
			case 'INPUT':
			switch (form.elements[i].type) {
				case 'text':
				case 'hidden':
				case 'password':
				case 'email':
				case 'button':
				case 'reset':
				case 'submit':
				q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
				break;
				case 'checkbox':
				case 'radio':
				if (form.elements[i].checked) {
					q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
				}						
				break;
				case 'file':
				break;
			}
			break;			 
			case 'TEXTAREA':
			q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
			break;
			case 'SELECT':
			switch (form.elements[i].type) {
				case 'select-one':
				q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
				break;
				case 'select-multiple':
				for (j = form.elements[i].options.length - 1; j >= 0; j = j - 1) {
					if (form.elements[i].options[j].selected) {
						q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].options[j].value));
					}
				}
				break;
			}
			break;
			case 'BUTTON':
			switch (form.elements[i].type) {
				case 'reset':
				case 'submit':
				case 'button':
				q.push(form.elements[i].name + "=" + encodeURIComponent(form.elements[i].value));
				break;
			}
			break;
		}
	}
	return q.join("&");
}

var REQ = {
	URL_DOWNLOAD: "",
	ACTION: function( url, data, cb ){
	    $.ajax({
	        type: "POST",
	        url:url,
	        dataType: 'json',
	        data: data,
	        success: function(res){
	            if( typeof cb == 'function' ) cb( res );
	        },
	        error: function( jqXHR, textStatus, errorThrown ){
	            console.log(textStatus);
	            console.log(errorThrown);
	            // console.log(data);
	        }
	    });
	}
};

function PamiraNotify( type, header, text, hide ){
	if( hide == undefined ) hide = true;
	new PNotify({
          title: header,
          text: text,
          type: type,
          styling: 'bootstrap3',
          hide: hide
      });
}


// var base_li = create_element( "li", [] ),
				// 	item_header  = create_element( "div", ["item-header"] ),
				// 	item_cont = create_element( "div", ["item-container", "clearfix"] ),
				// 	left_side = create_element("div", ["left-side", "clearfix"]),
				// 	preview_cont = create_element("div", ["preview-container", "ov_12_9"]),
				// 	round_border = create_element("div", ["round-border"]),
				// 	preview_img = create_img( "res/temp_upload/hawa.jpg", "Preview" ),
				// 	options_cont = create_element("div", ["options-container"]),
				// 	options_ul = create_element("ul", ["options-list", "clearfix"]),
				// 	navi_cont = create_element( "div", ["navigation-container"]),
				// 	navi_ul = create_element( "ul", [] ),
				// 	navi_ul_li, option_base_li, option_title, opt_ul, opt_li, opt_li_a;

				// // varyantları oluştur	
				// for( var i = 0; i < TestVariants.length; i++ ){
				// 	option_base_li = create_element( "li", [] );
				// 	option_title = create_element( "span", ["option-header"] );
				// 	set_html( option_title, TestVariants[i].title );
				// 	opt_ul = create_element("ul", ["option"]);
				// 	opt_ul.setAttribute("option", TestVariants[i].title);
				// 	for( var x = 0; x < TestVariants[i].options.length; x++){
				// 		opt_li = create_element("li",[]);
				// 		opt_li_a = create_element("a", [] );
				// 		opt_li_a.href="";
				// 		set_html(opt_li_a, TestVariants[i].options[x] );
				// 		opt_li.appendChild(opt_li_a);
				// 		opt_ul.appendChild( opt_li );
				// 	}	
				// 	option_base_li.appendChild(option_title);
				// 	option_base_li.appendChild(opt_ul);
				// 	options_ul.appendChild(option_base_li);
				// }
				// options_cont.appendChild(options_ul);

				// // sag navigasyon butonları
				// var navi_buttons = ["Resmi Yükle", "Listeye Ekle", "Sipariş Notu Ekle", "İptal Et"],
				// 	navi_buttons_icons = ["upload_picture", "add_to_list", "add_note", "cancel"];
				// for( var i = 0; i < navi_buttons.length; i++ ){
				// 	navi_ul_li = create_element("li", [] );
				// 	var li_a = create_element("a", []);
				// 	li_a.appendChild( create_element("i", [navi_buttons_icons[i]] ) );
				// 	append_html(li_a, "#"+navi_buttons[i]);
				// 	navi_ul_li.appendChild(li_a);
				// 	navi_ul.appendChild(navi_ul_li);
				// }
				// // sag preview ve fiyat 
				// var nav_bottom = create_element("div", ["nav-bottom-section"]),
				// 	bottom_prev = create_element("div", ["preview-container"]),
				// 	price_cont = create_element("div", ["price-container"]),
				// 	price_span = create_element("span", [] ),
				// 	price_bold = create_element("span", ["price"]);

				// // sag alt olusturma
				// price_span.appendChild( price_bold );
				// set_html(price_bold, "10 TL");
				// price_cont.appendChild(price_span);
				// bottom_prev.appendChild( create_img( "res/temp_upload/hawa.jpg", "Preview" ) );
				// nav_bottom.appendChild( bottom_prev );
				// nav_bottom.appendChild( price_cont );
				// navi_cont.appendChild( navi_ul );
				// navi_cont.appendChild( nav_bottom );

				// // sol taraf
				// round_border.appendChild( preview_img );
				// preview_cont.appendChild(round_border);
				// left_side.appendChild( preview_cont );
				// left_side.appendChild( options_cont );
				// item_cont.appendChild(left_side);
				// item_cont.appendChild( navi_cont );
				// set_html(item_header, "Oval Seri");
				// // final container
				// base_li.appendChild( item_header);
				// base_li.appendChild( item_cont);	
				// listeye ekle






				 // AHReady( function(){

                //     var tab_divs_container = find_elem( document, ".tab-divs"),
                //         tab_bullets_container = find_elem( document, ".tab-bullets");
                //     for( var i = 0; i < tab_divs_container.length; i++ ){
                //         var div = find_elem( tab_divs_container[i], "li" ),
                //             bullet = find_elem( tab_bullets_container[i], "li" );
                //         addClass( div[0], "selected" );
                //         addClass( bullet[0], "selected" );
                //     }
                //     add_event( $AHC("tab-bullet"), "click", function(){
                //         if( !hasClass(this, "selected")){
                //             var parent = this.parentNode.parentNode.parentNode,
                //                 divs   = find_elem( find_elem( parent, ".tab-divs" ), "li" ),
                //                 bullets   = find_elem( find_elem( parent, ".tab-bullets" ), "li" );
                //             for( var i = 0; i < divs.length; i++ ){
                //                 removeClass( divs[i], "selected");
                //                 removeClass( bullets[i], "selected");
                //             }
                //             addClass( divs[get_node_index(this.parentNode)], "selected" );
                //             addClass( this.parentNode, "selected");
                //         }
                //     });


                // });