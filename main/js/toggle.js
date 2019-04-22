const APP_VER = '1.0.0';
const APP_REL = '20181209';

// ==================================================================================================================

function doCompare() {
    $('[id^="size-"]').each(function(){
        var $row = $(this).find('.row:eq(1)');
        $(this).find('.row:eq(0) .col').each(function(idx){
            console.log(idx);
            var strHtml = '<div class="badge badge-success text-monospace">H: '+ $(this).find('div.toggle, .btn, [class^="form-control"]').css('height') +'</div>';
            $row.find('.col:eq('+idx+')').append( strHtml );
        });
    });
}

function appStartup() {
    setTimeout(doCompare,500);
}

// ==================================================================================================================
window.onload = function(){ appStartup() };