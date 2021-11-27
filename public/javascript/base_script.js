//title_barの高さとyの位置を取得
var navPos = $( '#title_bar' ).offset().top; // グローバルメニューの位置
var navHeight = $( '#title_bar' ).outerHeight(); // グローバルメニューの高さ

//title_barをスクロールしても良しなに一番上に表示されるようにする
jQuery( window ).on( 'scroll', function() {
	if ( jQuery( this ).scrollTop() > navPos ) {
		jQuery( '#title_bar' ).addClass( 'fixed' );
	} else {
		jQuery( '#title_bar' ).removeClass( 'fixed' );
	}
});

//mobile_menu_buttonを、いい感じの所で、いい場所に表示させる
jQuery( window ).on( 'scroll', function() {
	if ( jQuery( this ).scrollTop() > navPos ) {
		jQuery( '#mobile_menu_button' ).css( 'display', 'none' );
		jQuery( '#mobile_menu_button' ).addClass( 'fixed' );
	} else {
		jQuery( '#mobile_menu_button' ).css( 'display', 'block' );
		jQuery( '#mobile_menu_button' ).removeClass( 'fixed' );
	}
});

scrollBy(1, 1);