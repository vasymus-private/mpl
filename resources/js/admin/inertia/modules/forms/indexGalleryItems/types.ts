import { GalleryItemListItem } from "@/admin/inertia/modules/galleryItems/types"

export interface Values {
    galleryItems: Array<Partial<GalleryItemListItem>>
}

export interface GalleryItemsResponse {
    data: Array<GalleryItemListItem>
}
