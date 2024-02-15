 

let show = "";
let minValue = 0;
let maxValue = 0;
let digits = [];
var actualQuestion = "ask";
let onShow=false;
let selectRangeElement = document.getElementById("aralik");
let selectedRange = selectRangeElement.selectedOptions[0].textContent;

let timeElement = document.getElementById("bekleme");
let time = timeElement.selectedOptions[0].textContent;

let generatedNumber = 0;
let pagePoint = 0;
let pageTime = 0;
let pagePointElementFinger = document.getElementById("daily-point-finger");
let pagePointElement = document.getElementById("current-point");
let pageTimeElement = document.getElementById("current-time-seconds");



let startButton = document.getElementById("start");
startButton.addEventListener("click", start);

document.addEventListener("keyup", function (event) {
   
    if (event.key === "Enter") {
        if (document.activeElement !== startButton) {
            if(onShow===false){
             startButton.click();   
            }
            
        }
    }
    
});

startButton.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        if(onShow===false){
            startButton.click();   
           }
    }
});

let popupPoint = document.getElementById("popupPoint");

async function showPopup(score, isTrue, msg) {
    onShow = true; 
        startButton.click();     
    var popup = document.createElement("div");
     
    popup.id = "popup";

    if (isTrue) {
        var trueImg = document.createElement("img");
        trueImg.src = "/img/trueImg.png";
        trueImg.alt = "True";
        trueImg.style.width = "40px";
        trueImg.style.height = "40px";
        popup.appendChild(trueImg);
        popup.innerHTML += "<br>";
        popup.innerHTML += "Puan: " + Math.round(score);
        popup.style.background = "Gainsboro ";
        
    } else if (isTrue === false) {
        popup.style.background = "Gainsboro";
        var falseImg = document.createElement("img");
        falseImg.src = "/img/falseImg.png";
        falseImg.alt = "False";
        falseImg.style.width = "40px";
        falseImg.style.height = "40px";
        popup.appendChild(falseImg);
        popup.innerHTML += "<br>";
        popup.innerHTML += lastQuestionFingerPositions + "<br><h2>Cevap: " + msg + "<h2>";
    } else {
        popup.style.background = "White";
        var questioImg = document.createElement("img");
        questioImg.src = "/img/questionImg.png";
        questioImg.alt = "Question";
        questioImg.style.width = "40px";
        questioImg.style.height = "40px";
        popup.appendChild(questioImg);
        popup.innerHTML += "<br>";
        popup.innerHTML += lastQuestionFingerPositions;
    }

    popup.style.background = "transparent";  
    popup.style.display = "block";
    popup.style.position = "fixed";
   
    popup.style.top = "50%";
    popup.style.left = "50%";
    popup.style.transform = "translate(-50%, -50%)";
    popup.style.padding = "20px";

    popup.style.border = "1px solid #ccc";
    popup.style.boxShadow = "0 2px 10px rgba(0, 0, 0, 0.1)";
    popup.style.zIndex = "1000";
    popup.style.fontSize = "24px";

    popupPoint.appendChild(popup);

    if(isTrue){
        await wait(1500);
        await hidePopup();
        onShow = false; 
    } else if(isTrue === false){
        await wait(3000);
        await hidePopup();
        onShow = false; 
    } else {
        var timeMiliSecond = parseFloat(time) * 1000;
        await wait(timeMiliSecond + 1000); // Add 1000 milliseconds for an extra second
        await hidePopup();
        onShow = false; 
    }
}

async function hidePopup() {
    var popup = document.getElementById("popup");
    if (popup) {
        setTimeout(function () {
            popup.style.display = "none";
            popupPoint.removeChild(popup);
        }, 1);
    }
}

function playBeepSound(name) {
    var beepAudio = document.getElementById(name);
    beepAudio.currentTime = 0;
    beepAudio.play();
}

function getValueInRange() {
    let generated = 0;

    if (selectedRange == "Birlikler") {
        generated = Math.floor(Math.random() * (maxValue - minValue + 1)) + minValue;
        digits[0] = "00";
        digits[1] = generated == 0 ? "0" : generated.toString();
    } else if (selectedRange == "Onluklar") {
        generated = (Math.floor(Math.random() * (maxValue - minValue + 1)) + minValue) * 10;
        digits[0] = generated.toString();
        digits[1] = "0";
    } else if (selectedRange == "1-99") {
        generated = Math.floor(Math.random() * (maxValue - minValue + 1)) + minValue;
        digits[0] = (Math.floor(generated / 10) * 10).toString();
        digits[1] = (generated % 10).toString();
    }

    generatedNumber = generated;

    return [generated, digits];
}

function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

