/* @flow */

export const binaraySearch = (key: Number, arr: Array) => {
  let lo = 0
  let hi = arr.length - 1
  while(lo <= hi){
      let mid = Math.floor(lo + (hi - lo) / 2)
      if(key<arr[mid]){
          hi = mid - 1 
      }else if(key > arr[mid]){
          lo = mid + 1
      }else{
          return mid
      }
  }
  return -1
}
