const printData = (users) => {
    const tbody = document.querySelector('.prueba-wordpress__table-body')
    tbody.innerHTML = ""
    
    if (Array.isArray(users)) {
        users.forEach((values, key) => {
            let tr = setTr(values)
            tbody.appendChild(tr)
        })
    } else {
        Object.entries(users).forEach(([key, values]) => {
            let tr = setTr(values)
            tbody.appendChild(tr)
        })
    }
}

const setTr = (values) => {
    let tr = document.createElement('tr')
    Object.entries(values).forEach(([key, value]) => {
        if (key != 'id') {            
            let td = document.createElement('td')
            let text = document.createTextNode(value)
    
            td.appendChild(text)
            tr.appendChild(td)
        }
    })

    return tr
}

const setEventToForm = (form) => {
    form.addEventListener('submit', function(event) {
        event.preventDefault()
        
        const formData = new FormData(form)
        formData.append('action', 'filter_user_data')

        fetch(form.action, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            printData(data.data)
        })
        .catch(error => console.error('Error:', error))
    })
}

const showAllUsers = () => {
    const url = `${ajax_object.ajax_url}?action=get_all_data`
    fetch(url, {
        method: 'GET',
        credentials: 'same-origin'
    })
    .then(response => response.json())
    .then(data => {
        printData(data.data)
    })
    .catch(error => console.error('Error:', error))
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.prueba-wordpress__form')
    setEventToForm(form)
    showAllUsers()
})