let lastQuestionFingerPositions;

function loadImage(src) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.src = src;
        img.onload = () => resolve(img);
        img.onerror = (err) => reject(err);
    });
}

function getMaxSizeStyle(maxSize) {
    return 'max-width: ' + maxSize + 'px; max-height: ' + maxSize + 'px; width: auto; height: auto;';
}

async function askQuestion() {
    let output = getValueInRange();
    actualQuestion = '<div class="row"><div class="col-md-6" style="display: flex;">' +
                  '<img src="/img/' + output[1][0] + '.png" style="' + getMaxSizeStyle(450) + '" class="rounded float-start" alt="...">' +
                  '<img src="/img/' + output[1][1] + '.png" style="' + getMaxSizeStyle(450) + '" class="rounded float-end" alt="...">' +
                '</div></div>';

    lastQuestionFingerPositions = actualQuestion;
    playBeepSound("beep");
    await showPopup();
    await Promise.all([loadImage('/img/' + output[1][0] + '.png'), loadImage('/img/' + output[1][1] + '.png')]);

     
    
}

function checkInputBoxes() {
    aralik = document.getElementById("aralik").selectedOptions[0].textContent;
    time = document.getElementById("bekleme").selectedOptions[0].textContent;

    if (aralik == "Etkinlik Seçin") {
        scene.innerHTML = "Lütfen bir aralık seçin.";
        return false;
    }

    if (time == "Sure Seçin") {
        scene.innerHTML = "Lütfen bir süre seçin.";
        return false;
    }

    return true;
}

let scene = document.getElementById("scene");
scene.innerHTML = "";

async function start(event) {
    event.preventDefault();

    if (scene.innerHTML.includes("Kontrol Et") || scene.innerHTML.includes("img") || actualQuestion !== "ask") return;

    if (checkInputBoxes() == false) {
        console.log("Complete the inputs");
        return;
    }

    pagePointElement = document.getElementById("current-point");
    pageTimeElement = document.getElementById("current-time-seconds");
   

 

    selectedRange = document.getElementById("aralik").selectedOptions[0].textContent;

    if (selectedRange == "Birlikler") {
        minValue = 1;
        maxValue = 9;
    } else if (selectedRange == "Onluklar") {
        minValue = 1;
        maxValue = 9;
    } else if (selectedRange == "1-99") {
        minValue = 1;
        maxValue = 99;
    }

    
    await wait(300);
    await askQuestion();
     
   

    if (scene) {
        scene.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
    }

    scene.innerHTML = '<div class="row mt-4"><div class="col-4 offset-4"><input type="text" class="form-control" placeholder="Sayıyı Girin... " aria-label="First name" id="user-answer"><button type="submit" class="btn btn-primary" id="control">Kontrol Et</button></div></div>';
    let inputElement = document.getElementById("user-answer");
    inputElement.focus();
    let checkButton = document.getElementById("control");

    inputElement.addEventListener("keyup", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
            setTimeout(async () => {
                checkButton.click();
                  
            }, 0);
        }
    });

    let newPoint;
    let newTime;

    checkButton.addEventListener("click", () => {
        let userAnswer = document.getElementById("user-answer").value;
        if (!userAnswer) return;

    selectedRange = selectRangeElement.selectedOptions[0].textContent;
         
        
        if(selectedRange==="1-99"){
            newPoint = 5 + parseInt(5 / parseFloat(time));
          
          
        }else{
            newPoint = 5 + parseInt(5 / parseFloat(time));
             
            
            if(newPoint>20) newPoint=20;
        }



        newTime = parseFloat(time);

        if (generatedNumber == parseInt(userAnswer)) {
            scene.innerHTML = "";
            playBeepSound("yes");

            pagePointElement.innerHTML = Math.round(parseInt(pagePointElement.innerHTML) + newPoint);

            
            pagePointElementFinger.innerHTML = parseInt(pagePointElementFinger.innerHTML) +newPoint;


            update_right_side_bar(pagePointElementFinger.innerHTML,"finger");

            pageTimeElement.innerHTML = Math.round(parseInt(pageTimeElement.innerHTML) + newTime+1);

            showPopup(newPoint, true);
             
            

            kazanilanPuaniHesaplaVeGonder(newPoint);
            kazanilanSureyiHesaplaVeGonder(newTime+1);
            actualQuestion = "ask";
        } else {
            scene.innerHTML = "";
            showPopup(newPoint, false, generatedNumber);
            playBeepSound("no");

            pageTimeElement.innerHTML = Math.round(parseInt(pageTimeElement.innerHTML) + newTime);
            actualQuestion = "ask";
        }
    });

    
}

 
 
    

 
