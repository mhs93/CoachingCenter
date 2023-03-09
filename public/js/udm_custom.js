
//Home page Carousel video
$('.hero-play-button').on('click', function (ev) {
  $(".hero-video-iframe iframe")[0].src += "&autoplay=1";
  ev.preventDefault();
  $(".hero-iframe-video .hero-video-iframe").css('display', 'block');
  $(".hero-play-button").css('display', 'none');
  $(".hero-iframe-video img").css('display', 'none');   
}); 


//Iframe Video Section
$('.play-button').on('click', function (ev) {
    $('#carouselVideo').attr('data-bs-interval', "false");
    ev.preventDefault();
    var selectedId = $(this).attr("data-id");
    console.log(selectedId);
    $(".iframe-video").each(function () {
        var cId = $(this).attr("data-id");       
        console.log(cId);
        if (cId == selectedId) {
            $("#iframe-video-iframe-" + cId)[0].src += "&autoplay=1";
            $("#iframe-video-container-" + cId).css('display', 'block');
            $("#iframe-play-button-" + cId).css('display', 'none');
            $("#iframe-video-img-" + cId).css('display', 'none');
        }
        else {
            $("#iframe-video-iframe-" + cId)[0].src +="?autoplay=1";
            $("#iframe-video-container-" + cId).css('display', 'none');
            $("#iframe-play-button-" + cId).css('display', 'flex');
            $("#iframe-video-img-" + cId).css('display', 'block');
        }
    });        
});


//Iframe Video Section
//var i = 0;
//$(".video-section .images").each(function () {
//    $('.play-button').on('click', function (ev) {
//      $('#carouselVideo').attr('data-bs-interval', "false");
//      $(".video-iframe iframe")[0].src += "&autoplay=1";
//      ev.preventDefault();
//      $(".iframe-video .video-iframe").css('display', 'block');
//      $(".play-button").css('display', 'none');
//      $(".iframe-video img").css('display', 'none'); 

//        $(".video-iframe2 iframe")[0].src += "?autoplay=1";
//        $(".iframe-video2 .video-iframe2").css('display', 'none');
//        $(".play-button2").css('display', 'flex');
//        $(".iframe-video2 img").css('display', 'block');
//    });
//    i++;
//});

//Iframe Video2 Section
//$('.play-button2').on('click', function (ev) {
//    $('#carouselVideo').attr('data-bs-interval', "false");
//    $(".video-iframe2 iframe")[0].src += "&autoplay=1";
//    ev.preventDefault();
//    $(".iframe-video2 .video-iframe2").css('display', 'block');
//    $(".play-button2").css('display', 'none');
//    $(".iframe-video2 img").css('display', 'none');

//    $(".video-iframe iframe")[0].src += "?autoplay=1";
//    $(".iframe-video .video-iframe").css('display', 'none');
//    $(".play-button").css('display', 'flex');
//    $(".iframe-video img").css('display', 'block');
//});

//Course Details Video
$('.course-iframe-video .course-play-button').on('click', function (ev) {
    $(".course-iframe-video iframe")[0].src += "&autoplay=1";
    ev.preventDefault();
    $(".course-iframe-video .video-iframe").css('display', 'block');
    $(".course-iframe-video .course-play-button").css('display', 'none');
    $(".course-iframe-video img").css('display', 'none');
});

//hero slider responsive script
if (window.matchMedia('(max-width: 1140px)').matches)
{
    $(".hero-fluid").removeClass("container-fluid").addClass("container");        
}


  