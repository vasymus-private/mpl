export interface ToastProps {
    _uuid?: string
    message?: string
    delay?: number
    color?: string
    title?: string
}

export interface ToastPayload {
    type: ToastType
    props: ToastProps
}

export enum ToastType {
    ERROR,
    INFO,
}
