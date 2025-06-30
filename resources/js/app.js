import './bootstrap';

let firstPlay = document.getElementById("title")
let removeCharacter = document.getElementById("removeCharacter")

let secondPlay = document.getElementById("secondPlay")
let addCharacter = document.getElementById("addCharacter")

window.handleRemoveCharacter = function() {
    let WorkID = firstPlay.value

    fetch(`http://0.0.0.0:8000/api/characters/work/${WorkID}`)
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            let characterList = data.data
            removeCharacter.innerHTML = '<option value="">No character selected</option>'
            characterList.forEach((character) => {
                removeCharacter.innerHTML += `<option value="${character.CharID}">${character.CharName}</option>`
            })
        })
}

window.handleAddCharacter = function() {
    let WorkID = secondPlay.value

    fetch(`http://0.0.0.0:8000/api/characters/work/${WorkID}`)
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            let characterList = data.data
            addCharacter.innerHTML = '<option value="">No character selected</option>'
            characterList.forEach((character) => {
                addCharacter.innerHTML += `<option value="${character.CharID}">${character.CharName}</option>`
            })
        })
}
