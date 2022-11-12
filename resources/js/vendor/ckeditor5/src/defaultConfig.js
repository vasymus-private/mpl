export const itemsWithImageUpload = [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    '|',
    'outdent',
    'indent',
    '|',
    'blockQuote',
    'insertTable',
    'imageUpload',
    'mediaEmbed',
    'undo',
    'redo'
]

export const itemsWithoutImageUpload = [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    '|',
    'outdent',
    'indent',
    '|',
    'blockQuote',
    'insertTable',
    'mediaEmbed',
    'undo',
    'redo'
]

const imageToolbar = [
    'imageTextAlternative',
    'imageStyle:inline',
    'imageStyle:block',
    'imageStyle:side'
]

export default {
    toolbar: {
        items: itemsWithImageUpload
    },
    language: 'ru',
    image: {
        toolbar: imageToolbar
    },
    table: {
        contentToolbar: [
            'tableColumn',
            'tableRow',
            'mergeTableCells'
        ]
    }
}
