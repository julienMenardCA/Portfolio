// Le code JS ci-dessous sert à rendre la section du CV deployable
let coll = document.getElementsByClassName("collapsible");

for (let i = 0; i < coll.length; i++)
{
	coll[i].addEventListener("click", function() {
		this.classList.toggle("collapsed");
		let content = this.nextElementSibling;
		if (content.style.maxHeight)
		{
			content.style.maxHeight = null;
		}
		else
		{
			content.style.maxHeight = content.scrollHeight + "px";
		}
	});
}

//Code JS pour le bouton de retour en haut de page
$(document).ready(function(){
	$(window).scroll(function () {
			if ($(this).scrollTop() > 50) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		// scroll body to 0px on click
		$('#back-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
});