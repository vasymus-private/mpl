export interface ModalPayload {
    type: ModalType
    props?: object
}

export enum ModalType {
    SORT_ADMIN_COLUMNS,
    CREATE_EDIT_VARIATION,
    EDIT_ORDER_PRODUCT,
    ADD_ORDER_PRODUCT_ITEM,
}
