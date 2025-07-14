import './bootstrap';

//JS to control burger menu for nav

let menuOpenButton = document.querySelector(".menu-open")
let menuCloseButton = document.querySelector(".menu-close")

window.handleMenuOpen = function() {
    menuOpenButton.classList.add("hidden")
    menuCloseButton.classList.remove("hidden")
}

window.handleMenuClose = function() {
    menuCloseButton.classList.add("hidden")
    menuOpenButton.classList.remove("hidden")
}


//JS to control play and character list options

let url = 'http://0.0.0.0:8000'

let firstPlay = document.getElementById("title")
let removeCharacter = document.getElementById("removeCharacter")

let secondPlay = document.getElementById("secondPlay")
let addCharacter = document.getElementById("addCharacter")

const excludedCharacters = ['All', 'All Citizens', 'All Conspirators', 'All Ladies', 'All Lords', 'All Servants', 'All The People', 'Another', 'Both', 'Both Citizens', 'Both Tribunes', 'Brothers', 'Several Citizens', 'Some Speak', '(stage directions)']

window.handleFirstPlayChange = function() {
    handleRemoveCharacter()
    createSecondPlayList()
    handleAddCharacter()
}

window.handleRemoveCharacter = function() {
    let WorkID = firstPlay.value

    fetch(`${url}/api/characters/work/${WorkID}`)
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            let characterList = data.data
            removeCharacter.innerHTML = '<option value="">No character selected</option>'
            characterList.forEach((character) => {
                if (character.SpeechCount == 0 || excludedCharacters.includes(character.CharName)) {
                    //do nothing
                } else {
                    removeCharacter.innerHTML += `<option value="${character.CharID}">${character.CharName}</option>`
                }
            })
        })
}

window.handleAddCharacter = function(){
    let WorkID = secondPlay.value

    fetch(`${url}/api/characters/work/${WorkID}`)
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            let characterList = data.data
            addCharacter.innerHTML = '<option value="">No character selected</option>'
            characterList.forEach((character) => {
                if (character.SpeechCount == 0 || excludedCharacters.includes(character.CharName)) {
                    //do nothing
                } else {
                    addCharacter.innerHTML += `<option value="${character.CharID}">${character.CharName}</option>`
                }
            })
        })
}

window.createSecondPlayList = function() {
    let WorkID = firstPlay.value

    fetch(`${url}/api/works`)
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            let secondPlayList = data.data
            secondPlay.innerHTML = '<option value="">No play selected</option>'
            secondPlayList.forEach((work) => {
                if (WorkID != work.WorkID) {
                    secondPlay.innerHTML += `<option value="${work.WorkID}">${work.Title}</option>`
                }
            })
        })
}
