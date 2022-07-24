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
