
let show = "";
let minValue=0;
let maxValue=0;
let digits=[];
var actualQuestion ="ask";

let selectRangeElement =  document.getElementById("aralik");
let selectedRange = selectRangeElement.selectedOptions[0].textContent;

let timeElement = document.getElementById("bekleme")
let time = timeElement.selectedOptions[0].textContent;


let generatedNumber =0;
let pagePoint = 0;
let pageTime = 0;
let pagePointElement =document.getElementById("current-point");
let pageTimeElement = document.getElementById("current-time-seconds");

let startButton = document.getElementById("start");
startButton.addEventListener("click", start);




document.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        // Enter tuşuna basıldığında ve sayfa üzerinde başka bir etkileşim olmadığında
        if (document.activeElement !==startButton) {
            startButton.click();
        }
    }
});

startButton.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        // Enter tuşuna basıldığında butonu tetikle
        startButton.click();
    }
});

 
let popupPoint = document.getElementById("popupPoint");
 
function showPopup(score,isTrue,msg) {
    var popup = document.createElement("div");
    
    popup.id = "popup";

    if(isTrue){
       
        var trueImg = document.createElement("img");
        trueImg.src ="/img/trueImg.png"; // True durumu için görselin yolu
        trueImg.alt = "True";
        trueImg.style.width = "40px"; // Görselin genişliği
        trueImg.style.height = "40px"; // Görselin yüksekliği
        popup.appendChild(trueImg);
        popup.innerHTML+="<br>"
        popup.innerHTML += "Puan: " + Math.round(score);
        popup.style.background = "Gainsboro "; // Arkaplan rengi
        


    }else if(isTrue===false){
        
        popup.style.background = "Gainsboro"; // Arkaplan rengi

        
        var falseImg = document.createElement("img");
        falseImg.src = "img/falseImg.png"; // False durumu için görselin yolu
        falseImg.alt = "False";
        falseImg.style.width = "40px"; // Görselin genişliği
        falseImg.style.height = "40px"; // Görselin yüksekliği
        popup.appendChild(falseImg);
        popup.innerHTML+="<br>"
        popup.innerHTML +=lastQuestionFingerPositions+ "<br><h2>Cevap: "+msg+" olmalıydı<h2>";


    }else{

       
    
       
        popup.style.background = "White"; // Arkaplan rengi

        
        var questioImg = document.createElement("img");
        questioImg.src = "img/questionImg.png"; // False durumu için görselin yolu
        questioImg.alt = "Question";
        questioImg.style.width = "40px"; // Görselin genişliği
        questioImg.style.height = "40px"; // Görselin yüksekliği
        popup.appendChild(questioImg);
        popup.innerHTML+="<br>"
        popup.innerHTML +=lastQuestionFingerPositions;
        
    }

    

    popup.style.display = "block";
    popup.style.position = "fixed";

    popup.style.top = "60%";
    popup.style.left = "50%";
    popup.style.transform = "translate(-50%, -50%)";
    popup.style.padding = "20px";

    popup.style.border = "1px solid #ccc";
    popup.style.boxShadow = "0 2px 10px rgba(0, 0, 0, 0.1)";
    popup.style.zIndex = "1000";
    popup.style.fontSize = "24px"; // Font boyutu

    popupPoint.appendChild(popup);

    
}


function hidePopup(){
    var popup = document.getElementById("popup");
    if (popup) {
        setTimeout(function () {
            // popup değişkenini kullan
            popup.style.display = "none";
            popupPoint.removeChild(popup);
        }, 1);
    }
}







function playBeepSound(name) {
    var beepAudio = document.getElementById(name);

    // Ses dosyasını başa sar ve çal
    beepAudio.currentTime = 0;
    beepAudio.play();


}




function getValueInRange(){
 

    let generated=0;
    
        if(selectedRange=="Birlikler"){
           
        generated =  Math.floor(Math.random() * (maxValue - minValue + 1)) + minValue;

        digits[0]="00" 
        digits[1]= generated==0 ? "0":generated.toString();
         
        
       }else if(selectedRange=="Onluklar"){

        generated =  (Math.floor(Math.random() * (maxValue - minValue + 1)) + minValue)*10;

        digits[0]=generated.toString() 
        digits[1]="0";

       }else if(selectedRange=="1-99"){

        generated =  Math.floor(Math.random() * (maxValue - minValue + 1)) + minValue;

        digits[0]=(Math.floor(generated / 10)*10).toString()
        digits[1]=(generated % 10).toString();
       }

       generatedNumber=generated;

    return [generated, digits];
}






function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


let lastQuestionFingerPositions;

async function askQuestion() {
  
 
    


     
        let output = getValueInRange();
           
           
            
        actualQuestion = '<img src="/img/' + output[1][0] + '.png" class="roundedfloat-start mr-3" alt="..."><img src="/img/' + output[1][1] + '.png" class="rounded float-end" alt="..."></img>';
        lastQuestionFingerPositions = actualQuestion;
        
        showPopup();
        
        playBeepSound("beep");
       

  


    


    
}




 


