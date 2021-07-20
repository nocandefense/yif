jQuery("document").ready(function($) {
    console.log("-- performant-iframe.js (loaded) --");
    console.log("version 3");
    myWidth="100%";
    myHeight="100%";
    
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

});

