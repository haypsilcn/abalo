// Create cookie
function setCookie(cookieName, cookieValue, expireDay) {
    const date = new Date();
    date.setTime(date.getTime() + (expireDay*24*60*60*1000));
    let expires = "expires="+ date.toUTCString();
    document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
}

// Delete cookie
function deleteCookie(cookieName) {
    const date = new Date();
    date.setTime(date.getTime() + (24*60*60*1000));
    let expires = "expires="+ date.toUTCString();
    document.cookie = cookieName + "=;" + expires + ";path=/";
}

// Read cookie
function getCookie(cookieName) {
    let name = cookieName + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');

    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];

        while (c.charAt(0) === ' ')
            c = c.substring(1);

        if (c.indexOf(name) === 0)
            return c.substring(name.length, c.length);

    }
    return "";
}

// Set cookie consent
function acceptCookieConsent(){
    deleteCookie('user_cookie_consent');
    setCookie('user_cookie_consent', 1, 30);
    document.getElementById("cookieNotice").style.display = "none";
}

let cookie_consent = getCookie("user_cookie_consent");
if(cookie_consent !== ""){
    document.getElementById("cookieNotice").style.display = "none";
}else{
    document.getElementById("cookieNotice").style.display = "block";
}
