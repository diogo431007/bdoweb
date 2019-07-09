$(function() {
    
    
            $('#principal').tabs({ fxFade: true, fxSpeed: 'fast' });


            $('<p><a href="#">Disable third tab<\/a><\/p>').prependTo('#parte-28').find('a').click(function() {
                $(this).parents('div').eq(1).disableTab(3);
                return false;
            });
            $('<p><a href="#">Activate third tab<\/a><\/p>').prependTo('#parte-28').find('a').click(function() {
                $(this).parents('div').eq(1).triggerTab(3);
                return false;
            });
            $('<p><a href="#">Enable third tab<\/a><\/p>').prependTo('#parte-28').find('a').click(function() {
                $(this).parents('div').eq(1).enableTab(3);
                return false;
            });

});