console.log("my_js_pc_chekout_loaded :)");

window.onload = function() 
{
    if(!window.location.hash) 
    {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}

