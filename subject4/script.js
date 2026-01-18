// 1 수
function concatArray(arr1, arr2) {
    return [...arr1, ...arr2];
}

const array1 = ['A', 'B', 'C'];
const array2 = ['D', 'E', 'F'];

console.log(concatArray(array1, array2));

// 2 수
function insertElement(arr, index, value) {
	if (arr.length < index)  return `현재 배열의 길이는 ${arr.length}로 ${index}은/는 입력 불가능합니다.`;
    return [...arr.slice(0, index), value, ...arr.slice(index, arr.length)];
}

const nums = [1, 2, 3, 4, 5];

console.log(insertElement(nums, 2, 6));
console.log(insertElement(nums, 10, 6)); // console.error("현재 배열의 길이는 5로 10은 입력 불가능합니다.")

// 3 수
function removeElement(arr, index) {
	return arr.filter((e, i) => i !== index);
}

const chars = ['A', 'B', 'C', 'D', 'E'];

console.log(removeElement(chars, 3)); // ['A', 'B', 'C', 'E'] 출력
console.log(removeElement([1, 2, 1, 3], 2)); // ['A', 'B', 'C', 'E'] 출력

// 4 수
function removeElement(arr, character) {
	if (!arr.includes(character)) return `배열에 ${character}가 없습니다.`;
    return arr.filter(e => e !== character);
}

const chars2 = ['A', 'B', 'B', 'C', 'D', 'E'];

console.log(removeElement(chars2, 'B')); // ['A', 'C', 'D', 'E'] 출력
console.log(removeElement(chars2, 'D')); // ['A', 'B', 'B', 'C', 'E'] 출력
console.log(removeElement(chars2, 'Z')); // console.error("배열에 Z가 없습니다.");

// 5 수
function excludeElements(arr, start, end) {
	return arr.filter((e, i) => i < start || i > end);
}

const nums2 = [1, 2, 3, 4, 5, 6, 7];

console.log(excludeElements(nums2, 2, 5)); // [1, 2, 7] 출력

// 6 수
function reverseArray(arr) {
	for (let i = 0; i < arr.length-1; i++) {
        for (let j = 0; j < arr.length; j++) {
            if (arr[j] < arr[j+1]) {
                let temp = arr[j];
                arr[j] = arr[j+1];
                arr[j+1] = temp;
            }
        }
    }

    return arr;
}

const nums3 = [1, 2, 3, 4, 5];

console.log(reverseArray(nums3)); // [5, 4, 3, 2, 1] 출력

// 7 
function joinStrings(arr) {
    let joinedString = "";
    arr.forEach(e => joinedString = joinedString.concat(e));
    return joinedString;
}

const words = ['Hello', 'World', '!'];

console.log(joinStrings(words)); // 'HelloWorld!' 출력

// 8 수
function removeDuplicates(arr) {
    return arr.reduce((newArr, e) => {
        if (!newArr.includes(e)) newArr.push(e);
        return newArr;
    }, [])
    // return [...new Set(arr)];
}

const nums4 = [1, 2, 3, 1, 4, 2, 5];

console.log(removeDuplicates(nums4)); // [1, 2, 3, 4, 5] 출력

// 9 수
function average(arr) {
    let newArr = [];
    arr.forEach(e => {
        newArr = [...newArr, ...e]
    });
    return newArr.reduce((sum, e) => sum + e, 0) / newArr.length;
}

const nums5 = [[1, 2, 3, 4, 5], [9, 10, 11, 12, 13]];

console.log(average(nums5)); // 7 출력

// 10 완
function getLongestString(arr) {
	let longestString = arr[0];
    arr.forEach(e => {
        if (e.length > longestString.length) longestString = e;
    })
    return longestString;
}

const strings = ['apple', 'banana', 'orange', 'kiwi', 'grape'];

console.log(getLongestString(strings)); // 'banana' 출력