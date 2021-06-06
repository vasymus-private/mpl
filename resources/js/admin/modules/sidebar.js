let collapseSelector = `[data-toggle="collapse"]`
let $collapse = $('.js-admin-sidbar').find(collapseSelector)

const STORAGE_KEY = 'admin-sidebar'

init()

addListeners()

$('.js-navigate-categories').on('click', event => {
    event.stopPropagation()
    event.preventDefault()
    let $currentTarget = $(event.currentTarget)
    let route = $currentTarget.data('route')

    if (!route) return true

    let $navLink = $currentTarget.parents('[data-toggle="collapse"]').first()

    let collapsibleSelector = $navLink.attr('href') || $navLink.data('target')
    let childCollapsibleId = collapsibleSelector.slice(1)

    handleSaveOpen(childCollapsibleId)

    location.href = route
})

function init() {
    let sidebarStorage = getSidebarStorage()

    for (let collapsibleId in sidebarStorage) {
        let isOpen = sidebarStorage[collapsibleId]

        if (isOpen) {
            $(`#${collapsibleId}`).collapse('show')
        }
    }
}

function addListeners() {
    $collapse.each((index, el) => {
        let collapsibleSelector = $(el).attr('href') || $(el).data('target')
        let $collapsible = $(collapsibleSelector)

        $collapsible.on('show.bs.collapse', (event) => {
            event.stopPropagation()
            let id = $(event.currentTarget).attr('id')
            handleSaveOpen(id)
        })

        $collapsible.on('hide.bs.collapse', (event) => {
            event.stopPropagation()
            let id = $(event.currentTarget).attr('id')
            handleSaveClose(id)
        })
    })
}

function handleSaveOpen(id) {
    saveOpen(id)
}

function handleSaveClose(id) {
    saveClose(id)
    let $currentCollapsible = $(`#${id}`)
    let $collapsibleChildToggle = $currentCollapsible.find(collapseSelector)

    $collapsibleChildToggle.each((index, el) => {
        let childCollapsibleTarget = $(el).attr('href') || $(el).data('target')
        if (childCollapsibleTarget) {
            let childCollapsibleId = childCollapsibleTarget.slice(1)
            saveClose(childCollapsibleId)
        }
    })
}

function saveOpen(id) {
    setInSidebarStorage(id, true)
}

function saveClose(id) {
    setInSidebarStorage(id, false)
}

function getSidebarStorage() {
    let storage = localStorage.getItem(STORAGE_KEY)
    try {
        storage = JSON.parse(storage)
        if (!storage) storage = {}
    } catch (error) {
        storage = {}
    }

    return storage
}

function setInSidebarStorage(key, value) {
    let storage = getSidebarStorage()
    storage[key] = value
    saveSidebarStorage(storage)
}

function saveSidebarStorage(storage) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(storage))
}
