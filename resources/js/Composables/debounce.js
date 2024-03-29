export function debounce(fn, duration = 0) {
    let timeout
    return (...args) => {
        clearTimeout(timeout)
        timeout = setTimeout(() => fn(...args), duration)
    }
}