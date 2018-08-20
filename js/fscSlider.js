/**
 * Name           :  fscSlider.js
 * Version        :  0.0.1
 * Author         :  Lawrence Aberba (amazingws.0fees.us, twitter: @laberba)
 * Copyright      :  Copyright (c) 2015 Laberba Creative Works
 * Description    :  A fast, simple and clean coded slider which works :)
 * Dependencies   :  jQuery Version 1 or never

                     Default configuration options for fscSlider
                     Note: Do not add any 'px' to arguments for width and height because
                           they are added by default in the code
                     defaultOptions = {
                         slideWidth: 600,
                         slideHeight: 300,
                         slideSpeed: 350,
                         slideInterval: 3000,
                         tooltipTextColor: "rgba(0, 0, 0, 0.8)",
                         tooltipBackgroundColor: "#ffffff",
                         tooltipWidth: 300,
                         tooltipHeight: null,
                     };
 */

;(function($) {
    $.fn.fscSlider = function(customOptions) {
    	var options = $.extend({}, $.fn.fscSlider.defaultOptions, customOptions);
        var slideAllowed = true;

        var slider = $(this);
        slider.css({
            width: options.slideWidth + "px",
            height: (options.slideHeight === null) ? "auto" : options.slideHeight + "px"
        });

        // Configure sildes
        slider.children("img").addClass("slide"); // Give each slide a className of "slide"
        slider.children("img:first").addClass("current"); // Set first slide as current

        // Set slide width with the optinal slide with
        slider.children("img").css({
            width: options.slideWidth + "px",
            height: (options.slideHeight === null) ? "auto" : options.slideHeight + "px",
        });


        //create textbox for each slider image alt text
        var tooltip = $("<div />", {"class":"tooltip-div"}).css({
            position: "absolute",
            top: "20px",
            left: options.tooltipLeftOffset + "px",
            right: options.tooltipRightOffset + "px",
            padding: options.tooltipPadding + "px",
            borderRadius: "3px",
            textAlign: "center",
            color: options.tooltipTextColor,
            textShadow: "1px 1px rgba(0,0,0,0.10)",
            boxShadow: "1px 1px rgba(0,0,0,0.10)",
            width: options.tooltipWidth + "px",
            height: (options.tooltipHeight === null) ? options.tooltipHeight + "px" : "auto",
            backgroundColor: options.tooltipBackgroundColor,
            zIndex: 3
        })
        .append( $("<h4 />").html(slider.children("img.current").data("tooltipheader")) )
        .append( $("<p />").html(slider.children("img.current").data("tooltipcontent")) );

        slider.append(tooltip);

        // Add navigation arrows
        var nextArrow = $("<span />", {"class":"arrow next", "html":"&raquo;"}).css({
            top: options.arrowsTopOffset + "px",
            right: options.arrowsSideOffset + "px"
        });
        var prevArrow = nextArrow.clone().removeClass("next").addClass("prev").html("&laquo;").css({
            right: "0px",
            left: options.arrowsSideOffset + "px"
        });
        slider.append(nextArrow).append(prevArrow);

        /**
         * Function called to slide to next image
         * Note: this function takes a boolen argument, true for forward slide and
           false for back slide
         */
        var _next = function(direction) {
            if (direction === null || direction === undefined) throw new Error("_next() expects a boolean argument 'direction'");

            var current = slider.children("img.current"),
                next,
                delta = 1; // -1 for back slide animation offset and +1 for forward slide offset

            if (direction) { // true boolen means slide forward
                next    = current.next();
                if (!next.is("img.slide")) next = slider.children("img:first");
                delta = 1;

            } else { // "false" boolen means slide back
                next = current.prev();
                if (!next.is("img.slide")) next = slider.children("img:last");
                delta = -1;
            }


            // Fadeout tooltip
            // Note: tooltip is show after slide is updated and the tooltip's content is also updated
            tooltip.fadeOut("slow");

            // When delta is +ve, slide image will be displaced right in the animation
            // else when delta is -ve, slide image will be displaced left.
            next.animate({ left: (options.slideWidth * delta) + "px" }, 200, "linear", function() {
                next.addClass("current"); // Set the next slide as current to bring it on top
                current.removeClass("current").addClass("previous"); // Send current slide below

                // Move the next slide back in-place to be ontop
                next.animate({left:0}, options.slideSpeed, "linear", function() {
                    current.removeClass("previous"); // set the replaced slide back to normal place just as the others with a z-index of zero

                    tooltip.children("h4").html(next.data("tooltipheader")); // Update tootip header
                    tooltip.children("p").html(next.data("tooltipcontent")); // Update tootip content
                    tooltip.fadeIn("slow"); // Now show the tooltip
                });

            });

        }

        // Bind event to updates 'slideAllowed' for pausing or resuming slide
        slider.children("img.slide, .arrow").on("mouseover focus", function() {
            slideAllowed = false;
        });

        slider.children("img.slide, .arrow").on("mouseout blur", function() {
            slideAllowed = true;
        });


        // Make event binding and setInterval for forward slide
        slider.children(".next").on("click", function() {
            _next(true);
        });

        slider.children(".prev").on("click", function() {
            _next(false);
        });

        setInterval(function() {
            if (slideAllowed) _next(true);
        }, options.slideInterval);
    };

    $.fn.fscSlider.defaultOptions = {
        slideWidth: 600,
        slideHeight: 300,
        slideSpeed: 350,
        slideInterval: 3000,
        tooltipPadding: 5,
        tooltipTextColor: "rgba(0, 0, 0, 0.8)",
        tooltipBackgroundColor: "#ffffff",
        tooltipWidth: 300,
        tooltipHeight: null,
        tooltipTopOffset: 20,
        tooltipLeftOffset: 20,
        tooltipRightOffset: 0,
        arrowsTopOffset: 50,
        arrowsSideOffset: 20
    };

}(jQuery));
