def mergeSort(array):
    if len(array) <= 1:
        return array
    else:
        mid = len(array) // 2
        return merge(mergeSort(array[:mid]), mergeSort(array[mid:]))


def merge(array1, array2):
    result = []
    i = 0
    for element in array1:
        while i < len(array2) and array2[i] < element:
            result.append(array2[i])
            i += 1
        result.append(element)
    result += array2[i:]
    return result


def binarySearch(array, value):
    lo, hi = 0, len(array) - 1
    while lo <= hi:
        mid = ((hi - lo) // 2) + lo
        if value == array[mid]:
            return mid
        hi = mid - 1 if value < array[mid] else hi
        lo = mid + 1 if value > array[mid] else lo
    return None


def test():
    myArray = [5, 5, 2, 4, 16, 15, 20, 1, 18, 10, 21, 51, 41, 31]
    print("old", myArray)
    myArray = mergeSort(myArray)
    print("new", myArray)
    print(binarySearch(myArray, 15))
    print(binarySearch(myArray, 22))


test()
