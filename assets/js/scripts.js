import importObserver from './importObserver.js'

function main() {
  console.log('hello Press Wind !!')
}

document.addEventListener('DOMContentLoaded', () => {
  main()

  // importObserver
  // use only name of file without extension and ./, root is ./assets/js
  importObserver(document.querySelector('.site-footer'), 'hello')
})
