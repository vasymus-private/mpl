$('.js-show-product-form').on('submit', async event => {
    event.preventDefault();

    let $target = $(event.target)

    let componentsNames = $target.data('names');
    let id = $target.data('id');

    for (let i = 0; i < componentsNames.length; i++) {
        let c = livewire.components.getComponentsByName(componentsNames[i])
        if (c.length) {
            await livewire.find(c[0].id).handleSave()
        }
    }

    livewire.find(id).afterSave()
})
