 

let result = 0;
let testResult = 0;
let show = "";
let time = document.getElementById("bekleme").selectedOptions[0].textContent;
let operator = document.getElementById("islem").selectedOptions[0].textContent;
let aralik = document.getElementById("aralik").selectedOptions[0].textContent;
let islemSayisi = document.getElementById("islem-sayisi").selectedOptions[0].textContent;

let minValue = aralik.split("-")[0];
let maxValue = aralik.split("-")[1];
 
let questions="";


let level ="L" + parseInt(document.getElementById("selected_level").selectedOptions[0].textContent);
 

let isWorking=false;

//ILK SAYI 50 OLURSA HATA OLUŞUYOR

function playBeepSound(name) {
    var beepAudio = document.getElementById(name);

    // Ses dosyasını başa sar ve çal
    beepAudio.currentTime = 0;
    beepAudio.play();


}


document.addEventListener("keyup", function (event) {
    if (event.key === "Enter") {
        // Enter tuşuna basıldığında ve sayfa üzerinde başka bir etkileşim olmadığında
        if (document.activeElement !==startButton) {
            startButton.click();
        }
    }
});




function checkAdditionConditions(active1, active2) {
    let  level1Condition=(active1 < 5 && (active1 + active2 < 5 || active2 === 5 || (active2 > (active1 + 5) && (active1 + active2) < 10))) ||
    (active1 === 5 && active2 < 5) ||
    (active1 > 5 && (active1 + active2 <= 9))
   
    let level2Condition= active1 < 5 && (active1 + active2 >= 5 && active2 <5)

    let level3Condition = active1+active2>=10;
   
    if(level==="L1"){
        return level1Condition;
    }else if(level==="L2"){

        return level1Condition || level2Condition ;

    }else if(level==="L3"){

        return level1Condition || level2Condition || level3Condition;

    }

    return false;

}

function checkSubtractionConditions(active1, active2) {

  let  level1Condition=(active1 < 5 && active2 <= active1) ||
    (active1 === 5 && active2 === 5) ||
    (active1 > 5 && (active2 === 5 || (active2 > 5 && active2 <= active1)));

    let level2Condition=(active1 == 5 && (active2<5))
    ||
    (active1 > 5 
        && (
            (active2<5) 
            && 
            (active2>(active1-5))
            )
    )

    let level3Condition = active1<active2;

   if(level==="L1"){
    return level1Condition;
   }else if(level==="L2"){
    return  level1Condition || level2Condition;

    }else if(level==="L3"){
        return  level1Condition || level2Condition || level3Condition;
    
        }

   return false;
}

function levelChecker(n1, n2, activeOperator) {
    let minCommonNumberOfDigits = Math.min(n1, n2).toString().length;
    let isTrue = true;

    for (let i = 0; i < minCommonNumberOfDigits; i++) {
        let active1 = Math.floor(n1 / Math.pow(10, i)) % 10;
        let active2 = Math.floor(n2 / Math.pow(10, i)) % 10;

        if (activeOperator === "+") {
            if (!checkAdditionConditions(active1, active2)) {
                return false;
            }
        }

        if (activeOperator === "-") {
            if (!checkSubtractionConditions(active1, active2)) {
                return false;
            }
        }
    }

    return isTrue;
}




function getValueInRange(){
    return Math.floor(Math.random() * (maxValue - minValue + 1)) + minValue;
}


function addNumber(givenNumber) {
    let number = givenNumber;  
    show = "+" + number;
    return  result + number;  
}

function subtractNumber(givenNumber) {
    let number =givenNumber;
    show = "-" + number;
    return  result - number;
}

function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

