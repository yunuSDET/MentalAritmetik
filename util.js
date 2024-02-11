
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


function update_right_side_bar(newScore,nameOfProgress) {
    var xhr = new XMLHttpRequest();

    if(nameOfProgress==="finger"){
 

        let progressBar = document.getElementById("progress-bar");
    if(newScore>=1000){
        progressBar.style.width =100 + "%";
        progressBar.setAttribute("aria-valuenow", 100);
            progressBar.setAttribute("class", "progress-bar bg-success");
            document.getElementById("daily-progress").innerHTML = 100;
            return;
    } 
    newScore = (newScore / 1000).toFixed(2).split(".")[1];
    

    
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("daily-progress").innerHTML = newScore;
        
           
            progressBar.style.width = newScore + "%";
            progressBar.setAttribute("aria-valuenow", newScore);
      
             

        }
    };


    }else if(nameOfProgress==="levels"){
        let progressBar = document.getElementById("progress-bar-islemler");
    if(newScore>=1000){
        progressBar.style.width =100 + "%";
        progressBar.setAttribute("aria-valuenow", 100);
            progressBar.setAttribute("class", "progress-bar bg-success");
            document.getElementById("daily-progress-islemler").innerHTML = 100;
            return;
    } 
    newScore = (newScore / 1000).toFixed(2).split(".")[1];
    

    
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("daily-progress-islemler").innerHTML = newScore;
        
           
            progressBar.style.width = newScore + "%";
            progressBar.setAttribute("aria-valuenow", newScore);
      
             

        }
    };

    }


    







    xhr.open("GET", "right-side-bar.php", true);
    xhr.send();
}


function calcultePoint(time,islemSayisi,level,max){
    let result =parseInt(5 +parseInt(islemSayisi)*parseInt(islemSayisi/time));
    

 
    
    if(max===20){
        result = parseInt(result*1.3) 
    }else if(max===50){
        result = parseInt(result*1.6) 
    }else if(max===99){

        result = parseInt(result*1.9) 
    }else if(max===999){
        result = parseInt(result*2.5) 
    }



    if (level===2){
  
       result = parseInt(result*1.5) 
    }

    if (level===3){
        result = parseInt(result*2) 
     }

     
     console.log(result);
     
     for(let i=40;i<1000000;i+=20){
        if(result<i) break;
        result=i + parseInt((result-i)*0.5)
     }
     


     console.log(result);
  
     
     
     return result;

}


window.kazanilanPuaniHesaplaVeGonder = kazanilanPuaniHesaplaVeGonder;
window.kazanilanSureyiHesaplaVeGonder = kazanilanSureyiHesaplaVeGonder;
window.getLoggedInUserId = getLoggedInUserId;
window.update_right_side_bar = update_right_side_bar;
window.calcultePoint = calcultePoint;