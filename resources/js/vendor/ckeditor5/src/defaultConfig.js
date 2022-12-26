export const itemsWithImageUpload = [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    'alignment',
    '|',
    'outdent',
    'indent',
    '|',
    'blockQuote',
    'insertTable',
    'imageUpload',
    'mediaEmbed',
    'undo',
    'redo',
    'sourceEditing'
]

export const itemsWithoutImageUpload = [
    'heading',
    '|',
    'bold',
    'italic',
    'link',
    'bulletedList',
    'numberedList',
    'alignment',
    '|',
    'outdent',
    'indent',
    '|',
    'blockQuote',
    'insertTable',
    'mediaEmbed',
    'undo',
    'redo',
    'sourceEditing',
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
    },
    htmlSupport: {
        allow: [
            {
                name: /^(div|section|article|p|h1|h2|h3|h4|h5|h6|a|strong|i|img|ol|ul|li|table|thead|tbody|tr|td|th|figure)$/,
                styles: true,
                classes: true,
                attributes: true,
            }
        ]
    }
}
