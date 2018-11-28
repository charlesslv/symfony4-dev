if (document.getElementsByClassName('js-categories-filter')[0]) {
  initCategoriesFilter(false, 1);
  const inputs = document.querySelectorAll('.js-categories-filter');

  inputs.forEach(input => {
    input.addEventListener('change', () => {
      this.initCategoriesFilter(false, 1)
    })
  })
}

function initCategoriesFilter(append, page) {
  //const self = this;

  let data = new FormData();
  data.append('category', document.querySelector('.js-categories-filter[name=categories] option:checked').value);
  data.append('page', page);

  const request = new XMLHttpRequest();
  request.open('POST', '/album/albums-filter', true);

  request.onload = function () {
    if (request.status >= 200 && request.status < 400) {
      if (append) {
        document.querySelector('#albums-results').innerHTML += request.responseText;
      } else {
        document.querySelector('#albums-results').innerHTML = request.responseText;
      }

      // show more
      if(document.querySelector('.show-more')){
        document.querySelector('.show-more').addEventListener('click', () => {
          const button = document.querySelector('.show-more');
          const page = button.getAttribute('data-page');
          button.parentNode.removeChild(button);

          initCategoriesFilter(true, page)
        })
      }
    }
  };

  request.send(data);
}
