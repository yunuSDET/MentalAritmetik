
function kazanilanPuaniHesaplaVeGonder(earnedPoints) {
    console.log("Kazanılan Puan: " + earnedPoints);

    var currentPageName = window.location.pathname.split("/").pop();

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "saveData.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var userId = getLoggedInUserId();
    var params = "userId=" + userId + "&earnedPoints=" + earnedPoints + "&pageName=" + currentPageName;

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log("Veritabanına başarıyla kaydedildi.");
        }
    };

    xhr.send(params);
}


function kazanilanSureyiHesaplaVeGonder(earnedTime) {
    console.log("Kazanılan Zaman: " + earnedTime);

    var currentPageName = window.location.pathname.split("/").pop();

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "saveData.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var userId = getLoggedInUserId();
    var params = "userId=" + userId + "&earnedTime=" + earnedTime + "&pageName=" + currentPageName; // earnedPoints yerine earnedTime düzeltildi

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log("Veritabanına başarıyla kaydedildi.");
        }
    };

    xhr.send(params);
}




function getLoggedInUserId() {
    var cookieName = "userId";
    var allCookies = document.cookie;
    var cookiesArray = allCookies.split(";");

    var userIdCookie = cookiesArray.find(cookie => cookie.includes(cookieName));

    if (userIdCookie) {
        var userId = userIdCookie.split("=")[1];
        return userId;
    } else {
        return null;
    }
}

window.kazanilanPuaniHesaplaVeGonder = kazanilanPuaniHesaplaVeGonder;
window.kazanilanSureyiHesaplaVeGonder = kazanilanSureyiHesaplaVeGonder;
window.getLoggedInUserId = getLoggedInUserId;