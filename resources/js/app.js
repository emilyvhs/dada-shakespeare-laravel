import './bootstrap';

let anotherPlayCharacter = document.getElementById("anotherPlayCharacter")
let addCharacter = document.getElementById("addCharacter")

window.handleAnotherPlayCharacter = function() {
    let WorkID = anotherPlayCharacter.value

    fetch(`http://0.0.0.0:8000/api/characters/work/${WorkID}`)
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            let characterList = data.data
            addCharacter.innerHTML = ''
            characterList.forEach((character) => {
                addCharacter.innerHTML += `<option value="${character.CharID}">${character.CharName}</option>`
            })
        })
}