async function askQuestion(miliSeconds) {
    for (let i = 1; i <= parseInt(islemSayisi); i++) {
        let tempResult=0;

        let number = getValueInRange();
        let n1=result;
        let n2=number;
        let activeOperator = getOperator();

        if(i==1){
        result=number;
        scene.innerHTML="";
        await wait(100);
        scene.innerHTML=result;
        playBeepSound("beep");
        questions=number+" "
        await wait(miliSeconds);
        continue;
        }
        let infinite=0;
        while(true){  

            if(activeOperator=="+"){
                tempResult = addNumber(number);
            }else if(activeOperator=="-"){
                tempResult = subtractNumber(number);
            }

            console.log("Debug => ", n1, " ", activeOperator, " ", n2);

            if(tempResult>=minValue && tempResult<=maxValue && levelChecker(n1,n2,activeOperator)==true){
                    break;
            }
            number = getValueInRange();
            n1=result;
            n2=number;
            activeOperator = getOperator();
            
            if(infinite>200){
                alert("Beklenmedik bir hata ile karşılaşıldı. Yaşanan sorundan dolayı üzgünüz. Hata raporu iletildi. Çalışmaya devam edebilirsiniz.");
                return;
                
            }
            infinite++;

         
        }
        result=tempResult;
        scene.innerHTML="";
        await wait(100);
        scene.innerHTML=show;
        questions+=show+" ";
       
        
        playBeepSound("beep");
        await wait(miliSeconds);

    }
}



function getOperator(){



    switch(operator){
        case "+":
            return operator;
        case "-+":
            return ["-", "+"][Math.floor(Math.random() * 2)];
        default:
            console.log("Invalid value");
            
    }
}



function checkInputBoxes(){

    time = document.getElementById("bekleme").selectedOptions[0].textContent;
    operator = document.getElementById("islem").selectedOptions[0].textContent;
    aralik = document.getElementById("aralik").selectedOptions[0].textContent;
    islemSayisi = document.getElementById("islem-sayisi").selectedOptions[0].textContent;

    if (time == "Sure Seçin") {
        scene.innerHTML = "Lütfen bir süre seçin.";
        console.log(time);
        
        return false;
    } 


    if (aralik == "Aralık Seçin") {
        scene.innerHTML = "Lütfen bir aralık seçin.";
        console.log(aralik);
        
        return false;
    } 

    if (operator == "İşlem Seçin") {
        scene.innerHTML = "Lütfen bir işlem seçin.";
        console.log(operator);
        
        return false;
    }


    if (islemSayisi == "İşlem Sayısı") {
        scene.innerHTML = "Lütfen işlem sayısı seçin.";
        console.log(operator);
        
        return false;
    }


    return true;



}


let startButton = document.getElementById("start");
startButton.addEventListener("click", start);

let scene = document.getElementById("scene");


async function start(event) {

    event.preventDefault();
    level ="L" + parseInt(document.getElementById("selected_level").selectedOptions[0].textContent);
 

    if(!(level==="L1" || level==="L2" || level==="L3")){
        console.log("Seviye bir dışındaki seviler güncellendikçe burada güncelleme yapılsın.");
        
        return;
    }

     
    if (isWorking==true) return;

    

    
    if(checkInputBoxes()==false) {
        console.log("Complete the inputs");
        return;
        
    }

    minValue = parseInt(aralik.split("-")[0]);
    maxValue =  parseInt(aralik.split("-")[1]);

    time = document.getElementById("bekleme").selectedOptions[0].textContent;

 
        
    timeMiliSecond = parseFloat(time) * 1000;
    isWorking=true;
    await askQuestion(timeMiliSecond);

    await wait(2000);

    
    scene.innerHTML='<div class="row mt-4"><div class="col-4 offset-4"><input type="text" class="form-control" placeholder="Cevabı Girin... " aria-label="First name" id="user-answer"><button type="submit" class="btn btn-primary" id="control">Kontrol Et</button></div></div>';





    let inputElement =  document.getElementById("user-answer")
    inputElement.focus();
   
 
    inputElement.addEventListener("keyup", function (event) {
      if (event.key === "Enter") {
         event.preventDefault();
         setTimeout(() => {
             checkButton.click();
         }, 0);
      }
    });










    let checkButton = document.getElementById("control");
    checkButton.addEventListener("click", () => {
        let userAnswer = document.getElementById("user-answer").value;
        if(!userAnswer) return;
        if(result==parseInt(userAnswer)){
            scene.innerHTML='<h1 class="display-2 bg-success">Tebrikler,<br>Cevap '+result+'.</h1>'
            playBeepSound("claps")
        }else{
            scene.innerHTML='<h1 class="display-2 bg-danger">Hata<br>Cevap '+result+'.</h1>' 
            scene.innerHTML+='<p style="font-size:50px">Soru: '+questions+'</p>';
            playBeepSound("error1")
        }

        console.log(questions);
        
        
        isWorking=false;
    })
         
    
}

