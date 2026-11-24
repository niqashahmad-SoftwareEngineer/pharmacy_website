export type Product = {id:number;name:string;category:string;label:string;accent:string;description:string};
export type Category = {name:string;icon:string;tint:string};
export function filterProducts(products: Product[], query: string, category: string): Product[] {
    const term=query.trim().toLowerCase();
    return products.filter(p=>(category==='All essentials'||p.category===category)&& (p.name+' '+p.category).toLowerCase().includes(term));
}
