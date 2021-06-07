let adminSidebarSelector = '.js-admin-sidbar'
let collapseSelector = `[data-toggle="collapse"]`
let $adminSidebar = $(adminSidebarSelector)
let $collapse = $adminSidebar.find(collapseSelector)

const STORAGE_KEY = 'admin-sidebar'

let tree = getTree()
let parentChildrenMap = getParentChildrenMap()
let childParentsMap = getChildParentsMap()
let siblingsMap = getSiblingsMap()

console.log("---", getTree(), siblingsMap)


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

    let siblings = siblingsMap[id]
    siblings.forEach(siblingId => {
        handleSaveClose(siblingId)
    })
}

function handleSaveClose(id) {
    saveClose(id)

    let subtreeIds = parentChildrenMap[id]

    subtreeIds.forEach(id => saveClose(id))
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

function getParentChildrenMap() {
    let treeIds = {}

    let allIds = getAllIds()

    allIds.forEach(id => {
        treeIds = {
            ...treeIds,
            [id] : getSubtreeIds(id)
        }
    })

    return treeIds
}

function getChildParentsMap() {
    let childParentsMap = {}

    let allIds = getAllIds()

    allIds.forEach(id => {
        childParentsMap = {
            ...childParentsMap,
            [id] : getParentsIds(id)
        }
    })

    return childParentsMap
}

function getAllIds() {
    let allIds = []

    $collapse.each((index, el) => {
        let $el = $(el)
        let collapsibleSelector = $el.attr('href') || $el.data('target')
        let id = collapsibleSelector.slice(1)
        allIds = [...allIds, id]
    })

    return allIds
}

function getSubtreeIds(id) {
    let subtreeIds = []

    let $currentCollapsible = $(`#${id}`)
    let $collapsibleChildToggle = $currentCollapsible.find(collapseSelector)

    $collapsibleChildToggle.each((index, el) => {
        let $el = $(el)
        let target = $el.attr('href') || $el.data('target')
        if (target) {
            let targetId = target.slice(1)
            subtreeIds = [...subtreeIds, targetId]
        }
    })

    return subtreeIds
}

function getParentsIds(id) {
    let parentsIds = []

    let $currentCollapsible = $(`#${id}`)
    let $parents = $currentCollapsible.parents('.collapse')

    $parents.each((index, el) => {
        let $el = $(el)
        let id = $el.attr('id')
        if (id) {
            parentsIds = [...parentsIds, id]
        }
    })

    return parentsIds
}

function getTree() {
    let tree = {}

    let parentChildrenMap = getParentChildrenMap()
    let childParentsMap = getChildParentsMap()

    let firstLevel = getForLevel(0)

    firstLevel.forEach(id => {
        tree[id] = {}
    })

    let secondLevel = getForLevel(1)

    secondLevel.forEach(id => {
        let parentId = getParentFor(id, firstLevel)

        tree[parentId][id] = {}
    })

    let thirdLevel = getForLevel(2)

    thirdLevel.forEach(id => {
        let secondLevelParentId = getParentFor(id, secondLevel)

        let firstLevelParentId = getParentFor(secondLevelParentId, firstLevel)

        tree[firstLevelParentId][secondLevelParentId][id] = {}
    })

    let fourthLevel = getForLevel(3)

    fourthLevel.forEach(id => {
        let thirdLevelParentId = getParentFor(id, thirdLevel)

        let secondLevelParentId = getParentFor(thirdLevelParentId, secondLevel)

        let firstLevelParentId = getParentFor(secondLevelParentId, firstLevel)

        tree[firstLevelParentId][secondLevelParentId][thirdLevelParentId][id] = {}
    })

    let fifthLevel = getForLevel(4)

    fifthLevel.forEach(id => {
        let fourthLevelParentId = getParentFor(id, fourthLevel)

        let thirdLevelParentId = getParentFor(fourthLevelParentId, thirdLevel)

        let secondLevelParentId = getParentFor(thirdLevelParentId, secondLevel)

        let firstLevelParentId = getParentFor(secondLevelParentId, firstLevel)

        tree[firstLevelParentId][secondLevelParentId][thirdLevelParentId][fourthLevelParentId][id] = {}
    })

    function getForLevel(level) {
        let forLevel = []

        for (let id in parentChildrenMap) {
            let count = getCount(id)

            if (count === level) {
                forLevel = [...forLevel, id]
            }
        }

        return forLevel
    }

    function getCount(id) {
        let count = 0

        for (let _id in parentChildrenMap) {
            if (id === _id) continue

            let childrenIds = parentChildrenMap[_id]

            if (childrenIds.includes(id)) {
                count++
            }
        }

        return count
    }

    function getParentFor(id, upperLevel) {
        let parents = childParentsMap[id]

        for (let i = 0; i < parents.length; i++) {
            let parentId = parents[i]
            if (upperLevel.includes(parentId)) {
                return parentId
            }
        }
    }

    return tree
}

function getSiblingsMap() {
    let siblingsMap = {}

    let allIds = getAllIds()
    allIds.forEach(id => {
        siblingsMap[id] = []
    })

    for (let id in tree) { // first level
        setSiblingsFor(id, tree)

        let children = tree[id]

        for (let id1 in children) { // second level
            setSiblingsFor(id1, children)

            let children2 = children[id1]

            for (let id2 in children2) { // third level
                setSiblingsFor(id2, children2)

                let children3 = children2[id2]

                for (let id3 in children3) { // fourth level
                    setSiblingsFor(id3, children3)

                    let children4 = children3[id3]

                    for (let id4 in children4) { // fifth level
                        setSiblingsFor(id4, children4)
                    }
                }
            }
        }
    }

    function setSiblingsFor(id, level) {
        let levelIds = Object.keys(level)
        levelIds.forEach(id => {
            levelIds.forEach(_id => {
                if (_id !== id && !siblingsMap[id].includes(_id)) {
                    siblingsMap[id] = [...siblingsMap[id], _id]
                }
            })
        })
    }

    return siblingsMap
}

function getSiblingsAndTheirChildren(id) {
    let siblingsAndTheirChildren = []

    let parents = childParentsMap[id]



    for (let _id in tree) {
        if (id === _id) {

        }
    }

    return siblingsAndTheirChildren
}
