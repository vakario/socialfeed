$(document).ready(function() {

	var color1 = $('#social_feed_display  #tw_feed .tweet_text').css('color');
	var color2 = $('#social_feed_display .color_line_two').css('color');
	
	console.log('1=' +color1);
	console.log('2=' +color2);


	$('#tw_feed .tweet_text').each(function(index, element) {
/*        var titi = $(this).text().replace(new RegExp("\(?:(http|https|ftp):\/\/)((?:www.)?(?:[^\W\s]|\.|-)+[\.][^\W\s]{2,4})(?::(\d*))?([\/]?[^\s\?]*[\/]{1})*(?:\/?([^\s\n\?\[\]\{\}\#]*(?:(?=\.)){1}|[^\s\n\?\[\]\{\}\.\#]*)?([\.]{1}[^\s\?\#]*)?)?", "g"), '');
*/		
		var toto = $(this).text().split(" ");
		var titi = "";
		
		$(toto).each(function(index, element) {
			
/*			console.log(element + "===>>>>" + element.search(new RegExp("\(?:(http|https|ftp):\/\/)", "g")));
*/
            if(element.search(new RegExp("\(?:(http|https|ftp):\/\/)", "g")) != -1)
			{
				titi += '<a target="_blank" class="tw_link" href="'+element+'">+++ '+ seemore +' +++ </a>';
			}
			else if(element.search(new RegExp("\(?:(@))", "g")) != -1)
			{
				var elm = element.substr(1, element.lenght);
				titi += '<a target="_blank" class="tw_user" href="http://twitter.com/'+elm+'"> '+ element +'  </a>';
			}
			else
			{
				titi += element +" ";
			}
      });
	   $(this).html(titi);
	   
		
    });
});
