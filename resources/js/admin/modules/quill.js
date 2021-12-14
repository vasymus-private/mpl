import Quill from "quill/dist/quill"
import 'quill/dist/quill.snow.css'
import 'quill/dist/quill.bubble.css'

let options = {
    theme: 'snow'
}

window.livewireQuill = () => {
    console.log('--- livewireQuill')
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
        if (!jQuery(`#${editorId}`).length && !jQuery(`#${sourceId}`).length) {
            return true
        }

        console.log('--- editorId', editorId)
        console.log('--- sourceId', sourceId)

        let quill = new Quill(`#${editorId}`, options);
        let delta = quill.clipboard.convert(document.getElementById(sourceId).value)
        quill.setContents(delta, 'api')

        quill.on('text-change', function() {
            console.log('args', arguments)
            let elements = [
                document.getElementById(editorId),
                document.getElementById(sourceId)
            ]
            jQuery(elements).val(quill.root.innerHTML)
            elements.forEach(element => {
                element.dispatchEvent(new Event('input'))
            })
        })
    })
}


