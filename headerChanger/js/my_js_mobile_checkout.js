window.onload = function() 
{
    if(!window.location.hash) 
    {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}
console.log("my_js_mobile_checkout_loaded :)");