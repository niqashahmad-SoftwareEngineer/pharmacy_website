import {test} from 'node:test';
import assert from 'node:assert/strict';
import {filterProducts, type Product} from '../../resources/js/lib/catalogue.ts';
const products:Product[]=[
{id:1,name:'Daily skin care',category:'Personal Care',label:'',accent:'',description:''},
{id:2,name:'Baby care essentials',category:'Baby Care',label:'',accent:'',description:''}
];
test('search is case insensitive and trimmed',()=>assert.deepEqual(filterProducts(products,'  SKIN  ','All essentials').map(p=>p.id),[1]));
test('category and search combine',()=>assert.equal(filterProducts(products,'skin','Baby Care').length,0));
test('reset returns every product without mutating input',()=>{assert.equal(filterProducts(products,'','All essentials').length,2);assert.equal(products.length,2)});
test('unknown search returns empty results',()=>assert.equal(filterProducts(products,'unavailable','All essentials').length,0));
