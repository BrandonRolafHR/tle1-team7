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
        img: "../avatar-components/tle1_accessories/bow-pink.PNG"
    },
    {
        name:"bow-purple",
        img: "../avatar-components/tle1_accessories/bow-purple.PNG"
    },
    {
        name:"none",
        img: "../avatar-components/tle1_accessories/none.svg"
    },
]

const skinStyles = [
    {
        name:"pale",
        img: "../avatar-components/tle1_body/body-pale.PNG"
    },
    {
        name:"tan-1",
        img: "../avatar-components/tle1_body/body-tan-1.PNG"
    },
    {
        name:"tan-2",
        img: "../avatar-components/tle1_body/body-tan-2.PNG"
    },
    {
        name:"brown",
        img: "../avatar-components/tle1_body/body-brown.PNG"
    }
]

const hairStyles = [
    {
        name:"long_black",
        img: "../avatar-components/tle1_black/long_black.PNG"
    },
    {
        name:"long_brown",
        img: "../avatar-components/tle1_brown/long_brown.PNG"
    },
    {
        name:"long_blonde",
        img: "../avatar-components/tle1_blonde/long_blonde.PNG"
    },
    {
        name:"afro_black",
        img: "../avatar-components/tle1_black/afro_black.PNG"
    },
    {
        name:"afro_brown",
        img: "../avatar-components/tle1_brown/afro_brown.PNG"
    },
    {
        name:"afro_blonde",
        img: "../avatar-components/tle1_blonde/afro_blonde.PNG"
    },
    {
        name:"shag_black",
        img: "../avatar-components/tle1_black/shag_black.PNG"
    },
    {
        name:"shag_brown",
        img: "../avatar-components/tle1_brown/shag_brown.PNG"
    },
    {
        name:"shag_blonde",
        img: "../avatar-components/tle1_blonde/shag_blonde.PNG"
    },
    {
        name:"short_black",
        img: "../avatar-components/tle1_black/short_black.PNG"
    },
    {
        name:"short_brown",
        img: "../avatar-components/tle1_brown/short_brown.PNG"
    },
    {
        name:"short_blonde",
        img: "../avatar-components/tle1_blonde/short_blonde.PNG"
    },
    {
        name:"pigtails_black",
        img: "../avatar-components/tle1_black/pigtails_black.PNG"
    },
    {
        name:"pigtails_brown",
        img: "../avatar-components/tle1_brown/pigtails_brown.PNG"
    },
    {
        name:"pigtails_blonde",
        img: "../avatar-components/tle1_blonde/pigtails_blonde.PNG"
    }
]

const clothingStyles = [
    {
        name:"style-1",
        img: "../avatar-components/tle1_clothing/style-1.PNG"
    },
    {
        name:"style-2",
        img: "../avatar-components/tle1_clothing/style-2.PNG"
    },
    {
        name:"style-3",
        img: "../avatar-components/tle1_clothing/style-3.PNG"
    },
    {
        name:"style-4",
        img: "../avatar-components/tle1_clothing/style-4.PNG"
    }
]

const eyeStyles = [
    {
        name:"eyes_blue",
        img: "../avatar-components/tle1_eyes/eyes_blue.PNG"
    },
    {
        name:"eyes_brown",
        img: "../avatar-components/tle1_eyes/eyes_brown.PNG"
    },
    {
        name:"eyes_green",
        img: "../avatar-components/tle1_eyes/eyes_green.PNG"
    },
    {
        name:"eyes_pink",
        img: "../avatar-components/tle1_eyes/eyes_pink.PNG"
    }
]


function updateMiminData() {
    document.getElementById("avatarData").value = JSON.stringify(style)
}


// skin buttons
let currentNumberSkin = 0;

function displaySkin() {
    let selectedOption = skinStyles[currentNumberSkin];

    document.getElementById("skinImg").src = selectedOption.img;
    document.getElementById("skinImg").alt = selectedOption.name;
}

