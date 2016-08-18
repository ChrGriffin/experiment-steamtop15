$(document).ready(function(){
	// get all the games on the page
	var games = $('.games_container .game');

	// perform the following function for each game
	// pass the index to the function to be used as a delay multiplier for a stylish staggered animation
	$(games).each(function(index){

		// get the width percentage (this is calculated via PHP and echoed out as a data attribute)
		var percentage = $(this).attr('data-percentage');
		// using the index as a multiplier, delay a certain amount of time before executing the animation
		// animate the width to the correct percentage
		$(this).delay(20 * index).animate({'width': percentage}, 1000, 'easeInOutQuint');
	});
});