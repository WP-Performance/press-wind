/**
 * Import JS file when target is in viewport
 * @param target - DOM element
 * @param file - name of file in /dynamic directory without extension
 */
function importObserver(target, file) {
  if (!target) return
  // import when target is in viewport
  const observer = new IntersectionObserver(async (entries) => {
    if (entries[0].isIntersecting) {
      await import(`./dynamic/${file}.js`)
      // stop observing
      observer.disconnect()
    }
  })
  observer.observe(target)
}

export default importObserver
