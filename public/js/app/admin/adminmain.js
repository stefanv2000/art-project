$(document).ready(function(){
    $('.nav a').each(function(index,element){
        console.log(index,$(this).get(0).href);
        if (window.location.href == $(this).get(0).href) {
            $(this).addClass('navlinkactive');
        }
    });

    $('#canceleditbutton').click(function(e){
        e.preventDefault();
        parent.history.back();
    })
});

function makeLinkActive(section){
    $('.nav li a').each(function(index,elem){
        if ($(this).attr('href').indexOf("/admin/"+section)>=0) $(this).addClass("navlinkactive");
    });
}