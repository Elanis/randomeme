/**
 * Set a cookie.
 *
 * @param      {string}  cname   Cookie name
 * @param      {string}  cvalue  Cookie value
 * @param      {number}  exdays  Expiration day count
 */
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

/**
 * Get a cookie's value
 *
 * @param      {string}  cname   Cookie name
 * @return     {string}  Cookie's Value
 */
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

/**
 * Check if a cookie exists
 *
 * @param      {<type>}   cname   Cookie name
 * @return     {boolean}  Check if exists or not
 */
function existCookie(cname) {
    var content = getCookie(cname);
    if (content != "" || content!=null) {
        return true;
    } else {
        return false;
    }
}