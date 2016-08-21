$(document).ready(function(){
 
$("#MainDiv").on("swipeleft",swipe_left);
$("#MainDiv").on("swiperight",swipe_right);
 
//Sammelt alle URLs zu den Bilder die sich im Slider befinden.
var tn_array = $("#slider img").map(function () {
	return $(this).attr("src");
}).get();
 
$('#MainImage').attr('src', tn_array[0]);
// $('#Previous').css("visibility", "hidden");
 
 
var lengthImages = tn_array.length;
var CurrImage = 0;
var widthImg = 200;
var BottomLength = 4;
var IndexDiff;
 
$('.slide img').click(function () {
	var Imagesrc = $(this).attr('src');
	var ImageIndex = $(this).parent('.slide').index();
 
	$('#MainImage').fadeOut(200, function () {
 
		$('#MainImage').attr('src', Imagesrc);
 
	}).fadeIn(200);
});

$('#Next').click(function () {
 
	$('#MainImage').fadeOut(200, function () {
		CurrImage = CurrImage + 1; // Update current image index
		if(CurrImage > (tn_array.length - 1)) {
			CurrImage = 0;
		}
		$('#MainImage').attr('src', tn_array[CurrImage]); // set image to Main image
		}).fadeIn(200);
 
});

$('#Previous').click(function () {
	$('#MainImage').fadeOut(200, function () {
		CurrImage = CurrImage - 1;
		if(CurrImage < 0) {
			CurrImage = tn_array.length - 1;
		}
		$('#MainImage').attr('src', tn_array[CurrImage]);
 
	}).fadeIn(200);
});
 
 
$('.slide > img').hover(function () {
	$(this).css('cursor', 'pointer');
	$(this).css({ 'filter': 'alpha(opacity=50)', 'opacity': '0.5' });
}, function () {
	$(this).css('cursor', 'none');
	$(this).css({ 'filter': 'alpha(opacity=100)', 'opacity': '1' });
});
 
 
function swipe_right(){
	$('#MainImage').fadeOut(200, function () {
		CurrImage = CurrImage - 1;
		if(CurrImage < 0) {
			CurrImage = tn_array.length - 1;
		}
		$('#MainImage').attr('src', tn_array[CurrImage]);
 
	}).fadeIn(200);
 
}

function swipe_left(){
	$('#MainImage').fadeOut(200, function () {
		CurrImage = CurrImage + 1;
		if(CurrImage > (tn_array.length - 1)) {
			CurrImage = 0;
		}
		$('#MainImage').attr('src', tn_array[CurrImage]);
 
	}).fadeIn(200);
 
}
 
 
//var CurrSlides = 0;
 
//setInterval(function () {
// $('#slider .slides').animate({ 'margin-left': '-=200' }, 1000,
// function () {
// CurrSlides = CurrSlides + 1;
// if (CurrSlides === tn_array.length-3) {
// //CurrSlides = 0;
// $('#slider .slides').css('margin-left', '600');
// }
// });
//}, 3000);
 
 
});