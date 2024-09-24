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
            printData(data.data.users)
            setupPagination(data.data.total_pages, 1)
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
        printData(data.data.users)
        setupPagination(data.data.total_pages, 1)
    })
    .catch(error => console.error('Error:', error))
}

const setupPagination = (totalPages, currentPage) => {
    currentPage = Number(currentPage)
    const paginationContainer = document.querySelector('.prueba-wordpress__pagination')
    paginationContainer.innerHTML = ""

    let prevButton = document.createElement('button')
    prevButton.textContent = 'Prev'
    
    prevButton.classList.add('prueba-wordpress__form-button')

    if (currentPage == 1) {
        prevButton.disabled = true
        prevButton.classList.add('prueba-wordpress__form-button-disabled')
    }
    
    prevButton.addEventListener('click', function(e) {
        loadPageData(currentPage - 1)
    })

    paginationContainer.appendChild(prevButton)

    let nextButton = document.createElement('button')
    nextButton.textContent = 'Next'
    nextButton.classList.add('prueba-wordpress__form-button')
    
    if (currentPage == totalPages) {
        nextButton.disabled = true
        nextButton.classList.add('prueba-wordpress__form-button-disabled')
    }

    nextButton.addEventListener('click', function(e) {
        loadPageData(currentPage + 1)
    })

    paginationContainer.appendChild(nextButton)
}

const loadPageData = (page) => {
    const url = `${ajax_object.ajax_url}?action=change_page`
    const formData = new FormData()
    formData.append('page', page)

    fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        body: formData
    })
    .then(response => response.json())
    .then(data => {        
        printData(data.data.users)
        setupPagination(data.data.total_pages, data.data.current_page)
    })
    .catch(error => console.error('Error:', error))
} 

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.prueba-wordpress__form')
    setEventToForm(form)
    showAllUsers()
})