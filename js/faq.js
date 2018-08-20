$(function() {

    $(".question .title").on("click", function() {
    	FAQ.toggleAnswer(this);
    });

    $(".question .toggle").on("click", function() {
    	var $title = $(this).siblings(".title");
    	FAQ.toggleAnswer($title);
    });
});

FAQ =  {
	toggleAnswer: function(element) {
	   if($(element).siblings(".answer").is(":visible")) return false;
	   $(".question .toggle").html(" + ");
	   $(element).siblings(".toggle").html(" - ");
	   $(".answer").hide("slow");
	   $(element).siblings(".answer").slideToggle("slow");
	}
}