// 1
function concatArray(arr1, arr2) {
    const newArr = [];
    arr1.forEach(e => newArr.push(e));
    arr2.forEach(e => newArr.push(e));
    return newArr;
}

const array1 = ['A', 'B', 'C'];
const array2 = ['D', 'E', 'F'];

console.log(concatArray(array1, array2));

// 2
function insertElement(arr, index, value) {
	if (arr.length < index)  return `현재 배열의 길이는 ${arr.length}로 ${index}은/는 입력 불가능합니다.`;
    arr[index] = value;
    return arr;
}

const nums = [1, 2, 3, 4, 5];

console.log(insertElement(nums, 2, 6));
console.log(insertElement(nums, 10, 6)); // console.error("현재 배열의 길이는 5로 10은 입력 불가능합니다.")

// 3
function removeElement(arr, index) {
	return arr.filter(e => arr.indexOf(e) !== index);
}

const chars = ['A', 'B', 'C', 'D', 'E'];

console.log(removeElement(chars, 3)); // ['A', 'B', 'C', 'E'] 출력

// 4
function removeElement(arr, character) {
	if (!arr.includes(character)) return `배열에 ${character}가 없습니다.`;
    return arr.filter(e => e !== character);
}

const chars2 = ['A', 'B', 'B', 'C', 'D', 'E'];

console.log(removeElement(chars2, 'B')); // ['A', 'C', 'D', 'E'] 출력
console.log(removeElement(chars2, 'D')); // ['A', 'B', 'B', 'C', 'E'] 출력
console.log(removeElement(chars2, 'Z')); // console.error("배열에 Z가 없습니다.");

// 5
function excludeElements(arr, start, end) {
	return arr.filter(e => arr.indexOf(e) < start || arr.indexOf(e) > end);
}

const nums2 = [1, 2, 3, 4, 5, 6, 7];

console.log(excludeElements(nums2, 2, 5)); // [1, 2, 7] 출력

// 6
function reverseArray(arr) {
	return arr.toReversed();
}

const nums3 = [1, 2, 3, 4, 5];

console.log(reverseArray(nums3)); // [5, 4, 3, 2, 1] 출력

// 7
function joinStrings(arr) {
    return arr.join("");
}

const words = ['Hello', 'World', '!'];

console.log(joinStrings(words)); // 'HelloWorld!' 출력

// 8
function removeDuplicates(arr) {
	let newArr = [];
    arr.forEach(e => {
        if (!newArr.includes(e)) newArr.push(e);
    })
    return newArr;
}

const nums4 = [1, 2, 3, 1, 4, 2, 5];

console.log(removeDuplicates(nums4)); // [1, 2, 3, 4, 5] 출력

// 9
function average(arr) {
    let avg = 0;
	arr.forEach(e => {
        avg += e.reduce((sum, e) => sum + e, 0) / e.length;
    })
    
    return avg / arr.length
}

const nums5 = [[1, 2, 3, 4, 5], [9, 10, 11, 12, 13]];

console.log(average(nums5)); // 7 출력

// 10
function getLongestString(arr) {
	let longestString = arr[0];
    arr.forEach(e => {
        if (e.length > longestString.length) longestString = e;
    })
    return longestString;
}

const strings = ['apple', 'banana', 'orange', 'kiwi', 'grape'];

console.log(getLongestString(strings)); // 'banana' 출력

const arr523 = [1, 2, 3, 3, 3];
console.log(arr523.findIndex(e => e===3));