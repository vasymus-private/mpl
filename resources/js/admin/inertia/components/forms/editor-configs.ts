import Underline from "@ckeditor/ckeditor5-basic-styles/src/underline"
import Strikethrough from "@ckeditor/ckeditor5-basic-styles/src/strikethrough"
import Superscript from "@ckeditor/ckeditor5-basic-styles/src/superscript"
import Subscript from "@ckeditor/ckeditor5-basic-styles/src/subscript"
import Code from "@ckeditor/ckeditor5-basic-styles/src/code"
import RemoveFormat from "@ckeditor/ckeditor5-remove-format/src/removeformat"
import FindAndReplace from "@ckeditor/ckeditor5-find-and-replace/src/findandreplace"
import Font from "@ckeditor/ckeditor5-font/src/font"
import Highlight from "@ckeditor/ckeditor5-highlight/src/highlight"
import CodeBlock from "@ckeditor/ckeditor5-code-block/src/codeblock"
import TodoList from "@ckeditor/ckeditor5-list/src/todolist"
import ListProperties from "@ckeditor/ckeditor5-list/src/listproperties"
import TableProperties from "@ckeditor/ckeditor5-table/src/tableproperties"
import TableCellProperties from "@ckeditor/ckeditor5-table/src/tablecellproperties"
import TableCaption from "@ckeditor/ckeditor5-table/src/tablecaption"
import ImageResize from "@ckeditor/ckeditor5-image/src/imageresize"
import LinkImage from "@ckeditor/ckeditor5-link/src/linkimage"
import LinkImageEditing from "@ckeditor/ckeditor5-link/src/linkimageediting"
import AutoImage from "@ckeditor/ckeditor5-image/src/autoimage"
import HtmlEmbed from "@ckeditor/ckeditor5-html-embed/src/htmlembed"
import AutoLink from "@ckeditor/ckeditor5-link/src/autolink"
import Mention from "@ckeditor/ckeditor5-mention/src/mention"
import TextTransformation from "@ckeditor/ckeditor5-typing/src/texttransformation"
import Alignment from "@ckeditor/ckeditor5-alignment/src/alignment"
import IndentBlock from "@ckeditor/ckeditor5-indent/src/indentblock"
import PasteFromOffice from "@ckeditor/ckeditor5-paste-from-office/src/pastefromoffice"
import PageBreak from "@ckeditor/ckeditor5-page-break/src/pagebreak"
import HorizontalLine from "@ckeditor/ckeditor5-horizontal-line/src/horizontalline"
import SpecialCharacters from "@ckeditor/ckeditor5-special-characters/src/specialcharacters"
import SpecialCharactersEssentials from "@ckeditor/ckeditor5-special-characters/src/specialcharactersessentials"
import WordCount from "@ckeditor/ckeditor5-word-count/src/wordcount"
import ImageUpload from "@ckeditor/ckeditor5-image/src/imageupload"
import TextPartLanguage from "@ckeditor/ckeditor5-language/src/textpartlanguage"
import SourceEditing from "@ckeditor/ckeditor5-source-editing/src/sourceediting"
import ImageEditing from "@ckeditor/ckeditor5-image/src/image/imageediting"
import ImageBlockEditing from "@ckeditor/ckeditor5-image/src/image/imageblockediting"
import SimpleUploadAdapter from "@ckeditor/ckeditor5-upload/src/adapters/simpleuploadadapter"

import EssentialsPlugin from "@ckeditor/ckeditor5-essentials/src/essentials"
import BoldPlugin from "@ckeditor/ckeditor5-basic-styles/src/bold"
import ItalicPlugin from "@ckeditor/ckeditor5-basic-styles/src/italic"
import LinkPlugin from "@ckeditor/ckeditor5-link/src/link"
import ParagraphPlugin from "@ckeditor/ckeditor5-paragraph/src/paragraph"
import { getRouteUrl, routeNames } from "@/admin/inertia/modules/routes"

export const configSimple = {
    toolbar: ["heading", "|", "bold", "italic"],
}

export const configWithSimpleUpload = {
    // plugins: [SimpleUploadAdapter],
    simpleUpload: {
        uploadUrl: getRouteUrl(routeNames.ROUTE_ADMIN_PRODUCT_IMAGE_UPLOAD),
        withCredentials: true,
        headers: {
            "X-CSRF-TOKEN": "CSRF-Token",
            Authorization: "Bearer <JSON Web Token>",
        },
    },
}

