(() => {
    window.___editors = {}

    let options = {
        toolbarGroups : [
            { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
            { name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
            { name: 'links' },
            { name: 'insert' },
            { name: 'forms' },
            { name: 'tools' },
            { name: 'document',       groups: [ 'mode', 'document', 'doctools' ] },
            { name: 'others' },
            '/',
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
            { name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
            { name: 'styles' },
            { name: 'colors' },
            { name: 'about' }
        ]
    }

    window.livewireCkeditor4 = () => {
        let selectors = [
            {
                editorId : 'item-preview-tinymce',
                sourceId : 'item.preview'
            },
            {
                editorId : 'item-description-tinymce',
                sourceId : 'item.description'
            },
            {
                editorId : 'currentVariation-preview-tinymce',
                sourceId : 'currentVariation.preview'
            },
            {
                editorId : 'brand-preview-tinymce',
                sourceId : 'brand.preview'
            },
            {
                editorId : 'brand-description-tinymce',
                sourceId : 'brand.description'
            },
        ]

        selectors.forEach(({editorId, sourceId}) => {
            if (!jQuery(`#${editorId}`).length) {
                return true
            }

            console.log('--- editorId', editorId)
            console.log('--- sourceId', sourceId)

            if (window.___editors[editorId]) {
                window.___editors[editorId].destroy()
            }

            let editor = window.___editors[editorId] = CKEDITOR.replace(editorId, options)
            editor.setData(
                document.getElementById(sourceId).value
            )

            window.___editor = editor

            editor.on('change', function(event) {
                let el = document.getElementById(sourceId)
                jQuery(el).val(event.editor.getData())
                el.dispatchEvent(new Event('input'))
            })
        })
    }
})()