function nextFunctionSkin(){
    if (currentNumberSkin === 3) {
        currentNumberSkin = 0;
    }
    else {
        currentNumberSkin++;
    }

    displaySkin();

    style.skin = skinStyles[currentNumberSkin].name;
    updateMiminData();
}

function prevFunctionSkin(){
    if (currentNumberSkin === 0) {
        currentNumberSkin = 3;
    }
    else {
        currentNumberSkin--;
    }

    displaySkin();

    style.skin = skinStyles[currentNumberSkin].name;
    updateMiminData();
}



// eye buttons
let currentNumberEyes = 0;

function displayEyes() {
    let selectedOption = eyeStyles[currentNumberEyes];

    document.getElementById("eyesImg").src = selectedOption.img;
    document.getElementById("eyesImg").alt = selectedOption.name;
}

function nextFunctionEyes(){
    if (currentNumberEyes === 3) {
        currentNumberEyes = 0;
    }
    else {
        currentNumberEyes++;
    }
    displayEyes();

    style.eyes = eyeStyles[currentNumberEyes].name;
    updateMiminData();
}

function prevFunctionEyes(){
    if (currentNumberEyes === 0) {
        currentNumberEyes = 3;
    }
    else {
        currentNumberEyes--;
    }
    displayEyes();

    style.eyes = eyeStyles[currentNumberEyes].name;
    updateMiminData();
}



// hair buttons
let currentNumberHair = 0;

function displayHair() {
    let selectedOption = hairStyles[currentNumberHair];

    document.getElementById("hairImg").src = selectedOption.img;
    document.getElementById("hairImg").alt = selectedOption.name;
}

function nextFunctionHair(){
    if (currentNumberHair === 14) {
        currentNumberHair = 0;
    }
    else {
        currentNumberHair++;
    }
    displayHair();

    style.hair = hairStyles[currentNumberHair].name;
    updateMiminData();
}

function prevFunctionHair(){
    if (currentNumberHair === 0) {
        currentNumberHair = 14;
    }
    else {
        currentNumberHair--;
    }
    displayHair();

    style.hair = hairStyles[currentNumberHair].name;
    updateMiminData();
}





// clothing buttons
let currentNumberClothing = 0;

function displayClothing() {
    let selectedOption = clothingStyles[currentNumberClothing];

    document.getElementById("clothingImg").src = selectedOption.img;
    document.getElementById("clothingImg").alt = selectedOption.name;
}

function nextFunctionClothing(){
    if (currentNumberClothing === 3) {
        currentNumberClothing = 0;
    }
    else {
        currentNumberClothing++;
    }
    displayClothing();

    style.clothing = clothingStyles[currentNumberClothing].name;
    updateMiminData();
}

function prevFunctionClothing(){
    if (currentNumberClothing === 0) {
        currentNumberClothing = 3;
    }
    else {
        currentNumberClothing--;
    }
    displayClothing();

    style.clothing = clothingStyles[currentNumberClothing].name;
    updateMiminData();
}

// accessory buttons
let currentNumberAccessories = 0;

function displayAccessories() {
    let selectedOption = accessoriesStyles[currentNumberAccessories];

    document.getElementById("accessoriesImg").src = selectedOption.img;
    document.getElementById("accessoriesImg").alt = selectedOption.name;
}

function nextFunctionAccessories(){
    if (currentNumberAccessories === 2) {
        currentNumberAccessories = 0;
    }
    else {
        currentNumberAccessories++;
    }
    displayAccessories();

    style.accessories = accessoriesStyles[currentNumberAccessories].name;
    updateMiminData();
}

function prevFunctionAccessories(){
    if (currentNumberAccessories === 0) {
        currentNumberAccessories = 2;
    }
    else {
        currentNumberAccessories--;
    }
    displayAccessories();

    style.accessories = accessoriesStyles[currentNumberAccessories].name;
    updateMiminData();
}