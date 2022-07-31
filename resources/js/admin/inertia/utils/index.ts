export const isNumeric = (n: any): boolean =>
    !isNaN(parseFloat(n)) && isFinite(n)

export const getXsrfToken = (): string | null => {
    return cookieRead("XSRF-TOKEN")
}

export const cookieRead = (name: string): string | null => {
    let match = document.cookie.match(
        new RegExp("(^|;\\s*)(" + name + ")=([^;]*)")
    )
    return match ? decodeURIComponent(match[3]) : null
}

export const randomId = (): string => `id${Math.random().toString(16).slice(2)}`

/**
 * @see https://stackoverflow.com/a/29390393
 */
export const blobToFile = (theBlob: Blob, fileName:string): File => {
    let b: any = theBlob;
    //A Blob() is almost a File() - it's just missing the two properties below which we will add
    b.lastModifiedDate = new Date();
    b.name = fileName;

    //Cast to a File() type
    return <File>theBlob;
}
