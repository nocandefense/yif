jQuery("document").ready(function($) {
    console.log("-- performant-iframe.js (loaded) --");
    console.log("version 3");

    $("figure.p-iframe-wrap").each(function() {
	let thumbnail = $(this);
	thumbnail.click(function() {
	    thumb = thumbnail.find(".p-iframe-thumb");
	    playBtn = thumbnail.find(".p-iframe-play-btn");
	    $iframe = thumbnail.attr("data-attribute");
	    thumb.replaceWith($iframe);
	    playBtn.remove();
	});
    });

});