function checkInputBoxes(){

    aralik = document.getElementById("aralik").selectedOptions[0].textContent;

    time = document.getElementById("bekleme").selectedOptions[0].textContent;



    if (aralik == "Etkinlik Seçin") {
        scene.innerHTML = "Lütfen bir aralık seçin.";
        console.log(aralik);
        
        return false;
    } 
 

    if (time == "Sure Seçin") {
        scene.innerHTML = "Lütfen bir süre seçin.";
        console.log(time);
        
        return false;
    } 



    return true;



}




let scene = document.getElementById("scene");

 scene.innerHTML=""













async function start(event) {

    event.preventDefault();

 
 
    if(scene.innerHTML.includes("Kontrol Et") || scene.innerHTML.includes("img") || actualQuestion!=="ask") return;
    
    if(checkInputBoxes()==false) {
        console.log("Complete the inputs");
        return;
        
    }
	
	pagePointElement =document.getElementById("current-point");
	pageTimeElement = document.getElementById("current-time-seconds")
    
    hidePopup();
 

    


   selectedRange  = document.getElementById("aralik").selectedOptions[0].textContent;

   if(selectedRange=="Birlikler"){
    minValue=1;
    maxValue=9;
   }else if(selectedRange=="Onluklar"){
    minValue=1;
    maxValue=9;
   }else if(selectedRange=="1-99"){
    minValue=1;
    maxValue=99;
   }
 

   
        
   
   timeMiliSecond = parseFloat(time) * 1000;
 
   await askQuestion();

   await wait(timeMiliSecond);
   hidePopup();




   scene.innerHTML='<div class="row mt-4"><div class="col-4 offset-4"><input type="text" class="form-control" placeholder="Sayıyı Girin... " aria-label="First name" id="user-answer"><button type="submit" class="btn btn-primary" id="control">Kontrol Et</button></div></div>';
   let inputElement =  document.getElementById("user-answer")
   inputElement.focus();
   let checkButton = document.getElementById("control");

   inputElement.addEventListener("keyup", function (event) {
     if (event.key === "Enter") {
        event.preventDefault();
        setTimeout(() => {
            checkButton.click();
        }, 0);
     }
   });



   checkButton.addEventListener("click", () => {
       let userAnswer = document.getElementById("user-answer").value;
       if(!userAnswer) return;
       

       let newPoint = 5+5/parseFloat(time)
       let newTime = parseFloat(time)


       if(generatedNumber==parseInt(userAnswer)){
           scene.innerHTML="";
           playBeepSound("yes")

        

           pagePointElement.innerHTML=Math.round(parseInt(pagePointElement.innerHTML)+newPoint);

           let newPointWithPersentage=(pagePointElement.innerHTML/1000).toFixed(2).split(".")[1];

           
            update_right_side_bar(newPointWithPersentage);

		   pageTimeElement.innerHTML=Math.round(parseInt(pageTimeElement.innerHTML)+newTime);

           showPopup(newPoint,true);
           actualQuestion = "ask";



       }else{
          scene.innerHTML="";
           showPopup(newPoint,false,generatedNumber);
           playBeepSound("no")
           
		   pageTimeElement.innerHTML=Math.round(parseInt(pageTimeElement.innerHTML)+newTime);
           actualQuestion = "ask";
       }
       
     

   })

 
    
   function update_right_side_bar(newScore){
    // AJAX ile sayfa içeriğini güncelle
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {

            document.getElementById("daily-progress").innerHTML = newScore;
            
           let progressBar= document.getElementById("progress-bar");
           progressBar.style.width = newScore + "%";
           progressBar.setAttribute("aria-valuenow", newScore);
        }
    };

    // AJAX isteğini gönder
    xhr.open("GET", "right-side-bar.php", true);
    xhr.send();



   }

   
        

  
         
    
}




// JavaScript tarafında puan hesaplama ve sunucuya istek gönderme
function kazanilanPuaniHesaplaVeGonder(earnedPoints) {
    // Puan hesaplamalarını ve site etkileşimini yap

    // Örnek olarak bir puan kazanıldığını varsayalım
    console.log("Kazanılan Puan: " + earnedPoints);

    // Veritabanına puanı göndermek için bir HTTP isteği gönder
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "saveData.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Kullanıcının oturum (session) bilgilerini gönder
    var userId = getLoggedInUserId(); // Bu fonksiyonun implementasyonunu size bırakıyorum
    var params = "userId=" + userId + "&earnedPoints=" + earnedPoints;

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log("Veritabanına başarıyla kaydedildi.");
        }
    };

    // İsteği gönder
    xhr.send(params);
}

// Bu fonksiyon, kullanıcının oturum bilgilerini döndürür
function getLoggedInUserId() {
    // Örneğin, tarayıcıda bir cookie kullanarak oturum bilgilerini alabilirsiniz
    var cookieName = "userId"; // Kullanıcının ID'sini saklayan bir cookie adı

    // Tarayıcıdaki tüm cookieleri al
    var allCookies = document.cookie;

    // Cookieleri parçalayarak bir dizi haline getir
    var cookiesArray = allCookies.split(";");

    // Kullanıcının ID'sini içeren cookie'yi bul
    var userIdCookie = cookiesArray.find(cookie => cookie.includes(cookieName));

    if (userIdCookie) {
        // Cookie bulunduysa, kullanıcının ID'sini çıkar
        var userId = userIdCookie.split("=")[1];
        return userId;
    } else {
        // Cookie bulunamazsa veya kullanıcı oturum açmamışsa null döndür
        return null;
    }
}