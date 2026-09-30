let style = {
    skin: "pale",
    eyes: "brown",
    hair: "black-2",
    clothing: "style-1",
    accessories: "bow-pink"
}

const accessoriesStyles = [
    {
        name:"bow-pink",
        img: "avatar-components/tle1_accessories/bow-pink.PNG"
    },
    {
        name:"bow-purple",
        img: "avatar-components/tle1_accessories/bow-purple.PNG"
    }
]

const skinStyles = [
    {
        name:"pale",
        img: "avatar-components/tle1_body/body-pale.PNG"
    },
    {
        name:"tan-1",
        img: "avatar-components/tle1_body/body-tan-1.PNG"
    },
    {
        name:"tan-2",
        img: "avatar-components/tle1_body/body-tan-2.PNG"
    },
    {
        name:"brown",
        img: "avatar-components/tle1_body/body-brown.PNG"
    }
]

const blackHairStyles = [
    {
        name:"afro_black",
        img: "avatar-components/tle1_black/afro_black.PNG"
    },
    {
        name:"long_black",
        img: "avatar-components/tle1_black/long_black.PNG"
    },
    {
        name:"shag_black",
        img: "avatar-components/tle1_black/shag_black.PNG"
    },
    {
        name:"short_black",
        img: "avatar-components/tle1_black/short_black.PNG"
    },
    {
        name:"pigtails_black",
        img: "avatar-components/tle1_black/pigtails_black.PNG"
    }
]

const brownHairStyles = [
    {
        name:"afro_brown",
        img: "avatar-components/tle1_brown/afro_brown.PNG"
    },
    {
        name:"long_brown",
        img: "avatar-components/tle1_brown/long_brown.PNG"
    },
    {
        name:"shag_brown",
        img: "avatar-components/tle1_brown/shag_brown.PNG"
    },
    {
        name:"short_brown",
        img: "avatar-components/tle1_brown/short_brown.PNG"
    },
    {
        name:"pigtails_brown",
        img: "avatar-components/tle1_brown/pigtails_brown.PNG"
    }
]

const blondeHairStyles = [
    {
        name:"afro_blonde",
        img: "avatar-components/tle1_blonde/afro_blonde.PNG"
    },
    {
        name:"long_blonde",
        img: "avatar-components/tle1_blonde/long_blonde.PNG"
    },
    {
        name:"shag_blonde",
        img: "avatar-components/tle1_blonde/shag_blonde.PNG"
    },
    {
        name:"short_blonde",
        img: "avatar-components/tle1_blonde/short_blonde.PNG"
    },
    {
        name:"pigtails_blonde",
        img: "avatar-components/tle1_blonde/pigtails_blonde.PNG"
    }
]

const clothingStyles = [
    {
        name:"style-1",
        img: "avatar-components/tle1_clothing/style-1.PNG"
    },
    {
        name:"style-2",
        img: "avatar-components/tle1_clothing/style-2.PNG"
    },
    {
        name:"style-3",
        img: "avatar-components/tle1_clothing/style-3.PNG"
    },
    {
        name:"style-4",
        img: "avatar-components/tle1_clothing/style-4.PNG"
    }
]

const eyeStyles = [
    {
        name:"eyes_blue",
        img: "avatar-components/tle1_eyes/eyes_blue.PNG"
    },
    {
        name:"eyes_brown",
        img: "avatar-components/tle1_eyes/eyes_brown.PNG"
    },
    {
        name:"eyes_green",
        img: "avatar-components/tle1_eyes/eyes_green.PNG"
    },
    {
        name:"eyes_pink",
        img: "avatar-components/tle1_eyes/eyes_pink.PNG"
    }
]


// skin buttons
let currentNumberSkin = 0;

function nextFunctionSkin(){
    if (currentNumberSkin === 3) {
        currentNumberSkin = 0;
    }
    else {
        currentNumberSkin++;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (skinStyles[currentNumberSkin].name);
}

function prevFunctionSkin(){
    if (currentNumberSkin === 0) {
        currentNumberSkin = 3;
    }
    else {
        currentNumberSkin--;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (skinStyles[currentNumberSkin].name);
}



// eye buttons
let currentNumberEyes = 0;

function nextFunctionEyes(){
    if (currentNumberEyes === 3) {
        currentNumberEyes = 0;
    }
    else {
        currentNumberEyes++;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (eyeStyles[currentNumberEyes].name);
}

function prevFunctionEyes(){
    if (currentNumberEyes === 0) {
        currentNumberEyes = 3;
    }
    else {
        currentNumberEyes--;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (eyeStyles[currentNumberEyes].name);
}



// black hair buttons
let currentNumberBlackHair = 0;

function nextFunctionBlackHair(){
    if (currentNumberBlackHair === 4) {
        currentNumberBlackHair = 0;
    }
    else {
        currentNumberBlackHair++;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (blackHairStyles[currentNumberBlackHair].name);
}

function prevFunctionBlackHair(){
    if (currentNumberBlackHair === 0) {
        currentNumberBlackHair = 4;
    }
    else {
        currentNumberBlackHair--;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (blackHairStyles[currentNumberBlackHair].name);
}



// brown hair buttons
let currentNumberBrownHair = 0;

function nextFunctionBrownHair(){
    if (currentNumberBrownHair === 4) {
        currentNumberBrownHair = 0;
    }
    else {
        currentNumberBrownHair++;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (brownHairStyles[currentNumberBrownHair].name);
}

function prevFunctionBrownHair(){
    if (currentNumberBrownHair === 0) {
        currentNumberBrownHair = 4;
    }
    else {
        currentNumberBrownHair--;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (brownHairStyles['name'][currentNumberBrownHair]);
}



// blonde hair buttons
let currentNumberBlondeHair = 0;

function nextFunctionBlondeHair(){
    if (currentNumberBlondeHair === 4) {
        currentNumberBlondeHair = 0;
    }
    else {
        currentNumberBlondeHair++;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (blondeHairStyles['name'][currentNumberBlondeHair]);
}

function prevFunctionBlondeHair(){
    if (currentNumberBlondeHair === 0) {
        currentNumberBlondeHair = 4;
    }
    else {
        currentNumberBlondeHair--;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (blondeHairStyles[currentNumberBlondeHair].name);
}



// clothing buttons
let currentNumberClothing = 0;

function nextFunctionClothing(){
    if (currentNumberClothing === 3) {
        currentNumberClothing = 0;
    }
    else {
        currentNumberClothing++;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (clothingStyles[currentNumberClothing].name);
}

function prevFunctionClothing(){
    if (currentNumberClothing === 0) {
        currentNumberClothing = 3;
    }
    else {
        currentNumberClothing--;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (clothingStyles[currentNumberClothing].name);
}

// accessory buttons
let currentNumberAccessories = 0;

function nextFunctionAccessories(){
    if (currentNumberAccessories === 1) {
        currentNumberAccessories = 0;
    }
    else {
        currentNumberAccessories++;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (accessoriesStyles[currentNumberAccessories].name);
}

function prevFunctionAccessories(){
    if (currentNumberAccessories === 0) {
        currentNumberAccessories = 1;
    }
    else {
        currentNumberAccessories--;
    }
    let x = document.getElementById("paragraph");
    x.innerHTML = (accessoriesStyles[currentNumberAccessories].name);
}