jQuery("document").ready(function($) {
    console.log("-- performant-iframe.js (loaded) --");
    console.log("version 3");
    let myWidth="100%";
    let myHeight="100%";
    let domain_name = document.location.hostname;
    let icon_dir_path = '/wp-content/plugins/performant-iframe/icons/';
    let light_play_btn = 'youtube-play-0.png';
    let dark_play_btn = 'youtube-play-1.png';
    
    $("figure.p-iframe-wrap").each(function() {
	let thumbnail = $(this);
	thumbnail.click(function() {
	    thumb = thumbnail.find(".p-iframe-thumb");
	    playBtn = thumbnail.find(".p-iframe-play-btn");
	    $iframe = thumbnail.attr("data-attribute");
	    $iframe = $iframe.replace(/width="([0-9])+"/, `width="${myWidth}"`);
	    $iframe = $iframe.replace(/height="([0-9])+"/, `height="${myHeight}"`);
	    playBtn.remove();
	    thumb.replaceWith($iframe);
	});
    });

    $(".p-iframe-wrap").hover(function () {
	let btn = $(this).find(".p-iframe-play-btn");
	btn.css("color", "red");
    }, function () {
	let btn = $(this).find(".p-iframe-play-btn");
	btn.css("color", "black");
    });
});

