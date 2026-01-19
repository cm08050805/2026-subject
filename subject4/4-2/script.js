// 1
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

// 3
function getObjectKeysAndValues(object) {
    const resultArr = [[], []];
	for (const [k, v] of Object.entries(object)) {
        resultArr[0].push(k);
        resultArr[1].push(v);
    }

    return resultArr;
}

const obj = { a: "A", b: "B", c: "C" };

console.log(getObjectKeysAndValues(obj)); // [['a', 'b', 'c'], ['A', 'B', 'C']] 출력

// 4
function removeKeyFromObject(object, keys) {
	for (e of keys) {
        delete object[e];
    }

    return object
}

const obj2 = {a: "hi", b: "there", c: "world"};

console.log(removeKeyFromObject(obj2, ['b', 'c'])); // {a: "hi"} 출력

// 5
function selectValuesByKey(objectArray, key) {
	const resultArr = [];
    for (e of objectArray) {
        resultArr.push(e[key]);
    }

    return resultArr;
}

const objectArray = [
	{ id: 1, name: "Alice" },
	{ id: 2, name: "Bob" },
	{ id: 3, name: "Cathy" },
];

console.log(selectValuesByKey(objectArray, "name")); 
// ["Alice", "Bob", "Cathy"] 출력

// 6