export const configExample = {
    plugins: [
        EssentialsPlugin,
        BoldPlugin,
        ItalicPlugin,
        LinkPlugin,
        ParagraphPlugin,
    ],

    toolbar: {
        items: ["bold", "italic", "link", "undo", "redo"],
    },
}

export const config1 = {
    plugins: [
        Underline,
        Strikethrough,
        Superscript,
        Subscript,
        Code,
        RemoveFormat,
        FindAndReplace,
        Font,
        Highlight,
        CodeBlock,
        TodoList,
        ListProperties,
        TableProperties,
        TableCellProperties,
        TableCaption,
        ImageResize,
        LinkImage,
        LinkImageEditing,
        AutoImage,
        HtmlEmbed,
        AutoLink,
        Mention,
        TextTransformation,
        Alignment,
        IndentBlock,
        PasteFromOffice,
        PageBreak,
        HorizontalLine,
        SpecialCharacters,
        SpecialCharactersEssentials,
        WordCount,
        ImageUpload,
        TextPartLanguage,
        SourceEditing,
        ImageEditing,
        ImageBlockEditing,
    ],
    toolbar: {
        items: [
            "undo",
            "redo",
            "|",
            "findAndReplace",
            "selectAll",
            "|",
            "heading",
            "|",
            "removeFormat",
            "bold",
            "italic",
            "strikethrough",
            "underline",
            "code",
            "subscript",
            "superscript",
            "|",
            "specialCharacters",
            "horizontalLine",
            "pageBreak",
            "|",
            "-",
            "highlight",
            "fontSize",
            "fontFamily",
            "fontColor",
            "fontBackgroundColor",
            "|",
            "link",
            "blockQuote",
            "insertTable",
            "uploadImage",
            "mediaEmbed",
            "codeBlock",
            "htmlEmbed",
            "|",
            "bulletedList",
            "numberedList",
            "todoList",
            "|",
            "outdent",
            "indent",
            "alignment",
            "|",
            "textPartLanguage",
            "|",
            "sourceEditing",
        ],
        shouldNotGroupWhenFull: true,
    },
    fontFamily: {
        supportAllValues: true,
    },
    fontSize: {
        options: [10, 12, 14, "default", 18, 20, 22],
        supportAllValues: true,
    },
    htmlEmbed: {
        showPreviews: true,
    },
    image: {
        styles: ["alignCenter", "alignLeft", "alignRight"],
        resizeOptions: [
            {
                name: "resizeImage:original",
                label: "Original",
                value: null,
            },
            {
                name: "resizeImage:50",
                label: "50%",
                value: "50",
            },
            {
                name: "resizeImage:75",
                label: "75%",
                value: "75",
            },
        ],
        toolbar: [
            "imageTextAlternative",
            "toggleImageCaption",
            "|",
            "imageStyle:inline",
            "imageStyle:wrapText",
            "imageStyle:breakText",
            "imageStyle:side",
            "|",
            "resizeImage",
        ],
        insert: {
            integrations: ["insertImageViaUrl"],
        },
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true,
        },
    },
    link: {
        decorators: {
            addTargetToExternalLinks: true,
            defaultProtocol: "https://",
            toggleDownloadable: {
                mode: "manual",
                label: "Downloadable",
                attributes: {
                    download: "file",
                },
            },
        },
    },
    mention: {
        feeds: [
            {
                marker: "@",
                feed: [
                    "@apple",
                    "@bears",
                    "@brownie",
                    "@cake",
                    "@cake",
                    "@candy",
                    "@canes",
                    "@chocolate",
                    "@cookie",
                    "@cotton",
                    "@cream",
                    "@cupcake",
                    "@danish",
                    "@donut",
                    "@dragée",
                    "@fruitcake",
                    "@gingerbread",
                    "@gummi",
                    "@ice",
                    "@jelly-o",
                    "@liquorice",
                    "@macaroon",
                    "@marzipan",
                    "@oat",
                    "@pie",
                    "@plum",
                    "@pudding",
                    "@sesame",
                    "@snaps",
                    "@soufflé",
                    "@sugar",
                    "@sweet",
                    "@topping",
                    "@wafer",
                ],
                minimumCharacters: 1,
            },
        ],
    },
    placeholder: "Type or paste your content here!",
    table: {
        contentToolbar: [
            "tableColumn",
            "tableRow",
            "mergeTableCells",
            "tableProperties",
            "tableCellProperties",
            "toggleTableCaption",
        ],
    },
}
