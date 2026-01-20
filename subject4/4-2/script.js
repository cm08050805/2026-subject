// 1 완
function mergeObjects(obj1, obj2) {
    return {...obj1, ...obj2}
}

const object1 = {a: 'A', b: 'B', c: 'C'};
const object2 = {b: 'X', c: 'Y', d: 'Z'};

console.log(mergeObjects(object1, object2)); // {a: 'A', b: 'X', c: 'Y', d: 'Z'} 출력

// 2
function countLetters(string) {
	const resultObj = {};
    for (char of string) {
        resultObj[char] = (resultObj[char] || 0) + 1;
    }

    return resultObj;
}

const str = "apple";

console.log(countLetters(str)); // {a: 1, p: 2, l: 1, e: 1} 출력

// 3 수
function getObjectKeysAndValues(object) {
    return [Object.keys(object), Object.values(object)]
}

const obj = { a: "A", b: "B", c: "C" };

console.log(getObjectKeysAndValues(obj)); // [['a', 'b', 'c'], ['A', 'B', 'C']] 출력

// 4 수
function removeKeyFromObject(object, keys) {
		return Object.entries(object).reduce((acc, [k, v]) => {
			if (!keys.includes(k)) acc[k] = v;
			return acc;
		}, {});
}

const obj2 = {a: "hi", b: "there", c: "world"};

console.log(removeKeyFromObject(obj2, ['b', 'c'])); // {a: "hi"} 출력

// 5 수
function selectValuesByKey(objectArray, key) {
    return objectArray.map(e => e[key]);
}

const objectArray = [
	{ id: 1, name: "Alice" },
	{ id: 2, name: "Bob" },
	{ id: 3, name: "Cathy" },
];

console.log(selectValuesByKey(objectArray, "name"));
// ["Alice", "Bob", "Cathy"] 출력

// 6 완
function filterByScore(students, score) {
	return students.filter(e => e.score >= score).map(e => e.name);
}

const students = [
	{ name: "Alice", score: 85 },
	{ name: "Bob", score: 75 },
	{ name: "Cathy", score: 90 },
	{ name: "David", score: 65 },
];

console.log(filterByScore(students, 80)); // ["Alice", "Cathy"] 출력

// 7 완
function filterByAverageScore(students, score) {
	return students.filter(e => (e.score.reduce((sum, v) => {return sum + v}, 0) / e.score.length) >= score).map(e => e.name);
}

const students2 = [
	{ name: "Alice", score: [90, 60, 70, 100] },
	{ name: "Bob", score: [75, 35, 40, 60] },
	{ name: "Cathy", score: [90, 10, 20, 30] },
	{ name: "David", score: [70, 75, 85, 95] },
];

console.log(filterByAverageScore(students2, 80)); // ["Alice", "David"] 출력

// 8 완
function getBooksByCategory(books, category) {
	return books.filter(e => e.category === category).map(e => e.title);
}

const books = [
	{ title: "The Hobbit", category: "novel" },
	{ title: "Harry Potter", category: "novel" },
	{ title: "JavaScript for Beginners", category: "programming" },
	{ title: "Python Crash Course", category: "programming" },
];

console.log(getBooksByCategory(books, "programming")); 
// ["JavaScript for Beginners", "Python Crash Course"] 출력

// 9 수
function getBooksStatsByCategory(books, category) {
	const categoryBooks = books.filter(e => e.category === category);
    return {titles: [...categoryBooks.map(e => e.title)], avgPages: `${(categoryBooks.reduce((sum, e) => {return sum + e.pages}, 0)/categoryBooks.length).toFixed(3)}`}
}

const books2 = [
	{ title: "The Hobbit", category: "novel", pages: 310 },
	{ title: "Harry Potter", category: "novel", pages: 450 },
	{ title: "JavaScript for Beginners", category: "programming", pages: 200 },
	{ title: "Python Crash Course", category: "programming", pages: 250 },
	{ title: "Eloquent JavaScript", category: "programming", pages: 280 },
	{ title: "Crime and Punishment", category: "novel", pages: 480 },
];

console.log(getBooksStatsByCategory(books2, "programming"));
// { titles: ["JavaScript for Beginners", "Python Crash Course", "Eloquent JavaScript"], avgPages: 243.333 } 출력
console.log(getBooksStatsByCategory(books2, "novel"));
// { titles: ["The Hobbit", "Harry Potter", "Crime and Punishment"], avgPages: 413.333 } 출력

// 10 수
const defaultFilterOptions = {
	minPages: 0, 
  maxPages: Infinity, 
  minPrice: 0, 
  maxPrice: Infinity,
	category: undefined // 선택 사항
}

function searchBooks(books, options = defaultFilterOptions) {
	const newObj = {};
	let isPagesValid;
	let isPriceValid;
	let isCategoryValid;
    for (e of Object.values(books)) {
		isPagesValid = e.pages >= options.minPages && e.pages <= options.maxPages;
		isPriceValid = e.price >= options.minPrice && e.price <= options.maxPrice;
		isCategoryValid = options.category && e.category !== options.category;
        if (isPagesValid && isPriceValid) {
            if (isCategoryValid) continue;
            newObj[e.category] = {
                titles: [...(newObj[e.category]?.titles ?? []), e.title],
                totalPages: (newObj[e.category]?.totalPages ?? 0) + e.pages,
                totalPrices: (newObj[e.category]?.totalPrices ?? 0) + e.price
            };
        }
    }

    return newObj;
}

const books3 = [
	{ title: "The Hobbit", category: "novel", pages: 310, price: 13 },
	{ title: "Harry Potter", category: "novel", pages: 450, price: 28 },
	{ title: "JavaScript for Beginners", category: "programming", pages: 200, price: 15 },
	{ title: "Python Crash Course", category: "programming", pages: 250, price: 18 },
	{ title: "Eloquent JavaScript", category: "programming", pages: 280, price: 20 },
	{ title: "Crime and Punishment", category: "novel", pages: 480, price: 27 },
	{ title: "JavaScript: The Good Parts", category: "programming", pages: 170, price: 10 },
	{ title: "To Kill a Mockingbird", category: "novel", pages: 320, price: 15 },
];

console.log(searchBooks(books3));
/* 
{
  novel: { titles: ["The Hobbit", "Harry Potter", "Crime and Punishment", "To Kill a Mockingbird"], totalPages: 1560, totalPrices: 83 },
  programming: { titles: ["JavaScript for Beginners", "Python Crash Course", "Eloquent JavaScript", "JavaScript: The Good Parts"], totalPages: 900, totalPrices: 63 }
}
출력
*/

console.log(searchBooks(books3, { minPages: 200, maxPages: 370, minPrice: 15, maxPrice: 20 }));
/*
{
  novel: { titles: ["The Hobbit", "To Kill a Mockingbird"], totalPages: 630, totalPrices: 28 },
  programming: { titles: ["JavaScript for Beginners", "Python Crash Course", "Eloquent JavaScript"], totalPages: 730, totalPrices: 53 }
}
출력
*/