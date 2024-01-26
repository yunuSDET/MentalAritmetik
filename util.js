var webPath = "/";
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


function update_right_side_bar(newScore) {
    newScore = (newScore / 2000).toFixed(2).split(".")[1];

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("daily-progress").innerHTML = newScore;
            
            
            let progressBar = document.getElementById("progress-bar");
            progressBar.style.width = newScore + "%";
            progressBar.setAttribute("aria-valuenow", newScore);
        }
    };

    xhr.open("GET", "right-side-bar.php", true);
    xhr.send();
}


function calcultePoint(time,islemSayisi){
    return 5 + (islemSayisi/time);
}


window.kazanilanPuaniHesaplaVeGonder = kazanilanPuaniHesaplaVeGonder;
window.kazanilanSureyiHesaplaVeGonder = kazanilanSureyiHesaplaVeGonder;
window.getLoggedInUserId = getLoggedInUserId;
window.update_right_side_bar = update_right_side_bar;
window.calcultePoint = calcultePoint;
 