class Application {
    static init() {
        console.log('App running...')
    }

    static sendmail(event) {

        event.preventDefault()
        let url = event.target.getAttribute('action')

        if (event.target.name.value != '' && event.target._replyto.value != '' && event.target.message.value != '') {
            const xhr = new XMLHttpRequest()

            xhr.open('POST', url)
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onload = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        let div = document.querySelector('#messages')
                        div.classList.add('alert-success')
                        div.innerHTML = xhr.responseText
                        div.style.display = "block"
                    }
                }
            }

            xhr.send(`name=${event.target.name.value}&&email=${event.target._replyto.value}&&message=${event.target.message.value}`)

        } else {

            alert('Veuillez remplir tous les champs!')
        }
    }
}