export default interface CategoryTreeItem {
    id: number
    name: string
    subcategories: Array<CategoryTreeItem>
}
